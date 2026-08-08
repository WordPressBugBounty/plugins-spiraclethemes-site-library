<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
if ( ! defined( 'ABSPATH' ) ) exit;

$settings = $this->get_settings();
$id = $this->get_id();

// Settings
$section_tag      = ! empty( $settings['section_tag'] ) ? $settings['section_tag'] : '';
$section_title    = ! empty( $settings['section_title'] ) ? $settings['section_title'] : '';
$section_subtitle = ! empty( $settings['section_subtitle'] ) ? $settings['section_subtitle'] : '';
$show_header      = $settings['show_section_header'] === 'yes';
$prod_count       = absint( $settings['prod_count'] ?? 6 );
$prod_orderby     = $settings['prod_orderby'] ?? 'popularity';
$prod_categories   = ! empty( $settings['prod_categories'] ) ? $settings['prod_categories'] : '';
$columns          = $settings['columns'] ?? '3';
$show_badge       = $settings['show_badge'] === 'yes';
$show_add_to_cart = $settings['show_add_to_cart'] === 'yes';
$show_wishlist    = $settings['show_wishlist'] === 'yes';
$show_category    = $settings['show_category'] === 'yes';
$show_price       = $settings['show_price'] === 'yes';

// Column class
$column_class = 'shopnex-prod-columns-' . esc_attr( $columns );

// Build WooCommerce query args
$args = array(
    'status'   => 'publish',
    'limit'    => $prod_count,
    'paginate' => false,
);

// Order by
switch ( $prod_orderby ) {
    case 'popularity':
        $args['orderby'] = 'popularity';
        $args['order']   = 'desc';
        break;
    case 'date':
        $args['orderby'] = 'date';
        $args['order']   = 'desc';
        break;
    case 'price':
        $args['orderby'] = 'price';
        $args['order']   = 'asc';
        break;
    case 'price-desc':
        $args['orderby'] = 'price';
        $args['order']   = 'desc';
        break;
    case 'rating':
        $args['orderby'] = 'rating';
        $args['order']   = 'desc';
        break;
    case 'rand':
        $args['orderby'] = 'rand';
        break;
    case 'title':
        $args['orderby'] = 'title';
        $args['order']   = 'asc';
        break;
    default:
        $args['orderby'] = 'popularity';
        $args['order']   = 'desc';
}

// Category filter
if ( ! empty( $prod_categories ) ) {
    $cats = array_map( 'trim', explode( ',', $prod_categories ) );
    $args['category'] = $cats;
}

// Query products
$products = wc_get_products( $args );

// Check if WooCommerce is active
if ( ! class_exists( 'WooCommerce' ) ) {
    echo '<div class="shopnex-bestsellers-section" style="padding: 40px; text-align: center;">';
    echo '<p style="color: #6B6560; font-size: 15px;">' . esc_html__( 'WooCommerce plugin is required to display products.', 'spiraclethemes-site-library' ) . '</p>';
    echo '</div>';
    return;
}
?>

<div class="shopnex-bestsellers-section">
    <?php if ( $show_header && ( $section_tag || $section_title || $section_subtitle ) ) : ?>
    <div class="shopnex-section-header">
        <?php if ( $section_tag ) : ?>
            <span class="shopnex-section-tag"><?php echo esc_html( $section_tag ); ?></span>
        <?php endif; ?>
        <?php if ( $section_title ) : ?>
            <h2 class="shopnex-section-title"><?php echo esc_html( $section_title ); ?></h2>
        <?php endif; ?>
        <?php if ( $section_subtitle ) : ?>
            <p class="shopnex-section-subtitle"><?php echo esc_html( $section_subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ( ! empty( $products ) ) : ?>
    <div class="shopnex-products-grid <?php echo esc_attr( $column_class ); ?>">
        <?php foreach ( $products as $product ) :
            $product_id      = $product->get_id();
            $product_name    = $product->get_name();
            $product_link    = $product->get_permalink();
            $product_price   = preg_replace('/<p\s+class="saved-sale">.*?<\/p>/i', '', $product->get_price_html());
            $product_image   = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_single' );
            $product_image_alt = get_post_meta( $product->get_image_id(), '_wp_attachment_image_alt', true );

            if ( ! $product_image ) {
                $product_image = wc_placeholder_img_src( 'woocommerce_single' );
            }
            if ( ! $product_image_alt ) {
                $product_image_alt = $product_name;
            }

            // Badge logic
            $badge_text  = '';
            $badge_class = '';
            if ( $show_badge ) {
                if ( $product->is_on_sale() ) {
                    $badge_text  = esc_html__( 'Sale', 'spiraclethemes-site-library' );
                    $badge_class = 'badge-sale';
                } elseif ( $this->is_product_new( $product ) ) {
                    $badge_text  = esc_html__( 'New', 'spiraclethemes-site-library' );
                    $badge_class = 'badge-new';
                }
            }

            // Product categories
            $category_names = '';
            if ( $show_category ) {
                $terms = get_the_terms( $product_id, 'product_cat' );
                if ( $terms && ! is_wp_error( $terms ) ) {
                    $cat_names = array();
                    foreach ( $terms as $term ) {
                        $cat_names[] = $term->name;
                    }
                    $category_names = implode( ' · ', $cat_names );
                }
            }
        ?>
        <div class="shopnex-product-card">
            <div class="shopnex-product-image-wrapper">
                <?php if ( $badge_text ) : ?>
                    <span class="shopnex-product-badge <?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $badge_text ); ?></span>
                <?php endif; ?>
                <a href="<?php echo esc_url( $product_link ); ?>">
                    <img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_image_alt ); ?>" loading="lazy">
                </a>
                <?php if ( $show_add_to_cart || $show_wishlist ) : ?>
                <div class="shopnex-product-actions">
                    <?php if ( $show_add_to_cart ) :
                        $product_type = $product->get_type();
                        $is_purchasable = $product->is_purchasable() && $product->is_in_stock();
                        $in_cart = false;
                        if ( function_exists( 'WC' ) && WC()->cart ) {
                            foreach ( WC()->cart->get_cart() as $cart_item ) {
                                if ( $cart_item['product_id'] == $product_id ) {
                                    $in_cart = true;
                                    break;
                                }
                            }
                        }
                        $btn_class = 'shopnex-add-to-cart-btn' . ( $in_cart ? ' in-cart' : '' );
                    ?>
                        <button type="button" class="<?php echo esc_attr( $btn_class ); ?>" aria-label="<?php echo $in_cart ? esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) : esc_attr__( 'Add to cart', 'spiraclethemes-site-library' ); ?>" title="<?php echo $in_cart ? esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) : esc_attr__( 'Add to cart', 'spiraclethemes-site-library' ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-type="<?php echo esc_attr( $product_type ); ?>" data-product-url="<?php echo esc_url( $product_link ); ?>" data-purchasable="<?php echo $is_purchasable ? 'yes' : 'no'; ?>">
                            <?php if ( $in_cart ) : ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            <?php else : ?>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            <?php endif; ?>
                        </button>
                    <?php endif; ?>
                    <?php if ( $show_wishlist ) : ?>
                        <button type="button" class="shopnex-wishlist-btn" aria-label="<?php esc_attr_e( 'Add to wishlist', 'spiraclethemes-site-library' ); ?>" title="<?php esc_attr_e( 'Add to wishlist', 'spiraclethemes-site-library' ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="shopnex-product-info">
                <a href="<?php echo esc_url( $product_link ); ?>" class="shopnex-product-name"><?php echo esc_html( $product_name ); ?></a>
                <?php if ( $category_names ) : ?>
                    <div class="shopnex-product-category"><?php echo esc_html( $category_names ); ?></div>
                <?php endif; ?>
                <?php if ( $show_price && $product_price ) : ?>
                    <div class="shopnex-product-price"><?php echo wp_kses_post( $product_price ); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else : ?>
    <div style="text-align: center; padding: 40px 0;">
        <p style="color: #6B6560; font-size: 15px;"><?php esc_html_e( 'No products found.', 'spiraclethemes-site-library' ); ?></p>
    </div>
    <?php endif; ?>
</div>

<style>
    .shopnex-bestsellers-section {
        max-width: 100%;
    }
    .shopnex-section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    .shopnex-section-tag {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #B8977E;
        font-weight: 600;
        margin-bottom: 12px;
        display: block;
    }
    .shopnex-section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(28px, 3.5vw, 40px);
        font-weight: 500;
        letter-spacing: -0.015em;
        color: #1C1C1C;
        margin-bottom: 12px;
    }
    .shopnex-section-subtitle {
        font-size: 15px;
        color: #6B6560;
        font-weight: 400;
        max-width: 480px;
        margin: 0 auto;
        line-height: 1.5;
    }

    /* ─── Products Grid ─── */
    .shopnex-products-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }
    .shopnex-prod-columns-2 {
        grid-template-columns: repeat(2, 1fr);
    }
    .shopnex-prod-columns-3 {
        grid-template-columns: repeat(3, 1fr);
    }
    .shopnex-prod-columns-4 {
        grid-template-columns: repeat(4, 1fr);
    }

    /* ─── Product Card ─── */
    .shopnex-product-card {
        position: relative;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: #FFFFFF;
    }
    .shopnex-product-card:hover {
        box-shadow: 0 12px 40px rgba(28, 28, 28, 0.08);
        transform: translateY(-6px);
    }

    /* ─── Product Image ─── */
    .shopnex-product-image-wrapper {
        position: relative;
        aspect-ratio: 3 / 4;
        overflow: hidden;
        background: #F3EFEA;
    }
    .shopnex-product-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        display: block;
    }
    .shopnex-product-card:hover .shopnex-product-image-wrapper img {
        transform: scale(1.05);
    }
    .shopnex-product-image-wrapper a {
        display: block;
        width: 100%;
        height: 100%;
    }

    /* ─── Product Badge ─── */
    .shopnex-product-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        z-index: 2;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        background: #1C1C1C;
        color: #fff;
        padding: 5px 12px;
        border-radius: 50px;
        font-weight: 500;
    }
    .shopnex-product-badge.badge-new {
        background: #B8977E;
    }
    .shopnex-product-badge.badge-sale {
        background: #1C1C1C;
    }

    /* ─── Product Actions ─── */
    .shopnex-product-actions {
        position: absolute;
        bottom: 16px;
        right: 16px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .shopnex-product-card:hover .shopnex-product-actions {
        opacity: 1;
        transform: translateY(0);
    }
    .shopnex-product-actions button {
        width: 40px;
        height: 40px;
        min-width: 40px;
        min-height: 40px;
        border-radius: 50%;
        background: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        color: #1C1C1C;
        padding: 0;
        margin: 0;
        flex-shrink: 0;
        box-sizing: border-box;
    }
    .shopnex-product-actions button:hover {
        background: #1C1C1C;
        color: #fff;
        box-shadow: 0 12px 40px rgba(28, 28, 28, 0.08);
    }
    
    .shopnex-product-actions button.shopnex-add-to-cart-btn.in-cart {
        background: #fff;
        color: #1C1C1C;
        cursor: default;
    }
    .shopnex-product-actions button.shopnex-add-to-cart-btn.in-cart:hover {
        background: #fff;
        color: #1C1C1C;
    }
    .shopnex-product-info {
        padding: 18px 16px;
    }
    .shopnex-product-name {
        font-size: 15px;
        font-weight: 500;
        color: #1C1C1C;
        letter-spacing: -0.01em;
        margin-bottom: 2px;
        transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        display: block;
    }
    .shopnex-product-card:hover .shopnex-product-name {
        color: #B8977E;
    }
    .shopnex-product-category {
        font-size: 12px;
        color: #9C9792;
        letter-spacing: 0.02em;
        margin-bottom: 6px;
    }
    .shopnex-product-price {
        font-size: 15px;
        font-weight: 600;
        color: #1C1C1C;
        letter-spacing: -0.01em;
    }
    .shopnex-product-price del {
        text-decoration: line-through;
        color: #9C9792;
        font-weight: 400;
        margin-left: 8px;
        font-size: 13px;
    }
    .shopnex-product-price ins {
        text-decoration: none;
    }

    /* ─── Responsive ─── */
    @media (max-width: 1024px) {
        .shopnex-products-grid.shopnex-prod-columns-3,
        .shopnex-products-grid.shopnex-prod-columns-4 {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .shopnex-products-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .shopnex-product-info {
            padding: 12px 10px;
        }
        .shopnex-product-name {
            font-size: 13px;
        }
        .shopnex-product-price {
            font-size: 13px;
        }
        .shopnex-section-header {
            margin-bottom: 30px;
        }
    }

    @media (max-width: 480px) {
        .shopnex-products-grid,
        .shopnex-products-grid.shopnex-prod-columns-2,
        .shopnex-products-grid.shopnex-prod-columns-3,
        .shopnex-products-grid.shopnex-prod-columns-4 {
            grid-template-columns: 1fr;
            gap: 16px;
        }
        .shopnex-product-actions {
            opacity: 1;
            transform: translateY(0);
            bottom: 10px;
            right: 10px;
        }
        .shopnex-product-actions button {
            width: 34px;
            height: 34px;
        }
    }
</style>

<script>
(function() {
    // WooCommerce AJAX add-to-cart endpoint
    var wcAddToCartUrl = '<?php echo esc_js( class_exists( "WC_AJAX" ) ? esc_url_raw( WC_AJAX::get_endpoint( "add_to_cart" ) ) : esc_url_raw( admin_url( "admin-ajax.php?action=woocommerce_add_to_cart" ) ) ); ?>';

    function showAddedFeedback(btn) {
        var svg = btn.querySelector('svg');
        if (svg) {
            svg.innerHTML = '<polyline points="20 6 9 17 4 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        }
        btn.classList.add('in-cart');
        btn.setAttribute('title', '<?php echo esc_js( esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) ); ?>');
        btn.setAttribute('aria-label', '<?php echo esc_js( esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) ); ?>');
    }

    function showErrorFeedback(btn) {
        btn.style.background = '#e74c3c';
        btn.style.color = '#fff';
        setTimeout(function() {
            btn.style.background = '';
            btn.style.color = '';
        }, 1500);
    }

    // Add to cart AJAX
    document.querySelectorAll('.shopnex-add-to-cart-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var productId = this.getAttribute('data-product-id');
            var productType = this.getAttribute('data-product-type') || 'simple';
            var productUrl = this.getAttribute('data-product-url') || '';
            var isPurchasable = this.getAttribute('data-purchasable') !== 'no';

            if (!productId) return;

            // Redirect to product page for types that require option selection
            if (productType === 'variable' || productType === 'grouped' || productType === 'external') {
                if (productUrl) {
                    window.location.href = productUrl;
                }
                return;
            }

            if (!isPurchasable) {
                showErrorFeedback(btn);
                return;
            }

            // Disable button while processing
            btn.disabled = true;

            var params = new URLSearchParams();
            params.append('product_id', productId);
            params.append('quantity', 1);

            fetch(wcAddToCartUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: params.toString(),
                credentials: 'same-origin'
            }).then(function(response) {
                if (!response.ok) throw new Error('HTTP ' + response.status);
                var ct = response.headers.get('content-type') || '';
                if (ct.indexOf('json') !== -1) {
                    return response.json().then(function(data) {
                        return { json: true, data: data };
                    });
                }
                // Non-JSON (HTML redirect page) — product was still added
                return { json: false, data: null };
            }).then(function(result) {
                if (result.json && result.data && result.data.error) {
                    // Redirect to product page if options are needed
                    if (result.data.url && productUrl) {
                        window.location.href = productUrl;
                    }
                    return;
                }
                // Success
                showAddedFeedback(btn);
                if (typeof jQuery !== 'undefined') {
                    if (result.json && result.data && result.data.fragments) {
                        jQuery.each(result.data.fragments, function(key, value) {
                            jQuery(key).replaceWith(value);
                        });
                    }
                    jQuery(document.body).trigger('wc_fragment_refresh');
                    var fragments = (result.json && result.data) ? result.data.fragments : null;
                    var cartHash = (result.json && result.data) ? result.data.cart_hash : null;
                    jQuery(document.body).trigger('added_to_cart', [fragments, cartHash, btn]);
                }
            }).catch(function() {
                showAddedFeedback(btn);
                if (typeof jQuery !== 'undefined') {
                    jQuery(document.body).trigger('wc_fragment_refresh');
                }
            }).finally(function() {
                btn.disabled = false;
            });
        });
    });

    // Wishlist button (requires Shopnex Pro Addons)
    document.querySelectorAll('.shopnex-wishlist-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // Trigger custom event for Shopnex Pro Addons to handle
            if (typeof jQuery !== 'undefined') {
                jQuery(document).trigger('shopnex_wishlist_toggle', [btn]);
            }
            // Visual feedback - toggle heart fill
            var svg = btn.querySelector('svg');
            if (svg) {
                var isFilled = btn.classList.contains('shopnex-wishlisted');
                if (isFilled) {
                    btn.classList.remove('shopnex-wishlisted');
                    svg.innerHTML = '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                } else {
                    btn.classList.add('shopnex-wishlisted');
                    svg.innerHTML = '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
                }
            }
        });
    });
})();
</script>
