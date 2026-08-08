<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * FAQ
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings           = $this->get_settings();
$id                 = $this->get_id();
$items              = $settings['items'] ?? [];
$eyebrow            = $settings['eyebrow'] ?? '';
$title              = $settings['title'] ?? '';
$columns            = $settings['columns'] ?? '2';
$open_first         = $settings['open_first'] ?? 'yes';
$single_open        = $settings['single_open'] ?? 'yes';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Border flags — mirror the products-grid pattern.
$wrap_class  = 'pawwell-faq pawwell-faq-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-faq-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-faq-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-faq-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-faq-inner">
		<?php if ( ! empty( $eyebrow ) || ! empty( $title ) ) : ?>
			<div class="pawwell-faq-head">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-faq-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="pawwell-faq-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="pawwell-faq-grid">
				<?php foreach ( $items as $index => $item ) :
					$question = $item['question'] ?? '';
					$answer   = $item['answer'] ?? '';
					if ( '' === $question && '' === $answer ) {
						continue;
					}
					$open_class = ( 0 === $index && 'yes' === $open_first ) ? ' open' : '';
					?>
					<div class="pawwell-faq-item<?php echo esc_attr( $open_class ); ?>">
						<div class="pawwell-faq-q" role="button" tabindex="0" aria-expanded="<?php echo ( 0 === $index && 'yes' === $open_first ) ? 'true' : 'false'; ?>">
							<span class="pawwell-faq-q-text"><?php echo esc_html( $question ); ?></span>
							<span class="pawwell-faq-ic" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
							</span>
						</div>
						<div class="pawwell-faq-a">
							<div class="pawwell-faq-a-inner"><?php echo wp_kses_post( wpautop( $answer ) ); ?></div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-faq-<?php echo esc_attr( $id ); ?> {
		position: relative;
		padding: 80px 50px;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?>.pawwell-faq-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-faq-<?php echo esc_attr( $id ); ?>.pawwell-faq-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-faq-<?php echo esc_attr( $id ); ?>.pawwell-faq-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-inner {
		max-width: 1280px;
		margin: 0 auto;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-head {
		margin-bottom: 44px;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-eyebrow {
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.5px;
		margin-bottom: 8px;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-title {
		font-weight: 700;
		font-size: 40px;
		line-height: 1.1;
		margin: 0;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-grid {
		display: grid;
		grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);
		gap: 18px;
		align-items: start;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-item {
		border: 1px solid #E8E2DA;
		border-radius: 16px;
		overflow: hidden;
		transition: box-shadow .25s ease, border-color .25s ease;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-item.open {
		box-shadow: 0 18px 40px -22px rgba(0,0,0,0.16);
		border-color: transparent;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-q {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 16px;
		padding: 22px 26px;
		cursor: pointer;
		font-weight: 700;
		font-size: 16px;
		letter-spacing: -0.01em;
		transition: color .2s ease;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-q:focus-visible {
		outline: 2px solid #C45B3E;
		outline-offset: -2px;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-q-text {
		flex: 1;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-ic {
		width: 32px;
		height: 32px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
		transition: background .3s cubic-bezier(.16,1,.3,1), color .3s cubic-bezier(.16,1,.3,1), transform .3s cubic-bezier(.16,1,.3,1);
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-ic svg {
		width: 18px;
		height: 18px;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-item.open .pawwell-faq-ic {
		color: #fff;
		transform: rotate(180deg);
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-a {
		max-height: 0;
		overflow: hidden;
		transition: max-height .35s cubic-bezier(.16,1,.3,1);
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-a-inner {
		padding: 0 26px 24px;
		font-size: 15px;
		line-height: 1.75;
	}
	.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-a-inner p:last-child {
		margin-bottom: 0;
	}

	@media (max-width: 767px) {
		.pawwell-faq-<?php echo esc_attr( $id ); ?> {
			padding: 48px 20px;
		}
		.pawwell-faq-<?php echo esc_attr( $id ); ?> .pawwell-faq-title {
			font-size: 28px;
		}
	}
</style>

<script>
(function() {
	var root = document.querySelector('.pawwell-faq-<?php echo esc_js( $id ); ?>');
	if (!root) return;

	var singleOpen = '<?php echo esc_js( $single_open ); ?>' === 'yes';

	function setAnswerHeight(item, open) {
		var answer = item.querySelector('.pawwell-faq-a');
		if (!answer) return;
		if (open) {
			answer.style.maxHeight = answer.scrollHeight + 'px';
		} else {
			answer.style.maxHeight = null;
		}
	}

	function openItem(item) {
		item.classList.add('open');
		var q = item.querySelector('.pawwell-faq-q');
		if (q) q.setAttribute('aria-expanded', 'true');
		setAnswerHeight(item, true);
	}

	function closeItem(item) {
		item.classList.remove('open');
		var q = item.querySelector('.pawwell-faq-q');
		if (q) q.setAttribute('aria-expanded', 'false');
		setAnswerHeight(item, false);
	}

	function toggle(item) {
		var isOpen = item.classList.contains('open');

		if (singleOpen) {
			root.querySelectorAll('.pawwell-faq-item.open').forEach(function(openItem) {
				closeItem(openItem);
			});
		}

		if (isOpen) {
			closeItem(item);
		} else {
			openItem(item);
		}
	}

	root.querySelectorAll('.pawwell-faq-q').forEach(function(q) {
		q.addEventListener('click', function() {
			toggle(q.closest('.pawwell-faq-item'));
		});
		q.addEventListener('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				toggle(q.closest('.pawwell-faq-item'));
			}
		});
	});

	// Recalc heights of open items on resize / font load.
	var openOnLoad = root.querySelector('.pawwell-faq-item.open');
	if (openOnLoad) {
		var recalc = function() {
			setAnswerHeight(openOnLoad, true);
		};
		if (document.fonts && document.fonts.ready) {
			document.fonts.ready.then(recalc);
		}
		window.addEventListener('resize', recalc);
	}
})();
</script>
