<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Our Story
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings        = $this->get_settings();
$id              = $this->get_id();
$eyebrow         = $settings['eyebrow'] ?? '';
$title           = $settings['title'] ?? '';
$description     = $settings['description'] ?? '';
$layout          = $settings['layout'] ?? 'left';
$image_data      = $settings['image'] ?? [];
$show_badge      = $settings['show_badge'] ?? 'yes';
$badge_value     = $settings['badge_value'] ?? '';
$badge_label     = $settings['badge_label'] ?? '';
$show_quote      = $settings['show_quote'] ?? 'yes';
$quote_text      = $settings['quote_text'] ?? '';
$show_signature  = $settings['show_signature'] ?? 'yes';
$sig_avatar_text = $settings['sig_avatar_text'] ?? '';
$sig_name        = $settings['sig_name'] ?? '';
$sig_role        = $settings['sig_role'] ?? '';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

$is_reversed = ( 'right' === $layout );

// Border flags
$wrap_class  = 'pawwell-os pawwell-os-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-os-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-os-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-os-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-os-inner">
		<div class="pawwell-os-grid<?php echo $is_reversed ? ' pawwell-os-grid-rev' : ''; ?>">

			<div class="pawwell-os-image-wrap">
				<?php if ( ! empty( $image_data['url'] ) ) : ?>
					<div class="pawwell-os-image-main">
						<?php echo \Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings, 'image', 'image' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>

				<?php if ( 'yes' === $show_badge ) : ?>
					<div class="pawwell-os-badge">
						<?php if ( ! empty( $settings['badge_icon']['value'] ) ) : ?>
							<div class="pawwell-os-badge-icon">
								<?php \Elementor\Icons_Manager::render_icon( $settings['badge_icon'], [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						<?php endif; ?>
						<div>
							<?php if ( ! empty( $badge_value ) ) : ?>
								<div class="pawwell-os-badge-value"><?php echo esc_html( $badge_value ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $badge_label ) ) : ?>
								<div class="pawwell-os-badge-label"><?php echo esc_html( $badge_label ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="pawwell-os-content">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-os-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="pawwell-os-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $description ) ) : ?>
					<div class="pawwell-os-desc"><?php echo wp_kses_post( $description ); ?></div>
				<?php endif; ?>

				<?php if ( 'yes' === $show_quote && ! empty( $quote_text ) ) : ?>
					<div class="pawwell-os-quote"><?php echo esc_html( $quote_text ); ?></div>
				<?php endif; ?>

				<?php if ( 'yes' === $show_quote && 'yes' === $show_signature && ( ! empty( $sig_name ) || ! empty( $sig_role ) ) ) : ?>
					<div class="pawwell-os-signature">
						<?php if ( ! empty( $sig_avatar_text ) ) : ?>
							<div class="pawwell-os-sig-avatar"><?php echo esc_html( $sig_avatar_text ); ?></div>
						<?php endif; ?>
						<div>
							<?php if ( ! empty( $sig_name ) ) : ?>
								<div class="pawwell-os-sig-name"><?php echo esc_html( $sig_name ); ?></div>
							<?php endif; ?>
							<?php if ( ! empty( $sig_role ) ) : ?>
								<div class="pawwell-os-sig-role"><?php echo esc_html( $sig_role ); ?></div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>

<style>
	.pawwell-os-<?php echo esc_attr( $id ); ?> {
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?>.pawwell-os-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-os-<?php echo esc_attr( $id ); ?>.pawwell-os-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-os-<?php echo esc_attr( $id ); ?>.pawwell-os-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-inner {
		margin: 0 auto;
		padding: 0 32px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 60px;
		align-items: center;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-grid-rev .pawwell-os-image-wrap {
		order: 2;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-image-wrap {
		position: relative;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-image-main {
		border-radius: 20px;
		overflow: hidden;
		aspect-ratio: 4/5;
		box-shadow: 0 24px 64px rgba(30,30,30,.10);
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-image-main img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge {
		position: absolute;
		bottom: -24px;
		right: -24px;
		border-radius: 20px;
		padding: 24px 28px;
		box-shadow: 0 24px 64px rgba(30,30,30,.10);
		display: flex;
		align-items: center;
		gap: 16px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-grid-rev .pawwell-os-badge {
		right: auto;
		left: -24px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge-icon {
		width: 48px;
		height: 48px;
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge-icon i,
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge-icon svg {
		width: 26px;
		height: 26px;
		font-size: 26px;
		color: #fff;
		fill: currentColor;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge-value {
		font-size: 28px;
		font-weight: 700;
		line-height: 1;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge-label {
		font-size: 13px;
		opacity: 0.75;
		margin-top: 4px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-eyebrow {
		margin-bottom: 12px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-title {
		line-height: 1.1;
		letter-spacing: -0.02em;
		margin-bottom: 24px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-desc p {
		line-height: 1.8;
		margin-bottom: 18px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-desc p:last-child {
		margin-bottom: 0;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-quote {
		font-style: italic;
		border-left: 3px solid #C45B3E;
		padding-left: 20px;
		margin: 28px 0;
		line-height: 1.5;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-signature {
		margin-top: 24px;
		display: flex;
		align-items: center;
		gap: 14px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-sig-avatar {
		width: 52px;
		height: 52px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 20px;
		font-weight: 700;
		color: #fff;
		flex-shrink: 0;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-sig-name {
		font-weight: 700;
		font-size: 15px;
	}
	.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-sig-role {
		font-size: 13px;
		margin-top: 2px;
	}

	/* Responsive */
	@media (max-width: 920px) {
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-grid {
			grid-template-columns: 1fr;
			gap: 48px;
		}
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-grid-rev .pawwell-os-image-wrap {
			order: 0;
		}
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-title {
			font-size: 34px;
		}
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge {
			bottom: -20px;
			right: 20px;
		}
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-grid-rev .pawwell-os-badge {
			left: 20px;
		}
	}
	@media (max-width: 640px) {
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-inner {
			padding: 0 20px;
		}
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-title {
			font-size: 28px;
		}
		.pawwell-os-<?php echo esc_attr( $id ); ?> .pawwell-os-badge {
			position: relative;
			bottom: auto;
			right: auto;
			left: auto;
			display: inline-flex;
			margin-top: 20px;
		}
	}
</style>
