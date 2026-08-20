<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * About Hero
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$label        = $settings['section_label'] ?? '';
$title        = $settings['title'] ?? '';
$description  = $settings['description'] ?? '';

$image_pos    = $settings['image_position'] ?? 'right';
$image_data   = $settings['image'] ?? array();
$image_url    = ! empty( $image_data['url'] ) ? $image_data['url'] : '';
$image_alt    = $settings['image_alt'] ?? '';
$has_image    = ( 'hidden' !== $image_pos && $image_url );

$primary_text = $settings['primary_btn_text'] ?? '';
$primary_link = $settings['primary_btn_url'] ?? array();

$show_second  = 'yes' === ( $settings['show_secondary_btn'] ?? '' );
$second_text  = $settings['secondary_btn_text'] ?? '';
$second_link  = $settings['secondary_btn_url'] ?? array();

/* Lucide "shopping-bag" used in the primary CTA. */
$bag_svg = '<svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>';

/* Build link attributes. */
$primary_url      = ! empty( $primary_link['url'] ) ? $primary_link['url'] : '#';
$primary_target   = ! empty( $primary_link['is_external'] ) ? ' target="_blank"' : '';
$primary_nofollow = ! empty( $primary_link['nofollow'] ) ? ' rel="nofollow"' : '';

$second_url       = ! empty( $second_link['url'] ) ? $second_link['url'] : '#';
$second_target    = ! empty( $second_link['is_external'] ) ? ' target="_blank"' : '';
$second_nofollow  = ! empty( $second_link['nofollow'] ) ? ' rel="nofollow"' : '';

$id = $this->get_id();
?>

<section class="shopbar-ab-section shopbar-ab-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-ab-inner">
		<div class="shopbar-ab-row">

			<?php if ( $has_image && 'left' === $image_pos ) : ?>
				<div class="shopbar-ab-media">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
				</div>
			<?php endif; ?>

			<div class="shopbar-ab-content">
				<?php if ( $label ) : ?>
					<span class="shopbar-ab-label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h2 class="shopbar-ab-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<p class="shopbar-ab-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>

				<?php if ( $primary_text || ( $show_second && $second_text ) ) : ?>
					<div class="shopbar-ab-actions">
						<?php if ( $primary_text ) : ?>
							<a class="shopbar-ab-btn shopbar-ab-btn--primary" href="<?php echo esc_url( $primary_url ); ?>"<?php echo $primary_target . $primary_nofollow; // phpcs:ignore ?>>
								<span class="shopbar-ab-btn-icon"><?php echo $bag_svg; // phpcs:ignore ?></span>
								<span><?php echo esc_html( $primary_text ); ?></span>
							</a>
						<?php endif; ?>

						<?php if ( $show_second && $second_text ) : ?>
							<a class="shopbar-ab-btn shopbar-ab-btn--secondary" href="<?php echo esc_url( $second_url ); ?>"<?php echo $second_target . $second_nofollow; // phpcs:ignore ?>>
								<span><?php echo esc_html( $second_text ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_image && 'right' === $image_pos ) : ?>
				<div class="shopbar-ab-media">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.shopbar-ab-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--ab-accent: #B8977E;
		width: 100%;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?> *,
	.shopbar-ab-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-ab-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-inner {
		width: 100%;
		max-width: 1350px;
		margin: 0 auto;
		padding: 0 24px;
	}

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-row {
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
		column-gap: 60px;
		padding-top: 70px;
		padding-bottom: 70px;
	}

	/* ── Content ────────────────────────────────────────── */
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-content {
		flex: 1 1 0%;
		min-width: 0;
		display: flex;
		flex-direction: column;
		gap: 18px;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?>.shopbar-ab-align-center .shopbar-ab-content {
		align-items: center;
		text-align: center;
	}

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-label {
		display: inline-block;
		font-family: var(--font-mono, 'DM Mono', monospace);
		font-size: 13px;
		font-weight: 600;
		letter-spacing: 2px;
		text-transform: uppercase;
		color: var(--ab-accent);
	}

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-title {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 44px;
		font-weight: 600;
		line-height: 1.15;
		letter-spacing: -0.01em;
		color: #1C1C1C;
		margin: 0;
	}

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-desc {
		font-size: 16px;
		line-height: 1.7;
		color: #6B6560;
		margin: 0;
		max-width: 520px;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?>.shopbar-ab-align-center .shopbar-ab-desc { max-width: 600px; }

	/* ── Actions ────────────────────────────────────────── */
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-actions {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		gap: 14px;
		margin-top: 6px;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		font-size: 14px;
		font-weight: 600;
		line-height: 1;
		text-decoration: none;
		white-space: nowrap;
		transition: background-color .3s ease, color .3s ease, border-color .3s ease, transform .3s ease, box-shadow .3s ease;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn:hover { transform: translateY(-2px); }

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn--primary {
		background-color: #1C1C1C;
		color: #FFFFFF;
		padding: 14px 28px;
		border-radius: 8px;
		border: 1px solid #1C1C1C;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn--primary:hover { box-shadow: 0 12px 28px -12px rgba(28, 28, 28, 0.5); }
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn--primary:hover { background-color: var(--ab-accent); border-color: var(--ab-accent); }
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn-icon { display: inline-flex; align-items: center; justify-content: center; }

	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-btn--secondary {
		background-color: #FFFFFF;
		color: #1C1C1C;
		border: 1px solid #DDDDDD;
		padding: 14px 28px;
		border-radius: 8px;
	}

	/* ── Media ──────────────────────────────────────────── */
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media {
		flex: 0 0 50%;
		width: 50%;
		min-width: 0;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media img {
		width: 100%;
		height: 430px;
		object-fit: cover;
		display: block;
		border-radius: 16px;
		transition: transform .5s ease;
	}
	.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media:hover img { transform: scale(1.02); }

	.shopbar-ab-media-hidden .shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-content { flex: 1 1 100%; }

	/* ── Responsive ───────────────────────────────────────
	*/
	@media (max-width: 1024px) {
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-title { font-size: 38px !important; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-row { column-gap: 32px !important; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media img { height: 380px !important; }
	}
	@media (max-width: 768px) {
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-row {
			flex-direction: column;
			align-items: stretch;
			column-gap: 0 !important;
			padding-top: 44px !important;
			padding-bottom: 44px !important;
		}
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media {
			flex: 0 0 100% !important;
			width: 100% !important;
			order: -1 !important;
			margin-bottom: 26px;
		}
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media img { height: 300px !important; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-title { font-size: 30px !important; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-desc { max-width: 100% !important; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-content { gap: 14px; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-actions { gap: 10px; }
	}
	@media (max-width: 480px) {
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-media img { height: 240px !important; }
		.shopbar-ab-<?php echo esc_attr( $id ); ?> .shopbar-ab-title { font-size: 26px !important; }
	}
</style>
