<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * CTA / Call to Action
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
if ( ! function_exists( 'shopbar_cta_render_icon' ) ) {
	function shopbar_cta_render_icon( $key, $size = 24 ) {
		$icons = array(
			'bag'         => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
			'cart'        => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>',
			'tag'         => '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>',
			'gift'        => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>',
			'credit-card' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
			'sparkles'    => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
			'truck'       => '<path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><path d="M15 18H9"/><circle cx="17" cy="18" r="2"/>',
			'zap'         => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>',
			'percent'     => '<line x1="19" x2="5" y1="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/>',
		);

		if ( ! isset( $icons[ $key ] ) || '' === $key ) {
			return '';
		}

		return '<svg width="' . esc_attr( (string) $size ) . '" height="' . esc_attr( (string) $size ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
	}
}

$eyebrow     = $settings['eyebrow_text'] ?? '';
$title       = $settings['cta_title'] ?? '';
$description = $settings['cta_description'] ?? '';
$btn_text    = $settings['btn_text'] ?? '';
$btn_url     = $settings['btn_url'] ?? array();

$show_secondary = $settings['show_secondary_btn'] ?? 'no';
$sec_text       = $settings['secondary_btn_text'] ?? '';
$sec_url        = $settings['secondary_btn_url'] ?? array();

$cta_bg_type = $settings['cta_bg_type'] ?? 'gradient';
$overflow_hidden = $settings['overflow_hidden'] ?? 'yes';

/* Discount badge. */
$show_badge   = $settings['show_badge'] ?? 'yes';
$badge_top    = $settings['badge_top_text'] ?? '';
$badge_main   = $settings['badge_main_text'] ?? '';
$badge_bottom = $settings['badge_bottom_text'] ?? '';

/* Primary button link attributes. */
$btn_link     = ! empty( $btn_url['url'] ) ? esc_url( $btn_url['url'] ) : '#';
$btn_target   = ! empty( $btn_url['is_external'] ) ? ' target="_blank"' : '';
$btn_nofollow = ! empty( $btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

/* Secondary button link attributes. */
$sec_link     = ! empty( $sec_url['url'] ) ? esc_url( $sec_url['url'] ) : '#';
$sec_target   = ! empty( $sec_url['is_external'] ) ? ' target="_blank"' : '';
$sec_nofollow = ! empty( $sec_url['nofollow'] ) ? ' rel="nofollow"' : '';

/* Gradient background. */
$gradient_c1  = $settings['gradient_color_1'] ?? '#1C1C1C';
$gradient_c2  = $settings['gradient_color_2'] ?? '#2A2622';
$gradient_dir = $settings['gradient_direction'] ?? '135deg';

/* Decorative shopping icons. */
$show_decor   = 'yes' === ( $settings['show_decor_icons'] ?? 'yes' );
$decor_color  = $settings['decor_color'] ?? '#FFFFFF';
$decor_opacity = max( 0, min( 100, isset( $settings['decor_opacity']['size'] ) ? intval( $settings['decor_opacity']['size'] ) : 100 ) ) / 100;
$decor_size    = max( 0.4, min( 2, ( isset( $settings['decor_size']['size'] ) ? intval( $settings['decor_size']['size'] ) : 100 ) / 100 ) );

/* Build the band background. */
if ( 'solid' === $cta_bg_type ) {
	$band_bg_style = '';
} else {
	$band_bg_style = sprintf(
		'background: linear-gradient(%1$s, %2$s, %3$s);',
		esc_attr( $gradient_dir ),
		esc_attr( $gradient_c1 ),
		esc_attr( $gradient_c2 )
	);
}

$id = $this->get_id();
?>

<section class="shopbar-cta-section shopbar-cta-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-cta-inner">
		<div class="shopbar-cta-band<?php echo 'yes' === $overflow_hidden ? ' shopbar-cta-band--clip' : ''; ?>"<?php echo '' !== $band_bg_style ? ' style="' . esc_attr( $band_bg_style ) . '"' : ''; ?>>

			<?php if ( 'yes' === $show_badge && ( $badge_top || $badge_main || $badge_bottom ) ) : ?>
				<div class="shopbar-cta-badge">
					<?php if ( $badge_top ) : ?><small><?php echo esc_html( $badge_top ); ?></small><?php endif; ?>
					<?php if ( $badge_main ) : ?><strong><?php echo esc_html( $badge_main ); ?></strong><?php endif; ?>
					<?php if ( $badge_bottom ) : ?><small><?php echo esc_html( $badge_bottom ); ?></small><?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $show_decor ) : ?>
				<div class="shopbar-cta-decor" aria-hidden="true" style="color:<?php echo esc_attr( $decor_color ); ?>">
					<?php
					$decor = array(
						array( 'bag',         130, 24,  40,  0.06, -8 ),
						array( 'cart',         84, 150, 78,  0.07, -5 ),
						array( 'tag',          64, 96,  186, 0.09, 14 ),
						array( 'percent',      74, 36,  210, 0.07, -10 ),
						array( 'sparkles',     46, 210, 168, 0.10, 0 ),
						array( 'gift',         56, 190, 44,  0.06, 9 ),
					);
					foreach ( $decor as $d ) {
						list( $d_icon, $d_size, $d_bottom, $d_right, $d_op, $d_rot ) = $d;
						printf(
							'<span class="shopbar-cta-decor-item" style="bottom:%2$dpx;right:%3$dpx;opacity:%4$.2f;transform:scale(%5$.2f) rotate(%6$ddeg)">%1$s</span>',
							shopbar_cta_render_icon( $d_icon, $d_size ), // phpcs:ignore
							$d_bottom,
							$d_right,
							( $decor_opacity * $d_op ),
							$decor_size,
							$d_rot
						);
					}
					?>
				</div>
			<?php endif; ?>

			<div class="shopbar-cta-content">
				<?php if ( $eyebrow ) : ?>
					<span class="shopbar-cta-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<h2 class="shopbar-cta-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
				<?php endif; ?>

				<?php if ( $description ) : ?>
					<p class="shopbar-cta-desc"><?php echo esc_html( $description ); ?></p>
				<?php endif; ?>

				<?php if ( $btn_text || ( 'yes' === $show_secondary && $sec_text ) ) : ?>
					<div class="shopbar-cta-actions">
						<?php if ( $btn_text ) : ?>
							<a class="shopbar-cta-btn shopbar-cta-btn--primary" href="<?php echo esc_url( $btn_link ); ?>"<?php echo esc_attr( $btn_target ); // phpcs:ignore ?><?php echo ' ' . esc_attr( trim( $btn_nofollow ) ); ?>>
								<span><?php echo esc_html( $btn_text ); ?></span>
								<?php
								if ( ! empty( $settings['btn_icon']['value'] ) ) {
									\Elementor\Icons_Manager::render_icon( $settings['btn_icon'], array( 'aria-hidden' => 'true' ) );
								}
								?>
							</a>
						<?php endif; ?>

						<?php if ( 'yes' === $show_secondary && $sec_text ) : ?>
							<a class="shopbar-cta-btn shopbar-cta-btn--secondary" href="<?php echo esc_url( $sec_link ); ?>"<?php echo esc_attr( $sec_target ); // phpcs:ignore ?><?php echo ' ' . esc_attr( trim( $sec_nofollow ) ); ?>>
								<?php echo esc_html( $sec_text ); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>

<style>
	.shopbar-cta-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--cta-accent: var(--brand-accent-warm, #B8977E);
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> *,
	.shopbar-cta-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-cta-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	/* Content band — mirrors the theme header/footer container. */
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-inner {
		max-width: 1350px;
		margin: 0 auto;
		width: 100%;
		padding: 0 24px;
	}

	/* ── Band ── */
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-band {
		position: relative;
		min-height: 360px;
		border-radius: 16px;
		display: flex;
		align-items: center;
		overflow: visible;
		background: #1C1C1C;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-band--clip { overflow: hidden; }

	/* ── Decorative shopping icons ── */
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-decor {
		position: absolute;
		inset: 0;
		z-index: 1;
		pointer-events: none;
		color: #FFFFFF;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-decor-item {
		position: absolute;
		line-height: 0;
		filter: drop-shadow(0 4px 12px rgba(0,0,0,0.20));
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-decor-item svg {
		display: block;
		stroke-width: 1.5;
	}

	/* ── Content ── */
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-content {
		position: relative;
		z-index: 2;
		max-width: 70%;
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-eyebrow {
		display: inline-block;
		font-family: var(--font-mono, 'DM Mono', monospace);
		font-size: 12.5px;
		font-weight: 500;
		letter-spacing: 0.14em;
		text-transform: uppercase;
		color: var(--cta-accent);
		margin-bottom: 16px;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-title {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 44px;
		font-weight: 500;
		line-height: 1.1em;
		letter-spacing: -0.02em;
		color: #FFFFFF;
		margin: 0 0 18px;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-desc {
		font-size: 16px;
		line-height: 1.6;
		color: #D9D2C8;
		margin: 0 0 32px;
	}

	/* ── Actions ── */
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-actions {
		display: flex;
		align-items: center;
		flex-wrap: wrap;
		gap: 14px;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		font-weight: 600;
		font-size: 15px;
		text-decoration: none;
		white-space: nowrap;
		transition: background .25s ease, color .25s ease, border-color .25s ease, transform .25s ease;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-btn:hover { transform: translateY(-2px); }
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-btn--primary {
		background: #FFFFFF;
		color: #1C1C1C;
		padding: 15px 30px;
		border-radius: 8px;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-btn--secondary {
		background: transparent;
		color: #FFFFFF;
		border: 1px solid rgba(255,255,255,0.35);
		padding: 14px 29px;
		border-radius: 8px;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-btn svg,
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-btn i { width: 16px; height: 16px; font-size: 16px; }

	/* ── Discount badge ── */
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-badge {
		position: absolute;
		top: 40px;
		right: 40px;
		width: 104px;
		height: 104px;
		border-radius: 50%;
		background: #FF3D81;
		color: #fff;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		text-align: center;
		line-height: 1.2;
		font-weight: 700;
		box-shadow: 0 12px 32px rgba(255, 61, 129, 0.40);
		border: 4px solid rgba(255,255,255,0.55);
		z-index: 3;
	}
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-badge small { font-size: 11px; letter-spacing: 1.4px; opacity: .92; }
	.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-badge strong { font-size: 24px; }

	/* ── Responsive ── */
	@media (max-width: 1024px) {
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-title { font-size: 38px; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-decor { transform: scale(0.85); transform-origin: bottom right; }
	}
	@media (max-width: 768px) {
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-content { max-width: 100% !important; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-title { font-size: 30px; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-actions { width: 100%; flex-direction: column; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-actions .shopbar-cta-btn { width: 100%; max-width: 320px; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-badge { width: 78px; height: 78px; top: 18px; right: 18px; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-badge strong { font-size: 18px; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-badge small { font-size: 9px; }
		.shopbar-cta-<?php echo esc_attr( $id ); ?> .shopbar-cta-decor { display: none; }
	}
</style>
