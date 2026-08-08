<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Call To Action
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings           = $this->get_settings();
$id                 = $this->get_id();
$eyebrow_icon       = $settings['eyebrow_icon'] ?? [];
$title              = $settings['title'] ?? '';
$description        = $settings['description'] ?? '';
$primary_btn_text   = $settings['primary_btn_text'] ?? '';
$primary_btn_url    = $settings['primary_btn_url'] ?? [];
$primary_btn_icon   = $settings['primary_btn_icon'] ?? [];
$secondary_btn_text = $settings['secondary_btn_text'] ?? '';
$secondary_btn_url  = $settings['secondary_btn_url'] ?? [];
$show_decorations   = $settings['show_decorations'] ?? 'yes';
$decor_one          = $settings['decor_one_color'] ?? '#1E1E1E';
$decor_two          = $settings['decor_two_color'] ?? '#7B8F6B';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Button link attributes.
$primary_link     = ! empty( $primary_btn_url['url'] ) ? $primary_btn_url['url'] : '#';
$primary_target   = ! empty( $primary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$primary_nofollow = ! empty( $primary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

$secondary_link     = ! empty( $secondary_btn_url['url'] ) ? $secondary_btn_url['url'] : '#';
$secondary_target   = ! empty( $secondary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$secondary_nofollow = ! empty( $secondary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

// Border flags — mirror the products-grid pattern.
$wrap_class  = 'pawwell-cta pawwell-cta-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-cta-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-cta-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-cta-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<?php if ( 'yes' === $show_decorations ) : ?>
		<span class="pawwell-cta-decor pawwell-cta-decor-one" aria-hidden="true"></span>
		<span class="pawwell-cta-decor pawwell-cta-decor-two" aria-hidden="true"></span>
	<?php endif; ?>
	<div class="pawwell-cta-inner">
		<?php if ( ! empty( $eyebrow_icon['value'] ) ) : ?>
			<div class="pawwell-cta-icon">
				<?php \Elementor\Icons_Manager::render_icon( $eyebrow_icon, [ 'aria-hidden' => 'true' ] ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $title ) ) : ?>
			<h2 class="pawwell-cta-title"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $description ) ) : ?>
			<p class="pawwell-cta-desc"><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $primary_btn_text ) || ! empty( $secondary_btn_text ) ) : ?>
			<div class="pawwell-cta-buttons">
				<?php if ( ! empty( $primary_btn_text ) ) : ?>
					<a href="<?php echo esc_url( $primary_link ); ?>" class="pawwell-cta-btn pawwell-cta-btn-primary"<?php echo $primary_target . $primary_nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<span><?php echo esc_html( $primary_btn_text ); ?></span>
						<?php if ( ! empty( $primary_btn_icon['value'] ) ) : ?>
							<?php \Elementor\Icons_Manager::render_icon( $primary_btn_icon, [ 'aria-hidden' => 'true' ] ); ?>
						<?php endif; ?>
					</a>
				<?php endif; ?>
				<?php if ( ! empty( $secondary_btn_text ) ) : ?>
					<a href="<?php echo esc_url( $secondary_link ); ?>" class="pawwell-cta-btn pawwell-cta-btn-secondary"<?php echo $secondary_target . $secondary_nofollow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
						<span><?php echo esc_html( $secondary_btn_text ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-cta-<?php echo esc_attr( $id ); ?> {
		position: relative;
		padding: 80px 32px;
		overflow: hidden;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?>.pawwell-cta-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-cta-<?php echo esc_attr( $id ); ?>.pawwell-cta-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-cta-<?php echo esc_attr( $id ); ?>.pawwell-cta-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-inner {
		max-width: 640px;
		margin: 0 auto;
		text-align: center;
		position: relative;
		z-index: 2;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-decor {
		position: absolute;
		border-radius: 50%;
		pointer-events: none;
		z-index: 1;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-decor-one {
		width: 500px;
		height: 500px;
		background: <?php echo esc_attr( $decor_one ); ?>;
		opacity: 0.06;
		top: -200px;
		right: -100px;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-decor-two {
		width: 400px;
		height: 400px;
		background: <?php echo esc_attr( $decor_two ); ?>;
		opacity: 0.1;
		bottom: -150px;
		left: -100px;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-icon {
		width: 64px;
		height: 64px;
		margin: 0 auto 20px;
		border-radius: 18px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-icon i,
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-icon svg {
		width: 32px;
		height: 32px;
		font-size: 32px;
		fill: currentColor;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-title {
		font-weight: 700;
		font-size: 40px;
		margin: 0 0 14px;
		line-height: 1.15;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-desc {
		font-size: 17px;
		line-height: 1.6;
		margin: 0 0 28px;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-buttons {
		display: flex;
		gap: 14px;
		flex-wrap: wrap;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		padding: 14px 28px;
		border: 2px solid transparent;
		font-weight: 600;
		font-size: 14px;
		letter-spacing: 0.01em;
		transition: transform .25s cubic-bezier(.16,1,.3,1), background .25s ease, box-shadow .25s ease;
		white-space: nowrap;
		cursor: pointer;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn i,
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn svg {
		width: 18px;
		height: 18px;
		font-size: 18px;
		fill: currentColor;
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn-primary {
		box-shadow: 0 4px 16px rgba(0,0,0,0.2);
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn-primary:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 24px rgba(0,0,0,0.25);
	}
	.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn-secondary:hover {
		transform: translateY(-2px);
	}

	@media (max-width: 767px) {
		.pawwell-cta-<?php echo esc_attr( $id ); ?> {
			padding: 56px 20px;
		}
		.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-title {
			font-size: 26px;
		}
		.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-buttons {
			flex-direction: column;
		}
		.pawwell-cta-<?php echo esc_attr( $id ); ?> .pawwell-cta-btn {
			width: 100%;
		}
	}
</style>
