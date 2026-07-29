<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Page Title Section - Frontend Render (Shop Zen)
 *
 * Centered hero-style heading with pill, title (with highlight line), and subtext.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings     = $this->get_settings_for_display();
$id           = $this->get_id();
$show_pill    = $settings['show_pill'] ?? 'yes';
$pill_text    = $settings['pill_text'] ?? '';
$title_before = $settings['title_before'] ?? '';
$title_highlight = $settings['title_highlight'] ?? '';
$subtext      = $settings['subtext'] ?? '';
$link         = $settings['link'] ?? [];
$dotted       = $settings['dotted_texture'] ?? 'yes';
$dot_color    = $settings['dot_color'] ?? 'rgba(58,95,63,0.07)';

$href       = ! empty( $link['url'] ) ? $link['url'] : '';
$target     = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
$nofollow   = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
$attr_str   = trim( $target . ' ' . $nofollow );

$title_tag = ! empty( $href ) ? 'a' : 'h1';
?>
<section class="shopzen-pt shopzen-pt-<?php echo esc_attr( $id ); ?>" id="shopzen-pt-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-pt-center">

		<?php if ( 'yes' === $show_pill && ! empty( $pill_text ) ) : ?>
			<div class="shopzen-pt-pill">
				<span class="shopzen-pt-pill-dot"></span>
				<?php echo esc_html( $pill_text ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $title_before ) || ! empty( $title_highlight ) ) : ?>
			<<?php echo esc_html( $title_tag ); ?> class="shopzen-pt-title"<?php echo ! empty( $href ) ? ' href="' . esc_url( $href ) . '"' . ( ! empty( $attr_str ) ? ' ' . esc_attr( $attr_str ) : '' ) : ''; ?>>
				<?php if ( ! empty( $title_before ) ) : ?>
					<?php echo esc_html( $title_before ); ?>
				<?php endif; ?>
				<?php if ( ! empty( $title_highlight ) ) : ?>
					<span class="shopzen-pt-green"><?php echo esc_html( $title_highlight ); ?></span>
				<?php endif; ?>
			</<?php echo esc_html( $title_tag ); ?>>
		<?php endif; ?>

		<?php if ( ! empty( $subtext ) ) : ?>
			<p class="shopzen-pt-sub"><?php echo esc_html( $subtext ); ?></p>
		<?php endif; ?>

	</div>
</section>

<style>
	.shopzen-pt-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
		background: #F9F7F2;
		background-image: radial-gradient(rgba(58,95,63,0.07) 1px, transparent 1px), radial-gradient(rgba(58,95,63,0.04) 1px, transparent 1px);
		background-size: 20px 20px, 10px 10px;
		background-position: 0 0, 10px 10px;
		padding: 90px 16px 100px;
		text-align: center;
	}
	<?php if ( 'yes' !== $dotted ) : ?>
	.shopzen-pt-<?php echo esc_attr( $id ); ?> { background-image: none; }
	<?php else : ?>
	.shopzen-pt-<?php echo esc_attr( $id ); ?> {
		background-image: radial-gradient(<?php echo esc_attr( $dot_color ); ?> 1px, transparent 1px), radial-gradient(rgba(58,95,63,0.04) 1px, transparent 1px);
	}
	<?php endif; ?>
	.shopzen-pt-<?php echo esc_attr( $id ); ?> *,
	.shopzen-pt-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-pt-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-center {
		max-width: 860px;
		margin: 0 auto;
		display: flex;
		flex-direction: column;
		align-items: center;
		position: relative;
	}
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-center::before {
		content: '';
		position: absolute;
		top: -28px;
		left: -10px;
		width: 40px;
		height: 40px;
		border-left: 3px solid #3A5F3F;
		border-top: 3px solid #3A5F3F;
		opacity: 0.12;
		border-radius: 4px 0 0 0;
	}

	/* Pill */
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-pill {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: #fff;
		border: 1px solid #E5E7EB;
		padding: 6px 14px;
		border-radius: 999px;
		font-family: Inter, sans-serif;
		font-size: 12px;
		font-weight: 700;
		color: #3F4A3C;
		width: fit-content;
		margin-bottom: 18px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
		text-transform: uppercase;
		letter-spacing: 0.4px;
		position: relative;
	}
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-pill::after {
		content: '\2022\2022\2022';
		position: absolute;
		right: -20px;
		top: 50%;
		transform: translateY(-50%);
		font-size: 8px;
		letter-spacing: 2px;
		color: #3A5F3F;
		opacity: 0.35;
	}
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-pill-dot {
		width: 6px;
		height: 6px;
		background: #8BA888;
		border-radius: 50%;
		display: inline-block;
	}

	/* Title */
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-title {
		font-family: Outfit, sans-serif;
		font-size: 64px;
		line-height: 1.05em;
		margin: 0 0 16px;
		font-weight: 800;
		color: #1A202C;
		letter-spacing: -0.5px;
		text-decoration: none;
	}
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-green {
		color: #4A6B3F;
		display: block;
	}

	/* Sub text */
	.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-sub {
		font-family: Inter, sans-serif;
		font-size: 17px;
		color: #4B5563;
		max-width: 640px;
		margin: 0 auto;
		line-height: 1.65em;
		font-weight: 500;
	}

	/* Responsive */
	@media (max-width: 1100px) {
		.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-title { font-size: 52px; }
	}
	@media (max-width: 768px) {
		.shopzen-pt-<?php echo esc_attr( $id ); ?> { padding: 70px 16px 70px; }
		.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-title { font-size: 40px; }
		.shopzen-pt-<?php echo esc_attr( $id ); ?> .shopzen-pt-center::before { display: none; }
	}
</style>
