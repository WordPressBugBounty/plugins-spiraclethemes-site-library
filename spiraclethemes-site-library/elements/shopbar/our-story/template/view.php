<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Our Story
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$label       = $settings['section_label'] ?? '';
$title       = $settings['title'] ?? '';
$description = $settings['description'] ?? '';
$features    = $settings['features'] ?? array();

$show_badge = 'yes' === ( $settings['show_badge'] ?? '' );
$badge_num  = $settings['badge_number'] ?? '';
$badge_text = $settings['badge_label'] ?? '';

$show_founder   = 'yes' === ( $settings['show_founder'] ?? '' );
$founder_data   = $settings['founder_image'] ?? array();
$founder_url    = ! empty( $founder_data['url'] ) ? $founder_data['url'] : '';
$founder_name   = $settings['founder_name'] ?? '';
$founder_role   = $settings['founder_role'] ?? '';

$image_pos = $settings['image_position'] ?? 'left';
$image_data = $settings['image'] ?? array();
$image_url  = ! empty( $image_data['url'] ) ? $image_data['url'] : '';
$image_alt  = $settings['image_alt'] ?? '';
$has_image  = ( 'hidden' !== $image_pos && $image_url );

/* Lucide "circle-check" used for each promise. */
$check_svg = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>';

$id = $this->get_id();
?>

<section class="shopbar-os-section shopbar-os-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-os-inner">
		<div class="shopbar-os-row">

			<?php if ( $has_image && 'left' === $image_pos ) : ?>
				<div class="shopbar-os-media">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
					<?php if ( $show_badge && ( $badge_num || $badge_text ) ) : ?>
						<div class="shopbar-os-badge">
							<?php if ( $badge_num ) : ?>
								<span class="shopbar-os-badge-num"><?php echo esc_html( $badge_num ); ?></span>
							<?php endif; ?>
							<?php if ( $badge_text ) : ?>
								<span class="shopbar-os-badge-text"><?php echo esc_html( $badge_text ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="shopbar-os-content">
				<?php if ( $label ) : ?>
					<span class="shopbar-os-label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h2 class="shopbar-os-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<p class="shopbar-os-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $features ) && is_array( $features ) ) : ?>
					<ul class="shopbar-os-list">
						<?php foreach ( $features as $item ) :
							$item_text = $item['text'] ?? '';
							if ( '' === $item_text ) {
								continue;
							}
						?>
							<li>
								<span class="shopbar-os-check"><?php echo $check_svg; // phpcs:ignore ?></span>
								<span class="shopbar-os-list-text"><?php echo esc_html( $item_text ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $show_founder && ( $founder_url || $founder_name ) ) : ?>
					<div class="shopbar-os-founder">
						<?php if ( $founder_url ) : ?>
							<img class="shopbar-os-founder-avatar" src="<?php echo esc_url( $founder_url ); ?>" alt="<?php echo esc_attr( $founder_name ); ?>" loading="lazy">
						<?php endif; ?>
						<div class="shopbar-os-founder-meta">
							<?php if ( $founder_name ) : ?>
								<span class="shopbar-os-founder-name"><?php echo esc_html( $founder_name ); ?></span>
							<?php endif; ?>
							<?php if ( $founder_role ) : ?>
								<span class="shopbar-os-founder-role"><?php echo esc_html( $founder_role ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $has_image && 'right' === $image_pos ) : ?>
				<div class="shopbar-os-media">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
					<?php if ( $show_badge && ( $badge_num || $badge_text ) ) : ?>
						<div class="shopbar-os-badge">
							<?php if ( $badge_num ) : ?>
								<span class="shopbar-os-badge-num"><?php echo esc_html( $badge_num ); ?></span>
							<?php endif; ?>
							<?php if ( $badge_text ) : ?>
								<span class="shopbar-os-badge-text"><?php echo esc_html( $badge_text ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.shopbar-os-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--os-accent: #B8977E;
		--os-badge-offset: 24px;
		width: 100%;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> *,
	.shopbar-os-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-os-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-inner {
		width: 100%;
		max-width: 1350px;
		margin: 0 auto;
		padding: 0 24px;
	}

	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-row {
		display: flex;
		align-items: center;
		justify-content: space-between;
		flex-wrap: wrap;
		column-gap: 60px;
		padding-top: 75px;
		padding-bottom: 75px;
	}

	/* ── Content ────────────────────────────────────────── */
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-content {
		flex: 1 1 0%;
		min-width: 0;
		display: flex;
		flex-direction: column;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?>.shopbar-os-align-center .shopbar-os-content {
		align-items: center;
		text-align: center;
	}

	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-label {
		display: inline-block;
		font-family: var(--font-mono, 'DM Mono', monospace);
		font-size: 13px;
		font-weight: 600;
		letter-spacing: 2px;
		text-transform: uppercase;
		color: var(--os-accent);
		margin-bottom: 14px;
	}

	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-title {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 38px;
		font-weight: 600;
		line-height: 1.15em;
		letter-spacing: -0.01em;
		color: #1C1C1C;
		margin: 0 0 16px;
	}

	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-desc {
		font-size: 15px;
		line-height: 1.7em;
		color: #6B6560;
		margin: 0 0 22px;
		max-width: 540px;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?>.shopbar-os-align-center .shopbar-os-desc { max-width: 600px; }

	/* ── Feature list ───────────────────────────────────── */
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-list {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-list li {
		display: flex;
		align-items: flex-start;
		column-gap: 12px;
		margin-bottom: 14px;
		font-size: 15px;
		line-height: 1.5em;
		color: #1C1C1C;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-list li:last-child { margin-bottom: 0; }
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-check {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
		margin-top: 3px;
		color: #5A8A6A;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-check svg { width: 18px; height: 18px; display: block; }
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-list-text { min-width: 0; }
	.shopbar-os-<?php echo esc_attr( $id ); ?>.shopbar-os-align-center .shopbar-os-list { max-width: 520px; }

	/* ── Founder ────────────────────────────────────────── */
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-founder {
		display: flex;
		align-items: center;
		column-gap: 14px;
		margin-top: 28px;
		padding-top: 24px;
		border-top: 1px solid #E8E4DF;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-founder-avatar {
		width: 52px;
		height: 52px;
		border-radius: 50%;
		object-fit: cover;
		flex-shrink: 0;
		display: block;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-founder-meta { display: flex; flex-direction: column; }
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-founder-name {
		font-size: 16px;
		font-weight: 700;
		line-height: 1.2em;
		color: #1C1C1C;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-founder-role {
		font-size: 13px;
		color: #9C9792;
	}

	/* ── Media + badge ──────────────────────────────────── */
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media {
		flex: 0 0 50%;
		width: 50%;
		min-width: 0;
		position: relative;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media img {
		width: 100%;
		height: 460px;
		object-fit: cover;
		display: block;
		border-radius: 16px;
		transition: transform .5s ease;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media:hover img { transform: scale(1.02); }

	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-badge {
		position: absolute;
		z-index: 2;
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		padding: 16px 22px;
		border-radius: 12px;
		background-color: #1C1C1C;
	}
	.shopbar-os-badge-pos-tl .shopbar-os-badge { top: var(--os-badge-offset); left: var(--os-badge-offset); }
	.shopbar-os-badge-pos-tr .shopbar-os-badge { top: var(--os-badge-offset); right: var(--os-badge-offset); }
	.shopbar-os-badge-pos-bl .shopbar-os-badge { bottom: var(--os-badge-offset); left: var(--os-badge-offset); }
	.shopbar-os-badge-pos-br .shopbar-os-badge { bottom: var(--os-badge-offset); right: var(--os-badge-offset); }
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-badge-num {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 28px;
		font-weight: 600;
		line-height: 1em;
		color: #FFFFFF;
	}
	.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-badge-text {
		font-size: 12px;
		font-weight: 500;
		line-height: 1.3em;
		color: #9C9792;
		margin-top: 4px;
	}

	/* When the image is hidden, the content takes the full width. */
	.shopbar-os-media-hidden .shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-content { flex: 1 1 100%; }

	/* ── Responsive ───────────────────────────────────────
	   Elementor emits its own per-widget rules (e.g. .elementor-2016 .elementor-element
	   .elementor-element-XXXX .shopbar-os-title { font-size: 38px; }) with higher
	   specificity than the base rules below, so responsive overrides need !important
	   to actually take effect on tablet/mobile. */
	@media (max-width: 1024px) {
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-title { font-size: 34px !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-row { column-gap: 32px !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media img { height: 400px !important; }
	}
	@media (max-width: 768px) {
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-row {
			flex-direction: column;
			align-items: stretch;
			column-gap: 0 !important;
			padding-top: 48px !important;
			padding-bottom: 48px !important;
		}
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media {
			flex: 0 0 100% !important;
			width: 100% !important;
			order: -1 !important;
			margin-bottom: 26px;
		}
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media img { height: 320px !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-title { font-size: 28px !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-desc { max-width: 100% !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-founder { margin-top: 22px; padding-top: 18px; }
	}
	@media (max-width: 480px) {
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-media img { height: 250px !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-title { font-size: 25px !important; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-badge { padding: 10px 14px; border-radius: 10px; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-badge-num { font-size: 20px; }
		.shopbar-os-<?php echo esc_attr( $id ); ?> .shopbar-os-list li { font-size: 14px; }
	}
</style>
