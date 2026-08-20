<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Categories
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;

$categories   = $settings['categories'] ?? array();
$show_header  = $settings['show_header'] ?? 'yes';
$image_fit    = $settings['image_fit'] ?? 'contain';
$show_arrow   = $settings['show_arrow'] ?? 'yes';
$placeholder  = \Elementor\Utils::get_placeholder_image_src();
$id           = $this->get_id();

if ( empty( $categories ) ) {
	return;
}

$arrow_svg = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
?>

<section class="shopbar-cg-section shopbar-cg-<?php echo esc_attr( $id ); ?> shopbar-cg-section--fit-<?php echo esc_attr( $image_fit ); ?>">
	<div class="shopbar-cg-inner">

		<?php if ( 'yes' === $show_header && ( ! empty( $settings['header_eyebrow'] ) || ! empty( $settings['header_title'] ) || ! empty( $settings['header_desc'] ) ) ) : ?>
		<div class="shopbar-cg-head">
			<?php if ( ! empty( $settings['header_eyebrow'] ) ) : ?>
				<span class="shopbar-cg-eyebrow"><?php echo esc_html( $settings['header_eyebrow'] ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $settings['header_title'] ) ) : ?>
				<h2 class="shopbar-cg-heading"><?php echo esc_html( $settings['header_title'] ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $settings['header_desc'] ) ) : ?>
				<p class="shopbar-cg-desc"><?php echo esc_html( $settings['header_desc'] ); ?></p>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<div class="shopbar-cg-grid">
			<?php foreach ( $categories as $cat ) :
				$title    = $cat['title'] ?? '';
				$subtitle = $cat['subtitle'] ?? '';
				$badge    = $cat['badge'] ?? '';
				$link     = $cat['link'] ?? array();
				$img      = $cat['image'] ?? array();
				$img_url  = ! empty( $img['url'] ) ? $img['url'] : $placeholder;
				$img_alt  = ! empty( $img['alt'] ) ? $img['alt'] : $title;

				$url      = ! empty( $link['url'] ) ? $link['url'] : '';
				$tag      = $url ? 'a' : 'div';
				$href     = $url ? ' href="' . esc_url( $url ) . '"' : '';
				$target   = ( $url && ! empty( $link['is_external'] ) ) ? ' target="_blank"' : '';
				$nofollow = ( $url && ! empty( $link['nofollow'] ) ) ? ' rel="nofollow"' : '';
			?>
			<<?php echo esc_attr( $tag ); ?> class="shopbar-cg-card"<?php echo $href . $target . $nofollow; // phpcs:ignore ?>>
				<div class="shopbar-cg-media">
					<?php if ( $badge ) : ?>
						<span class="shopbar-cg-badge"><?php echo esc_html( $badge ); ?></span>
					<?php endif; ?>
					<img class="shopbar-cg-img" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy" />
				</div>
				<div class="shopbar-cg-body">
					<div class="shopbar-cg-text">
						<?php if ( $title ) : ?>
							<h4 class="shopbar-cg-title"><?php echo esc_html( $title ); ?></h4>
						<?php endif; ?>
						<?php if ( $subtitle ) : ?>
							<span class="shopbar-cg-sub"><?php echo esc_html( $subtitle ); ?></span>
						<?php endif; ?>
					</div>
					<?php if ( 'yes' === $show_arrow ) : ?>
						<span class="shopbar-cg-arrow"><?php echo $arrow_svg; // phpcs:ignore ?></span>
					<?php endif; ?>
				</div>
			</<?php echo esc_attr( $tag ); ?>>
			<?php endforeach; ?>
		</div>

	</div>
</section>

<style>
	.shopbar-cg-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--cg-accent: #B8977E;
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> *,
	.shopbar-cg-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-cg-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-inner {
		max-width: 1350px;
		margin: 0 auto;
		width: 100%;
		padding: 0 24px;
	}

	/* ── Section header ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-head {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 8px;
		margin-bottom: 28px;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-eyebrow {
		font-size: 12.5px;
		font-weight: 700;
		letter-spacing: 0.14em;
		text-transform: uppercase;
		color: var(--cg-accent);
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-heading {
		font-size: 30px;
		font-weight: 800;
		line-height: 1.2;
		color: #1C1C1C;
		margin: 0;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-desc {
		font-size: 15px;
		line-height: 1.6;
		color: #6B6560;
		margin: 0;
		max-width: 560px;
	}

	/* ── Grid ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-grid {
		display: grid;
		grid-template-columns: repeat(6, minmax(0, 1fr));
		column-gap: 18px;
		row-gap: 18px;
	}

	/* ── Card ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-card {
		display: flex;
		flex-direction: column;
		text-decoration: none;
		background: #FFFFFF;
		border: 1px solid #E8E2DA;
		border-radius: 18px;
		padding: 0;
		box-shadow: 0 6px 22px -8px rgba(28, 28, 28, 0.08);
		overflow: hidden;
		transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-card:hover {
		transform: translateY(-6px);
		box-shadow: 0 18px 40px -12px rgba(184, 151, 126, 0.22);
		border-color: #D8C9B8;
	}

	/* ── Media stage (edge-to-edge, clipped by card corners) ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-media {
		position: relative;
		height: 150px;
		border-radius: 0;
		background: #F3EFEA;
		display: flex;
		align-items: center;
		justify-content: center;
		overflow: hidden;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-img {
		transition: transform .4s ease;
	}
	.shopbar-cg-section--fit-contain.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-img {
		max-width: 82%;
		max-height: 82%;
		width: auto;
		height: auto;
		object-fit: contain;
	}
	.shopbar-cg-section--fit-cover.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	/* ── Badge ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-badge {
		position: absolute;
		top: 10px;
		left: 10px;
		z-index: 2;
		display: inline-flex;
		align-items: center;
		background: var(--cg-accent);
		color: #FFFFFF;
		font-size: 11px;
		font-weight: 700;
		letter-spacing: 0.02em;
		padding: 4px 10px;
		border-radius: 30px;
	}

	/* ── Body ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-body {
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 12px;
		padding: 16px 14px;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-text {
		display: flex;
		flex-direction: column;
		gap: 3px;
		min-width: 0;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-title {
		font-size: 16px;
		font-weight: 700;
		color: #1C1C1C;
		line-height: 1.3;
		margin: 0;
		transition: color .25s ease;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-sub {
		font-size: 13px;
		font-weight: 500;
		color: #6B6560;
		line-height: 1.4;
	}

	/* ── Arrow CTA ── */
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-arrow {
		flex: 0 0 auto;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 38px;
		height: 38px;
		border-radius: 30px;
		background: #E8E2DA;
		color: #1C1C1C;
		transition: transform .3s ease, background .3s ease, color .3s ease;
	}
	.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-card:hover .shopbar-cg-arrow {
		transform: translateX(3px);
		background: var(--cg-accent);
		color: #FFFFFF;
	}

	@media (max-width: 1024px) {
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-heading { font-size: 26px; }
	}
	@media (max-width: 768px) {
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-head { margin-bottom: 22px; }
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-heading { font-size: 23px; }
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-media { height: 120px; }
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-card { padding: 0; }
	}
	@media (max-width: 480px) {
		.shopbar-cg-<?php echo esc_attr( $id ); ?> .shopbar-cg-grid { grid-template-columns: repeat(1, minmax(0, 1fr)); }
	}
</style>
