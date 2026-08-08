<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonprefixedVariableFound
/**
 * Stats
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$stats = $settings['stats'] ?? array();
$full  = 'full' === ( $settings['band_max_width'] ?? 'full' );

/**
 * Split a stat value into a leading numeric part (rendered as the main
 * number) and the trailing symbol (rendered with the accent color).
 * Falls back to the full value if there is no leading digit.
 *
 * @param string $value Raw stat value.
 * @return array{0:string,1:string} [main, accent]
 */
$shopbar_st_split = function ( $value ) {
	if ( preg_match( '/^([\d.,]+)/u', $value, $m ) ) {
		$main   = $m[1];
		$accent = substr( $value, strlen( $m[1] ) );
		return array( $main, $accent );
	}
	return array( $value, '' );
};

$id = $this->get_id();
?>

<section class="shopbar-st-section shopbar-st-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-st-inner">
		<div class="shopbar-st-grid">

			<?php if ( ! empty( $stats ) && is_array( $stats ) ) :
				foreach ( $stats as $index => $item ) :
					$value = $item['value'] ?? '';
					$label = $item['label'] ?? '';
					if ( '' === $value && '' === $label ) {
						continue;
					}
					list( $main, $accent ) = $shopbar_st_split( $value );
			?>
				<div class="shopbar-st-item elementor-repeater-item-<?php echo esc_attr( $item['_id'] ?? '' ); ?>">
					<?php if ( $value ) : ?>
						<h3 class="shopbar-st-value">
							<?php echo esc_html( $main ); ?><?php if ( $accent ) : ?><span class="shopbar-st-value-accent"><?php echo esc_html( $accent ); ?></span><?php endif; ?>
						</h3>
					<?php endif; ?>
					<?php if ( $label ) : ?>
						<p class="shopbar-st-label"><?php echo esc_html( $label ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach;
			endif; ?>

		</div>
	</div>
</section>

<style>
	.shopbar-st-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--st-accent: #B8977E;
		width: 100%;
	}
	.shopbar-st-<?php echo esc_attr( $id ); ?> *,
	.shopbar-st-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-st-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-inner {
		background-color: #F3EFEA;
		padding: 48px 40px;
	}
	<?php if ( ! $full ) : ?>
	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-inner {
		max-width: 1350px;
		margin: 0 auto;
		border-radius: 16px;
	}
	<?php endif; ?>

	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		justify-items: center;
	}

	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-item {
		text-align: center;
		border-left: 0 solid #E8E4DF;
		padding-left: 0;
		padding-right: 0;
	}
	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-item:first-child { border-left: 0; }

	.shopbar-st-<?php echo esc_attr( $id ); ?>.shopbar-st-align-left .shopbar-st-item   { text-align: left;   justify-self: start; }
	.shopbar-st-<?php echo esc_attr( $id ); ?>.shopbar-st-align-right .shopbar-st-item  { text-align: right;  justify-self: end; }

	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-value {
		font-family: var(--font-display, 'Fraunces', serif);
		font-size: 40px;
		font-weight: 600;
		line-height: 1.1em;
		letter-spacing: -0.01em;
		color: #1C1C1C;
		margin: 0 0 6px;
	}
	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-value-accent { color: var(--st-accent); }

	.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-label {
		font-size: 14px;
		font-weight: 500;
		line-height: 1.4em;
		color: #6B6560;
		margin: 0;
	}

	/* ── Responsive ─────────────────────────────────────── */
	@media (max-width: 768px) {
		.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-item { border-left: 0 !important; padding-left: 0 !important; padding-right: 0 !important; }
		.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-value { font-size: 32px; }
		.shopbar-st-<?php echo esc_attr( $id ); ?> .shopbar-st-inner { padding: 40px 24px; }
	}
</style>
