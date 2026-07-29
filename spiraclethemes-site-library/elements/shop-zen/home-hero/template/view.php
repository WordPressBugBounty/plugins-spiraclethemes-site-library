<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Home Hero Section - Frontend Render (Shop Zen)
 *
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings_for_display();
$id       = $this->get_id();

$eyebrow_text        = $settings['eyebrow_text'] ?? '';
$hero_title          = $settings['hero_title'] ?? '';
$hero_title_accent   = $settings['hero_title_accent'] ?? '';
$hero_description    = $settings['hero_description'] ?? '';
$primary_btn_text     = $settings['primary_btn_text'] ?? '';
$primary_btn_url      = $settings['primary_btn_url'] ?? [];
$secondary_btn_text   = $settings['secondary_btn_text'] ?? '';
$secondary_btn_url    = $settings['secondary_btn_url'] ?? '';

$show_sale_badge     = $settings['show_sale_badge'] ?? 'yes';
$badge_top_text      = $settings['badge_top_text'] ?? '';
$badge_main_text     = $settings['badge_main_text'] ?? '';
$badge_bottom_text   = $settings['badge_bottom_text'] ?? '';

$primary_link       = ! empty( $primary_btn_url['url'] ) ? esc_url( $primary_btn_url['url'] ) : '#';
$primary_target     = ! empty( $primary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$primary_nofollow   = ! empty( $primary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';
$primary_attr_str   = trim( $primary_target . ' ' . $primary_nofollow );

$secondary_link       = ! empty( $secondary_btn_url['url'] ) ? esc_url( $secondary_btn_url['url'] ) : '#';
$secondary_target     = ! empty( $secondary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$secondary_nofollow   = ! empty( $secondary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';
$secondary_attr_str   = trim( $secondary_target . ' ' . $secondary_nofollow );

$title_html = '';
if ( ! empty( $hero_title ) ) {
	$title_html .= nl2br( esc_html( $hero_title ) );
}
if ( ! empty( $hero_title_accent ) ) {
	if ( ! empty( $title_html ) ) {
		$title_html .= ' ';
	}
	$title_html .= '<span class="green">' . esc_html( $hero_title_accent ) . '</span>';
}
?>

<section class="shopzen-hh shopzen-hh-<?php echo esc_attr( $id ); ?>" id="shopzen-hh-<?php echo esc_attr( $id ); ?>">

	<?php if ( 'yes' === $show_sale_badge && ( ! empty( $badge_top_text ) || ! empty( $badge_main_text ) || ! empty( $badge_bottom_text ) ) ) : ?>
		<div class="shopzen-hh-sale-badge">
			<?php if ( ! empty( $badge_top_text ) ) : ?>
				<small><?php echo esc_html( $badge_top_text ); ?></small>
			<?php endif; ?>
			<?php if ( ! empty( $badge_main_text ) ) : ?>
				<strong><?php echo esc_html( $badge_main_text ); ?></strong>
			<?php endif; ?>
			<?php if ( ! empty( $badge_bottom_text ) ) : ?>
				<small><?php echo esc_html( $badge_bottom_text ); ?></small>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="shopzen-hh-content">
		<div class="shopzen-hh-center">

			<?php if ( ! empty( $eyebrow_text ) ) : ?>
				<div class="shopzen-hh-pill">
					<span class="shopzen-hh-pill-dot"></span>
					<?php echo esc_html( $eyebrow_text ); ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $title_html ) ) : ?>
				<h1 class="shopzen-hh-title"><?php echo wp_kses_post( $title_html ); ?></h1>
			<?php endif; ?>

			<?php if ( ! empty( $hero_description ) ) : ?>
				<p class="shopzen-hh-sub"><?php echo esc_html( $hero_description ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $primary_btn_text ) || ! empty( $secondary_btn_text ) ) : ?>
				<div class="shopzen-hh-cta">
					<?php if ( ! empty( $primary_btn_text ) ) : ?>
						<a href="<?php echo esc_url( $primary_link ); ?>" class="shopzen-hh-btn-primary" <?php echo esc_attr( $primary_attr_str ); ?>>
							<?php echo esc_html( $primary_btn_text ); ?>
							<?php
							if ( ! empty( $settings['primary_btn_icon']['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $settings['primary_btn_icon'], [ 'aria-hidden' => 'true' ] );
							}
							?>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $secondary_btn_text ) ) : ?>
						<a href="<?php echo esc_url( $secondary_link ); ?>" class="shopzen-hh-btn-link" <?php echo esc_attr( $secondary_attr_str ); ?>>
							<?php echo esc_html( $secondary_btn_text ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	/* Outer wrapper: full-bleed background. Width follows the host Elementor
	   section/container so the hero is consistent in both full-width and boxed
	   layouts. The background colour + dot pattern extend to the edges. */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> {
		position: relative;
		background: #F9F7F2;
		background-image: radial-gradient(rgba(58,95,63,0.07) 1px, transparent 1px), radial-gradient(rgba(58,95,63,0.04) 1px, transparent 1px);
		background-size: 20px 20px, 10px 10px;
		background-position: 0 0, 10px 10px;
		padding: 80px 0 100px;
		text-align: center;
		width: 100%;
		max-width: 100%;
		overflow: hidden;
		overflow-x: clip;
		box-sizing: border-box;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> *,
	.shopzen-hh-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-hh-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	/* Inner content box: this is what matches the theme header/footer width
	   (1240px). It is centered with margin auto so the hero content always
	   sits in the same horizontal band as the header and footer regardless
	   of whether the host Elementor container is boxed or full-width. The
	   horizontal gutter lives INSIDE this box (same pattern the theme uses
	   for its header/footer content containers) so the box edges line up
	   exactly with the header/footer band. */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-content {
		position: relative;
		z-index: 2;
		max-width: 1240px;
		margin: 0 auto;
		width: 100%;
		padding: 0 16px;
	}

	/* The centered hero content block (max 860px) */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-center {
		max-width: 860px;
		margin: 0 auto;
		display: flex;
		flex-direction: column;
		align-items: center;
		position: relative;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-center::before {
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

	/* Pill / eyebrow */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-pill {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: #fff;
		border: 1px solid #E5E7EB;
		padding: 6px 14px;
		border-radius: 999px;
		font-size: 12px;
		font-weight: 700;
		color: #3F4A3C;
		width: fit-content;
		margin: 0 auto 18px;
		box-shadow: 0 2px 8px rgba(0,0,0,0.05);
		text-transform: uppercase;
		letter-spacing: 0.4px;
		position: relative;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-pill::after {
		content: '•••';
		position: absolute;
		right: -20px;
		top: 50%;
		transform: translateY(-50%);
		font-size: 8px;
		letter-spacing: 2px;
		color: #3A5F3F;
		opacity: 0.35;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-pill-dot {
		width: 6px;
		height: 6px;
		background: #8BA888;
		border-radius: 50%;
	}

	/* Title */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title {
		font-family: Outfit, sans-serif;
		font-size: 68px;
		line-height: 1.02em;
		margin: 0 0 16px;
		font-weight: 800;
		letter-spacing: -0.02em;
		color: #1A202C;
		max-width: 100%;
		overflow-wrap: break-word;
		word-break: break-word;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title .green {
		color: #4A6B3F;
		display: block;
		position: relative;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title .green::after {
		content: '‥‥‥';
		position: absolute;
		right: -30px;
		bottom: 8px;
		font-size: 14px;
		letter-spacing: 2px;
		color: #3A5F3F;
		opacity: 0.25;
	}

	/* Description */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sub {
		font-size: 16px;
		color: #4B5563;
		max-width: 560px;
		margin: 0 auto 28px;
		line-height: 1.6;
		font-weight: 500;
	}

	/* CTAs */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-cta {
		display: flex;
		align-items: center;
		gap: 18px;
		justify-content: center;
		flex-wrap: wrap;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-primary {
		background: #1E3F2A;
		color: #fff;
		padding: 13px 24px;
		border-radius: 999px;
		font-weight: 700;
		font-size: 14px;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		transition: transform .2s, box-shadow .2s, background .2s;
		box-shadow: 0 4px 14px rgba(30,63,42,0.22);
		border: 1px solid #0f2316;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		text-decoration: none;
		white-space: nowrap;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-primary:hover {
		transform: translateY(-1px);
		box-shadow: 0 6px 18px rgba(30,63,42,0.28);
		background: #163322;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-primary i,
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-primary svg {
		width: 16px;
		height: 16px;
		font-size: 16px;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-link {
		font-weight: 700;
		color: #1F2937;
		font-size: 13px;
		border-bottom: 2px solid #D1D5DB;
		padding: 0 0 2px;
		transition: border-color .2s, color .2s;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		text-decoration: none;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-link:hover {
		border-color: #1F2937;
	}

	/* Sale badge — positioned relative to the .shopzen-hh-content block so it
	   aligns within the 1240px header/footer band in BOTH layout modes. */
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge {
		position: absolute;
		top: 28px;
		right: 72px;
		width: 104px;
		height: 104px;
		background: #1E3F2A;
		color: #fff;
		border-radius: 50%;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		text-align: center;
		font-family: Outfit, sans-serif;
		font-weight: 800;
		line-height: 1.05;
		border: 4px solid #fff;
		box-shadow: 0 8px 24px rgba(0,0,0,0.2);
		z-index: 3;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge small {
		font-size: 10px;
		letter-spacing: 1.2px;
		opacity: 0.9;
		font-weight: 700;
	}
	.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge strong {
		font-size: 26px;
	}

	/* Responsive */
	@media (max-width: 1100px) {
		.shopzen-hh-<?php echo esc_attr( $id ); ?> { padding: 70px 0 80px; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title { font-size: 56px; }
	}
	@media (max-width: 768px) {
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title { font-size: 44px; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title .green::after { display: none; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sub { font-size: 14px; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-cta {
			flex-direction: column;
			align-items: center;
			gap: 12px;
		}
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge {
			top: 16px;
			right: 16px;
			width: 84px;
			height: 84px;
		}
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge strong { font-size: 22px; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-center::before { display: none; }
	}
	@media (max-width: 480px) {
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-title { font-size: 38px; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge {
			width: 78px;
			height: 78px;
			top: 12px;
			right: 12px;
		}
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-sale-badge strong { font-size: 20px; }
		.shopzen-hh-<?php echo esc_attr( $id ); ?> .shopzen-hh-btn-primary {
			width: 100%;
			justify-content: center;
		}
	}
</style>
