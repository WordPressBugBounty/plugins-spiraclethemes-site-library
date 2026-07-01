<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Visit & Hours - Frontend Render
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings           = $this->get_settings();
$id                 = $this->get_id();
$eyebrow            = $settings['eyebrow'] ?? '';
$title              = $settings['title'] ?? '';
$description        = $settings['description'] ?? '';
$hours              = $settings['hours'] ?? [];
$address_label      = $settings['address_label'] ?? '';
$address_text       = $settings['address_text'] ?? '';
$show_map           = $settings['show_map'] ?? 'yes';
$map_embed          = $settings['map_embed'] ?? '';
$layout             = $settings['layout'] ?? '2col';
$map_position       = $settings['map_position'] ?? 'left';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

$day_names = [
	'0' => __( 'Sunday', 'spiraclethemes-site-library' ),
	'1' => __( 'Monday', 'spiraclethemes-site-library' ),
	'2' => __( 'Tuesday', 'spiraclethemes-site-library' ),
	'3' => __( 'Wednesday', 'spiraclethemes-site-library' ),
	'4' => __( 'Thursday', 'spiraclethemes-site-library' ),
	'5' => __( 'Friday', 'spiraclethemes-site-library' ),
	'6' => __( 'Saturday', 'spiraclethemes-site-library' ),
];

$has_map = ( 'yes' === $show_map && '2col' === $layout && ! empty( $map_embed ) );

// Border flags — mirror the products-grid pattern.
$wrap_class  = 'pawwell-vh pawwell-vh-' . esc_attr( $id );
$wrap_class .= $has_map ? ' pawwell-vh-has-map' : '';
$wrap_class .= 'left' === $map_position ? ' pawwell-vh-map-left' : ' pawwell-vh-map-right';
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-vh-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-vh-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-vh-fullwidth' : '';

// Hours card markup (reused for both layouts).
ob_start();
?>
<div class="pawwell-vh-hours">
	<div class="pawwell-vh-decor" aria-hidden="true"></div>
	<div class="pawwell-vh-card-inner">
		<?php if ( ! empty( $eyebrow ) || ! empty( $title ) || ! empty( $description ) ) : ?>
			<div class="pawwell-vh-head">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-vh-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h3 class="pawwell-vh-title"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
				<?php if ( ! empty( $description ) ) : ?>
					<p class="pawwell-vh-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $hours ) ) : ?>
			<div class="pawwell-vh-list">
				<?php foreach ( $hours as $row ) :
					$day       = $row['day'] ?? '1';
					$day_label = $day_names[ $day ] ?? '';
					$is_closed = ( 'yes' === ( $row['is_closed'] ?? 'no' ) );
					$row_hours = $row['hours'] ?? '';
					?>
					<div class="pawwell-vh-row<?php echo $is_closed ? ' closed' : ''; ?>" data-day="<?php echo esc_attr( $day ); ?>">
						<span class="pawwell-vh-day"><?php echo esc_html( $day_label ); ?></span>
						<span class="pawwell-vh-time">
							<?php echo esc_html( $is_closed ? __( 'Closed', 'spiraclethemes-site-library' ) : $row_hours ); ?>
						</span>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $address_label ) || ! empty( $address_text ) ) : ?>
			<div class="pawwell-vh-address">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-6 7-11a7 7 0 0 0-14 0c0 5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
				<div>
					<?php if ( ! empty( $address_label ) ) : ?>
						<strong><?php echo esc_html( $address_label ); ?></strong>
					<?php endif; ?>
					<?php if ( ! empty( $address_text ) ) : ?>
						<p><?php echo wp_kses_post( nl2br( esc_html( $address_text ) ) ); ?></p>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<?php
$hours_html = ob_get_clean();
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-vh-inner">
		<div class="pawwell-vh-grid">

			<?php if ( $has_map ) : ?>
				<?php if ( 'left' === $map_position ) : ?>
					<div class="pawwell-vh-map">
						<iframe src="<?php echo esc_url( $map_embed ); ?>" title="<?php esc_attr_e( 'Store location map', 'spiraclethemes-site-library' ); ?>" loading="lazy"></iframe>
					</div>
					<?php echo $hours_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				<?php else : ?>
					<?php echo $hours_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="pawwell-vh-map">
						<iframe src="<?php echo esc_url( $map_embed ); ?>" title="<?php esc_attr_e( 'Store location map', 'spiraclethemes-site-library' ); ?>" loading="lazy"></iframe>
					</div>
				<?php endif; ?>
			<?php else : ?>
				<?php echo $hours_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.pawwell-vh-<?php echo esc_attr( $id ); ?> {
		position: relative;
		padding: 80px 32px;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?>.pawwell-vh-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-vh-<?php echo esc_attr( $id ); ?>.pawwell-vh-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-vh-<?php echo esc_attr( $id ); ?>.pawwell-vh-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-inner {
		max-width: 1380px;
		margin: 0 auto;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 28px;
		align-items: stretch;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?>:not(.pawwell-vh-has-map) .pawwell-vh-grid {
		grid-template-columns: 1fr;
		max-width: 760px;
		margin: 0 auto;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-map {
		border-radius: 16px;
		overflow: hidden;
		border: 1px solid #E8E2DA;
		min-height: 420px;
		background: #EFE9E2;
		position: relative;
		box-shadow: 0 6px 18px -10px rgba(0,0,0,0.12);
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-map iframe {
		width: 100%;
		height: 100%;
		min-height: 420px;
		border: 0;
		display: block;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-hours {
		border-radius: 16px;
		padding: 36px;
		color: #fff;
		position: relative;
		overflow: hidden;
		display: flex;
		flex-direction: column;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-decor {
		position: absolute;
		width: 320px;
		height: 320px;
		border-radius: 50%;
		background: #C45B3E;
		opacity: 0.1;
		top: -120px;
		right: -90px;
		pointer-events: none;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-card-inner {
		position: relative;
		z-index: 1;
		display: flex;
		flex-direction: column;
		height: 100%;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-head {
		margin-bottom: 28px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-eyebrow {
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.5px;
		margin-bottom: 10px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-title {
		font-weight: 700;
		font-size: 30px;
		line-height: 1.15;
		margin: 0 0 10px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-desc {
		font-size: 15px;
		line-height: 1.7;
		margin: 0;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-list {
		display: flex;
		flex-direction: column;
		gap: 2px;
		margin-bottom: 28px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-row {
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 14px 0;
		border-bottom: 1px solid rgba(255,255,255,0.08);
		font-size: 15px;
		transition: background .2s ease, padding .2s ease, margin .2s ease;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-row:last-child {
		border-bottom: none;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-day {
		font-weight: 500;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-time {
		font-weight: 700;
		display: inline-flex;
		align-items: center;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-row.today {
		background: rgba(255,255,255,0.05);
		border-radius: 8px;
		padding-left: 12px;
		padding-right: 12px;
		margin: 0 -12px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-badge {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 12px;
		font-weight: 700;
		padding: 4px 12px;
		border-radius: 999px;
		margin-left: 10px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-badge svg {
		width: 13px;
		height: 13px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-address {
		margin-top: auto;
		padding-top: 24px;
		border-top: 1px solid rgba(255,255,255,0.1);
		display: flex;
		align-items: flex-start;
		gap: 12px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-address svg {
		width: 20px;
		height: 20px;
		color: #C45B3E;
		flex-shrink: 0;
		margin-top: 2px;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-address strong {
		display: block;
		font-size: 12px;
		text-transform: uppercase;
		letter-spacing: 0.08em;
		color: rgba(255,255,255,0.5);
		margin-bottom: 4px;
		font-weight: 700;
	}
	.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-address p {
		font-size: 15px;
		color: rgba(255,255,255,0.9);
		line-height: 1.6;
		margin: 0;
	}

	@media (max-width: 900px) {
		.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-grid {
			grid-template-columns: 1fr;
		}
	}
	@media (max-width: 767px) {
		.pawwell-vh-<?php echo esc_attr( $id ); ?> {
			padding: 48px 20px;
		}
		.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-hours {
			padding: 28px 24px;
		}
		.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-title {
			font-size: 24px;
		}
		.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-map {
			min-height: 300px;
		}
		.pawwell-vh-<?php echo esc_attr( $id ); ?> .pawwell-vh-map iframe {
			min-height: 300px;
		}
	}
</style>

<script>
(function() {
	var root = document.querySelector('.pawwell-vh-<?php echo esc_js( $id ); ?>');
	if (!root) return;

	var today = new Date().getDay(); // 0 = Sunday.
	var row = root.querySelector('.pawwell-vh-row[data-day="' + today + '"]');
	if (row) {
		row.classList.add('today');
		var time = row.querySelector('.pawwell-vh-time');
		if (time) {
			var badge = document.createElement('span');
			badge.className = 'pawwell-vh-badge';
			badge.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg> <?php echo esc_js( __( 'Today', 'spiraclethemes-site-library' ) ); ?>';
			time.appendChild(badge);
		}
	}
})();
</script>
