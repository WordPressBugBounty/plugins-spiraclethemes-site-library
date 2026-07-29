<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Timeline Section - Frontend Render (Shop Zen)
 *
 * Centered vertical line with alternating year/content items. Each item has a
 * year (right-aligned, with a center node) beside its title + description.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings        = $this->get_settings_for_display();
$id              = $this->get_id();
$section_heading = $settings['section_heading'] ?? '';
$section_subtext = $settings['section_subtext'] ?? '';
$timeline_items  = $settings['timeline_items'] ?? [];
?>
<section class="shopzen-tl shopzen-tl-<?php echo esc_attr( $id ); ?>" id="shopzen-tl-<?php echo esc_attr( $id ); ?>">

	<?php if ( ! empty( $section_heading ) || ! empty( $section_subtext ) ) : ?>
		<div class="shopzen-tl-head">
			<?php if ( ! empty( $section_heading ) ) : ?>
				<h2 class="shopzen-tl-title"><?php echo esc_html( $section_heading ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $section_subtext ) ) : ?>
				<p class="shopzen-tl-sub"><?php echo esc_html( $section_subtext ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="shopzen-tl-timeline">

		<?php foreach ( $timeline_items as $item ) :
			$year  = $item['tl_year'] ?? '';
			$title = $item['tl_title'] ?? '';
			$desc  = $item['tl_description'] ?? '';
			?>
			<div class="shopzen-tl-item">
				<div class="shopzen-tl-year"><?php echo esc_html( $year ); ?></div>
				<div class="shopzen-tl-content">
					<?php if ( ! empty( $title ) ) : ?>
						<h4><?php echo esc_html( $title ); ?></h4>
					<?php endif; ?>
					<?php if ( ! empty( $desc ) ) : ?>
						<p><?php echo esc_html( $desc ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>

	</div>
</section>

<style>
	.shopzen-tl-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> *,
	.shopzen-tl-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-tl-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	/* Section head */
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-head {
		text-align: center;
		margin-bottom: 32px;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-title {
		font-family: Outfit, sans-serif;
		font-size: 36px;
		font-weight: 800;
		margin: 0 0 6px;
		color: #1A202C;
		position: relative;
		display: inline-block;
		padding: 0 26px;
		letter-spacing: -0.5px;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-title::before,
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-title::after {
		content: '\2022\2022\2022';
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		font-size: 9px;
		letter-spacing: 4px;
		color: #3A5F3F;
		opacity: 0.35;
		font-weight: 900;
		display: inline-block;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-title::before { left: 0; }
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-title::after { right: 0; }
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-sub {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 500;
		color: #6B7280;
		max-width: 560px;
		margin: 0 auto;
	}

	/* Timeline */
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-timeline {
		max-width: 900px;
		margin: 0 auto;
		padding: 0 16px;
		position: relative;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-timeline::before {
		content: '';
		position: absolute;
		left: 50%;
		top: 0;
		bottom: 0;
		width: 2px;
		background: #E5E7EB;
		transform: translateX(-1px);
	}

	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-item {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 40px;
		margin-bottom: 40px;
		position: relative;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-item:last-child {
		margin-bottom: 0;
	}

	/* Year */
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-year {
		font-family: Outfit, sans-serif;
		font-size: 22px;
		font-weight: 800;
		color: #3A5F3F;
		text-align: right;
		padding-right: 40px;
		position: relative;
		line-height: 1.2;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-year::after {
		content: '';
		position: absolute;
		right: -7px;
		top: 6px;
		width: 14px;
		height: 14px;
		background: #fff;
		border: 3px solid #3A5F3F;
		border-radius: 50%;
		box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
	}

	/* Content */
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-content {
		padding-left: 40px;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-content h4 {
		font-family: Outfit, sans-serif;
		font-size: 18px;
		font-weight: 800;
		margin: 0 0 6px;
		color: #1A202C;
		letter-spacing: -0.02em;
	}
	.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-content p {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 500;
		color: #4B5563;
		margin: 0;
		line-height: 1.6em;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-title {
			font-size: 28px;
		}
		.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-timeline::before { left: 20px; }
		.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-item {
			grid-template-columns: 1fr;
			gap: 0;
		}
		.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-year {
			text-align: left;
			padding-left: 48px;
			padding-right: 0;
			margin-bottom: 8px;
		}
		.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-year::after {
			left: 13px;
			right: auto;
		}
		.shopzen-tl-<?php echo esc_attr( $id ); ?> .shopzen-tl-content {
			padding-left: 48px;
		}
	}
</style>
