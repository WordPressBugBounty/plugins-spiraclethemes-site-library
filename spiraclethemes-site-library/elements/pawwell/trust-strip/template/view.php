<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Trust Strip
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings      = $this->get_settings();
$id            = $this->get_id();
$items         = $settings['items'] ?? [];
$show_dividers = $settings['show_dividers'] ?? 'yes';
$border_top    = $settings['border_top'] ?? 'yes';
$border_bottom = $settings['border_bottom'] ?? 'yes';
$full_width    = $settings['full_width'] ?? 'yes';

$wrap_class  = 'pawwell-ts';
$wrap_class .= ' pawwell-ts-' . esc_attr( $id );
$wrap_class .= 'yes' === $border_top ? ' pawwell-ts-bt' : '';
$wrap_class .= 'yes' === $border_bottom ? ' pawwell-ts-bb' : '';
$wrap_class .= 'yes' === $full_width ? ' pawwell-ts-fullwidth' : '';
?>

<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-ts-inner">
		<?php foreach ( $items as $index => $item ) :
			$i_title    = $item['item_title'] ?? '';
			$i_sub      = $item['item_subtitle'] ?? '';
			$i_bg       = $item['item_icon_bg'] ?? '#F4E0DA';
			$i_color    = $item['item_icon_color'] ?? '#C45B3E';
			$is_last    = ( $index === count( $items ) - 1 );
			$item_class = $is_last || 'yes' !== $show_dividers ? ' pawwell-ts-item-no-divider' : '';
			if ( '' === $i_title && '' === $i_sub ) {
				continue;
			}
			?>
			<div class="pawwell-ts-item<?php echo esc_attr( $item_class ); ?>">
				<span class="pawwell-ts-icon" style="background:<?php echo esc_attr( $i_bg ); ?>;color:<?php echo esc_attr( $i_color ); ?>">
					<?php
					if ( ! empty( $item['item_icon']['value'] ) ) {
						\Elementor\Icons_Manager::render_icon( $item['item_icon'], [ 'aria-hidden' => 'true' ] );
					}
					?>
				</span>
				<span class="pawwell-ts-text">
					<?php if ( ! empty( $i_title ) ) : ?>
						<strong class="pawwell-ts-title"><?php echo esc_html( $i_title ); ?></strong>
					<?php endif; ?>
					<?php if ( ! empty( $i_sub ) ) : ?>
						<small class="pawwell-ts-sub"><?php echo esc_html( $i_sub ); ?></small>
					<?php endif; ?>
				</span>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<style>
	.pawwell-ts-<?php echo esc_attr( $id ); ?> {
		background: #fff;
		position: relative;
		z-index: 3;
		border: 0 solid #E8E2DA;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?>.pawwell-ts-bt { border-top-width: 1px; }
	.pawwell-ts-<?php echo esc_attr( $id ); ?>.pawwell-ts-bb { border-bottom-width: 1px; }
	.pawwell-ts-<?php echo esc_attr( $id ); ?>.pawwell-ts-fullwidth { width: 100vw; margin-left: calc(50% - 50vw); margin-right: calc(50% - 50vw); }
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-inner {
		max-width: 1380px;
		margin: 0 auto;
		padding: 0 32px;
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 0;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-item {
		display: flex;
		align-items: center;
		gap: 14px;
		padding: 22px 0;
		justify-content: center;
		position: relative;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-item:not(.pawwell-ts-item-no-divider)::after {
		content: '';
		position: absolute;
		right: 0;
		top: 50%;
		transform: translateY(-50%);
		width: 1px;
		height: 28px;
		background: #E8E2DA;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-icon {
		width: 44px;
		height: 44px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-icon i,
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-icon svg {
		width: 22px;
		height: 22px;
		font-size: 22px;
		color: inherit;
		fill: currentColor;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-text {
		display: flex;
		flex-direction: column;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-title {
		display: block;
		font-weight: 700;
		color: #1E1E1E;
	}
	.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-sub {
		color: #8A8A8A;
		margin-top: 2px;
	}

	/* Responsive */
	@media (max-width: 920px) {
		.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-inner {
			grid-template-columns: 1fr 1fr;
		}
	}
	@media (max-width: 640px) {
		.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-inner {
			grid-template-columns: 1fr;
		}
		.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-item {
			justify-content: center;
			padding: 12px 0;
		}
		.pawwell-ts-<?php echo esc_attr( $id ); ?> .pawwell-ts-item:not(.pawwell-ts-item-no-divider)::after {
			display: none;
		}
	}
</style>
