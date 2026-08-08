<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Products Grid
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly.

$show_header     = $settings['show_header'] ?? 'yes';
$prod_count      = absint( $settings['prod_count'] ?? 4 );
$prod_orderby    = $settings['prod_orderby'] ?? 'popularity';
$prod_cats       = ! empty( $settings['prod_categories'] ) ? $settings['prod_categories'] : '';
$show_badge      = ( $settings['show_badge'] ?? 'yes' ) === 'yes';
$show_category   = ( $settings['show_category'] ?? 'yes' ) === 'yes';
$show_desc       = ( $settings['show_description'] ?? 'yes' ) === 'yes';
$show_rating     = ( $settings['show_rating'] ?? 'yes' ) === 'yes';
$show_price      = ( $settings['show_price'] ?? 'yes' ) === 'yes';
$show_atc        = ( $settings['show_add_to_cart'] ?? 'yes' ) === 'yes';

// Pro features (Wishlist, Quick View, Compare) are inline action icons
// rendered in the footer row next to add-to-cart, supplied by the
// shopbar-pro-addons plugin. They only render when the Pro plugin is
// active (and their respective toggle is on).
$is_pro          = defined( 'SBPA_VERSION' ) || class_exists( 'Shopbar_Pro_Addons' ) || function_exists( 'sbpa_fs' );
$show_wish       = $is_pro && ( $settings['show_wishlist'] ?? 'yes' ) === 'yes';
$show_quickview  = $is_pro && ( $settings['show_quickview'] ?? 'yes' ) === 'yes';
$show_compare    = $is_pro && ( $settings['show_compare'] ?? 'yes' ) === 'yes';

$image_ratio     = $settings['image_ratio'] ?? '1-1';

$id = $this->get_id();

// WooCommerce guard.
if ( ! class_exists( 'WooCommerce' ) ) {
	echo '<div class="shopbar-pg-section shopbar-pg-' . esc_attr( $id ) . '" style="padding:40px;text-align:center;">';
	echo '<p style="color:#6B6560;font-size:15px;">' . esc_html__( 'WooCommerce plugin is required to display products.', 'spiraclethemes-site-library' ) . '</p>';
	echo '</div>';
	return;
}

// Build query args.
$args = array(
	'status'   => 'publish',
	'limit'    => $prod_count,
	'paginate' => false,
);

switch ( $prod_orderby ) {
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

if ( ! empty( $prod_cats ) ) {
	$args['category'] = array_map( 'trim', explode( ',', $prod_cats ) );
}

$products = function_exists( 'wc_get_products' ) ? wc_get_products( $args ) : array();

// Icons (match the shopbar theme card iconography).
$bag_svg   = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>';
$check_svg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M20 6 9 17l-5-5"/></svg>';
$heart_svg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>';
$eye_svg   = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
$compare_svg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><polyline points="16 3 21 3 21 8"></polyline><line x1="4" y1="20" x2="21" y2="3"></line><polyline points="21 16 21 21 16 21"></polyline><line x1="15" y1="15" x2="21" y2="21"></line><line x1="4" y1="4" x2="9" y2="9"></line></svg>';
?>

<section class="shopbar-pg-section shopbar-pg-<?php echo esc_attr( $id ); ?> shopbar-pg-section--ratio-<?php echo esc_attr( $image_ratio ); ?>">
	<div class="shopbar-pg-inner">

		<?php if ( 'yes' === $show_header && ( ! empty( $settings['header_eyebrow'] ) || ! empty( $settings['header_title'] ) || ! empty( $settings['header_desc'] ) ) ) : ?>
		<div class="shopbar-pg-head">
			<?php if ( ! empty( $settings['header_eyebrow'] ) ) : ?>
				<span class="shopbar-pg-eyebrow"><?php echo esc_html( $settings['header_eyebrow'] ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $settings['header_title'] ) ) : ?>
				<h2 class="shopbar-pg-heading"><?php echo esc_html( $settings['header_title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $settings['header_desc'] ) ) : ?>
				<p class="shopbar-pg-desc"><?php echo esc_html( $settings['header_desc'] ); ?></p>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php if ( ! empty( $products ) ) : ?>
		<div class="shopbar-pg-grid">
			<?php foreach ( $products as $product ) :
				$product_id   = $product->get_id();
				$product_name = $product->get_name();
				$product_link = $product->get_permalink();
				$product_img  = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' );
				$img_alt      = get_post_meta( $product->get_image_id(), '_wp_attachment_image_alt', true );

				if ( ! $product_img ) {
					$product_img = function_exists( 'wc_placeholder_img_src' ) ? wc_placeholder_img_src( 'woocommerce_thumbnail' ) : '';
				}
				if ( ! $img_alt ) {
					$img_alt = $product_name;
				}

				// Badge logic: Sold Out > Sale percentage > New (mirrors theme content-product.php).
				$badge_text  = '';
				$badge_class = '';
				if ( $show_badge ) {
					if ( ! $product->is_in_stock() ) {
						$badge_text  = esc_html__( 'Sold Out', 'spiraclethemes-site-library' );
						$badge_class = 'badge-oos';
					} elseif ( $product->is_on_sale() ) {
						$badge_text  = function_exists( 'shopbar_get_product_sale_percentage' ) ? shopbar_get_product_sale_percentage( $product ) : '';
						if ( '' === $badge_text ) {
							$badge_text = esc_html__( 'Sale', 'spiraclethemes-site-library' );
						}
						$badge_class = 'badge-sale';
					} elseif ( function_exists( 'shopbar_is_product_new' ) ? shopbar_is_product_new( $product_id ) : $this->is_product_new( $product ) ) {
						$badge_text  = esc_html__( 'New', 'spiraclethemes-site-library' );
						$badge_class = 'badge-new';
					}
				}

				// Category / brand eyebrow.
				$category_html = '';
				if ( $show_category ) {
					$cat_list = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( $product_id, ', ' ) : '';
					if ( $cat_list ) {
						$category_html = $cat_list;
					} elseif ( function_exists( 'shopbar_get_product_brand' ) ) {
						$brand = shopbar_get_product_brand( $product_id );
						if ( $brand ) {
							$category_html = esc_html( $brand );
						}
					}
				}

				// Short description (single clamped line, like the theme).
				$short_desc = '';
				if ( $show_desc ) {
					$short_desc = trim( wp_strip_all_tags( $product->get_short_description() ) );
				}

				// Rating.
				$avg_rating   = (float) $product->get_average_rating();
				$review_count = (int) $product->get_review_count();

				// Price.
				$product_price = $product->get_price_html();

				// Add-to-cart state.
				$in_cart        = false;
				$is_purchasable = $product->is_purchasable() && $product->is_in_stock();
				if ( function_exists( 'WC' ) && WC()->cart ) {
					foreach ( WC()->cart->get_cart() as $cart_item ) {
						if ( $cart_item['product_id'] == $product_id ) { // phpcs:ignore
							$in_cart = true;
							break;
						}
					}
				}
				$atc_label = $in_cart ? esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) : esc_attr__( 'Add to cart', 'spiraclethemes-site-library' );
			?>
		<article class="shopbar-pg-card<?php echo $product->is_on_sale() ? ' pg-on-sale' : ''; ?>">
			<div class="shopbar-pg-media">
				<a class="shopbar-pg-imglink" href="<?php echo esc_url( $product_link ); ?>" aria-label="<?php echo esc_attr( $product_name ); ?>">
					<?php if ( $product_img ) : ?>
						<img class="shopbar-pg-img" src="<?php echo esc_url( $product_img ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy" />
					<?php endif; ?>
					<?php
					// Secondary gallery image — fades in on hover (mirrors the
					// shopbar theme .secondary-image swap used in the carousel).
					$gallery_ids = $product->get_gallery_image_ids();
					if ( ! empty( $gallery_ids ) ) {
						$secondary_url = wp_get_attachment_image_url( $gallery_ids[0], 'woocommerce_thumbnail' );
						if ( $secondary_url ) {
							echo '<img class="shopbar-pg-img--secondary" src="' . esc_url( $secondary_url ) . '" alt="' . esc_attr( $img_alt ) . '" loading="lazy" />';
						}
					}
					?>
				</a>
				<?php if ( $badge_text ) : ?>
					<span class="shopbar-pg-badge <?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $badge_text ); ?></span>
				<?php endif; ?>
			</div>

			<div class="shopbar-pg-info">
				<?php if ( $category_html ) : ?>
					<div class="shopbar-pg-cat"><?php echo wp_kses_post( $category_html ); ?></div>
				<?php endif; ?>

				<h3 class="shopbar-pg-name">
					<a href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( $product_name ); ?></a>
				</h3>

				<?php if ( $short_desc ) : ?>
					<p class="shopbar-pg-desc"><?php echo esc_html( wp_trim_words( $short_desc, 9, '&hellip;' ) ); ?></p>
				<?php endif; ?>

				<?php if ( $show_rating && $avg_rating > 0 ) : ?>
					<div class="shopbar-pg-rating">
						<?php echo function_exists( 'wc_get_rating_html' ) ? wc_get_rating_html( $avg_rating, $review_count ) : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php if ( $review_count > 0 ) : ?>
							<span class="shopbar-pg-rating-count">(<?php echo esc_html( number_format_i18n( $review_count ) ); ?>)</span>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php
				// Footer mirrors the shopbar-pro-addons product-carousel card:
				// a column stack — price on its own row, then a single inline
				// row of action buttons (add-to-cart + wishlist + compare +
				// quick view). Pro icons only render when the pro plugin is
				// active (gating is preserved in the variables above).
				$show_footer_actions = $show_atc || $show_wish || $show_compare || $show_quickview;
				?>
			<?php if ( ( $show_price && $product_price ) || $show_footer_actions ) : ?>
			<div class="shopbar-pg-footer<?php echo $is_pro ? '' : ' shopbar-pg-footer--inline'; ?>">
				<?php if ( $show_price && $product_price ) : ?>
						<div class="shopbar-pg-price"><?php echo wp_kses_post( $product_price ); ?></div>
					<?php endif; ?>

					<?php if ( $show_footer_actions ) : ?>
					<div class="shopbar-pg-actions">
						<?php if ( $show_atc && $product->is_in_stock() ) : ?>
							<button type="button" class="shopbar-pg-atc<?php echo $in_cart ? ' quick-view-added' : ''; ?>" aria-label="<?php echo esc_attr( $atc_label ); ?>" title="<?php echo esc_attr( $atc_label ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-type="<?php echo esc_attr( $product->get_type() ); ?>" data-product-url="<?php echo esc_url( $product_link ); ?>" data-purchasable="<?php echo $is_purchasable ? 'yes' : 'no'; ?>"<?php echo $in_cart ? ' disabled' : ''; ?>>
								<?php echo $in_cart ? $check_svg : $bag_svg; // phpcs:ignore ?>
							</button>
						<?php endif; ?>
						<?php if ( $show_wish ) : ?>
							<button type="button" class="shopbar-pg-wish" aria-label="<?php esc_attr_e( 'Add to wishlist', 'spiraclethemes-site-library' ); ?>" title="<?php esc_attr_e( 'Add to wishlist', 'spiraclethemes-site-library' ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">
								<?php echo $heart_svg; // phpcs:ignore ?>
							</button>
						<?php endif; ?>
						<?php if ( $show_compare ) : ?>
							<button type="button" class="shopbar-pg-compare" aria-label="<?php esc_attr_e( 'Compare', 'spiraclethemes-site-library' ); ?>" title="<?php esc_attr_e( 'Compare', 'spiraclethemes-site-library' ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>">
								<?php echo $compare_svg; // phpcs:ignore ?>
							</button>
						<?php endif; ?>
						<?php if ( $show_quickview ) : ?>
							<button type="button" class="shopbar-pg-qv" aria-label="<?php esc_attr_e( 'Quick view', 'spiraclethemes-site-library' ); ?>" title="<?php esc_attr_e( 'Quick view', 'spiraclethemes-site-library' ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-url="<?php echo esc_url( $product_link ); ?>">
								<?php echo $eye_svg; // phpcs:ignore ?>
							</button>
						<?php endif; ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</article>
			<?php endforeach; ?>
		</div>
		<?php else : ?>
		<div class="shopbar-pg-empty">
			<p><?php esc_html_e( 'No products found.', 'spiraclethemes-site-library' ); ?></p>
		</div>
		<?php endif; ?>

	</div>
</section>

<style>
	.shopbar-pg-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--pg-accent: var(--brand-accent-warm, #B8977E);
		--pg-sale: #C44D4D;
		--pg-success: #166534;
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> *,
	.shopbar-pg-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-pg-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-inner {
		max-width: 1350px;
		margin: 0 auto;
		width: 100%;
		padding: 0 24px;
	}

	/* ── Section header ── */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-head {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 8px;
		margin-bottom: 34px;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-eyebrow {
		font-family: var(--font-mono, 'DM Mono', monospace);
		font-size: 12.5px;
		font-weight: 500;
		letter-spacing: 0.14em;
		text-transform: uppercase;
		color: var(--pg-accent);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-heading {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 30px;
		font-weight: 500;
		line-height: 1.2;
		letter-spacing: -0.015em;
		color: var(--brand-dark, #1C1C1C);
		margin: 0;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-desc {
		font-size: 15px;
		line-height: 1.6;
		color: var(--brand-text-muted, #9C9792);
		margin: 0;
		max-width: 560px;
	}

	/* ── Grid ── */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		column-gap: 24px;
		row-gap: 24px;
	}

	/* ── Card ── */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-card {
		position: relative;
		display: flex;
		flex-direction: column;
		background: var(--brand-card, #FFFFFF);
		border-radius: var(--radius-md, 10px);
		overflow: hidden;
		cursor: pointer;
		transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-card:hover {
		transform: translateY(-6px);
		box-shadow: 0 12px 40px rgba(28, 28, 28, 0.08);
	}

	/* ── Media stage (edge-to-edge) ── */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-media {
		position: relative;
		overflow: hidden;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-imglink {
		display: block;
		position: relative;
		width: 100%;
		overflow: hidden;
		background: var(--brand-bg-secondary, #F3EFEA);
	}
	.shopbar-pg-section--ratio-1-1.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-imglink { aspect-ratio: 1 / 1; }
	.shopbar-pg-section--ratio-4-3.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-imglink { aspect-ratio: 4 / 3; }
	.shopbar-pg-section--ratio-3-4.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-imglink { aspect-ratio: 3 / 4; }
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
		transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-card:hover .shopbar-pg-img {
		transform: scale(1.05);
	}

	/* Secondary gallery image — fades in on hover (theme .secondary-image). */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-img--secondary {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
		opacity: 0;
		transition: opacity 0.3s ease;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-card:hover .shopbar-pg-img--secondary {
		opacity: 1;
	}

	/* ── Badge (top-left pill) ── */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-badge {
		position: absolute;
		top: 14px;
		left: 14px;
		right: auto;
		z-index: 3;
		display: inline-flex;
		align-items: center;
		background: var(--brand-dark, #1C1C1C);
		color: #FFFFFF;
		font-size: 10px;
		font-weight: 500;
		letter-spacing: 0.07em;
		text-transform: uppercase;
		padding: 5px 12px;
		border-radius: 50px;
		line-height: 1;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-badge.badge-sale { background: var(--pg-sale); }
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-badge.badge-new  { background: var(--pg-accent); }
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-badge.badge-oos  { background: var(--brand-text-muted, #9C9792); }

	/* ── Info ── */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-info {
		display: flex;
		flex-direction: column;
		padding: 18px 16px;
	}

	/* Category eyebrow */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-cat {
		font-size: 12px;
		color: var(--brand-text-muted, #9C9792);
		letter-spacing: 0.02em;
		margin-bottom: 2px;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-cat a { text-decoration: none; }

	/* Name (single-line) */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-name {
		font-size: 15px;
		font-weight: 500;
		line-height: 1.3;
		letter-spacing: -0.01em;
		color: var(--brand-dark, #1C1C1C);
		margin: 4px 0 0;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-name a {
		color: var(--brand-dark, #1C1C1C);
		display: block;
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;
		text-decoration: none;
		transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-card:hover .shopbar-pg-name a {
		color: var(--pg-accent);
	}

	/* Description (clamped) */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-desc {
		font-size: 12.5px;
		line-height: 1.45;
		color: var(--brand-text-muted, #9C9792);
		margin: 4px 0 0;
		display: -webkit-box;
		-webkit-line-clamp: 1;
		line-clamp: 1;
		-webkit-box-orient: vertical;
		overflow: hidden;
	}

	/* Rating */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-rating {
		display: flex;
		align-items: center;
		gap: 6px;
		margin: 8px 0 0;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-rating .star-rating {
		font-size: 12px;
		line-height: 1;
		margin: 0;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-rating .star-rating::before {
		color: var(--brand-highlight, #FFB800);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-rating .star-rating span::before {
		color: var(--brand-highlight, #FFB800);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-rating-count {
		font-size: 11px;
		color: var(--brand-muted, #6B6560);
	}

	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-footer {
		display: flex;
		flex-direction: column;
		align-items: stretch;
		gap: 12px;
		flex-wrap: wrap;
		margin-top: 12px;
	}

	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-footer--inline {
		flex-direction: row;
		align-items: center;
		justify-content: space-between;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-footer--inline .shopbar-pg-price {
		flex: 1 1 auto;
		min-width: 0;
		width: auto;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-footer--inline .shopbar-pg-actions {
		width: auto;
		flex-shrink: 0;
	}

	/* Price */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price {
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
		flex: 0 0 auto;
		width: 100%;
		margin-top: 0;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price {
		margin: 0 !important;
		display: flex;
		align-items: center;
		gap: 8px;
		flex-wrap: wrap;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price del {
		font-size: 13px;
		color: var(--brand-text-muted, #9C9792);
		text-decoration: line-through;
		opacity: 1;
		font-weight: 400;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price ins {
		text-decoration: none;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price ins .woocommerce-Price-amount,
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price > .woocommerce-Price-amount {
		font-size: 15px;
		font-weight: 600;
		color: var(--brand-dark, #1C1C1C);
		letter-spacing: -0.01em;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .pg-on-sale .shopbar-pg-price .price ins .woocommerce-Price-amount {
		color: var(--pg-sale);
	}

	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: flex-start;
		gap: 6px;
		width: 100%;
		flex-wrap: wrap;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions button {
		width: 38px;
		height: 38px;
		min-width: 38px;
		min-height: 38px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		background: #FFFFFF;
		color: var(--brand-dark, #1C1C1C);
		border: 1px solid var(--brand-border-light, #F0EDE9);
		border-radius: 50%;
		padding: 0;
		cursor: pointer;
		box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
		transition: background 0.2s cubic-bezier(0.4, 0, 0.2, 1), color 0.2s cubic-bezier(0.4, 0, 0.2, 1), border-color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions button:hover {
		background: var(--brand-dark, #1C1C1C);
		color: #FFFFFF;
		border-color: var(--brand-dark, #1C1C1C);
	}
	/* Wishlist active state. */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions .shopbar-pg-wish.active {
		color: var(--brand-secondary, #FF3D81);
		border-color: var(--brand-secondary, #FF3D81);
		background: #FFFFFF;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions .shopbar-pg-wish.active svg { fill: var(--brand-secondary, #FF3D81); }
	/* Compare active state. */
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions .shopbar-pg-compare.active {
		color: var(--brand-sky, #0072FF);
		border-color: var(--brand-sky, #0072FF);
		background: #FFFFFF;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-atc.quick-view-added {
		background: var(--pg-success);
		color: #FFFFFF;
		border-color: var(--pg-success);
		cursor: not-allowed;
	}
	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-atc.quick-view-added:hover {
		background: var(--pg-success);
		color: #FFFFFF;
	}

	.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-empty {
		text-align: center;
		padding: 40px 0;
		color: var(--brand-muted, #6B6560);
		font-size: 15px;
	}

	/* ── Responsive ── */
	@media (max-width: 1024px) {
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-heading { font-size: 26px; }
	}
	@media (max-width: 768px) {
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-head { margin-bottom: 24px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-heading { font-size: 23px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-info { padding: 12px 10px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-name { font-size: 13px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price ins .woocommerce-Price-amount,
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price > .woocommerce-Price-amount { font-size: 13px; }
	}
	@media (max-width: 480px) {
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-name { font-size: 12px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-badge { top: 10px; left: 10px; right: auto; font-size: 9px; padding: 4px 10px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-actions button { width: 34px; height: 34px; min-width: 34px; min-height: 34px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price ins .woocommerce-Price-amount,
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price > .woocommerce-Price-amount { font-size: 12px; }
		.shopbar-pg-<?php echo esc_attr( $id ); ?> .shopbar-pg-price .price del { font-size: 11px; }
	}
</style>

<script>
(function() {
	var root = document.querySelector('.shopbar-pg-section.shopbar-pg-<?php echo esc_js( $id ); ?>');
	if (!root) return;

	var wcAddToCartUrl = '<?php echo esc_js( class_exists( "WC_AJAX" ) ? esc_url_raw( WC_AJAX::get_endpoint( "add_to_cart" ) ) : esc_url_raw( admin_url( "admin-ajax.php?action=woocommerce_add_to_cart" ) ) ); ?>';

	function setAdded(btn) {
		btn.classList.add('quick-view-added');
		btn.disabled = true;
		btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M20 6 9 17l-5-5"/></svg>';
		btn.setAttribute('title', '<?php echo esc_js( esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) ); ?>');
		btn.setAttribute('aria-label', '<?php echo esc_js( esc_attr__( 'Added to cart', 'spiraclethemes-site-library' ) ); ?>');
	}

	root.querySelectorAll('.shopbar-pg-atc').forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();

			if (btn.classList.contains('quick-view-added')) return;

			var productId   = btn.getAttribute('data-product-id');
			var productType = btn.getAttribute('data-product-type') || 'simple';
			var productUrl  = btn.getAttribute('data-product-url') || '';
			var purchasable = btn.getAttribute('data-purchasable') !== 'no';

			if (!productId) return;

			if (productType === 'variable' || productType === 'grouped' || productType === 'external') {
				if (productUrl) window.location.href = productUrl;
				return;
			}
			if (!purchasable) return;

			btn.disabled = true;

			var params = new URLSearchParams();
			params.append('product_id', productId);
			params.append('quantity', 1);

			fetch(wcAddToCartUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: params.toString(),
				credentials: 'same-origin'
			}).then(function(response) {
				if (!response.ok) throw new Error('HTTP ' + response.status);
				var ct = response.headers.get('content-type') || '';
				if (ct.indexOf('json') !== -1) {
					return response.json().then(function(data) { return { json: true, data: data }; });
				}
				return { json: false, data: null };
			}).then(function(result) {
				if (result.json && result.data && result.data.error) {
					if (result.data.url && productUrl) window.location.href = productUrl;
					return;
				}
				setAdded(btn);
				if (typeof jQuery !== 'undefined') {
					if (result.json && result.data && result.data.fragments) {
						jQuery.each(result.data.fragments, function(key, value) { jQuery(key).replaceWith(value); });
					}
					jQuery(document.body).trigger('wc_fragment_refresh');
					jQuery(document.body).trigger('added_to_cart', [(result.json && result.data) ? result.data.fragments : null, (result.json && result.data) ? result.data.cart_hash : null, btn]);
				}
			}).catch(function() {
				setAdded(btn);
				if (typeof jQuery !== 'undefined') { jQuery(document.body).trigger('wc_fragment_refresh'); }
			}).finally(function() {
				btn.disabled = btn.classList.contains('quick-view-added');
			});
		});
	});

	root.querySelectorAll('.shopbar-pg-wish').forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			btn.classList.toggle('active');
			if (typeof jQuery !== 'undefined') {
				jQuery(document).trigger('shopbar_wishlist_toggle', [btn]);
			}
		});
	});

	// Quick View (Pro)
	root.querySelectorAll('.shopbar-pg-qv').forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var pid = btn.getAttribute('data-product-id');
			var url = btn.getAttribute('data-product-url') || '';
			if (typeof window.shopbarProQuickView === 'function') {
				window.shopbarProQuickView(pid, btn);
			} else if (url) {
				window.location.href = url;
			}
		});
	});

	// Compare (Pro).
	root.querySelectorAll('.shopbar-pg-compare').forEach(function(btn) {
		btn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			btn.classList.toggle('active');
			if (typeof jQuery !== 'undefined') {
				jQuery(document).trigger('shopbar_compare_toggle', [btn]);
			}
		});
	});
})();
</script>
