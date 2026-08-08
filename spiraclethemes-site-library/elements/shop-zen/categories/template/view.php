<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Categories Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings_for_display();
$id       = $this->get_id();

$section_heading = $settings['section_heading'] ?? '';
$section_subtext = $settings['section_subtext'] ?? '';
$categories      = $settings['categories'] ?? [];

$settings_obj = $this->get_settings();
$image_size_key = ! empty( $settings_obj['cat_image_size_size'] ) ? $settings_obj['cat_image_size_size'] : 'medium_large';
?>
<section class="shopzen-cat shopzen-cat-<?php echo esc_attr( $id ); ?>" id="shopzen-cat-<?php echo esc_attr( $id ); ?>">

	<?php if ( ! empty( $section_heading ) || ! empty( $section_subtext ) ) : ?>
		<div class="shopzen-cat-head">
			<?php if ( ! empty( $section_heading ) ) : ?>
				<h2 class="shopzen-cat-title"><?php echo esc_html( $section_heading ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $section_subtext ) ) : ?>
				<p class="shopzen-cat-sub"><?php echo esc_html( $section_subtext ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="shopzen-cat-wrap">
		<div class="shopzen-cat-grid">

			<?php foreach ( $categories as $item ) :
				$label = $item['cat_label'] ?? '';
				$image = $item['cat_image'] ?? [];
				$link  = $item['cat_link'] ?? [];

				$img_id  = $image['id'] ?? '';
				$img_url = $image['url'] ?? '';

				$href       = ! empty( $link['url'] ) ? esc_url( $link['url'] ) : '';
				$target     = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
				$nofollow   = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
				$attr_str   = trim( $target . ' ' . $nofollow );

				$card_tag   = ! empty( $href ) ? 'a' : 'div';
				$card_attrs = ! empty( $href ) ? ' href="' . esc_url( $href ) . '"' : '';
				if ( ! empty( $attr_str ) ) {
					$card_attrs .= ' ' . esc_attr( $attr_str );
				}

				$alt = ! empty( $image['alt'] ) ? $image['alt'] : $label;
				?>

				<<?php echo esc_html( $card_tag ); ?> class="shopzen-cat-card"<?php echo $card_attrs; ?>>
					<?php if ( ! empty( $img_id ) ) :
						echo wp_get_attachment_image( absint( $img_id ), $image_size_key, false, [ 'class' => 'shopzen-cat-img', 'alt' => esc_attr( $alt ) ] );
					elseif ( ! empty( $img_url ) ) : ?>
						<img class="shopzen-cat-img" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
					<?php else : ?>
						<img class="shopzen-cat-img shopzen-cat-img-placeholder" src="<?php echo esc_url( \Elementor\Utils::get_placeholder_image_src() ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
					<?php endif; ?>

					<?php if ( ! empty( $label ) ) : ?>
						<span class="shopzen-cat-label"><?php echo esc_html( $label ); ?></span>
					<?php endif; ?>
				</<?php echo esc_html( $card_tag ); ?>>

			<?php endforeach; ?>

		</div>
	</div>
</section>

<style>
	.shopzen-cat-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
		padding: 40px 0;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> *,
	.shopzen-cat-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-cat-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	/* Section head */
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-head {
		text-align: center;
		margin-bottom: 26px;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title {
		font-family: Outfit, sans-serif;
		font-size: 34px;
		font-weight: 800;
		margin: 0 0 5px;
		color: #1A202C;
		line-height: 1.1em;
		letter-spacing: -0.5px;
		position: relative;
		display: inline-block;
		padding: 0 26px;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title::before,
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title::after {
		content: '•••';
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		font-size: 9px;
		letter-spacing: 4px;
		color: #3A5F3F;
		opacity: .35;
		font-weight: 900;
		display: inline-block;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title::before { left: 0; }
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title::after { right: 0; }
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-sub {
		font-family: Inter, sans-serif;
		font-size: 13px;
		font-weight: 500;
		color: #6B7280;
		max-width: 560px;
		margin: 0 auto;
		line-height: 1.6em;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-wrap {
		position: relative;
		max-width: 1280px;
		margin: 0 auto;
		width: 100%;
	}

	/* Grid */
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-grid {
		display: grid;
		grid-template-columns: repeat(6, minmax(0, 1fr));
		gap: 12px;
	}

	/* Card */
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-card {
		position: relative;
		display: block;
		overflow: hidden;
		aspect-ratio: 4 / 5;
		background: #F6F6F6;
		border: 1px solid #E5E7EB;
		border-radius: 14px;
		box-shadow: 0 4px 16px rgba(0,0,0,0.08);
		cursor: pointer;
		transition: transform .2s ease, box-shadow .2s ease;
		text-decoration: none;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-card:hover {
		transform: translateY(-2px);
		box-shadow: 0 4px 16px rgba(0,0,0,0.12);
	}

	/* Image */
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-card img.shopzen-cat-img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
		transition: transform .3s ease;
	}
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-card:hover img.shopzen-cat-img {
		transform: scale(1.06);
	}
	/* Label pill */
	.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-label {
		position: absolute;
		left: 50%;
		bottom: 10px;
		transform: translateX(-50%);
		background: #fff;
		padding: 6px 14px;
		border-radius: 999px;
		font-family: Inter, sans-serif;
		font-size: 11px;
		font-weight: 700;
		color: #1F2937;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		box-shadow: 0 4px 12px rgba(0,0,0,0.1);
		white-space: nowrap;
		border: 1px solid #E5E7EB;
		z-index: 2;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title { font-size: 28px; }
		.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title::before,
		.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title::after { display: none; }
	}
	@media (max-width: 480px) {
		.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-title { font-size: 24px; }
		.shopzen-cat-<?php echo esc_attr( $id ); ?> .shopzen-cat-wrap { padding: 0 12px; }
	}
</style>
