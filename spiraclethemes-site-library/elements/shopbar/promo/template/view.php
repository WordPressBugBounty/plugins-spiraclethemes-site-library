<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Promo Banner
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;

$items          = $settings['items'] ?? array();
$media_position = $settings['media_position'] ?? 'right';
$id             = $this->get_id();

if ( empty( $items ) ) {
	return;
}

/* Lucide "arrow-right" used inside the CTA chip. */
$arrow_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';
?>

<section class="shopbar-pm-section shopbar-pm-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-pm-inner">
		<div class="shopbar-pm-grid">
			<?php foreach ( $items as $item ) :
				$tag      = $item['tag'] ?? '';
				$title    = $item['title'] ?? '';
				$desc     = $item['description'] ?? '';
				$show_p   = ( 'yes' === ( $item['show_price'] ?? '' ) );
				$price_now= $item['price_now'] ?? '';
				$price_old= $item['price_old'] ?? '';
				$btn_text = $item['button_text'] ?? '';
				$link     = $item['link'] ?? array();
				$url      = ! empty( $link['url'] ) ? $link['url'] : '#';
				$target   = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
				$nofollow = ! empty( $link['nofollow'] ) ? ' rel="nofollow"' : '';
				$img      = $item['image'] ?? array();
				$img_url  = ! empty( $img['url'] ) ? $img['url'] : '';
				$ghost    = $item['ghost_text'] ?? '';
				$has_img  = ( 'hidden' !== $media_position && $img_url );
			?>
			<article class="shopbar-pm-card">
				<?php if ( $has_img && 'left' === $media_position ) : ?>
					<div class="shopbar-pm-media">
						<?php echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( wp_strip_all_tags( $title ) ) . '" loading="lazy">'; // phpcs:ignore ?>
					</div>
				<?php endif; ?>

				<div class="shopbar-pm-content">
					<?php if ( $ghost ) : ?>
						<span class="shopbar-pm-ghost" aria-hidden="true"><?php echo esc_html( $ghost ); ?></span>
					<?php endif; ?>
					<?php if ( $tag ) : ?>
						<span class="shopbar-pm-tag"><?php echo esc_html( $tag ); ?></span>
					<?php endif; ?>

					<?php if ( $title ) : ?>
						<h3 class="shopbar-pm-title"><?php echo esc_html( $title ); ?></h3>
					<?php endif; ?>

					<?php if ( $desc ) : ?>
						<p class="shopbar-pm-desc"><?php echo esc_html( $desc ); ?></p>
					<?php endif; ?>

					<?php if ( $show_p && ( $price_now || $price_old ) ) : ?>
						<div class="shopbar-pm-price">
							<?php if ( $price_now ) : ?>
								<span class="shopbar-pm-price-now"><?php echo esc_html( $price_now ); ?></span>
							<?php endif; ?>
							<?php if ( $price_old ) : ?>
								<span class="shopbar-pm-price-old"><?php echo esc_html( $price_old ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( $btn_text ) : ?>
						<a class="shopbar-pm-btn" href="<?php echo esc_url( $url ); ?>"<?php echo $target . $nofollow; // phpcs:ignore ?>>
							<span class="shopbar-pm-btn-label"><?php echo esc_html( $btn_text ); ?></span>
							<span class="shopbar-pm-btn-icon"><?php echo $arrow_svg; // phpcs:ignore ?></span>
						</a>
					<?php endif; ?>
				</div>

				<?php if ( $has_img && 'right' === $media_position ) : ?>
					<div class="shopbar-pm-media">
						<?php echo '<img src="' . esc_url( $img_url ) . '" alt="' . esc_attr( wp_strip_all_tags( $title ) ) . '" loading="lazy">'; // phpcs:ignore ?>
					</div>
				<?php endif; ?>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<style>
	.shopbar-pm-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--pm-accent: #B8977E;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> *,
	.shopbar-pm-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-pm-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-inner {
		width: 100%;
		max-width: 1350px;
		margin: 0 auto;
		padding: 0 24px;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-grid {
		display: grid;
		grid-template-columns: repeat(1, minmax(0, 1fr));
		column-gap: 24px;
		row-gap: 24px;
	}

	/* ── Card ───────────────────────────────────────────── */
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-card {
		position: relative;
		display: flex;
		align-items: stretch;
		overflow: hidden;
		background-color: #F3EFEA;
		border-radius: 10px;
		min-height: 340px;
		box-shadow: 0 10px 34px -12px rgba(28, 28, 28, 0.08);
		transition: box-shadow .35s ease, transform .35s ease;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-card:hover {
		box-shadow: 0 18px 50px -16px rgba(28, 28, 28, 0.16);
	}

	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-card::before {
		content: '';
		position: absolute;
		top: -40%;
		left: -15%;
		width: 55%;
		height: 180%;
		background: radial-gradient(circle, rgba(184, 151, 126, 0.16) 0%, rgba(184, 151, 126, 0) 65%);
		pointer-events: none;
		z-index: 0;
	}

	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-ghost {
		position: absolute;
		right: -8px;
		bottom: -44px;
		font-family: var(--font-display, 'Fraunces', serif);
		font-weight: 700;
		font-size: 200px;
		line-height: 0.8;
		color: #1C1C1C;
		opacity: 0.06;
		letter-spacing: -0.04em;
		pointer-events: none;
		z-index: 0;
		user-select: none;
	}

	/* ── Content ────────────────────────────────────────── */
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-content {
		position: relative;
		overflow: hidden;
		z-index: 2;
		flex: 1 1 50%;
		display: flex;
		flex-direction: column;
		justify-content: center;
		padding: 44px 48px;
		min-width: 0;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?>.shopbar-pm-align-center .shopbar-pm-content { align-items: center; text-align: center; }

	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-tag {
		display: inline-flex;
		align-items: center;
		align-self: flex-start;
		margin: 0 0 18px;
		padding: 7px 16px;
		background-color: var(--pm-accent);
		color: #fff;
		font-size: 12px;
		font-weight: 600;
		letter-spacing: 0.8px;
		text-transform: uppercase;
		border-radius: 50px;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?>.shopbar-pm-align-center .shopbar-pm-tag { align-self: center; }

	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-title {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 38px;
		font-weight: 600;
		line-height: 1.1;
		color: #1C1C1C;
		margin: 0 0 14px;
		letter-spacing: -0.01em;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-desc {
		font-size: 15px;
		line-height: 1.6;
		color: #6B6560;
		margin: 0 0 20px;
		max-width: 420px;
	}

	/* ── Price ──────────────────────────────────────────── */
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-price {
		display: flex;
		align-items: baseline;
		gap: 12px;
		margin: 0 0 24px;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-price-now {
		font-size: 28px;
		font-weight: 700;
		color: #1C1C1C;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-price-old {
		font-size: 16px;
		font-weight: 500;
		color: #9C9792;
		text-decoration: line-through;
	}

	/* ── Button ─────────────────────────────────────────── */
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-btn {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		align-self: flex-start;
		padding: 14px 26px;
		background-color: #1C1C1C;
		color: #fff;
		font-size: 14px;
		font-weight: 600;
		text-decoration: none;
		border-radius: 50px;
		transition: background-color .3s ease, box-shadow .3s ease;
		margin: 0;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?>.shopbar-pm-align-center .shopbar-pm-btn { align-self: center; }
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-btn:hover { box-shadow: 0 10px 24px -10px rgba(28, 28, 28, 0.45); }
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-btn-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		transition: transform .3s ease;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-btn:hover .shopbar-pm-btn-icon { transform: translateX(4px); }

	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-media {
		position: relative;
		z-index: 2;
		flex: 0 0 50%;
		width: 50%;
		align-self: stretch;
		overflow: hidden;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-media img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
		transition: transform .5s ease;
	}
	.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-card:hover .shopbar-pm-media img { transform: scale(1.04); }

	.shopbar-pm-media-hidden .shopbar-pm-content { flex: 1 1 100%; }

	/* ── Responsive ─────────────────────────────────────── */
	@media (max-width: 768px) {
		.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-card { flex-direction: column; min-height: 0; }
		.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-media {
			flex: 0 0 auto;
			width: 100%;
			min-height: 240px;
			order: -1 !important;
		}
		.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-content { padding: 28px; }
		.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-title { font-size: 30px; }
		.shopbar-pm-<?php echo esc_attr( $id ); ?> .shopbar-pm-ghost { font-size: 130px; bottom: -28px; right: -4px; }
	}
</style>
