<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Our Journey (Timeline) - Frontend Render
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings          = $this->get_settings();
$id                = $this->get_id();
$items             = $settings['items'] ?? [];
$eyebrow           = $settings['eyebrow'] ?? '';
$title             = $settings['title'] ?? '';
$subtitle          = $settings['subtitle'] ?? '';
$hover             = $settings['hover_effect'] ?? 'yes';
$show_border_top   = $settings['show_border_top'] ?? 'yes';
$show_border_bottom = $settings['show_border_bottom'] ?? 'yes';
$full_width_border = $settings['full_width_border'] ?? 'no';
$border_color      = $settings['border_color'] ?? '#E8E2DA';
$border_width      = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Border flags.
$wrap_class  = 'pawwell-oj pawwell-oj-' . esc_attr( $id );
$wrap_class .= 'yes' === $hover ? ' pawwell-oj-hover' : '';
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-oj-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-oj-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-oj-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-oj-inner">
		<?php if ( ! empty( $eyebrow ) || ! empty( $title ) || ! empty( $subtitle ) ) : ?>
			<div class="pawwell-oj-head">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-oj-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="pawwell-oj-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $subtitle ) ) : ?>
					<p class="pawwell-oj-sub"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="pawwell-oj-timeline">
				<?php foreach ( $items as $index => $item ) :
					$i_year  = $item['item_year'] ?? '';
					$i_title = $item['item_title'] ?? '';
					$i_desc  = $item['item_desc'] ?? '';
					if ( '' === $i_year && '' === $i_title && '' === $i_desc ) {
						continue;
					}
					?>
					<div class="pawwell-oj-item">
						<div class="pawwell-oj-dot" aria-hidden="true"></div>
						<div class="pawwell-oj-content">
							<?php if ( ! empty( $i_year ) ) : ?>
								<div class="pawwell-oj-year"><?php echo esc_html( $i_year ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $i_title ) ) : ?>
								<div class="pawwell-oj-item-title"><?php echo esc_html( $i_title ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $i_desc ) ) : ?>
								<div class="pawwell-oj-item-desc"><?php echo esc_html( $i_desc ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-oj-<?php echo esc_attr( $id ); ?> {
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?>.pawwell-oj-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-oj-<?php echo esc_attr( $id ); ?>.pawwell-oj-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-oj-<?php echo esc_attr( $id ); ?>.pawwell-oj-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-inner {
		max-width: 1380px;
		margin: 0 auto;
		padding: 0 32px;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-head {
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-eyebrow {
		margin-bottom: 10px;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-title {
		letter-spacing: -0.02em;
		line-height: 1.1;
		margin: 0 0 8px;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-sub {
		margin: 0;
	}

	/* Timeline */
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-timeline {
		position: relative;
		max-width: 900px;
		margin: 0 auto;
		padding: 20px 0;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-timeline::before {
		content: '';
		position: absolute;
		left: 50%;
		top: 0;
		bottom: 0;
		width: 2px;
		background: var(--pawwell-oj-line, #E8E2DA);
		transform: translateX(-50%);
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item {
		position: relative;
		width: 50%;
		padding: 0 40px 48px 0;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item:last-child {
		padding-bottom: 0;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item:nth-child(even) {
		left: 50%;
		padding: 0 0 48px 40px;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-dot {
		position: absolute;
		right: -9px;
		top: 4px;
		width: 18px;
		height: 18px;
		border-radius: 50%;
		background: #FFFFFF;
		border: 3px solid #C45B3E;
		z-index: 2;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item:nth-child(even) .pawwell-oj-dot {
		left: -9px;
		right: auto;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-content {
		border: 1px solid #E8E2DA;
		border-radius: 12px;
		padding: 24px;
		background: #FFFFFF;
		transition: all .3s ease;
	}
	.pawwell-oj-hover.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-content:hover {
		box-shadow: 0 12px 32px rgba(30,30,30,.08);
		transform: translateY(-2px);
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-year {
		margin-bottom: 8px;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item-title {
		margin-bottom: 6px;
	}
	.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item-desc {
		line-height: 1.6;
	}

	/* Responsive */
	@media (max-width: 920px) {
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-timeline::before {
			left: 20px;
		}
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item,
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item:nth-child(even) {
			width: 100%;
			left: 0;
			padding: 0 0 40px 56px;
		}
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-dot,
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-item:nth-child(even) .pawwell-oj-dot {
			left: 11px;
			right: auto;
		}
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-title {
			font-size: 36px;
		}
	}
	@media (max-width: 640px) {
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-inner {
			padding: 0 20px;
		}
		.pawwell-oj-<?php echo esc_attr( $id ); ?> .pawwell-oj-title {
			font-size: 30px;
		}
	}
</style>
