<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Browse by Category
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings          = $this->get_settings();
$id                = $this->get_id();
$eyebrow           = $settings['eyebrow'] ?? '';
$title             = $settings['title'] ?? '';
$show_view_all     = $settings['show_view_all'] ?? 'yes';
$view_all_text     = $settings['view_all_text'] ?? '';
$view_all_url      = $settings['view_all_url'] ?? [];
$categories        = $settings['categories'] ?? [];
$hover_circle      = $settings['avatar_hover_circle'] ?? 'yes';
$show_border_top    = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'no';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

$view_all_link     = ! empty( $view_all_url['url'] ) ? esc_url( $view_all_url['url'] ) : '#';
$view_all_target   = ! empty( $view_all_url['is_external'] ) ? ' target="_blank"' : '';
$view_all_nofollow = ! empty( $view_all_url['nofollow'] ) ? ' rel="nofollow"' : '';

// Border flags — CSS borders on the section + vw-breakout for full width.
$wrap_class  = 'pawwell-bc pawwell-bc-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-bc-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-bc-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-bc-fullwidth' : '';
?>

<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-bc-inner">
		<?php if ( ! empty( $title ) || ! empty( $eyebrow ) || 'yes' === $show_view_all ) : ?>
		<div class="pawwell-bc-head">
			<div class="pawwell-bc-heading">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<div class="pawwell-bc-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $title ) ) : ?>
						<h2 class="pawwell-bc-title"><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>
				</div>
				<?php if ( 'yes' === $show_view_all && ! empty( $view_all_text ) ) : ?>
					<a class="pawwell-bc-viewall" href="<?php echo esc_url( $view_all_link ); ?>"<?php echo esc_attr( $view_all_target . $view_all_nofollow ); ?>>
						<?php echo esc_html( $view_all_text ); ?>
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $categories ) ) : ?>
			<div class="pawwell-bc-grid<?php echo 'yes' === $hover_circle ? ' pawwell-bc-hover-circle' : ''; ?>">
				<?php foreach ( $categories as $cat ) :
					$c_name   = $cat['cat_name'] ?? '';
					$c_count  = $cat['cat_count'] ?? '';
					$c_bg     = $cat['cat_icon_bg'] ?? '#F4E0DA';
					$c_color  = $cat['cat_icon_color'] ?? '#C45B3E';
					$c_link   = $cat['cat_link'] ?? [];
					if ( '' === $c_name && '' === $c_count ) {
						continue;
					}
					$link     = ! empty( $c_link['url'] ) ? esc_url( $c_link['url'] ) : '#';
					$target   = ! empty( $c_link['is_external'] ) ? ' target="_blank"' : '';
					$nofollow = ! empty( $c_link['nofollow'] ) ? ' rel="nofollow"' : '';
					?>
					<a class="pawwell-bc-card" href="<?php echo esc_url( $link ); ?>"<?php echo esc_attr( $target . $nofollow ); ?>>
						<span class="pawwell-bc-avatar" style="background:<?php echo esc_attr( $c_bg ); ?>;color:<?php echo esc_attr( $c_color ); ?>">
							<?php
							if ( ! empty( $cat['cat_icon']['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $cat['cat_icon'], [ 'aria-hidden' => 'true' ] );
							}
							?>
						</span>
						<span class="pawwell-bc-name"><?php echo esc_html( $c_name ); ?></span>
						<?php if ( ! empty( $c_count ) ) : ?>
							<span class="pawwell-bc-count"><?php echo esc_html( $c_count ); ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-bc-<?php echo esc_attr( $id ); ?> {
		background: #fff;
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?>.pawwell-bc-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-bc-<?php echo esc_attr( $id ); ?>.pawwell-bc-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	
	.pawwell-bc-<?php echo esc_attr( $id ); ?>.pawwell-bc-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-inner {
		max-width: 1380px;
		margin: 0 auto;
		padding: 100px 32px;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-head {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 20px;
		margin-bottom: 48px;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-heading {
		flex: 1;
		min-width: 0;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-eyebrow {
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.1em;
		color: #C45B3E;
		margin-bottom: 10px;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-title {
		line-height: 1.1;
		letter-spacing: -0.02em;
		color: #1E1E1E;
		margin: 0;
		font-weight: 400;
		word-break: break-word;
		overflow-wrap: break-word;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-viewall {
		font-weight: 600;
		font-size: 14px;
		color: #C45B3E;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		text-decoration: none;
		transition: gap .2s;
		white-space: nowrap;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-viewall svg { width: 16px; height: 16px; }
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-viewall:hover { gap: 10px; }

	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 24px;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-card {
		text-align: center;
		text-decoration: none;
		color: inherit;
		min-width: 0;
		transition: transform .3s cubic-bezier(.16,1,.3,1);
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-card:hover { transform: translateY(-6px); }

	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-avatar {
		width: 120px;
		height: 120px;
		margin: 0 auto 16px;
		border-radius: 28px;
		display: flex;
		align-items: center;
		justify-content: center;
		position: relative;
		overflow: hidden;
		transition: border-radius .4s cubic-bezier(.16,1,.3,1), box-shadow .3s;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-avatar i,
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-avatar svg {
		width: 44px;
		height: 44px;
		font-size: 44px;
		color: inherit;
		fill: currentColor;
		transition: transform .3s;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid.pawwell-bc-hover-circle .pawwell-bc-card:hover .pawwell-bc-avatar {
		border-radius: 50%;
		box-shadow: 0 12px 32px rgba(0,0,0,.08);
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid.pawwell-bc-hover-circle .pawwell-bc-card:hover .pawwell-bc-avatar i,
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid.pawwell-bc-hover-circle .pawwell-bc-card:hover .pawwell-bc-avatar svg {
		transform: scale(1.1);
	}

	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-name {
		display: block;
		font-weight: 700;
		color: #1E1E1E;
		word-break: break-word;
		overflow-wrap: break-word;
	}
	.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-count {
		display: block;
		font-size: 13px;
		color: #8A8A8A;
		margin-top: 2px;
	}

	/* Responsive */
	@media (max-width: 1080px) {
		section.pawwell-bc.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
	}
	@media (max-width: 920px) {
		section.pawwell-bc		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-head { flex-direction: column; align-items: center; }
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-heading { flex: 0 0 100%; width: 100%; }
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-viewall { margin-top: 8px; }
	}
	@media (max-width: 640px) {
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-inner { padding: 64px 20px; }
		section.pawwell-bc.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 16px; }
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-avatar { width: 100px; height: 100px; border-radius: 24px; }
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-avatar i,
		.pawwell-bc-<?php echo esc_attr( $id ); ?> .pawwell-bc-avatar svg { width: 36px; height: 36px; font-size: 36px; }
	}
</style>
