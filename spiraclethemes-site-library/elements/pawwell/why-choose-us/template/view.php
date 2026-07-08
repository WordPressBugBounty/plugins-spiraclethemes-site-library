<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Why Choose Us - Frontend Render
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
$columns           = $settings['columns'] ?? '3';
$hover             = $settings['hover_effect'] ?? 'yes';
$show_border_top   = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border = $settings['full_width_border'] ?? 'no';
$border_color      = $settings['border_color'] ?? '#E8E2DA';
$border_width      = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Border flags
$wrap_class  = 'pawwell-wcu pawwell-wcu-' . esc_attr( $id );
$wrap_class .= 'yes' === $hover ? ' pawwell-wcu-hover' : '';
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-wcu-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-wcu-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-wcu-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-wcu-inner">
		<?php if ( ! empty( $eyebrow ) || ! empty( $title ) || ! empty( $subtitle ) ) : ?>
			<div class="pawwell-wcu-head">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-wcu-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="pawwell-wcu-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $subtitle ) ) : ?>
					<p class="pawwell-wcu-sub"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="pawwell-wcu-grid pawwell-wcu-col-<?php echo esc_attr( $columns ); ?>">
				<?php foreach ( $items as $item ) :
					$i_title    = $item['item_title'] ?? '';
					$i_sub      = $item['item_subtitle'] ?? '';
					$i_bg       = $item['item_icon_bg'] ?? '#E8F0FE';
					$i_color    = $item['item_icon_color'] ?? '#2D9CDB';
					if ( '' === $i_title && '' === $i_sub ) {
						continue;
					}
					?>
					<div class="pawwell-wcu-card">
						<div class="pawwell-wcu-icon" style="background:<?php echo esc_attr( $i_bg ); ?>;color:<?php echo esc_attr( $i_color ); ?>">
							<?php
							if ( ! empty( $item['item_icon']['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] );
							}
							?>
						</div>
						<?php if ( ! empty( $i_title ) ) : ?>
							<div class="pawwell-wcu-value-title"><?php echo esc_html( $i_title ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $i_sub ) ) : ?>
							<div class="pawwell-wcu-value-sub"><?php echo esc_html( $i_sub ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> {
		padding: 80px 32px;
		background: #FAF7F2;
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?>.pawwell-wcu-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-wcu-<?php echo esc_attr( $id ); ?>.pawwell-wcu-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-wcu-<?php echo esc_attr( $id ); ?>.pawwell-wcu-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-inner {
		max-width: 1280px;
		margin: 0 auto;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-head {
		display: flex;
		flex-direction: column;
		margin-bottom: 44px;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-eyebrow {
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.5px;
		color: #C45B3E;
		margin-bottom: 10px;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-title {
		font-weight: 800;
		color: #1E1E1E;
		margin: 0 0 12px;
		line-height: 1.2;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-sub {
		color: #8A8A8A;
		margin: 0;
		max-width: 540px;
		line-height: 1.6;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-grid {
		display: grid;
		grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);
		gap: 24px;
	}	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-card {
		text-align: center;
		padding: 38px 26px;
		background: #fff;
		border: 1px solid #E8E2DA;
		border-radius: 18px;
		transition: all .3s ease;
	}
	.pawwell-wcu-hover.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-card:hover {
		border-color: #F4E0DA;
		box-shadow: 0 16px 40px -18px rgba(0,0,0,0.18);
		transform: translateY(-4px);
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-icon {
		width: 68px;
		height: 68px;
		border-radius: 20px;
		margin: 0 auto 18px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-icon i,
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-icon svg {
		width: 32px;
		height: 32px;
		font-size: 32px;
		color: inherit;
		fill: currentColor;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-value-title {
		font-weight: 800;
		margin-bottom: 8px;
		color: #1E1E1E;
	}
	.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-value-sub {
		color: #8A8A8A;
		line-height: 1.6;
	}

	/* Responsive */
	@media (max-width: 767px) {
		.pawwell-wcu-<?php echo esc_attr( $id ); ?> {
			padding: 48px 20px;
		}
		.pawwell-wcu-<?php echo esc_attr( $id ); ?> .pawwell-wcu-title {
			font-size: 28px;
		}
	}
</style>
