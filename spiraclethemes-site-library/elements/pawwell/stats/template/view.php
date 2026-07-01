<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Stats Banner - Frontend Render
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings          = $this->get_settings();
$id                = $this->get_id();
$items             = $settings['items'] ?? [];
$show_blobs        = $settings['show_blobs'] ?? 'yes';
$show_border_top   = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border = $settings['full_width_border'] ?? 'no';
$border_color      = $settings['border_color'] ?? '#E8E2DA';
$border_width      = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Border flags — mirror the products-grid pattern.
$wrap_class  = 'pawwell-st pawwell-st-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-st-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-st-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-st-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-st-inner">
		<div class="pawwell-st-banner <?php echo 'yes' === $show_blobs ? 'pawwell-st-blobs' : ''; ?>">
			<?php if ( ! empty( $items ) ) : ?>
				<div class="pawwell-st-grid">
					<?php foreach ( $items as $item ) :
						$value    = isset( $item['stat_value'] ) ? $item['stat_value'] : 0;
						$prefix   = $item['stat_prefix'] ?? '';
						$suffix   = $item['stat_suffix'] ?? '';
						$decimals = isset( $item['stat_decimals'] ) ? (int) $item['stat_decimals'] : 0;
						$label    = $item['stat_label'] ?? '';
						$accent   = $item['stat_accent'] ?? '';
						$is_accent = ( 'yes' === $accent );
						?>
						<div class="pawwell-st-block">
							<div class="pawwell-st-value <?php echo $is_accent ? 'pawwell-st-accent' : ''; ?>">
								<span class="pawwell-st-prefix"><?php echo esc_html( $prefix ); ?></span><span class="pawwell-st-counter" data-count="<?php echo esc_attr( $value ); ?>" data-decimals="<?php echo esc_attr( $decimals ); ?>" data-suffix="<?php echo esc_attr( $suffix ); ?>">0</span>
							</div>
							<?php if ( ! empty( $label ) ) : ?>
								<div class="pawwell-st-label"><?php echo esc_html( $label ); ?></div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<style>
	.pawwell-st-<?php echo esc_attr( $id ); ?> {
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?>.pawwell-st-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-st-<?php echo esc_attr( $id ); ?>.pawwell-st-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-st-<?php echo esc_attr( $id ); ?>.pawwell-st-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-inner {
		margin: 0 auto;
		padding: 0 32px;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-banner {
		border-radius: 20px;
		padding: 56px 60px;
		position: relative;
		overflow: hidden;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-banner.pawwell-st-blobs::before {
		content: '';
		position: absolute;
		width: 500px;
		height: 500px;
		border-radius: 50%;
		background: #C45B3E;
		opacity: 0.08;
		top: -200px;
		right: -100px;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-banner.pawwell-st-blobs::after {
		content: '';
		position: absolute;
		width: 400px;
		height: 400px;
		border-radius: 50%;
		background: #7B8F6B;
		opacity: 0.06;
		bottom: -150px;
		left: -100px;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-grid {
		position: relative;
		z-index: 1;
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
		gap: 32px;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-block { text-align: center; }
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-value {
		letter-spacing: -0.02em;
		line-height: 1;
	}
	.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-label {
		margin-top: 10px;
	}

	/* Responsive */
	@media (max-width: 767px) {
		.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-inner {
			padding: 0 20px;
		}
		.pawwell-st-<?php echo esc_attr( $id ); ?> .pawwell-st-grid {
			grid-template-columns: 1fr;
			gap: 32px;
		}
	}
</style>

<script>
(function() {
	var banner = document.querySelector('.pawwell-st-<?php echo esc_js( $id ); ?> .pawwell-st-banner');
	if (!banner) {
		return;
	}
	var counters = banner.querySelectorAll('.pawwell-st-counter');
	var done = false;

	function animate() {
		if (done) {
			return;
		}
		done = true;
		counters.forEach(function(el) {
			var target = parseFloat(el.getAttribute('data-count')) || 0;
			var decimals = parseInt(el.getAttribute('data-decimals'), 10) || 0;
			var suffix = el.getAttribute('data-suffix') || '';
			var duration = 2000;
			var startTime = null;

			function step(timestamp) {
				if (startTime === null) {
					startTime = timestamp;
				}
				var progress = Math.min((timestamp - startTime) / duration, 1);
				var eased = 1 - Math.pow(1 - progress, 3);
				var current = target * eased;
				el.textContent = current.toFixed(decimals) + suffix;
				if (progress < 1) {
					window.requestAnimationFrame(step);
				}
			}
			window.requestAnimationFrame(step);
		});
	}

	if ('IntersectionObserver' in window) {
		var observer = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					setTimeout(animate, 300);
					observer.disconnect();
				}
			});
		}, { threshold: 0.3 });
		observer.observe(banner);
	} else {
		animate();
	}
})();
</script>
