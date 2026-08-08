<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Deal of the Day
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings      = $this->get_settings();
$id            = $this->get_id();

$eyebrow       = $settings['eyebrow'] ?? '';
$title         = $settings['title'] ?? '';
$description   = $settings['description'] ?? '';
$btn_text      = $settings['btn_text'] ?? '';
$btn_url       = $settings['btn_url'] ?? [];
$due_date      = $settings['due_date'] ?? '';
$show_days     = $settings['show_days'] ?? 'yes';
$show_hours    = $settings['show_hours'] ?? 'yes';
$show_minutes  = $settings['show_minutes'] ?? 'yes';
$show_seconds  = $settings['show_seconds'] ?? 'yes';
$expire_msg    = $settings['expire_message'] ?? '';
$show_circles  = $settings['decorative_circles'] ?? 'yes';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

$btn_link     = ! empty( $btn_url['url'] ) ? esc_url( $btn_url['url'] ) : '#';
$btn_target   = ! empty( $btn_url['is_external'] ) ? ' target="_blank"' : '';
$btn_nofollow = ! empty( $btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

// Border flags — CSS borders on the section + vw-breakout for full width.
$wrap_class  = 'pawwell-dod pawwell-dod-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-dod-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-dod-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-dod-fullwidth' : '';

// Convert due date to a Unix timestamp (ms) for the JS countdown.
$due_ts = 0;
if ( ! empty( $due_date ) ) {
	$due_ts = strtotime( $due_date . ' +0000' );
	if ( ! $due_ts ) {
		// Fallback: treat as site-local time.
		$due_ts = strtotime( $due_date );
	}
}
$due_ms = $due_ts ? ( $due_ts * 1000 ) : 0;

// SVG icons.
$zap_svg   = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13 2 3 14h7l-1 8 10-12h-7z"/></svg>';
$arrow_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>';

$circle_class = 'yes' === $show_circles ? ' pawwell-dod-banner--circles' : '';
?>

<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-dod-inner">
		<div class="pawwell-dod-banner<?php echo esc_attr( $circle_class ); ?>"
			data-due="<?php echo esc_attr( $due_ms ); ?>"
			data-expire="<?php echo esc_attr( $expire_msg ); ?>">
		<div class="pawwell-dod-content">
			<div class="pawwell-dod-heading">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-dod-eyebrow"><?php echo $zap_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><span><?php echo esc_html( $eyebrow ); ?></span></div>
				<?php endif; ?>

				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="pawwell-dod-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="pawwell-dod-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( $due_ms ) : ?>
				<div class="pawwell-dod-countdown" role="timer" aria-live="off">
					<?php if ( 'yes' === $show_days ) : ?>
						<div class="pawwell-dod-box">
							<strong class="pawwell-dod-number" data-unit="days">00</strong>
							<span class="pawwell-dod-unit"><?php esc_html_e( 'Days', 'spiraclethemes-site-library' ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_hours ) : ?>
						<div class="pawwell-dod-box">
							<strong class="pawwell-dod-number" data-unit="hours">00</strong>
							<span class="pawwell-dod-unit"><?php esc_html_e( 'Hours', 'spiraclethemes-site-library' ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_minutes ) : ?>
						<div class="pawwell-dod-box">
							<strong class="pawwell-dod-number" data-unit="minutes">00</strong>
							<span class="pawwell-dod-unit"><?php esc_html_e( 'Mins', 'spiraclethemes-site-library' ); ?></span>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_seconds ) : ?>
						<div class="pawwell-dod-box">
							<strong class="pawwell-dod-number" data-unit="seconds">00</strong>
							<span class="pawwell-dod-unit"><?php esc_html_e( 'Secs', 'spiraclethemes-site-library' ); ?></span>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $btn_text ) ) : ?>
				<a class="pawwell-dod-btn" href="<?php echo esc_url( $btn_link ); ?>"<?php echo esc_attr( $btn_target . $btn_nofollow ); ?>>
					<?php echo esc_html( $btn_text ); ?>
					<?php echo $arrow_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</a>
			<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<style>
	.pawwell-dod-<?php echo esc_attr( $id ); ?> {
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?>.pawwell-dod-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-dod-<?php echo esc_attr( $id ); ?>.pawwell-dod-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	
	.pawwell-dod-<?php echo esc_attr( $id ); ?>.pawwell-dod-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner {
		position: relative;
		overflow: hidden;
		background: #1E1E1E;
		color: #fff;
		border-radius: 20px;
		padding: 56px 60px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-inner {
		max-width: 1380px;
		margin: 0 auto;
		padding: 80px 32px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner--circles::before,
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner--circles::after {
		content: '';
		position: absolute;
		border-radius: 50%;
		pointer-events: none;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner--circles::before {
		width: 500px;
		height: 500px;
		background: #C45B3E;
		opacity: 0.08;
		top: -200px;
		right: -100px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner--circles::after {
		width: 400px;
		height: 400px;
		background: #7B8F6B;
		opacity: 0.06;
		bottom: -150px;
		left: -100px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-content {
		position: relative;
		z-index: 1;
		max-width: 560px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-eyebrow {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.1em;
		color: #C45B3E;
		margin-bottom: 14px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-eyebrow svg {
		width: 16px;
		height: 16px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-title {
		font-weight: 400;
		line-height: 1.15;
		letter-spacing: -0.01em;
		color: #fff;
		margin: 0 0 14px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-desc {
		font-size: 16px;
		line-height: 1.7;
		color: rgba(255,255,255,0.7);
		margin: 0 0 24px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-countdown {
		display: flex;
		flex-wrap: wrap;
		gap: 12px;
		margin-bottom: 28px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-box {
		background: rgba(255,255,255,0.08);
		border: 1px solid rgba(255,255,255,0.1);
		border-radius: 12px;
		padding: 14px 18px;
		text-align: center;
		min-width: 72px;
		backdrop-filter: blur(10px);
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-number {
		display: block;
		font-size: 28px;
		font-weight: 800;
		color: #fff;
		line-height: 1.1;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-unit {
		display: block;
		font-size: 11px;
		text-transform: uppercase;
		letter-spacing: 0.08em;
		color: rgba(255,255,255,0.7);
		margin-top: 2px;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-btn {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		padding: 14px 32px;
		font-size: 14px;
		font-weight: 600;
		text-decoration: none;
		color: #fff;
		background: #C45B3E;
		border-radius: 50px;
		border: none;
		cursor: pointer;
		box-shadow: 0 4px 16px rgba(196,91,62,0.3);
		transition: transform .3s cubic-bezier(0.4,0,0.2,1), box-shadow .3s, background .3s;
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-btn svg {
		width: 16px;
		height: 16px;
		transition: transform .3s cubic-bezier(0.4,0,0.2,1);
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-btn:hover {
		background: #A84A30;
		transform: translateY(-2px);
		box-shadow: 0 8px 24px rgba(196,91,62,0.35);
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-btn:hover svg {
		transform: translateX(3px);
	}
	.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-expired {
		font-size: 18px;
		font-weight: 600;
		color: #fff;
		margin-bottom: 28px;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner { padding: 40px 28px; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-box { min-width: 60px; padding: 10px; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-number { font-size: 22px; }
	}
	@media (max-width: 480px) {
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner { padding: 25px !important; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-inner { padding-left: 20px; padding-right: 20px; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-countdown { gap: 8px; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-box { min-width: 0; flex: 1; padding: 10px 6px; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-number { font-size: 20px; }
		.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-unit { font-size: 10px; }
	}
</style>

<script>
(function() {
	var banner = document.querySelector('.pawwell-dod-<?php echo esc_attr( $id ); ?> .pawwell-dod-banner');
	if (!banner) return;

	var due = parseInt(banner.getAttribute('data-due'), 10);
	if (!due) return;

	var expireMsg = banner.getAttribute('data-expire');
	var countdown = banner.querySelector('.pawwell-dod-countdown');
	var els = {
		days:    banner.querySelector('[data-unit="days"]'),
		hours:   banner.querySelector('[data-unit="hours"]'),
		minutes: banner.querySelector('[data-unit="minutes"]'),
		seconds: banner.querySelector('[data-unit="seconds"]')
	};

	function pad(n) { return n < 10 ? '0' + n : '' + n; }

	function tick() {
		var remaining = due - Date.now();
		if (remaining <= 0) {
			if (countdown) {
				var expiredEl = document.createElement('div');
				expiredEl.className = 'pawwell-dod-expired';
				expiredEl.textContent = expireMsg || '';
				countdown.innerHTML = '';
				countdown.appendChild(expiredEl);
			}
			clearInterval(interval);
			return;
		}
		var d = Math.floor(remaining / 86400000);
		var h = Math.floor((remaining % 86400000) / 3600000);
		var m = Math.floor((remaining % 3600000) / 60000);
		var s = Math.floor((remaining % 60000) / 1000);
		if (els.days)    els.days.textContent    = pad(d);
		if (els.hours)   els.hours.textContent   = pad(h);
		if (els.minutes) els.minutes.textContent = pad(m);
		if (els.seconds) els.seconds.textContent = pad(s);
	}

	tick();
	var interval = setInterval(tick, 1000);
})();
</script>
