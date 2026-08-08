<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Shop by Category Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings();
$id = $this->get_id();

// Settings
$show_header     = $settings['show_section_header'] ?? 'yes';
$section_tag     = $settings['section_tag'] ?? '';
$section_title   = $settings['section_title'] ?? '';
$section_subtitle = $settings['section_subtitle'] ?? '';
$category_list   = $settings['category_list'] ?? [];
$columns         = $settings['columns'] ?? '3';
?>

<div class="shopnex-categories-section shopnex-categories-<?php echo esc_attr( $id ); ?>">

	<?php if ( 'yes' === $show_header && ( ! empty( $section_tag ) || ! empty( $section_title ) || ! empty( $section_subtitle ) ) ) : ?>
		<div class="shopnex-section-header">
			<?php if ( ! empty( $section_tag ) ) : ?>
				<span class="shopnex-section-tag"><?php echo esc_html( $section_tag ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $section_title ) ) : ?>
				<h2 class="shopnex-section-title"><?php echo esc_html( $section_title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $section_subtitle ) ) : ?>
				<p class="shopnex-section-subtitle"><?php echo esc_html( $section_subtitle ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $category_list ) ) : ?>
		<div class="shopnex-categories-grid shopnex-columns-<?php echo esc_attr( $columns ); ?>">
			<?php foreach ( $category_list as $index => $item ) :
				$category_image = $item['category_image'] ?? [];
				$category_title = $item['category_title'] ?? '';
				$category_count = $item['category_count'] ?? '';
				$category_link  = $item['category_link'] ?? [];

				// Build link attributes
				$link_url      = ! empty( $category_link['url'] ) ? esc_url( $category_link['url'] ) : '';
				$link_target   = ! empty( $category_link['is_external'] ) ? ' target="_blank"' : '';
				$link_nofollow = ! empty( $category_link['nofollow'] ) ? ' rel="nofollow"' : '';

				// Image URL
				$image_url = '';
				if ( ! empty( $category_image['id'] ) ) {
					$image_url = wp_get_attachment_image_url( $category_image['id'], 'large' );
				} elseif ( ! empty( $category_image['url'] ) ) {
					$image_url = esc_url( $category_image['url'] );
				}

				$has_link = ! empty( $link_url );
				$wrapper_tag = $has_link ? 'a' : 'div';
				$link_attrs  = $has_link ? ' href="' . $link_url . '"' . $link_target . $link_nofollow : '';
			?>
				<div class="shopnex-category-card">
					<?php if ( $has_link ) : ?>
						<a href="<?php echo esc_url( $link_url ); ?>" class="shopnex-category-card-link"<?php echo esc_attr( $link_target . $link_nofollow ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $image_url ) ) : ?>
						<img
							class="shopnex-category-card-image"
							src="<?php echo esc_url( $image_url ); ?>"
							alt="<?php echo esc_attr( $category_title ); ?>"
							loading="lazy"
						>
					<?php endif; ?>

					<div class="shopnex-category-card-overlay"></div>

					<div class="shopnex-category-card-content">
						<?php if ( ! empty( $category_title ) ) : ?>
							<h3 class="shopnex-category-card-title"><?php echo esc_html( $category_title ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $category_count ) ) : ?>
							<span class="shopnex-category-card-count"><?php echo esc_html( $category_count ); ?></span>
						<?php endif; ?>
					</div>

					<?php if ( $has_link ) : ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>

<style>
	.shopnex-categories-section .shopnex-section-header {
		text-align: center;
		margin-bottom: 50px;
	}
	.shopnex-categories-section .shopnex-section-tag {
		font-size: 11px;
		text-transform: uppercase;
		letter-spacing: 0.1em;
		color: #B8977E;
		font-weight: 600;
		margin-bottom: 12px;
		display: block;
	}
	.shopnex-categories-section .shopnex-section-title {
		font-size: clamp(28px, 3.5vw, 40px);
		font-weight: 500;
		letter-spacing: -0.015em;
		color: #1C1C1C;
		margin-bottom: 12px;
		line-height: 1.2;
	}
	.shopnex-categories-section .shopnex-section-subtitle {
		font-size: 15px;
		color: #6B6560;
		font-weight: 400;
		max-width: 480px;
		margin: 0 auto;
		line-height: 1.5;
	}

	/* Grid */
	.shopnex-categories-section .shopnex-categories-grid {
		display: grid;
		gap: 20px;
	}
	.shopnex-categories-section .shopnex-columns-2 {
		grid-template-columns: repeat(2, 1fr);
	}
	.shopnex-categories-section .shopnex-columns-3 {
		grid-template-columns: repeat(3, 1fr);
	}
	.shopnex-categories-section .shopnex-columns-4 {
		grid-template-columns: repeat(4, 1fr);
	}

	/* Card */
	.shopnex-categories-section .shopnex-category-card {
		position: relative;
		border-radius: 10px;
		overflow: hidden;
		cursor: pointer;
		aspect-ratio: 3 / 4;
		background: #F3EFEA;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.shopnex-categories-section .shopnex-category-card:hover {
		box-shadow: 0 12px 40px rgba(28, 28, 28, 0.08);
		transform: translateY(-4px);
	}
	.shopnex-categories-section .shopnex-category-card-link {
		position: absolute;
		inset: 0;
		z-index: 3;
		display: block;
		text-decoration: none;
		color: inherit;
	}
	.shopnex-categories-section .shopnex-category-card-image {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.shopnex-categories-section .shopnex-category-card:hover .shopnex-category-card-image {
		transform: scale(1.06);
	}

	/* Card Overlay */
	.shopnex-categories-section .shopnex-category-card-overlay {
		position: absolute;
		inset: 0;
		background: linear-gradient(to top, rgba(28, 28, 28, 0.5) 0%, rgba(28, 28, 28, 0) 50%);
		z-index: 1;
	}

	/* Card Content */
	.shopnex-categories-section .shopnex-category-card-content {
		position: absolute;
		bottom: 0;
		left: 0;
		right: 0;
		padding: 28px;
		z-index: 2;
	}
	.shopnex-categories-section .shopnex-category-card-title {
		font-size: 22px;
		font-weight: 500;
		color: #fff;
		letter-spacing: -0.01em;
		margin-bottom: 4px;
		line-height: 1.3;
	}
	.shopnex-categories-section .shopnex-category-card-count {
		font-size: 12px;
		color: rgba(255, 255, 255, 0.7);
		letter-spacing: 0.03em;
	}

	/* Responsive */
	@media (max-width: 1024px) {
		.shopnex-categories-section .shopnex-columns-3,
		.shopnex-categories-section .shopnex-columns-4 {
			grid-template-columns: repeat(2, 1fr);
			gap: 16px;
		}
	}
	@media (max-width: 768px) {
		.shopnex-categories-section .shopnex-section-header {
			margin-bottom: 30px;
		}
		.shopnex-categories-section .shopnex-categories-grid {
			gap: 10px;
		}
		.shopnex-categories-section .shopnex-columns-2,
		.shopnex-categories-section .shopnex-columns-3,
		.shopnex-categories-section .shopnex-columns-4 {
			grid-template-columns: repeat(2, 1fr);
		}
		.shopnex-categories-section .shopnex-category-card-content {
			padding: 20px;
		}
		.shopnex-categories-section .shopnex-category-card-title {
			font-size: 18px;
		}
	}
	@media (max-width: 480px) {
		.shopnex-categories-section .shopnex-columns-2,
		.shopnex-categories-section .shopnex-columns-3,
		.shopnex-categories-section .shopnex-columns-4 {
			grid-template-columns: 1fr;
			gap: 10px;
		}
		.shopnex-categories-section .shopnex-category-card {
			aspect-ratio: 4 / 3;
		}
	}
</style>
