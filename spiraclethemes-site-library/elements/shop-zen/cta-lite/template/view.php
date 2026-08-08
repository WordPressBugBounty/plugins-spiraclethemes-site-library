<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * CTA Lite Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings      = $this->get_settings_for_display();
$id            = $this->get_id();
$icon          = $settings['icon'] ?? [];
$heading       = $settings['heading'] ?? '';
$subtext       = $settings['subtext'] ?? '';
$cta_text      = $settings['cta_text'] ?? '';
$cta_link      = $settings['cta_link'] ?? [];
$cta2_text     = $settings['cta2_text'] ?? '';
$cta2_link     = $settings['cta2_link'] ?? [];
$show_cta2     = $settings['show_cta2'] ?? 'yes';
$show_leaf     = $settings['show_leaf_deco'] ?? 'yes';

$cta_href       = ! empty( $cta_link['url'] ) ? $cta_link['url'] : '';
$cta_target     = ! empty( $cta_link['is_external'] ) ? ' target="_blank"' : '';
$cta_nofollow   = ! empty( $cta_link['nofollow'] ) ? ' rel="nofollow"' : '';
$cta_attr_str   = trim( $cta_target . ' ' . $cta_nofollow );

$cta2_href       = ! empty( $cta2_link['url'] ) ? $cta2_link['url'] : '';
$cta2_target     = ! empty( $cta2_link['is_external'] ) ? ' target="_blank"' : '';
$cta2_nofollow   = ! empty( $cta2_link['nofollow'] ) ? ' rel="nofollow"' : '';
$cta2_attr_str   = trim( $cta2_target . ' ' . $cta2_nofollow );
?>
<section class="shopzen-cta shopzen-cta-<?php echo esc_attr( $id ); ?>" id="shopzen-cta-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-cta-wrap">
		<div class="shopzen-cta-inner">

			<div class="shopzen-cta-left">
				<div class="shopzen-cta-icon">
					<?php if ( ! empty( $icon['value'] ) ) :
						\Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] );
					else : ?>
						<svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>
					<?php endif; ?>
				</div>
				<div class="shopzen-cta-text">
					<?php if ( ! empty( $heading ) ) : ?>
						<h3 class="shopzen-cta-heading"><?php echo esc_html( $heading ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $subtext ) ) : ?>
						<p class="shopzen-cta-sub"><?php echo esc_html( $subtext ); ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="shopzen-cta-right">
				<?php if ( ! empty( $cta_text ) && ! empty( $cta_href ) ) : ?>
					<a class="shopzen-cta-btn shopzen-cta-btn-primary" href="<?php echo esc_url( $cta_href ); ?>" <?php echo esc_attr( $cta_attr_str ); ?>>
						<?php echo esc_html( $cta_text ); ?>
					</a>
				<?php endif; ?>

				<?php if ( 'yes' === $show_cta2 && ! empty( $cta2_text ) && ! empty( $cta2_href ) ) : ?>
					<a class="shopzen-cta-btn shopzen-cta-btn-secondary" href="<?php echo esc_url( $cta2_href ); ?>" <?php echo esc_attr( $cta2_attr_str ); ?>>
						<?php echo esc_html( $cta2_text ); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' === $show_leaf ) : ?>
				<svg class="shopzen-cta-leaf" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M7 20c3-5 5-7 10-9 -2 4-3 7-5 9M12 4c-4 3-6 7-5 12 3-2 6-4 8-8 -1 5-2 8-3 10"></path></svg>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.shopzen-cta-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> *,
	.shopzen-cta-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-cta-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-wrap {
		max-width: 1240px;
		margin: 0 auto;
		padding: 0 16px;
	}

	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-inner {
		background: #DDE6DA;
		border-radius: 14px;
		padding: 20px 22px;
		display: flex;
		align-items: center;
		justify-content: space-between;
		gap: 18px;
		position: relative;
		overflow: hidden;
		border: 1px solid #C8D9C3;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
	}

	/* Left */
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-left {
		display: flex;
		align-items: center;
		gap: 13px;
		position: relative;
		z-index: 2;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-icon {
		width: 44px;
		height: 44px;
		background: #fff;
		border-radius: 11px;
		display: grid;
		place-items: center;
		color: #3A5F3F;
		flex-shrink: 0;
		box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
		border: 1px solid #E5E7EB;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-icon i,
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-icon svg {
		width: 22px;
		height: 22px;
		font-size: 22px;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-heading {
		font-family: Outfit, sans-serif;
		font-size: 18px;
		font-weight: 800;
		margin: 0 0 1px;
		color: #1A202C;
		line-height: 1.3;
		letter-spacing: -0.3px;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-sub {
		font-family: Inter, sans-serif;
		font-size: 12px;
		color: #3F4A3C;
		opacity: 0.9;
		font-weight: 500;
		margin: 0;
		line-height: 1.5;
	}

	/* Right — buttons */
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-right {
		display: flex;
		gap: 10px;
		position: relative;
		z-index: 2;
		flex-shrink: 0;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-btn {
		font-family: Inter, sans-serif;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: 999px;
		font-weight: 700;
		font-size: 12px;
		white-space: nowrap;
		transition: 0.2s;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		text-decoration: none;
		cursor: pointer;
		padding: 11px 26px;
		border: 1px solid transparent;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-btn-primary {
		background: #1E3F2A;
		color: #fff;
		border-color: #0f2316;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-btn-primary:hover {
		background: #13261A;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-btn-secondary {
		background: #fff;
		color: #1E3F2A;
		border-color: #C8D9C3;
	}
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-btn-secondary:hover {
		background: #F8FAF6;
	}

	/* Leaf decoration */
	.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-leaf {
		position: absolute;
		right: -14px;
		bottom: -14px;
		opacity: 0.12;
		transform: rotate(-15deg);
		color: #3A5F3F;
		pointer-events: none;
		z-index: 1;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-inner {
			flex-direction: column;
			align-items: center;
			padding: 18px 16px;
		}
		.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-left {
			flex-direction: column;
			align-items: center;
			text-align: center;
		}
		.shopzen-cta-<?php echo esc_attr( $id ); ?> .shopzen-cta-right {
			flex-wrap: wrap;
			justify-content: center;
		}
	}
</style>
