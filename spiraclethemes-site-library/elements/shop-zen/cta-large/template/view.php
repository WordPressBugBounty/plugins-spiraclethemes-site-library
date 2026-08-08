<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * CTA Large Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings    = $this->get_settings_for_display();
$id          = $this->get_id();
$heading     = $settings['heading'] ?? '';
$subtext     = $settings['subtext'] ?? '';
$button_text = $settings['button_text'] ?? '';
$button_link = $settings['button_link'] ?? [];
$show_arrow  = $settings['show_arrow'] ?? 'yes';
$show_deco   = $settings['show_deco'] ?? 'yes';

$btn_href       = ! empty( $button_link['url'] ) ? $button_link['url'] : '';
$btn_target     = ! empty( $button_link['is_external'] ) ? ' target="_blank"' : '';
$btn_nofollow   = ! empty( $button_link['nofollow'] ) ? ' rel="nofollow"' : '';
$btn_attr_str   = trim( $btn_target . ' ' . $btn_nofollow );
?>
<section class="shopzen-bcta shopzen-bcta-<?php echo esc_attr( $id ); ?>" id="shopzen-bcta-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-bcta-wrap">
		<div class="shopzen-bcta-box<?php echo 'yes' !== $show_deco ? ' no-deco' : ''; ?>">

			<?php if ( ! empty( $heading ) ) : ?>
				<h3 class="shopzen-bcta-heading"><?php echo esc_html( $heading ); ?></h3>
			<?php endif; ?>

			<?php if ( ! empty( $subtext ) ) : ?>
				<p class="shopzen-bcta-sub"><?php echo esc_html( $subtext ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $button_text ) && ! empty( $btn_href ) ) : ?>
				<a class="shopzen-bcta-btn" href="<?php echo esc_url( $btn_href ); ?>" <?php echo esc_attr( $btn_attr_str ); ?>>
					<?php echo esc_html( $button_text ); ?>
					<?php if ( 'yes' === $show_arrow ) : ?>
						<span class="shopzen-bcta-arrow">&rarr;</span>
					<?php endif; ?>
				</a>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
	}
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> *,
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-wrap {
		max-width: 1000px;
		margin: 0 auto;
		padding: 0 16px;
	}

	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-box {
		background: #1E3F2A;
		color: #fff;
		border-radius: 14px;
		padding: 48px 32px;
		text-align: center;
		position: relative;
		overflow: hidden;
		border: 1px solid #0f2316;
	}
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-box.no-deco::before {
		display: none;
	}
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-box::before {
		content: '';
		position: absolute;
		top: -40px;
		right: -40px;
		width: 160px;
		height: 160px;
		border: 3px solid rgba(255, 255, 255, 0.08);
		border-radius: 50%;
		pointer-events: none;
	}

	/* Heading */
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-heading {
		font-family: Outfit, sans-serif;
		font-size: 32px;
		font-weight: 800;
		color: #fff;
		margin: 0 0 10px;
		line-height: 1.2em;
		letter-spacing: -0.5px;
		position: relative;
		z-index: 1;
	}

	/* Sub text */
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-sub {
		font-family: Inter, sans-serif;
		font-size: 14px;
		color: #CBD5CE;
		max-width: 520px;
		margin: 0 auto 22px;
		line-height: 1.6em;
		font-weight: 500;
		position: relative;
		z-index: 1;
	}

	/* Button */
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-btn {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: #fff;
		color: #1E3F2A;
		padding: 13px 26px;
		border-radius: 999px;
		font-family: Inter, sans-serif;
		font-weight: 700;
		font-size: 14px;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		transition: 0.2s;
		box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
		text-decoration: none;
		position: relative;
		z-index: 1;
		cursor: pointer;
	}
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-btn:hover {
		transform: translateY(-1px);
		background: #F8FAF6;
	}
	.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-arrow {
		display: inline-block;
		font-size: 1em;
		line-height: 1;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-heading { font-size: 26px; }
		.shopzen-bcta-<?php echo esc_attr( $id ); ?> .shopzen-bcta-box { padding: 36px 20px; }
	}
</style>
