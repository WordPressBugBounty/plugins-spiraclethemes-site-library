<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Team Members - Frontend Render
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings            = $this->get_settings();
$id                  = $this->get_id();
$items               = $settings['items'] ?? [];
$eyebrow             = $settings['eyebrow'] ?? '';
$title               = $settings['title'] ?? '';
$subtitle            = $settings['subtitle'] ?? '';
$columns             = $settings['columns'] ?? '4';
$hover               = $settings['hover_effect'] ?? 'yes';
$always_show_socials = $settings['always_show_socials'] ?? 'no';
$show_border_top     = $settings['show_border_top'] ?? 'no';
$show_border_bottom  = $settings['show_border_bottom'] ?? 'no';
$full_width_border   = $settings['full_width_border'] ?? 'no';
$border_color        = $settings['border_color'] ?? '#E8E2DA';
$border_width        = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Brand SVG icons (Twitter uses the new X logo).
$pawwell_tm_icons = [
	'x'         => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
	'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.4 3H3.6C3.3 3 3 3.3 3 3.6v16.8c0 .3.3.6.6.6h16.8c.3 0 .6-.3.6-.6V3.6c0-.3-.3-.6-.6-.6zM8.3 18.3H5.5V9.7h2.8v8.6zM6.9 8.5c-.9 0-1.6-.7-1.6-1.6s.7-1.6 1.6-1.6c.9 0 1.6.7 1.6 1.6s-.7 1.6-1.6 1.6zm11.4 9.8h-2.8v-4.2c0-1 0-2.3-1.4-2.3s-1.6 1.1-1.6 2.2v4.3H9.7V9.7h2.7v1.2c.4-.7 1.3-1.4 2.7-1.4 2.9 0 3.4 1.9 3.4 4.4v4.4z"/></svg>',
	'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>',
	'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 9h3l.5-3H14V4.5c0-.8.3-1.5 1.5-1.5H17V.5C16.5.4 15.4 0 14.3 0 11.8 0 10 1.5 10 4.2V6H7v3h3v9h4V9z"/></svg>',
	'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 12s0-3.2-.4-4.7c-.2-.8-.9-1.5-1.7-1.7C19.4 5.2 12 5.2 12 5.2s-7.4 0-8.9.4c-.8.2-1.5.9-1.7 1.7C1 8.8 1 12 1 12s0 3.2.4 4.7c.2.8.9 1.5 1.7 1.7 1.5.4 8.9.4 8.9.4s7.4 0 8.9-.4c.8-.2 1.5-.9 1.7-1.7.4-1.5.4-4.7.4-4.7zM9.8 15.3V8.7l5.7 3.3-5.7 3.3z"/></svg>',
	'tiktok'    => '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16.6 5.8a4.8 4.8 0 0 1-1-2.8h-3v12.2a2.5 2.5 0 1 1-2.5-2.5c.3 0 .6.1.8.2V9.8c-.3 0-.5-.1-.8-.1a5.5 5.5 0 1 0 5.5 5.5V9.3a7.8 7.8 0 0 0 4.4 1.4V7.7a4.8 4.8 0 0 1-3.4-1.9z"/></svg>',
];

// Border flags — mirror the products-grid pattern.
$wrap_class  = 'pawwell-tm pawwell-tm-' . esc_attr( $id );
$wrap_class .= 'yes' === $hover ? ' pawwell-tm-hover' : '';
$wrap_class .= 'yes' === $always_show_socials ? ' pawwell-tm-socials-visible' : '';
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-tm-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-tm-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-tm-fullwidth' : '';
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-tm-inner">
		<?php if ( ! empty( $eyebrow ) || ! empty( $title ) || ! empty( $subtitle ) ) : ?>
			<div class="pawwell-tm-head">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-tm-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="pawwell-tm-title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( ! empty( $subtitle ) ) : ?>
					<p class="pawwell-tm-sub"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="pawwell-tm-grid">
				<?php foreach ( $items as $item ) :
					$m_name  = $item['member_name'] ?? '';
					$m_role  = $item['member_role'] ?? '';
					$m_bio   = $item['member_bio'] ?? '';
					$m_socials = $item['socials'] ?? [];
					if ( '' === $m_name && '' === $m_role ) {
						continue;
					}
					?>
					<div class="pawwell-tm-card">
						<div class="pawwell-tm-avatar">
							<?php
							if ( ! empty( $item['member_avatar']['id'] ) ) {
								echo wp_get_attachment_image( absint( $item['member_avatar']['id'] ), 'full', false, [ 'loading' => 'lazy', 'alt' => esc_attr( $m_name ) ] );
							} elseif ( ! empty( $item['member_avatar']['url'] ) ) {
								printf(
									'<img src="%1$s" alt="%2$s" loading="lazy">',
									esc_url( $item['member_avatar']['url'] ),
									esc_attr( $m_name )
								);
							}
							?>
							<?php if ( ! empty( $m_socials ) ) : ?>
								<div class="pawwell-tm-socials">
									<?php foreach ( $m_socials as $social ) :
										$network = $social['network'] ?? 'x';
										$url     = $social['url']['url'] ?? '';
										if ( '' === $url ) {
											continue;
										}
										$icon_html = $pawwell_tm_icons[ $network ] ?? '';
										if ( '' === $icon_html ) {
											continue;
										}
										$target = ! empty( $social['url']['is_external'] ) ? '_blank' : '_self';
										$rel    = '_blank' === $target ? 'noopener noreferrer' : '';
										printf(
											'<a href="%1$s" aria-label="%2$s" target="%3$s" rel="%4$s">%5$s</a>',
											esc_url( $url ),
											esc_attr( ucfirst( $network ) ),
											esc_attr( $target ),
											esc_attr( $rel ),
											$icon_html // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										);
									endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $m_name ) ) : ?>
							<div class="pawwell-tm-name"><?php echo esc_html( $m_name ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $m_role ) ) : ?>
							<div class="pawwell-tm-role"><?php echo esc_html( $m_role ); ?></div>
						<?php endif; ?>
						<?php if ( ! empty( $m_bio ) ) : ?>
							<div class="pawwell-tm-bio"><?php echo esc_html( $m_bio ); ?></div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-tm-<?php echo esc_attr( $id ); ?> {
		padding: 80px 32px;
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?>.pawwell-tm-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-tm-<?php echo esc_attr( $id ); ?>.pawwell-tm-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-tm-<?php echo esc_attr( $id ); ?>.pawwell-tm-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-inner {
		max-width: 1380px;
		margin: 0 auto;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-head {
		margin-bottom: 44px;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-eyebrow {
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.5px;
		margin-bottom: 10px;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-title {
		font-weight: 800;
		margin: 0 0 12px;
		line-height: 1.2;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-sub {
		margin: 0 auto;
		max-width: 540px;
		line-height: 1.6;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-grid {
		display: grid;
		grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);
		gap: 24px;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-card {
		text-align: center;
		transition: transform .3s cubic-bezier(.16,1,.3,1);
	}
	.pawwell-tm-hover.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-card:hover {
		transform: translateY(-6px);
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-avatar {
		width: 100%;
		aspect-ratio: 1;
		overflow: hidden;
		margin-bottom: 18px;
		position: relative;
		background: #EFE9E2;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-avatar img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform .4s ease;
	}
	.pawwell-tm-hover.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-card:hover .pawwell-tm-avatar img {
		transform: scale(1.05);
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-socials {
		position: absolute;
		bottom: 14px;
		left: 50%;
		transform: translateX(-50%) translateY(20px);
		display: flex;
		gap: 8px;
		opacity: 0;
		transition: opacity .3s ease, transform .3s ease;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?>.pawwell-tm-socials-visible .pawwell-tm-socials,
	.pawwell-tm-hover.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-card:hover .pawwell-tm-socials {
		opacity: 1;
		transform: translateX(-50%) translateY(0);
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-socials a {
		width: 36px;
		height: 36px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 6px 18px -6px rgba(0,0,0,0.25);
		transition: background .2s ease, color .2s ease;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-socials a svg {
		width: 16px;
		height: 16px;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-name {
		font-weight: 700;
		font-size: 17px;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-role {
		font-size: 13px;
		margin-top: 4px;
		font-weight: 600;
	}
	.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-bio {
		font-size: 13px;
		margin-top: 8px;
		line-height: 1.6;
	}

	@media (max-width: 767px) {
		.pawwell-tm-<?php echo esc_attr( $id ); ?> {
			padding: 48px 20px;
		}
		.pawwell-tm-<?php echo esc_attr( $id ); ?> .pawwell-tm-title {
			font-size: 28px;
		}
	}
</style>
