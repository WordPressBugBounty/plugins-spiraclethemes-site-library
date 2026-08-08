<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Contact Form
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings           = $this->get_settings();
$id                 = $this->get_id();
$info_title         = $settings['info_title'] ?? '';
$info_desc          = $settings['info_desc'] ?? '';
$methods            = $settings['methods'] ?? [];
$socials_label      = $settings['socials_label'] ?? '';
$socials            = $settings['socials'] ?? [];
$form_eyebrow       = $settings['form_eyebrow'] ?? '';
$form_title         = $settings['form_title'] ?? '';
$form_desc          = $settings['form_desc'] ?? '';
$cf7_shortcode      = $settings['cf7_shortcode'] ?? '';
$layout             = $settings['layout'] ?? '2col';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Brand SVG icons (Twitter uses the new X logo).
$pawwell_cf_icons = [
	'x'         => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
	'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3l.5-3H14V4.5c0-.8.3-1.5 1.5-1.5H17V.5C16.5.4 15.4 0 14.3 0 11.8 0 10 1.5 10 4.2V6H7v3h3v9h4V9z"/></svg>',
	'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>',
	'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 12s0-3.2-.4-4.7c-.2-.8-.9-1.5-1.7-1.7C19.4 5.2 12 5.2 12 5.2s-7.4 0-8.9.4c-.8.2-1.5.9-1.7 1.7C1 8.8 1 12 1 12s0 3.2.4 4.7c.2.8.9 1.5 1.7 1.7 1.5.4 8.9.4 8.9.4s7.4 0 8.9-.4c.8-.2 1.5-.9 1.7-1.7.4-1.5.4-4.7.4-4.7zM9.8 15.3V8.7l5.7 3.3-5.7 3.3z"/></svg>',
	'whatsapp'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15l-1.3 4.8 4.9-1.3A10 10 0 1 0 12 2zm0 18a8 8 0 0 1-4.1-1.1l-.3-.2-2.9.8.8-2.8-.2-.3A8 8 0 1 1 12 20zm4.5-5.9c-.2-.1-1.4-.7-1.6-.8-.2-.1-.4-.1-.6.1-.2.2-.6.8-.8 1-.1.2-.3.2-.5.1-.7-.3-1.5-.7-2.2-1.6-.5-.5-.9-1.1-1-1.3-.1-.2 0-.4.1-.5l.4-.5c.1-.2.2-.3.2-.5.1-.2 0-.4 0-.5l-.7-1.7c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.4.1-.7.3-.2.2-.9.9-.9 2.2s.9 2.5 1 2.7c.1.2 1.8 2.8 4.4 3.9.6.3 1.1.4 1.5.5.6.2 1.2.2 1.6.1.5-.1 1.4-.6 1.6-1.1.2-.5.2-1 .1-1.1 0-.2-.2-.2-.4-.3z"/></svg>',
	'tiktok'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16.6 5.8a4.8 4.8 0 0 1-1-2.8h-3v12.2a2.5 2.5 0 1 1-2.5-2.5c.3 0 .6.1.8.2V9.8c-.3 0-.5-.1-.8-.1a5.5 5.5 0 1 0 5.5 5.5V9.3a7.8 7.8 0 0 0 4.4 1.4V7.7a4.8 4.8 0 0 1-3.4-1.9z"/></svg>',
];

$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

// Border flags — mirror the products-grid pattern.
$wrap_class  = 'pawwell-cf pawwell-cf-' . esc_attr( $id );
$wrap_class .= '1col' === $layout ? ' pawwell-cf-form-only' : '';
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-cf-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-cf-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-cf-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-cf-inner">
		<div class="pawwell-cf-grid">

			<?php if ( '2col' === $layout ) : ?>
				<div class="pawwell-cf-info">
					<?php if ( ! empty( $info_title ) || ! empty( $info_desc ) ) : ?>
						<div class="pawwell-cf-intro">
							<?php if ( ! empty( $info_title ) ) : ?>
								<h2 class="pawwell-cf-info-title"><?php echo esc_html( $info_title ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $info_desc ) ) : ?>
								<p class="pawwell-cf-info-desc"><?php echo esc_html( $info_desc ); ?></p>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $methods ) ) : ?>
						<div class="pawwell-cf-methods">
							<?php foreach ( $methods as $method ) :
								$m_label = $method['method_label'] ?? '';
								$m_value = $method['method_value'] ?? '';
								$m_url   = $method['method_url']['url'] ?? '';
								$m_bg    = $method['method_icon_bg'] ?? '#F4E0DA';
								$m_color = $method['method_icon_color'] ?? '#C45B3E';
								if ( '' === $m_label && '' === $m_value ) {
									continue;
								}
								?>
								<div class="pawwell-cf-method">
									<div class="pawwell-cf-m-icon" style="background:<?php echo esc_attr( $m_bg ); ?>;color:<?php echo esc_attr( $m_color ); ?>">
										<?php
										if ( ! empty( $method['method_icon']['value'] ) ) {
											\Elementor\Icons_Manager::render_icon( $method['method_icon'], [ 'aria-hidden' => 'true' ] );
										}
										?>
									</div>
									<div class="pawwell-cf-m-text">
										<?php if ( ! empty( $m_label ) ) : ?>
											<small><?php echo esc_html( $m_label ); ?></small>
										<?php endif; ?>
										<?php if ( ! empty( $m_value ) ) :
											if ( ! empty( $m_url ) ) :
												$target = ! empty( $method['method_url']['is_external'] ) ? ' target="_blank"' : '';
												?>
												<strong><a href="<?php echo esc_url( $m_url ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo esc_html( $m_value ); ?></a></strong>
											<?php else : ?>
												<strong><?php echo esc_html( $m_value ); ?></strong>
											<?php endif; ?>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $socials ) ) : ?>
						<div class="pawwell-cf-social">
							<?php if ( ! empty( $socials_label ) ) : ?>
								<span class="pawwell-cf-social-label"><?php echo esc_html( $socials_label ); ?></span>
							<?php endif; ?>
							<?php foreach ( $socials as $social ) :
								$network = $social['network'] ?? 'x';
								$s_url   = $social['url']['url'] ?? '';
								if ( '' === $s_url ) {
									continue;
								}
								$icon_html = $pawwell_cf_icons[ $network ] ?? '';
								if ( '' === $icon_html ) {
									continue;
								}
								$target = ! empty( $social['url']['is_external'] ) ? '_blank' : '_self';
								$rel    = '_blank' === $target ? 'noopener noreferrer' : '';
								printf(
									'<a href="%1$s" aria-label="%2$s" target="%3$s" rel="%4$s">%5$s</a>',
									esc_url( $s_url ),
									esc_attr( ucfirst( $network ) ),
									esc_attr( $target ),
									esc_attr( $rel ),
									$icon_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								);
							endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="pawwell-cf-form-wrap">
				<?php
				if ( ! empty( $form_eyebrow ) || ! empty( $form_title ) || ! empty( $form_desc ) ) :
					?>
					<div class="pawwell-cf-form-head">
						<?php if ( ! empty( $form_eyebrow ) ) : ?>
							<div class="pawwell-cf-eyebrow"><?php echo esc_html( $form_eyebrow ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $form_title ) ) : ?>
							<h3 class="pawwell-cf-form-title"><?php echo esc_html( $form_title ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $form_desc ) ) : ?>
							<p class="pawwell-cf-form-desc"><?php echo esc_html( $form_desc ); ?></p>
						<?php endif; ?>
					</div>
					<?php
				endif;

				if ( ! empty( $cf7_shortcode ) ) {
					echo do_shortcode( shortcode_unautop( wp_kses_post( $cf7_shortcode ) ) );
				} elseif ( $is_editor ) {
					echo '<div class="pawwell-cf-placeholder"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg><p>' . esc_html__( 'Add a Contact Form 7 shortcode in the Form settings to display the form here.', 'spiraclethemes-site-library' ) . '</p></div>';
				}
				?>
			</div>

		</div>
	</div>
</section>

<style>
	.pawwell-cf-<?php echo esc_attr( $id ); ?> {
		position: relative;
		padding: 80px 32px;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?>.pawwell-cf-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-cf-<?php echo esc_attr( $id ); ?>.pawwell-cf-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-cf-<?php echo esc_attr( $id ); ?>.pawwell-cf-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-inner {
		max-width: 1380px;
		margin: 0 auto;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-grid {
		display: grid;
		grid-template-columns: 1fr 1.15fr;
		gap: 48px;
		align-items: start;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?>.pawwell-cf-form-only .pawwell-cf-grid {
		grid-template-columns: 1fr;
		max-width: 760px;
		margin: 0 auto;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-intro {
		margin-bottom: 36px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-info-title {
		font-weight: 700;
		font-size: 34px;
		line-height: 1.15;
		margin: 0 0 14px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-info-desc {
		font-size: 16px;
		line-height: 1.75;
		max-width: 440px;
		margin: 0;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-methods {
		display: flex;
		flex-direction: column;
		gap: 16px;
		margin-bottom: 36px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-method {
		display: flex;
		align-items: center;
		gap: 18px;
		border: 1px solid #E8E2DA;
		border-radius: 16px;
		padding: 22px 24px;
		transition: transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s ease, border-color .25s ease;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-method:hover {
		transform: translateY(-3px);
		box-shadow: 0 18px 40px -22px rgba(0,0,0,0.18);
		border-color: transparent;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-icon {
		width: 52px;
		height: 52px;
		border-radius: 14px;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-icon i,
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-icon svg {
		width: 26px;
		height: 26px;
		font-size: 26px;
		fill: currentColor;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-text small {
		display: block;
		font-size: 12px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 0.06em;
		color: #8A8A8A;
		margin-bottom: 3px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-text strong {
		display: block;
		font-size: 17px;
		font-weight: 700;
		color: #1E1E1E;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-text a {
		color: inherit;
		transition: color .2s;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-m-text a:hover {
		color: var(--pawwell-cf-accent, #C45B3E);
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-social {
		display: flex;
		align-items: center;
		gap: 12px;
		flex-wrap: wrap;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-social-label {
		font-size: 13px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.06em;
		color: #8A8A8A;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-social a {
		width: 44px;
		height: 44px;
		border-radius: 12px;
		background: #EFE9E2;
		color: #4A4A4A;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: background .2s ease, color .2s ease, transform .2s ease;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-social a:hover {
		background: #C45B3E;
		color: #fff;
		transform: translateY(-3px);
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-social a svg {
		width: 19px;
		height: 19px;
	}

	/* Form card */
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap {
		border: 1px solid #E8E2DA;
		border-radius: 16px;
		padding: 40px;
		box-shadow: 0 18px 40px -22px rgba(0,0,0,0.12);
		position: relative;
		overflow: hidden;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 5px;
		background: linear-gradient(90deg, var(--pawwell-cf-accent, #C45B3E), #A8472F);
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-head {
		margin-bottom: 28px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-eyebrow {
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.5px;
		margin-bottom: 8px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-title {
		font-weight: 700;
		font-size: 28px;
		line-height: 1.15;
		margin: 0;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-desc {
		font-size: 15px;
		margin-top: 8px;
	}

	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap .wpcf7-form-control:not(.wpcf7-submit) {
		width: 100%;
		padding: 14px 18px;
		border-radius: 10px;
		border: 1px solid #E8E2DA;
		background: #fff;
		font: inherit;
		font-size: 15px;
		color: #1E1E1E;
		outline: none;
		transition: border-color .2s ease, box-shadow .2s ease;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap .wpcf7-form-control:not(.wpcf7-submit):focus {
		border-color: var(--pawwell-cf-accent, #C45B3E);
		box-shadow: 0 0 0 3px rgba(196,91,62,0.18);
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap textarea.wpcf7-form-control {
		min-height: 130px;
		resize: vertical;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap .wpcf7-form label {
		display: block;
		font-size: 13px;
		font-weight: 600;
		color: #1E1E1E;
		margin-bottom: 8px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap .wpcf7-form p {
		margin-bottom: 18px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap .wpcf7-form-control.wpcf7-submit {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		padding: 14px 32px;
		border-radius: 999px;
		border: 2px solid #C45B3E;
		background: #C45B3E;
		color: #fff;
		font: inherit;
		font-weight: 600;
		font-size: 14px;
		letter-spacing: 0.01em;
		cursor: pointer;
		transition: transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s ease, background .25s ease;
		box-shadow: 0 4px 16px rgba(196,91,62,0.3);
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap .wpcf7-form-control.wpcf7-submit:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 24px rgba(196,91,62,0.35);
	}

	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-placeholder {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 12px;
		padding: 32px;
		text-align: center;
		color: #8A8A8A;
		border: 2px dashed #E8E2DA;
		border-radius: 12px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-placeholder svg {
		width: 40px;
		height: 40px;
	}
	.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-placeholder p {
		margin: 0;
		font-size: 14px;
		max-width: 360px;
	}

	@media (max-width: 900px) {
		.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-grid {
			grid-template-columns: 1fr;
			gap: 36px;
		}
	}
	@media (max-width: 767px) {
		.pawwell-cf-<?php echo esc_attr( $id ); ?> {
			padding: 48px 20px;
		}
		.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-form-wrap {
			padding: 28px 24px;
		}
		.pawwell-cf-<?php echo esc_attr( $id ); ?> .pawwell-cf-info-title {
			font-size: 28px;
		}
	}
</style>
