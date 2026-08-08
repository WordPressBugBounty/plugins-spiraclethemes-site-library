<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonprefixedVariableFound
/**
 * Contact Info
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Outline SVG icons (Shopbar style: 24x24 viewBox, stroke based).
 *
 * @param string $key  Icon key.
 * @param int    $size Pixel size.
 * @return string SVG markup.
 */
if ( ! function_exists( 'shopbar_ci_render_icon' ) ) {
	function shopbar_ci_render_icon( $key, $size = 24 ) {
		$icons = array(
			'map-pin' => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
			'phone'   => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
			'mail'    => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
			'chat'    => '<path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>',
			'clock'   => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
			'headset' => '<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/>',
			'send'    => '<path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/>',
			'globe'   => '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
			'sparkles'=> '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
		);

		if ( ! isset( $icons[ $key ] ) || '' === $key ) {
			return '';
		}

		return '<svg width="' . esc_attr( (string) $size ) . '" height="' . esc_attr( (string) $size ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
	}
}

$show_hero   = 'yes' === ( $settings['show_hero'] ?? 'yes' );
$label       = $settings['section_label'] ?? '';
$title       = $settings['title'] ?? '';
$description = $settings['description'] ?? '';
$cards       = $settings['cards'] ?? array();
$id          = $this->get_id();
?>

<section class="shopbar-ci-section shopbar-ci-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-ci-inner">

		<?php if ( $show_hero && ( $label || $title || $description ) ) : ?>
			<div class="shopbar-ci-hero">
				<?php if ( $label ) : ?>
					<span class="shopbar-ci-label"><?php echo esc_html( $label ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h2 class="shopbar-ci-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<p class="shopbar-ci-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $cards ) && is_array( $cards ) ) : ?>
			<div class="shopbar-ci-grid">

				<?php foreach ( $cards as $card ) :
					$icon     = $card['icon'] ?? '';
					$title    = $card['title'] ?? '';
					$subtitle = $card['subtitle'] ?? '';
					$highlight= $card['highlight'] ?? '';
					$link     = $card['link'] ?? array();
					$url      = ! empty( $link['url'] ) ? $link['url'] : '';

					$tag      = $url ? 'a' : 'div';
					$href     = $url ? ' href="' . esc_url( $url ) . '"' : '';
					$target   = ( $url && ! empty( $link['is_external'] ) ) ? ' target="_blank"' : '';
					$nofollow = ( $url && ! empty( $link['nofollow'] ) ) ? ' rel="nofollow"' : '';
				?>
					<<?php echo esc_attr( $tag ); ?> class="shopbar-ci-card"<?php echo $href . $target . $nofollow; // phpcs:ignore ?>>
						<?php if ( $icon ) : ?>
							<span class="shopbar-ci-icon"><?php echo shopbar_ci_render_icon( $icon ); // phpcs:ignore ?></span>
						<?php endif; ?>

						<?php if ( $title ) : ?>
							<h3 class="shopbar-ci-card-title"><?php echo esc_html( $title ); ?></h3>
						<?php endif; ?>

						<?php if ( $subtitle ) : ?>
							<p class="shopbar-ci-subtitle"><?php echo esc_html( $subtitle ); ?></p>
						<?php endif; ?>

						<?php if ( $highlight ) : ?>
							<p class="shopbar-ci-highlight"><?php echo esc_html( $highlight ); ?></p>
						<?php endif; ?>
					</<?php echo esc_attr( $tag ); ?>>
				<?php endforeach; ?>

			</div>
		<?php endif; ?>

	</div>
</section>

<style>
	.shopbar-ci-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--ci-accent: #B8977E;
		width: 100%;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> *,
	.shopbar-ci-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-ci-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-inner {
		width: 100%;
		max-width: 1350px;
		margin: 0 auto;
		padding: 0 24px;
	}

	/* ── Hero ───────────────────────────────────────────── */
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-hero {
		text-align: center;
		max-width: 700px;
		margin: 0 auto 18px;
		padding: 60px 0 0;
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 0;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-label {
		display: inline-block;
		font-family: var(--font-mono, 'DM Mono', monospace);
		font-size: 13px;
		font-weight: 600;
		letter-spacing: 2px;
		text-transform: uppercase;
		line-height: 1.2em;
		color: var(--ci-accent);
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-title {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 40px;
		font-weight: 600;
		line-height: 1.2em;
		letter-spacing: -0.01em;
		color: #1C1C1C;
		margin: 14px 0 16px;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-desc {
		font-size: 16px;
		line-height: 1.7em;
		color: #6B6560;
		margin: 0;
		max-width: 640px;
	}

	/* ── Grid + Cards ───────────────────────────────────── */
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		column-gap: 24px;
		row-gap: 24px;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-card {
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		text-decoration: none;
		background-color: #FFFFFF;
		border: 1px solid #E8E4DF;
		border-radius: 14px;
		padding: 32px 26px;
		transition: box-shadow .25s ease, transform .25s ease;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-card:hover {
		transform: translateY(-2px);
		box-shadow: 0 10px 30px rgba(28, 28, 28, 0.08);
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 60px;
		height: 60px;
		background-color: #F3EFEA;
		border-radius: 50%;
		margin-bottom: 18px;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-card-title {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 18px;
		font-weight: 600;
		line-height: 1.3em;
		color: #1C1C1C;
		margin: 0 0 10px;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-subtitle {
		font-size: 14px;
		line-height: 1.6em;
		color: #6B6560;
		margin: 0 0 4px;
	}
	.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-highlight {
		font-size: 14px;
		line-height: 1.6em;
		font-weight: 600;
		color: #1C1C1C;
		margin: 0;
	}

	/* ── Responsive ─────────────────────────────────────── */
	@media (max-width: 1024px) {
		.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-title { font-size: 34px; }
	}
	@media (max-width: 768px) {
		.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-hero { padding-top: 40px; }
		.shopbar-ci-<?php echo esc_attr( $id ); ?> .shopbar-ci-title { font-size: 28px; }
	}
</style>
