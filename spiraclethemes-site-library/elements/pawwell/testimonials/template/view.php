<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Testimonials
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings       = $this->get_settings();
$id             = $this->get_id();
$items          = $settings['items'] ?? [];
$eyebrow        = $settings['eyebrow'] ?? '';
$title          = $settings['title'] ?? '';
$columns        = $settings['columns'] ?? '3';
$show_view_all  = $settings['show_view_all'] ?? 'yes';
$view_all_text  = $settings['view_all_text'] ?? '';
$view_all_link  = $settings['view_all_link'] ?? [];
$show_border_top    = $settings['show_border_top'] ?? 'yes';
$show_border_bottom = $settings['show_border_bottom'] ?? 'yes';
$full_width_border  = $settings['full_width_border'] ?? 'no';
$border_color       = $settings['border_color'] ?? '#E8E2DA';
$border_width       = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Border flags
$wrap_class  = 'pawwell-testi pawwell-testi-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-testi-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-testi-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-testi-fullwidth' : '';

if ( ! empty( $view_all_link['url'] ) ) {
	$view_url   = esc_url( $view_all_link['url'] );
	$view_target = ! empty( $view_all_link['is_external'] ) ? ' target="_blank"' : '';
	$view_nofollow = ! empty( $view_all_link['nofollow'] ) ? ' rel="nofollow"' : '';
} else {
	$view_url = '#';
	$view_target = '';
	$view_nofollow = '';
}
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<div class="pawwell-testi-inner">
		<?php if ( ! empty( $eyebrow ) || ! empty( $title ) || 'yes' === $show_view_all ) : ?>
		<div class="pawwell-testi-head">
			<div class="pawwell-testi-heading">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<div class="pawwell-testi-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
					<?php endif; ?>
					<?php if ( ! empty( $title ) ) : ?>
						<h2 class="pawwell-testi-title"><?php echo esc_html( $title ); ?></h2>
					<?php endif; ?>
				</div>
				<?php if ( 'yes' === $show_view_all && ! empty( $view_all_text ) ) : ?>
					<a class="pawwell-testi-viewall" href="<?php echo esc_attr( $view_url ); ?>"<?php echo esc_attr( $view_target ); ?><?php echo esc_attr( $view_nofollow ); ?>>
						<?php echo esc_html( $view_all_text ); ?> <span aria-hidden="true">&rarr;</span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="pawwell-testi-grid pawwell-testi-col-<?php echo esc_attr( $columns ); ?>">
				<?php foreach ( $items as $item ) :
					$i_quote   = $item['item_quote'] ?? '';
					$i_letter  = $item['item_avatar_letter'] ?? '';
					$i_bg1     = $item['item_avatar_bg'] ?? '#C45B3E';
					$i_bg2     = $item['item_avatar_bg2'] ?? '#9A4128';
					$i_name    = $item['item_name'] ?? '';
					$i_meta    = $item['item_meta'] ?? '';
					$i_rating  = (int) ( $item['item_rating'] ?? 5 );
					if ( '' === $i_quote && '' === $i_name ) {
						continue;
					}
					?>
					<div class="pawwell-testi-card">
						<div class="pawwell-testi-stars" aria-label="<?php echo esc_attr( sprintf( /* translators: %d rating */ esc_html__( '%d out of 5 stars', 'spiraclethemes-site-library' ), $i_rating ) ); ?>">
							<?php echo esc_html( str_repeat( '★', max( 0, min( 5, $i_rating ) ) ) ); ?>
						</div>
						<?php if ( ! empty( $i_quote ) ) : ?>
							<p class="pawwell-testi-quote"><?php echo esc_html( $i_quote ); ?></p>
						<?php endif; ?>
						<div class="pawwell-testi-footer">
							<?php if ( ! empty( $i_letter ) ) : ?>
								<div class="pawwell-testi-avatar" style="background:linear-gradient(135deg, <?php echo esc_attr( $i_bg1 ); ?>, <?php echo esc_attr( $i_bg2 ); ?>);">
									<?php echo esc_html( mb_substr( $i_letter, 0, 1 ) ); ?>
								</div>
							<?php endif; ?>
							<div>
								<?php if ( ! empty( $i_name ) ) : ?>
									<div class="pawwell-testi-name"><?php echo esc_html( $i_name ); ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $i_meta ) ) : ?>
									<div class="pawwell-testi-meta">
										<svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
										<?php echo esc_html( $i_meta ); ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<style>
	.pawwell-testi-<?php echo esc_attr( $id ); ?> {
		padding: 80px 32px;
		background: #fff;
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?>.pawwell-testi-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-testi-<?php echo esc_attr( $id ); ?>.pawwell-testi-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-testi-<?php echo esc_attr( $id ); ?>.pawwell-testi-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-inner {
		max-width: 1280px;
		margin: 0 auto;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-head {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 24px;
		flex-wrap: wrap;
		margin-bottom: 40px;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-heading {
		flex: 1;
		min-width: 0;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-eyebrow {
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 1.5px;
		color: #C45B3E;
		margin-bottom: 10px;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-title {
		font-weight: 800;
		color: #1E1E1E;
		margin: 0;
		line-height: 1.2;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-viewall {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		font-size: 14px;
		font-weight: 600;
		color: #1E1E1E;
		text-decoration: none;
		white-space: nowrap;
		transition: gap .3s ease;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-viewall:hover { gap: 12px; }
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-grid {
		display: grid;
		grid-template-columns: repeat(<?php echo esc_attr( $columns ); ?>, 1fr);
		gap: 24px;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-card {
		background: #F7F1E8;
		border-radius: 18px;
		padding: 32px;
		display: flex;
		flex-direction: column;
		min-height: 260px;
		position: relative;
		overflow: hidden;
		transition: transform .3s cubic-bezier(.16,1,.3,1);
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-card:hover { transform: translateY(-4px); }
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-card::before {
		content: '\201C';
		font-family: Georgia, 'Times New Roman', serif;
		font-size: 72px;
		color: #F4E0DA;
		position: absolute;
		top: 16px;
		right: 24px;
		line-height: 1;
		pointer-events: none;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-stars {
		color: #D4A853;
		font-size: 16px;
		margin-bottom: 16px;
		display: flex;
		gap: 2px;
		letter-spacing: 2px;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-quote {
		color: #3A3A3A;
		line-height: 1.7;
		font-style: italic;
		flex: 1;
		margin: 0;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-footer {
		display: flex;
		align-items: center;
		gap: 14px;
		margin-top: 24px;
		padding-top: 20px;
		border-top: 1px solid #E8E2DA;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-avatar {
		width: 46px;
		height: 46px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 18px;
		font-weight: 700;
		color: #fff;
		flex-shrink: 0;
		text-transform: uppercase;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-name {
		font-weight: 700;
		color: #1E1E1E;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-meta {
		color: #5E7350;
		font-weight: 600;
		display: flex;
		align-items: center;
		gap: 4px;
		margin-top: 2px;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-meta svg {
		width: 13px;
		height: 13px;
		fill: currentColor;
		flex-shrink: 0;
	}

	/* Responsive */
	@media (max-width: 920px) {
		.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-grid {
			grid-template-columns: repeat(2, 1fr);
		}
	}
	@media (max-width: 640px) {
		.pawwell-testi-<?php echo esc_attr( $id ); ?> {
			padding: 48px 20px;
		}
		.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-grid {
			grid-template-columns: 1fr;
		}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-head {
		flex-direction: column;
		align-items: center;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-heading {
		flex: 0 0 100%;
		width: 100%;
	}
	.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-viewall {
		margin-top: 8px;
	}
		.pawwell-testi-<?php echo esc_attr( $id ); ?> .pawwell-testi-title {
			font-size: 28px;
		}
	}
</style>
