<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Products Grid
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings        = $this->get_settings();
$id              = $this->get_id();

$eyebrow         = $settings['eyebrow'] ?? '';
$title           = $settings['title'] ?? '';
$show_view_all   = $settings['show_view_all'] ?? 'yes';
$view_all_text   = $settings['view_all_text'] ?? '';
$view_all_url    = $settings['view_all_url'] ?? [];
$show_badge      = $settings['show_badge'] ?? 'yes';
$show_quick_add  = $settings['show_quick_add'] ?? 'yes';
$quick_add_text  = $settings['quick_add_text'] ?? '';

// PawWell Pro integration: wishlist + quick view + compare only render when the Pro plugin is active.
$pro_active      = function_exists( 'pwpa_is_feature_enabled' );
$show_wishlist   = $pro_active ? ( $settings['show_wishlist'] ?? 'yes' ) : 'no';
$show_quick_view = $pro_active ? ( $settings['show_quick_view'] ?? 'yes' ) : 'no';
$show_compare    = $pro_active ? ( $settings['show_compare'] ?? 'yes' ) : 'no';

// If Pro is active but a feature is disabled in Pro settings
if ( $pro_active ) {
	if ( ! pwpa_is_feature_enabled( 'wishlist' ) ) {
		$show_wishlist = 'no';
	}
	if ( ! pwpa_is_feature_enabled( 'quick_view' ) ) {
		$show_quick_view = 'no';
	}
	if ( ! pwpa_is_feature_enabled( 'compare' ) ) {
		$show_compare = 'no';
	}
}

// Whether the Pro action icon group should render at all.
$has_pro_actions = $pro_active && ( 'yes' === $show_wishlist || 'yes' === $show_quick_view || 'yes' === $show_compare );
$show_category   = $settings['show_category'] ?? 'yes';
$show_rating     = $settings['show_rating'] ?? 'yes';
$image_ratio     = $settings['image_ratio'] ?? '1 / 1';
$show_border_top    = $settings['show_border_top'] ?? 'yes';
$show_border_bottom = $settings['show_border_bottom'] ?? 'yes';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

$view_all_link     = ! empty( $view_all_url['url'] ) ? esc_url( $view_all_url['url'] ) : '#';
$view_all_target   = ! empty( $view_all_url['is_external'] ) ? ' target="_blank"' : '';
$view_all_nofollow = ! empty( $view_all_url['nofollow'] ) ? ' rel="nofollow"' : '';

// Border flags
$wrap_class  = 'pawwell-pg pawwell-pg-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-pg-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-pg-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-pg-fullwidth' : '';

// SVG icons.
$star_svg   = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';
	$zap_svg    = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 2 3 14h7l-1 8 10-12h-7z"/></svg>';
	$check_svg  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>';
// Pro action icons (heart / eye / compare).
$wish_svg     = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>';
$qview_svg    = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
$compare_svg  = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="16 3 21 3 21 8"/><line x1="4" y1="20" x2="21" y2="3"/><polyline points="21 16 21 21 16 21"/><line x1="15" y1="15" x2="21" y2="21"/><line x1="4" y1="4" x2="9" y2="9"/></svg>';
?>

<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-pg-inner">
		<?php if ( ! empty( $title ) || ! empty( $eyebrow ) || 'yes' === $show_view_all ) : ?>
		<div class="pawwell-pg-head">
			<div class="pawwell-pg-heading">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<div class="pawwell-pg-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $title ) ) : ?>
						<h2 class="pawwell-pg-title"><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>
				</div>
				<?php if ( 'yes' === $show_view_all && ! empty( $view_all_text ) ) : ?>
					<a class="pawwell-pg-viewall" href="<?php echo esc_url( $view_all_link ); ?>"<?php echo esc_attr( $view_all_target . $view_all_nofollow ); ?>>
						<?php echo esc_html( $view_all_text ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( false === $products ) : ?>
			<div class="pawwell-pg-empty">
				<p><?php esc_html_e( 'WooCommerce plugin is required to display products.', 'spiraclethemes-site-library' ); ?></p>
			</div>
		<?php elseif ( empty( $products ) ) : ?>
			<div class="pawwell-pg-empty">
				<p><?php esc_html_e( 'No products found.', 'spiraclethemes-site-library' ); ?></p>
			</div>
		<?php else : ?>
			<div class="pawwell-pg-grid">
				<?php
				// Product IDs currently in the cart (used for the persistent "Added to cart" state).
				$cart_product_ids = array();
				if ( function_exists( 'WC' ) && WC()->cart ) {
					foreach ( WC()->cart->get_cart() as $cart_item ) {
						if ( ! empty( $cart_item['product_id'] ) ) {
							$cart_product_ids[ (int) $cart_item['product_id'] ] = true;
						}
					}
				}
				?>
				<?php foreach ( $products as $product ) :
					$product_id    = $product->get_id();
					$in_cart       = isset( $cart_product_ids[ (int) $product_id ] );
					$product_name  = $product->get_name();
					$product_link  = $product->get_permalink();
					$product_image = wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_single' );
					$product_alt   = get_post_meta( $product->get_image_id(), '_wp_attachment_image_alt', true );

					if ( ! $product_image ) {
						$product_image = wc_placeholder_img_src( 'woocommerce_single' );
					}
					if ( ! $product_alt ) {
						$product_alt = $product_name;
					}

					// Price HTML from WooCommerce (handles variable, sale, etc.).
					$product_price = $product->get_price_html();

					// Badge logic (Sale / New / Bestseller).
					$badge_text  = '';
					$badge_type  = 'default';
					if ( 'yes' === $show_badge ) {
						if ( $product->is_on_sale() ) {
							$percentage = '';
							if ( $product->is_type( 'simple' ) ) {
								$regular = (float) $product->get_regular_price();
								$sale    = (float) $product->get_sale_price();
								if ( $regular > 0 && $sale > 0 && $sale < $regular ) {
									$percentage = '-' . round( ( ( $regular - $sale ) / $regular ) * 100 ) . '%';
								}
							}
							$badge_text = $percentage ? $percentage : esc_html__( 'Sale', 'spiraclethemes-site-library' );
							$badge_type = 'sale';
						} elseif ( $this->is_product_new( $product ) ) {
							$badge_text = esc_html__( 'New', 'spiraclethemes-site-library' );
							$badge_type = 'new';
						} elseif ( 'best_selling' === ( $settings['product_source'] ?? '' ) ) {
							$badge_text = esc_html__( 'Bestseller', 'spiraclethemes-site-library' );
							$badge_type = 'default';
						}
					}

					// Category.
					$category_names = '';
					if ( 'yes' === $show_category ) {
						$terms = get_the_terms( $product_id, 'product_cat' );
						if ( $terms && ! is_wp_error( $terms ) ) {
							$cat_names = [];
							foreach ( $terms as $term ) {
								$cat_names[] = $term->name;
							}
							$category_names = implode( ' · ', $cat_names );
						}
					}

					// Rating.
					$avg_rating = 'yes' === $show_rating ? (float) $product->get_average_rating() : 0;
					$review_count = (int) $product->get_review_count();

					// Quick add-to-cart attributes.
					$product_type   = $product->get_type();
					$is_purchasable = $product->is_purchasable() && $product->is_in_stock();
					?>
					<article class="pawwell-pg-card<?php echo $in_cart ? ' pawwell-pg-card--added' : ''; ?>">
						<div class="pawwell-pg-media">
							<a class="pawwell-pg-img-wrap" href="<?php echo esc_url( $product_link ); ?>">
								<span class="pawwell-pg-img" style="aspect-ratio: <?php echo esc_attr( $image_ratio ); ?>;">
									<img src="<?php echo esc_url( $product_image ); ?>" alt="<?php echo esc_attr( $product_alt ); ?>" loading="lazy">
								</span>
							</a>

							<?php if ( ! empty( $badge_text ) ) : ?>
								<span class="pawwell-pg-badge pawwell-pg-badge--<?php echo esc_attr( $badge_type ); ?>"><?php echo esc_html( $badge_text ); ?></span>
							<?php endif; ?>

							<?php if ( $has_pro_actions ) : ?>
								<div class="pawwell-pg-actions">
									<?php if ( 'yes' === $show_wishlist ) : ?>
										<button type="button" class="pawwell-pg-action-btn pawwell-pg-wishlist-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Add to wishlist', 'spiraclethemes-site-library' ); ?>"><?php echo $wish_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
									<?php endif; ?>

									<?php if ( 'yes' === $show_quick_view ) : ?>
										<button type="button" class="pawwell-pg-action-btn pawwell-pg-quick-view-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Quick view', 'spiraclethemes-site-library' ); ?>"><?php echo $qview_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
									<?php endif; ?>

									<?php if ( 'yes' === $show_compare ) : ?>
										<button type="button" class="pawwell-pg-action-btn pawwell-pg-compare-btn" data-product-id="<?php echo esc_attr( $product_id ); ?>" aria-label="<?php esc_attr_e( 'Compare', 'spiraclethemes-site-library' ); ?>"><?php echo $compare_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></button>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						<?php if ( 'yes' === $show_quick_add && ! empty( $quick_add_text ) ) :
							$added_label = esc_html__( 'Added to cart', 'spiraclethemes-site-library' );
							$qa_label    = $in_cart ? $added_label : $quick_add_text;
							$qa_icon     = $in_cart ? $check_svg : $zap_svg;
							$qa_classes  = 'pawwell-pg-quick-add' . ( $in_cart ? ' pawwell-pg-quick-added' : '' );
							?>
							<button type="button" class="<?php echo esc_attr( $qa_classes ); ?>" aria-label="<?php echo esc_attr( $qa_label ); ?>" data-product-id="<?php echo esc_attr( $product_id ); ?>" data-product-type="<?php echo esc_attr( $product_type ); ?>" data-product-url="<?php echo esc_url( $product_link ); ?>" data-purchasable="<?php echo $is_purchasable ? 'yes' : 'no'; ?>"<?php echo $in_cart ? ' data-pg-added="1"' : ''; ?>>
								<?php echo $qa_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								<span><?php echo esc_html( $qa_label ); ?></span>
							</button>
						<?php endif; ?>
						</div>

						<div class="pawwell-pg-body">
							<?php if ( ! empty( $category_names ) ) : ?>
								<div class="pawwell-pg-category"><?php echo esc_html( $category_names ); ?></div>
							<?php endif; ?>

							<a class="pawwell-pg-name" href="<?php echo esc_url( $product_link ); ?>"><?php echo esc_html( $product_name ); ?></a>

							<?php if ( $avg_rating > 0 || $review_count > 0 ) : ?>
								<div class="pawwell-pg-rating">
									<?php if ( $avg_rating > 0 ) : ?>
										<span class="pawwell-pg-stars">
											<?php for ( $s = 1; $s <= 5; $s++ ) :
												echo '<span class="pawwell-pg-star' . ( $s <= round( $avg_rating ) ? ' pawwell-pg-star--on' : '' ) . '">' . $star_svg . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
											endfor; ?>
										</span>
									<?php endif; ?>
									<?php if ( $review_count > 0 ) : ?>
										<span class="pawwell-pg-rating-count">(<?php echo esc_html( $review_count ); ?>)</span>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $product_price ) ) : ?>
								<div class="pawwell-pg-price-row">
									<div class="pawwell-pg-price"><?php echo wp_kses_post( $product_price ); ?></div>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-pg-<?php echo esc_attr( $id ); ?> {
		background: #fff;
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?>.pawwell-pg-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-pg-<?php echo esc_attr( $id ); ?>.pawwell-pg-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	
	.pawwell-pg-<?php echo esc_attr( $id ); ?>.pawwell-pg-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-inner {
		max-width: 1380px;
		margin: 0 auto;
		padding: 100px 32px;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-head {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 20px;
		margin-bottom: 48px;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-heading {
		flex: 1;
		min-width: 0;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-eyebrow {
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.1em;
		color: #C45B3E;
		margin-bottom: 10px;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-title {
		line-height: 1.1;
		letter-spacing: -0.02em;
		color: #1E1E1E;
		margin: 0;
		font-weight: 400;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-viewall {
		display: inline-block;
		padding: 10px 20px;
		font-size: 13px;
		font-weight: 600;
		line-height: 1;
		text-decoration: none;
		color: #1E1E1E;
		background: transparent;
		border: 1.5px solid #1E1E1E;
		border-radius: 999px;
		white-space: nowrap;
		transition: background .25s ease, color .25s ease;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-viewall:hover {
		background: #1E1E1E;
		color: #fff;
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 24px;
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-empty {
		text-align: center;
		padding: 40px 0;
		color: #8A8A8A;
		font-size: 15px;
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-card {
		position: relative;
		background: #fff;
		border: 1px solid #E8E2DA;
		border-radius: 20px;
		overflow: hidden;
		min-width: 0;
		display: flex;
		flex-direction: column;
		transition: transform .3s cubic-bezier(.16,1,.3,1), box-shadow .3s ease, border-color .3s ease;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 24px 64px rgba(30,30,30,.10);
		border-color: transparent;
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-media {
		position: relative;
		overflow: hidden;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-img-wrap {
		display: block;
		text-decoration: none;
		color: inherit;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-img {
		display: block;
		overflow: hidden;
		background: #F0EAE2;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-img img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform .4s ease;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-card:hover .pawwell-pg-img img {
		transform: scale(1.07);
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-badge {
		position: absolute;
		top: 16px;
		left: 16px;
		z-index: 2;
		background: #C45B3E;
		color: #fff;
		font-size: 11px;
		font-weight: 700;
		padding: 5px 12px;
		border-radius: 999px;
		letter-spacing: 0.02em;
		text-transform: uppercase;
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-actions {
		position: absolute;
		top: 16px;
		right: 16px;
		z-index: 2;
		display: flex;
		flex-direction: column;
		gap: 8px;
		opacity: 0;
		transform: translateX(8px);
		transition: opacity .3s ease, transform .3s cubic-bezier(.16,1,.3,1);
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-card:hover .pawwell-pg-actions {
		opacity: 1;
		transform: translateX(0);
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-action-btn {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		border: none;
		background: #fff;
		color: #1E1E1E;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		box-shadow: 0 8px 32px rgba(30,30,30,.10);
		padding: 0;
		line-height: 1;
		transition: color .2s, transform .2s, background .2s;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-action-btn svg { width: 18px; height: 18px; }
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-action-btn:hover {
		background: #1E1E1E;
		color: #fff;
		transform: scale(1.08);
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-wishlist-btn.active {
		color: #d65a5a;
		background: #FFF0F0;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-wishlist-btn.active svg { fill: #d65a5a; stroke: #d65a5a; }
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-compare-btn.active {
		color: #C45B3E;
		background: #FBEEE9;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-compare-btn.active svg { fill: #C45B3E; stroke: #C45B3E; }

	/* Quick add bar */
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-quick-add {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		z-index: 2;
		width: 100%;
		border: none;
		background: #1E1E1E;
		color: #fff;
		padding: 12px;
		font-weight: 600;
		font-size: 13px;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 6px;
		cursor: pointer;
		transform: translateY(100%);
		transition: transform .3s cubic-bezier(.16,1,.3,1), background .2s;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-quick-add svg { width: 16px; height: 16px; }
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-card:hover .pawwell-pg-quick-add {
		transform: translateY(0);
	}

	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-card--added .pawwell-pg-quick-add {
		transform: translateY(0);
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-quick-add:hover {
		background: #C45B3E;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-quick-add.pawwell-pg-quick-added {
		background: #7B8F6B;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-quick-add:disabled {
		cursor: wait;
		opacity: 0.7;
	}

	/* Body */
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-body {
		padding: 20px;
		flex: 1;
		display: flex;
		flex-direction: column;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-category {
		font-size: 11px;
		color: #8A8A8A;
		text-transform: uppercase;
		letter-spacing: 0.08em;
		font-weight: 600;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-name {
		display: block;
		font-weight: 700;
		line-height: 1.4;
		min-height: 42px;
		color: #1E1E1E;
		margin: 6px 0 8px;
		text-decoration: none;
		transition: color .2s;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-name:hover {
		color: #C45B3E;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-rating {
		display: flex;
		align-items: center;
		gap: 6px;
		font-size: 13px;
		color: #8A8A8A;
		margin-bottom: 12px;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-stars {
		display: inline-flex;
		gap: 1px;
		color: #D4A853;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-star { display: inline-flex; }
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-star svg { width: 14px; height: 14px; }
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-star:not(.pawwell-pg-star--on) {
		color: #E8E2DA;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-price-row {
		display: flex;
		align-items: center;
		justify-content: space-between;
		margin-top: auto;
		padding-top: 12px;
		border-top: 1px solid #E8E2DA;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-price {
		font-weight: 800;
		font-size: 16px;
		color: #1E1E1E;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-price del {
		font-size: 14px;
		font-weight: 400;
		text-decoration: line-through;
		margin-left: 8px;
	}
	.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-price ins {
		text-decoration: none;
	}

	/* Responsive */
	@media (max-width: 1080px) {
		section.pawwell-pg.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-grid { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; }
	}
	@media (max-width: 920px) {
		section.pawwell-pg.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-head { flex-direction: column; align-items: flex-start; }
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-heading { flex: 0 0 100%; width: 100%; }
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-viewall { margin-top: 8px; align-self: flex-start; }
	}
	@media (max-width: 640px) {
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-inner { padding: 64px 20px; }
		section.pawwell-pg.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-grid { grid-template-columns: 1fr !important; gap: 16px; }
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-name { min-height: 0; }
		/* Touch devices: keep quick-add visible since there's no hover. */
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-quick-add { transform: translateY(0); }
		/* Touch devices: keep action icons visible since there's no hover. */
		.pawwell-pg-<?php echo esc_attr( $id ); ?> .pawwell-pg-actions { opacity: 1; transform: translateX(0); }
	}
</style>

<script>
(function() {
	if (typeof jQuery === 'undefined') {
		return;
	}
	var $grid = jQuery('.pawwell-pg-<?php echo esc_attr( $id ); ?>');

	// WooCommerce AJAX add-to-cart endpoint (with working admin-ajax fallback).
	var wcAddToCartUrl = '<?php echo esc_js( class_exists( "WC_AJAX" ) ? esc_url_raw( WC_AJAX::get_endpoint( "add_to_cart" ) ) : esc_url_raw( admin_url( "admin-ajax.php?action=woocommerce_add_to_cart" ) ) ); ?>';

	// Visual feedback when an item is added to the cart
	function showAddedFeedback(btn) {
		if (btn.getAttribute('data-pg-added')) return;
		btn.setAttribute('data-pg-added', '1');
		var label = btn.querySelector('span');
		var svg = btn.querySelector('svg');
		btn.classList.add('pawwell-pg-quick-added');
		if (svg) {
			svg.innerHTML = '<polyline points="20 6 9 17 4 12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>';
		}
		if (label) {
			label.textContent = '<?php echo esc_js( esc_html__( 'Added to cart', 'spiraclethemes-site-library' ) ); ?>';
		}
	}

	// Pro integration: delegate wishlist / quick view / compare clicks to the
	// global functions exposed by PawWell Pro when it is active.
	$grid.find('.pawwell-pg-wishlist-btn').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var btn = this;
		var productId = btn.getAttribute('data-product-id');
		if (typeof window.pwpaToggleWishlist === 'function') {
			window.pwpaToggleWishlist(btn, productId);
		} else if (typeof window.pawwellToggleWishlist === 'function') {
			window.pawwellToggleWishlist(btn, productId);
		} else {
			btn.classList.toggle('active');
		}
		jQuery(document).trigger('pawwell_wishlist_toggle', [btn]);
	});

	$grid.find('.pawwell-pg-quick-view-btn').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var productId = this.getAttribute('data-product-id');
		if (typeof window.openQuickView === 'function') {
			window.openQuickView(productId);
		}
	});

	$grid.find('.pawwell-pg-compare-btn').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var btn = this;
		var productId = parseInt(btn.getAttribute('data-product-id'), 10);
		if (typeof window.toggleCompare === 'function') {
			window.toggleCompare(btn, productId);
		} else {
			btn.classList.toggle('active');
		}
	});

	// Quick add to cart (AJAX)
	$grid.find('.pawwell-pg-quick-add').on('click', function(e) {
		e.preventDefault();
		e.stopPropagation();

		var btn = this;
		var productId = btn.getAttribute('data-product-id');
		var productType = btn.getAttribute('data-product-type') || 'simple';
		var productUrl = btn.getAttribute('data-product-url') || '';
		var purchasable = btn.getAttribute('data-purchasable') !== 'no';

		if (!productId) return;

		// Types requiring option selection redirect to the product page.
		if (productType === 'variable' || productType === 'grouped' || productType === 'external') {
			if (productUrl) { window.location.href = productUrl; }
			return;
		}
		if (!purchasable) { return; }

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
			// Non-JSON (e.g. HTML redirect page) — product was still added to the cart.
			return { json: false, data: null };
		}).then(function(result) {
			if (result.json && result.data && result.data.error) {
				// Server signalled an error (e.g. options required) → go to product page.
				if (result.data.url && productUrl) { window.location.href = productUrl; }
				return;
			}
			// Success.
			showAddedFeedback(btn);
			if (typeof jQuery !== 'undefined') {
				// Manually swap every registered fragment (cart count, drawer, totals…) so the
				// header badge updates even without WooCommerce's own fragment handlers running.
				if (result.json && result.data && result.data.fragments) {
					jQuery.each(result.data.fragments, function(key, value) { jQuery(key).replaceWith(value); });
				}
				jQuery(document.body).trigger('wc_fragment_refresh');
				jQuery(document.body).trigger('added_to_cart', [(result.json && result.data) ? result.data.fragments : null, (result.json && result.data) ? result.data.cart_hash : null, btn]);
			}
		}).catch(function() {
			// Fallback: assume added and refresh fragments rather than bouncing away.
			showAddedFeedback(btn);
			jQuery(document.body).trigger('wc_fragment_refresh');
		}).finally(function() {
			btn.disabled = false;
		});
	});
})();
</script>
