<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Features Section - Frontend Render (Shop Zen)
 *
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings_for_display();
$id       = $this->get_id();

$features = $settings['features'] ?? [];
?>
<div class="shopzen-feat shopzen-feat-<?php echo esc_attr( $id ); ?>" id="shopzen-feat-<?php echo esc_attr( $id ); ?>">

	<div class="shopzen-feat-wrap">
		<div class="shopzen-feat-features">

			<?php foreach ( $features as $item ) :
				$title = $item['feature_title'] ?? '';
				$text  = $item['feature_text'] ?? '';
				$icon  = $item['feature_icon'] ?? [];
				?>
				<div class="shopzen-feat-feature">
					<?php if ( ! empty( $icon['value'] ) ) : ?>
						<span class="shopzen-feat-icon">
							<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
						</span>
					<?php endif; ?>

					<div class="shopzen-feat-text-wrap">
						<?php if ( ! empty( $title ) ) : ?>
							<h4 class="shopzen-feat-title"><?php echo esc_html( $title ); ?></h4>
						<?php endif; ?>
						<?php if ( ! empty( $text ) ) : ?>
							<p class="shopzen-feat-text"><?php echo esc_html( $text ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>

		</div>
	</div>
</div>

<style>
	.shopzen-feat-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		max-width: 100%;
		box-sizing: border-box;
	}
	.shopzen-feat-<?php echo esc_attr( $id ); ?> *,
	.shopzen-feat-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-feat-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	/* Wrap: matches the theme header/footer width (1240px), centered, with
	   the gutter INSIDE the box (same pattern as header/footer content
	   containers) so the bar edges line up with the content band. */
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-wrap {
		position: relative;
		z-index: 10;
		max-width: 1240px;
		margin: 0 auto;
		width: 100%;
		padding: 0 16px;
	}

	/* Features bar */
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-features {
		background: #fff;
		border-radius: 0 0 14px 14px;
		box-shadow: 0 4px 16px rgba(0,0,0,0.08);
		display: grid;
		grid-template-columns: repeat(5, minmax(0, 1fr));
		overflow: hidden;
		border: 1px solid #E5E7EB;
		border-top: 3px solid #1E3F2A;
	}

	/* Feature item */
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-feature {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 14px 12px;
		position: relative;
	}
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-feature:not(:last-child)::after {
		content: '';
		position: absolute;
		right: 0;
		top: 15%;
		bottom: 15%;
		width: 1px;
		background: #E5E7EB;
		display: block;
	}

	/* Icon box */
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-icon {
		width: 34px;
		height: 34px;
		border-radius: 8px;
		background: #F4F7F3;
		display: grid;
		place-items: center;
		flex-shrink: 0;
		color: #3A5F3F;
		border: 1px solid #E5E7EB;
	}
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-icon i,
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-icon svg {
		font-size: 18px;
		width: 18px;
		height: 18px;
	}

	/* Text block */
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-text-wrap {
		min-width: 0;
	}
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-title {
		font-family: Inter, sans-serif;
		font-size: 12px;
		font-weight: 700;
		margin: 0 0 1px;
		color: #1F2937;
		text-transform: uppercase;
		letter-spacing: 0.35px;
		line-height: 1.2em;
		overflow-wrap: break-word;
	}
	.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-text {
		font-family: Inter, sans-serif;
		font-size: 11px;
		margin: 0;
		color: #6B7280;
		font-weight: 600;
		line-height: 1.3em;
		overflow-wrap: break-word;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-features { border-radius: 0 0 12px 12px; }
		.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-feature:not(:last-child)::after { display: none; }
	}
	@media (max-width: 480px) {
		.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-wrap { padding: 0 12px; }
		.shopzen-feat-<?php echo esc_attr( $id ); ?> .shopzen-feat-feature { padding: 12px 8px; }
	}
</style>
