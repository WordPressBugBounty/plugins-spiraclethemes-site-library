<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Features Bar
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly;

/**
 * Outline SVG icons (Shopbar style: 24x24 viewBox, stroke based).
 *
 * @param string $key  Icon key.
 * @param int    $size Pixel size.
 * @return string SVG markup.
 */
if ( ! function_exists( 'shopbar_fb_render_icon' ) ) {
	function shopbar_fb_render_icon( $key, $size = 24 ) {
		$icons = array(
			'truck'       => '<path d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path d="M14 9h4l4 4v4c0 .6-.4 1-1 1h-2"/><circle cx="7" cy="18" r="2"/><path d="M15 18H9"/><circle cx="17" cy="18" r="2"/>',
			'returns'     => '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M3 21v-5h5"/>',
			'credit-card' => '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
			'headset'     => '<path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5a9 9 0 0 1 18 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/>',
			'shield'      => '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/>',
			'clock'       => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
			'wallet'      => '<path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>',
			'lock'        => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
			'badge'       => '<path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/>',
			'gift'        => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>',
			'zap'         => '<path d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z"/>',
			'phone'       => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
			'mail'        => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
			'tag'         => '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>',
			'sparkles'    => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
		);

		if ( ! isset( $icons[ $key ] ) || '' === $key ) {
			return '';
		}

		return '<svg width="' . esc_attr( (string) $size ) . '" height="' . esc_attr( (string) $size ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
	}
}

$features   = $settings['features'] ?? array();
$enable_bar = $settings['enable_bar'] ?? 'yes';
$item_layout = $settings['item_layout'] ?? 'horizontal';
$show_divider = $settings['show_divider'] ?? 'yes';
$id         = $this->get_id();

if ( empty( $features ) ) {
	return;
}
?>

<section class="shopbar-fb-section shopbar-fb-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-fb-inner">
	<?php if ( 'yes' === $enable_bar ) : ?>
		<div class="shopbar-fb">
	<?php endif; ?>
		<div class="shopbar-fb-grid<?php echo ( 'yes' === $show_divider ) ? ' shopbar-fb-grid--dividers' : ''; ?>">
			<?php foreach ( $features as $feature ) :
				$icon    = $feature['icon'] ?? '';
				$title   = $feature['title'] ?? '';
				$subtitle= $feature['subtitle'] ?? '';
				$link    = $feature['link'] ?? array();
				$url     = ! empty( $link['url'] ) ? $link['url'] : '';

				$tag     = $url ? 'a' : 'div';
				$href    = $url ? ' href="' . esc_url( $url ) . '"' : '';
				$target  = ( $url && ! empty( $link['is_external'] ) ) ? ' target="_blank"' : '';
				$nofollow= ( $url && ! empty( $link['nofollow'] ) ) ? ' rel="nofollow"' : '';
			?>
			<<?php echo esc_attr( $tag ); ?> class="shopbar-fb-item shopbar-fb-item--<?php echo esc_attr( $item_layout ); ?>"<?php echo $href . $target . $nofollow; // phpcs:ignore ?>>
				<?php if ( $icon ) : ?>
					<span class="shopbar-fb-icon"><?php echo shopbar_fb_render_icon( $icon ); // phpcs:ignore ?></span>
				<?php endif; ?>
				<span class="shopbar-fb-text">
					<?php if ( $title ) : ?>
						<span class="shopbar-fb-title"><?php echo esc_html( $title ); ?></span>
					<?php endif; ?>
					<?php if ( $subtitle ) : ?>
						<span class="shopbar-fb-subtitle"><?php echo esc_html( $subtitle ); ?></span>
					<?php endif; ?>
				</span>
			</<?php echo esc_attr( $tag ); ?>>
			<?php endforeach; ?>
		</div>
	<?php if ( 'yes' === $enable_bar ) : ?>
		</div>
	<?php endif; ?>
	</div>
</section>

<style>
	.shopbar-fb-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--fb-accent: #B8977E;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> {
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> *,
	.shopbar-fb-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-fb-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-inner {
		max-width: 1350px;
		margin: 0 auto;
		width: 100%;
		padding: 0 24px;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb {
		box-sizing: border-box;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		column-gap: 16px;
		row-gap: 16px;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-item {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 14px;
		text-decoration: none;
		text-align: center;
		transition: transform .25s ease;
		position: relative;
	}
	/* Vertical separator line between items, centered exactly in the column gap. */
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-item::after {
		content: '';
		position: absolute;
		top: 50%;
		left: calc(100% + var(--fb-gap, 16px) / 2);
		width: 1px;
		height: 50%;
		max-height: 46px;
		transform: translate(-50%, -50%);
		background: #E8E2DA;
		display: none;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid--dividers .shopbar-fb-item::after { display: block; }
	/* Never draw a line after the final item. */
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid--dividers .shopbar-fb-item:last-child::after { display: none; }
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-item--vertical {
		flex-direction: column;
		align-items: flex-start;
		gap: 12px;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-icon {
		flex: 0 0 auto;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 54px;
		height: 54px;
		background: #F3EFEA;
		border-radius: 14px;
		transition: background .25s ease, box-shadow .25s ease, transform .25s ease;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-item:hover .shopbar-fb-icon {
		transform: translateY(-2px);
		box-shadow: 0 8px 18px -6px rgba(184, 151, 126, 0.55);
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-text {
		display: flex;
		flex-direction: column;
		gap: 2px;
		min-width: 0;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-title {
		font-size: 16px;
		font-weight: 700;
		color: #1C1C1C;
		line-height: 1.3;
	}
	.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-subtitle {
		font-size: 13px;
		font-weight: 400;
		color: #6B6560;
		line-height: 1.4;
	}
	@media (max-width: 768px) {
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-item {
			gap: 12px;
		}
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-icon {
			width: 46px;
			height: 46px;
		}
		/* Single column: no separators needed. */
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid--dividers .shopbar-fb-item::after { display: none; }
	}
	/* Tablet & mobile */
	@media (max-width: 1024px) {
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid .shopbar-fb-item {
			text-align: left;
			justify-content: flex-start;
		}
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid .shopbar-fb-item--vertical {
			align-items: flex-start;
		}
	}
	@media (min-width: 769px) and (max-width: 1024px) {
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid--dividers .shopbar-fb-item:nth-child(2n)::after { display: none; }
	}
	
	@media (min-width: 1025px) {
		.shopbar-fb-<?php echo esc_attr( $id ); ?> .shopbar-fb-grid--dividers .shopbar-fb-item:nth-child(4n)::after { display: none; }
	}
</style>
