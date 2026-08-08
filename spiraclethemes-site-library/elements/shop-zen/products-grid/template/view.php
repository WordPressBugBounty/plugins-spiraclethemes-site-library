<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Products Grid Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings_for_display();
$id       = $this->get_id();

$product_type   = $settings['product_type'] ?? 'best_sellers';
$section_heading = $settings['section_heading'] ?? '';
$view_all_text  = $settings['view_all_text'] ?? '';
$view_all_link  = $settings['view_all_link'] ?? [];
$hide_view_all  = $settings['hide_view_all'] ?? '';

$settings_obj   = $this->get_settings();
$image_size_key  = ! empty( $settings_obj['prod_image_size_size'] ) ? $settings_obj['prod_image_size_size'] : 'medium_large';

/**
 * Normalize a single product into an assoc array that the markup below expects.
 *
 * @param array $item
 * @return array
 */
$shopzen_pg_normalize = function ( $item ) {
	return [
		'image'      => $item['prod_image'] ?? [],
		'title'      => $item['prod_title'] ?? '',
		'link'       => $item['prod_link'] ?? [],
		'badge_type' => $item['prod_badge_type'] ?? 'none',
		'badge_text' => $item['prod_badge_text'] ?? '',
		'price'      => $item['prod_price'] ?? '',
		'old_price'  => $item['prod_old_price'] ?? '',
		'rating'     => isset( $item['prod_rating'] ) ? (float) $item['prod_rating'] : 0,
		'reviews'    => isset( $item['prod_reviews'] ) ? (int) $item['prod_reviews'] : 0,
		'in_stock'   => $item['prod_in_stock'] ?? 'yes',
	];
};

$products = [];

if ( 'custom' !== $product_type ) {
	$wc_count = absint( $settings['woo_product_count'] ?? 6 );
	if ( function_exists( 'wc_get_products' ) ) {
		$wc_args = $this->get_woo_query_args( $product_type, $wc_count );
		if ( ! empty( $wc_args ) ) {
			$wc_products = wc_get_products( $wc_args );
			foreach ( $wc_products as $wc_product ) {
				/** @var WC_Product $wc_product */
				$img_id   = $wc_product->get_image_id();
				$img_url  = '';
				$img_alt  = '';
				if ( $img_id ) {
					$img_url = wp_get_attachment_url( $img_id );
					$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
				}
				if ( empty( $img_url ) ) {
					$img_url = wc_placeholder_img_src( 'medium_large' );
				}
				if ( empty( $img_alt ) ) {
					$img_alt = $wc_product->get_name();
				}

				$badge_type = 'none';
				$badge_text = '';
				if ( $wc_product->is_on_sale() ) {
					$badge_type = 'sale';
					$regular    = $wc_product->get_regular_price();
					$sale       = $wc_product->get_sale_price();
					if ( '' !== $regular && '' !== $sale && $regular > 0 ) {
						$badge_text = '-' . round( ( (float) $regular - (float) $sale ) / (float) $regular * 100 ) . '%';
					} else {
						$badge_text = esc_html__( 'SALE', 'spiraclethemes-site-library' );
					}
				}

			$regular_price  = wc_price( $wc_product->get_regular_price() );
			$current_price  = wc_price( $wc_product->get_price() );

			$rating  = (float) $wc_product->get_average_rating();
			$reviews = (int) $wc_product->get_review_count();

			$products[] = [
				'image'      => [ 'id' => $img_id ? absint( $img_id ) : '', 'url' => $img_url, 'alt' => $img_alt ],
				'title'      => $wc_product->get_name(),
				'link'       => [ 'url' => $wc_product->get_permalink() ],
				'badge_type' => $badge_type,
				'badge_text' => $badge_text,
				'price'      => $current_price,
				'old_price'  => $wc_product->is_on_sale() ? $regular_price : '',
				'rating'     => $rating,
				'reviews'    => $reviews,
				'in_stock'   => $wc_product->is_in_stock() ? 'yes' : '',
			];
			}
		}
	}
}

// Custom mode OR WooCommerce fallback -> use manual repeater items.
if ( empty( $products ) ) {
	$manual_items = $settings['products'] ?? [];
	foreach ( $manual_items as $item ) {
		$products[] = $shopzen_pg_normalize( $item );
	}
}

/**
 * Render a star rating string based on a 0-5 float.
 * Rounds to the nearest whole star and returns 5 filled/empty unicode stars.
 *
 * @param float $rating
 * @return string
 */
$shopzen_pg_stars = function ( $rating ) {
	$full  = (int) round( $rating );
	$full  = max( 0, min( 5, $full ) );
	$empty = 5 - $full;
	return str_repeat( '★', $full ) . str_repeat( '☆', $empty );
};

$view_all_href       = ! empty( $view_all_link['url'] ) ? $view_all_link['url'] : '';
$view_all_target     = ! empty( $view_all_link['is_external'] ) ? ' target="_blank"' : '';
$view_all_nofollow   = ! empty( $view_all_link['nofollow'] ) ? ' rel="nofollow"' : '';
$view_all_attr_str   = trim( $view_all_target . ' ' . $view_all_nofollow );
?>
<section class="shopzen-pg shopzen-pg-<?php echo esc_attr( $id ); ?>" id="shopzen-pg-<?php echo esc_attr( $id ); ?>" data-type="<?php echo esc_attr( $product_type ); ?>">

	<?php if ( ! empty( $section_heading ) || ( 'yes' !== $hide_view_all && ! empty( $view_all_href ) && ! empty( $view_all_text ) ) ) : ?>
		<div class="shopzen-pg-head">
			<?php if ( ! empty( $section_heading ) ) : ?>
				<h2 class="shopzen-pg-title"><?php echo esc_html( $section_heading ); ?></h2>
			<?php endif; ?>

			<?php if ( 'yes' !== $hide_view_all && ! empty( $view_all_href ) && ! empty( $view_all_text ) ) : ?>
				<a class="shopzen-pg-viewall" href="<?php echo esc_url( $view_all_href ); ?>" <?php echo esc_attr( $view_all_attr_str ); ?>>
					<?php echo esc_html( $view_all_text ); ?>
					<svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M13 5l7 7-7 7"></path></svg>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="shopzen-pg-grid">

		<?php foreach ( $products as $item ) :
			$image      = $item['image'] ?? [];
			$title      = $item['title'] ?? '';
			$link       = $item['link'] ?? [];
			$badge_type = $item['badge_type'] ?? 'none';
			$badge_text = $item['badge_text'] ?? '';
			$price      = $item['price'] ?? '';
			$old_price  = $item['old_price'] ?? '';
			$rating     = isset( $item['rating'] ) ? (float) $item['rating'] : 0;
			$reviews    = isset( $item['reviews'] ) ? (int) $item['reviews'] : 0;
			$in_stock   = $item['in_stock'] ?? 'yes';

			$img_id  = $image['id'] ?? '';
			$img_url = $image['url'] ?? '';
			$alt     = ! empty( $image['alt'] ) ? $image['alt'] : $title;

			$href       = ! empty( $link['url'] ) ? esc_url( $link['url'] ) : '';
			$target     = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
			$nofollow   = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
			$attr_str   = trim( $target . ' ' . $nofollow );

			$card_tag   = ! empty( $href ) ? 'a' : 'div';
			$card_attrs = ! empty( $href ) ? ' href="' . esc_url( $href ) . '"' : '';
			if ( ! empty( $attr_str ) ) {
				$card_attrs .= ' ' . esc_attr( $attr_str );
			}

			$badge_class = 'shopzen-pg-badge' . ( 'new' === $badge_type ? ' new' : '' );
			?>

			<<?php echo esc_html( $card_tag ); ?> class="shopzen-pg-product"<?php echo $card_attrs; ?>>
				<div class="shopzen-pg-img">
					<?php if ( ! empty( $img_id ) ) :
						echo wp_get_attachment_image( absint( $img_id ), $image_size_key, false, [ 'class' => 'shopzen-pg-img-el', 'alt' => esc_attr( $alt ) ] );
					elseif ( ! empty( $img_url ) ) : ?>
						<img class="shopzen-pg-img-el" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
					<?php endif; ?>

					<?php if ( 'none' !== $badge_type && ! empty( $badge_text ) ) : ?>
						<span class="<?php echo esc_attr( $badge_class ); ?>"><?php echo esc_html( $badge_text ); ?></span>
					<?php endif; ?>

					<?php if ( 'yes' === $in_stock ) :
						/**
						 * In-stock tag — rendered as a real element here (rather than a CSS ::after
						 * on the image wrapper) so the "Show IN STOCK" style control can toggle it.
						 * The Control's selectors target .shopzen-pg-instock for display toggle.
						 */
					?>
						<span class="shopzen-pg-instock"><?php esc_html_e( 'IN STOCK', 'spiraclethemes-site-library' ); ?></span>
					<?php endif; ?>

					<?php if ( shopzen_is_wishlist_available() ) : ?>
						<button type="button" class="shopzen-pg-wishlist" aria-label="<?php esc_attr_e( 'Add to wishlist', 'spiraclethemes-site-library' ); ?>"><svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"></path></svg></button>
					<?php endif; ?>
				</div>
				<div class="shopzen-pg-info">
					<h3 class="shopzen-pg-ptitle"><?php echo esc_html( $title ); ?></h3>

					<?php if ( $rating > 0 || $reviews > 0 ) : ?>
						<div class="shopzen-pg-rating">
							<div class="shopzen-pg-stars"><?php echo esc_html( $shopzen_pg_stars( $rating ) ); ?></div>
							<?php if ( $reviews > 0 ) : ?>
								<span class="shopzen-pg-reviews"><?php echo esc_html( sprintf( '%.1f (%d)', $rating, $reviews ) ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<div class="shopzen-pg-price">
						<?php if ( '' !== $old_price ) : ?>
							<span class="shopzen-pg-price-now"><?php echo wp_kses_post( $price ); ?></span>
							<span class="shopzen-pg-price-old"><?php echo wp_kses_post( $old_price ); ?></span>
						<?php else : ?>
							<span class="shopzen-pg-price-now"><?php echo wp_kses_post( $price ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</<?php echo esc_html( $card_tag ); ?>>
		<?php endforeach; ?>

	</div>
</section>

<style>
	.shopzen-pg-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
		padding: 40px 0;
		background-color: #FCFCFB;
		background-image: radial-gradient(rgba(0, 0, 0, 0.035) 1px, transparent 1px);
		background-size: 16px 16px;
		border-top: 1px solid #F0EFEA;
		border-bottom: 1px solid #F0EFEA;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> *,
	.shopzen-pg-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-pg-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	/* Head */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-head {
		display: flex;
		align-items: end;
		justify-content: space-between;
		max-width: 1280px;
		margin: 0 auto 20px;
		padding: 0 16px;
		gap: 14px;
		flex-wrap: wrap;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-title {
		font-family: Outfit, sans-serif;
		font-size: 34px;
		font-weight: 800;
		margin: 0;
		color: #1A202C;
		line-height: 1.1em;
		letter-spacing: -0.5px;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-viewall {
		font-family: Inter, sans-serif;
		font-weight: 700;
		color: #3A5F3F;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 13px;
		border: 1px solid #E5E7EB;
		padding: 6px 12px;
		border-radius: 999px;
		background: #fff;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
		text-transform: uppercase;
		letter-spacing: 0.3px;
		text-decoration: none;
		transition: 0.2s;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-viewall:hover {
		color: #1E3F2A;
		transform: translateX(2px);
	}

	/* Grid */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-grid {
		display: grid;
		grid-template-columns: repeat(6, minmax(0, 1fr));
		gap: 12px;
		max-width: 1280px;
		margin: 0 auto;
		padding: 0 16px;
	}

	/* Product card */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-product {
		display: block;
		background: #fff;
		border-radius: 14px;
		overflow: hidden;
		border: 1px solid #E5E7EB;
		transition: 0.2s;
		position: relative;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
		text-decoration: none;
		width: 100%;
		height: 100%;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-product:hover {
		transform: translateY(-3px);
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
	}

	/* Image wrapper */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-img {
		position: relative;
		background: #F8F8F6;
		aspect-ratio: 1;
		overflow: hidden;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-img-el {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
		transition: transform 0.3s ease;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-product:hover .shopzen-pg-img .shopzen-pg-img-el {
		transform: scale(1.06);
	}

	/* In stock tag */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-instock {
		position: absolute;
		bottom: 6px;
		left: 6px;
		background: #fff;
		color: #065F46;
		font-family: Inter, sans-serif;
		font-size: 9px;
		font-weight: 800;
		padding: 3px 6px;
		border-radius: 4px;
		border: 1px solid #D1FAE5;
		letter-spacing: 0.4px;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
		z-index: 2;
		pointer-events: none;
		line-height: 1;
		display: inline-block;
	}

	/* Badge */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-badge {
		position: absolute;
		top: 7px;
		left: 7px;
		background: #1E3F2A;
		color: #fff;
		font-family: Inter, sans-serif;
		font-size: 10px;
		font-weight: 800;
		padding: 4px 7px;
		border-radius: 999px;
		border: 1px solid rgba(0, 0, 0, 0.08);
		letter-spacing: 0.3px;
		text-transform: uppercase;
		z-index: 3;
		line-height: 1;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-badge.new {
		background: #3A5F3F;
	}

	/* Wishlist */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-wishlist {
		position: absolute;
		top: 7px;
		right: 7px;
		width: 28px;
		height: 28px;
		background: #fff;
		border: 1px solid #E5E7EB;
		border-radius: 50%;
		display: grid;
		place-items: center;
		box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
		color: #6B7280;
		transition: 0.2s;
		cursor: pointer;
		padding: 0;
		z-index: 3;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-wishlist:hover {
		color: #E11D48;
		transform: scale(1.05);
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-wishlist.active {
		color: #E11D48;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-wishlist.active svg {
		fill: #E11D48;
	}

	/* Product info */
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-info {
		padding: 10px 11px 13px;
		font-family: Inter, sans-serif;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-ptitle {
		font-weight: 700;
		font-size: 13px;
		margin: 0 0 4px;
		color: #111827;
		line-height: 1.3;
		text-decoration: none;
		display: block;
		font-family: Inter, sans-serif;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-ptitle:hover {
		color: #3A5F3F;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-rating {
		display: flex;
		align-items: center;
		gap: 4px;
		font-size: 11px;
		color: #6B7280;
		margin-bottom: 6px;
		font-weight: 600;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-stars {
		color: #F59E0B;
		display: flex;
		gap: 1px;
		letter-spacing: 1px;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-reviews {
		color: #6B7280;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-price {
		display: flex;
		align-items: baseline;
		gap: 6px;
		flex-wrap: wrap;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-price-now {
		font-weight: 800;
		font-size: 15px;
		color: #1E3F2A;
		font-family: Inter, sans-serif;
		text-decoration: none;
	}
	
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-price-now ins,
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-price-now .amount,
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-price del {
		text-decoration: none;
	}
	.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-price-old {
		text-decoration: line-through;
		color: #9CA3AF;
		font-size: 11px;
		font-weight: 600;
		font-family: Inter, sans-serif;
	}

	/* Responsive */
	@media (max-width: 1100px) {
		.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
	}
	@media (max-width: 768px) {
		.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-title { font-size: 28px; }
		.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-head { flex-direction: column; align-items: flex-start; }
		.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
	}
	@media (max-width: 390px) {
		.shopzen-pg-<?php echo esc_attr( $id ); ?> .shopzen-pg-title { font-size: 24px; }
	}
</style>

<?php if ( shopzen_is_wishlist_available() ) : ?>
<script>
	(function () {
		var wrap = document.getElementById('shopzen-pg-<?php echo esc_js( $id ); ?>');
		if (!wrap) return;
		wrap.querySelectorAll('.shopzen-pg-wishlist').forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				btn.classList.toggle('active');
			});
		});
	})();
</script>
<?php endif; ?>
