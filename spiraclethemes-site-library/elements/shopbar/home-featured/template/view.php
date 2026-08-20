<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Home Featured
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings_for_display();
$id       = $this->get_id();

/**
 * Outline SVG icons (Shopbar style: 24x24 viewBox, stroke based).
 *
 * @param string $key  Icon key.
 * @param int    $size Pixel size.
 * @return string SVG markup.
 */
if ( ! function_exists( 'shopbar_hf_render_icon' ) ) {
	function shopbar_hf_render_icon( $key, $size = 18 ) {
		$icons = array(
			'headphones' => '<path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/>',
			'shirt'      => '<path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/>',
			'home'       => '<path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>',
			'sparkles'   => '<path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .962 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.962 0z"/><path d="M20 3v4"/><path d="M22 5h-4"/><path d="M4 17v2"/><path d="M5 18H3"/>',
			'dumbbell'   => '<path d="m6.5 6.5 11 11"/><path d="m21 21-1-1"/><path d="m3 3 1 1"/><path d="m18 22 4-4"/><path d="m2 6 4-4"/><path d="m3 10 7-7"/><path d="m14 21 7-7"/>',
			'gamepad'    => '<line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/>',
			'car'        => '<path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><path d="M9 17h6"/><circle cx="17" cy="17" r="2"/>',
			'book'       => '<path d="M12 7v14"/><path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z"/>',
			'bag'        => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>',
			'watch'      => '<circle cx="12" cy="12" r="6"/><polyline points="12 10 12 12 13 13"/><path d="M16.13 7.66l-.81-4.05a2 2 0 0 0-2-1.61h-2.68a2 2 0 0 0-2 1.61l-.78 4.05"/><path d="M7.88 16.36l.8 4a2 2 0 0 0 2 1.61h2.72a2 2 0 0 0 2-1.61l.81-4.05"/>',
			'gift'       => '<rect x="3" y="8" width="18" height="4" rx="1"/><path d="M12 8v13"/><path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"/><path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"/>',
			'heart'      => '<path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>',
			'baby'       => '<path d="M9 12h.01"/><path d="M15 12h.01"/><path d="M10 16c.5.3 1.2.5 2 .5s1.5-.2 2-.5"/><path d="M19 6.3a9 9 0 0 1 1.8 3.9 2 2 0 0 1 0 3.6 9 9 0 0 1-17.6 0 2 2 0 0 1 0-3.6A9 9 0 0 1 12 3c2 0 3.5 1.1 3.5 2.5s-.9 2.5-2 2.5c-.8 0-1.5-.4-1.5-1"/>',
			'paw'        => '<circle cx="11" cy="4" r="2"/><circle cx="18" cy="8" r="2"/><circle cx="20" cy="16" r="2"/><path d="M9 10a5 5 0 0 1 5 5v3.5a3.5 3.5 0 0 1-6.84 1.045Q6.52 17.48 4.46 16.84A3.5 3.5 0 0 1 5.5 10Z"/>',
			'grid'       => '<rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/>',
			'cart'       => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>',
			'tag'        => '<path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/>',
			'credit-card'=> '<rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/>',
			'basket'     => '<path d="m5 11 4-7"/><path d="m9 11 4-7"/><path d="m13 11 4-7"/><path d="m17 11 4-7"/><path d="M5 11h14"/><path d="M5 11v1a7 7 0 0 0 14 0v-1"/><path d="M12 18v4"/>',
		);

		if ( ! isset( $icons[ $key ] ) || '' === $key ) {
			return '';
		}

		return '<svg class="shopbar-hf-cat-icon" width="' . esc_attr( (string) $size ) . '" height="' . esc_attr( (string) $size ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $icons[ $key ] . '</svg>';
	}
}

$show_sidebar   = $settings['show_sidebar'] ?? 'yes';
$sidebar_title  = $settings['sidebar_title'] ?? '';
$categories     = $settings['categories'] ?? array();
$show_see_all   = $settings['show_see_all'] ?? 'yes';
$see_all_text   = $settings['see_all_text'] ?? '';
$see_all_link   = $settings['see_all_link'] ?? array();

$eyebrow        = $settings['eyebrow_text'] ?? '';
$title          = $settings['banner_title'] ?? '';
$description    = $settings['banner_description'] ?? '';
$btn_text       = $settings['btn_text'] ?? '';
$btn_url        = $settings['btn_url'] ?? array();

$banner_image   = $settings['banner_image'] ?? array();

$show_badge     = $settings['show_badge'] ?? 'yes';
$badge_top      = $settings['badge_top_text'] ?? '';
$badge_main     = $settings['badge_main_text'] ?? '';
$badge_bottom   = $settings['badge_bottom_text'] ?? '';

$btn_link     = ! empty( $btn_url['url'] ) ? esc_url( $btn_url['url'] ) : '#';
$btn_target   = ! empty( $btn_url['is_external'] ) ? ' target="_blank"' : '';
$btn_nofollow = ! empty( $btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

$see_all_link_url   = ! empty( $see_all_link['url'] ) ? esc_url( $see_all_link['url'] ) : '#';
$see_all_target     = ! empty( $see_all_link['is_external'] ) ? ' target="_blank"' : '';
$see_all_nofollow   = ! empty( $see_all_link['nofollow'] ) ? ' rel="nofollow"' : '';

$banner_bg_type = $settings['banner_bg_type'] ?? 'gradient';
$content_width  = isset( $settings['content_width']['size'] ) ? intval( $settings['content_width']['size'] ) : 52;

/* Gradient background. */
$gradient_c1   = $settings['gradient_color_1'] ?? '#F5F5F5';
$gradient_c2   = $settings['gradient_color_2'] ?? '#EBEBEB';
$gradient_dir  = $settings['gradient_direction'] ?? '135deg';

/* Decorative shopping icons (gradient background only). */
$show_decor = ( 'gradient' === $banner_bg_type && 'yes' === ( $settings['show_decor_icons'] ?? 'yes' ) );
$decor_color   = $settings['decor_color'] ?? '#1C1C1C';
$decor_opacity = max( 0, min( 100, isset( $settings['decor_opacity']['size'] ) ? intval( $settings['decor_opacity']['size'] ) : 100 ) ) / 100;
$decor_size    = max( 0.4, min( 2, ( isset( $settings['decor_size']['size'] ) ? intval( $settings['decor_size']['size'] ) : 100 ) / 100 ) );

/* Image background + overlay. */
$img_url           = ! empty( $banner_image['url'] ) ? esc_url( $banner_image['url'] ) : '';
$overlay_color     = $settings['overlay_color'] ?? '#0B0B0F';
$overlay_opacity   = max( 0, min( 100, isset( $settings['overlay_opacity']['size'] ) ? intval( $settings['overlay_opacity']['size'] ) : 55 ) ) / 100;

/* Build the banner background. An overlay layer (::before) is only used in
   image mode to ensure text contrast over the photo. */
if ( 'image' === $banner_bg_type ) {
	$banner_bg_style = $img_url
		? sprintf( 'background: url("%s") center center / cover no-repeat;', $img_url )
		: sprintf( 'background: %s;', esc_attr( $overlay_color ) );
	$show_overlay = true;
} else {
	$banner_bg_style = sprintf(
		'background: linear-gradient(%1$s, %2$s, %3$s);',
		esc_attr( $gradient_dir ),
		esc_attr( $gradient_c1 ),
		esc_attr( $gradient_c2 )
	);
	$show_overlay = false;
}
?>

<section class="shopbar-hf shopbar-hf-<?php echo esc_attr( $id ); ?><?php echo ( 'yes' === $show_badge ) ? ' shopbar-hf--badge' : ''; ?>">
	<div class="shopbar-hf-inner">
		<div class="shopbar-hf-grid<?php echo ( 'yes' !== $show_sidebar ) ? ' shopbar-hf-grid--full' : ''; ?>">

			<?php if ( 'yes' === $show_sidebar ) : ?>
				<aside class="shopbar-hf-sidebar">
					<?php if ( ! empty( $sidebar_title ) ) : ?>
						<h3 class="shopbar-hf-sidebar-title"><?php echo esc_html( $sidebar_title ); ?></h3>
					<?php endif; ?>
					<ul class="shopbar-hf-cats">
						<?php foreach ( $categories as $cat ) :
							$cat_label = $cat['label'] ?? '';
							$cat_icon  = $cat['icon'] ?? '';
							$cat_url   = $cat['link']['url'] ?? '#';
							if ( '' === trim( $cat_label ) && '' === $cat_icon ) {
								continue;
							}
							$cat_target   = ! empty( $cat['link']['is_external'] ) ? ' target="_blank"' : '';
							$cat_nofollow = ! empty( $cat['link']['nofollow'] ) ? ' rel="nofollow"' : '';
							?>
							<li>
								<a class="shopbar-hf-cat-link" href="<?php echo '' === trim( $cat_url ) ? '#' : esc_url( $cat_url ); ?>"<?php echo esc_attr( $cat_target ); // phpcs:ignore ?><?php echo ' ' . esc_attr( trim( $cat_nofollow ) ); ?>>
								<?php if ( '' !== $cat_icon ) : ?>
									<span class="shopbar-hf-cat-icon-wrap"><?php echo shopbar_hf_render_icon( $cat_icon, 18 ); // phpcs:ignore ?></span>
								<?php endif; ?>
									<span class="shopbar-hf-cat-label"><?php echo esc_html( $cat_label ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>

						<?php if ( 'yes' === $show_see_all && ! empty( $see_all_text ) ) : ?>
							<li class="shopbar-hf-cat--all">
								<a class="shopbar-hf-cat-link shopbar-hf-cat-link--all" href="<?php echo esc_url( $see_all_link_url ); ?>"<?php echo esc_attr( $see_all_target ); // phpcs:ignore ?><?php echo ' ' . esc_attr( trim( $see_all_nofollow ) ); ?>>
									<span class="shopbar-hf-cat-icon-wrap"><?php echo shopbar_hf_render_icon( 'grid', 18 ); // phpcs:ignore ?></span>
									<span class="shopbar-hf-cat-label"><?php echo esc_html( $see_all_text ); ?></span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</aside>
			<?php endif; ?>

			<div class="shopbar-hf-banner" style="<?php echo esc_attr( $banner_bg_style ); ?>">

				<?php if ( 'yes' === $show_badge && ( $badge_top || $badge_main || $badge_bottom ) ) : ?>
					<div class="shopbar-hf-badge">
						<?php if ( $badge_top ) : ?><small><?php echo esc_html( $badge_top ); ?></small><?php endif; ?>
						<?php if ( $badge_main ) : ?><strong><?php echo esc_html( $badge_main ); ?></strong><?php endif; ?>
						<?php if ( $badge_bottom ) : ?><small><?php echo esc_html( $badge_bottom ); ?></small><?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="shopbar-hf-text" style="max-width: <?php echo esc_attr( $content_width ); ?>%;">
					<?php if ( $eyebrow ) : ?>
						<span class="shopbar-hf-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
					<?php endif; ?>

					<?php if ( $title ) : ?>
						<h2 class="shopbar-hf-title"><?php echo nl2br( esc_html( $title ) ); ?></h2>
					<?php endif; ?>

					<?php if ( $description ) : ?>
						<p class="shopbar-hf-desc"><?php echo esc_html( $description ); ?></p>
					<?php endif; ?>

					<?php if ( $btn_text ) : ?>
						<a class="shopbar-hf-btn" href="<?php echo esc_url( $btn_link ); ?>"<?php echo esc_attr( $btn_target ); // phpcs:ignore ?><?php echo ' ' . esc_attr( trim( $btn_nofollow ) ); ?>>
							<?php echo esc_html( $btn_text ); ?>
							<?php
							if ( ! empty( $settings['btn_icon']['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $settings['btn_icon'], array( 'aria-hidden' => 'true' ) );
							}
							?>
						</a>
				<?php endif; ?>
			</div>

			<?php if ( $show_decor ) : ?>
				<div class="shopbar-hf-decor" aria-hidden="true" style="color:<?php echo esc_attr( $decor_color ); ?>">
					<?php
					$decor = array(
						array( 'bag',         120, 22,  34,  0.60, -6 ),
						array( 'cart',         74, 150, 70,  0.65, -4 ),
						array( 'tag',          60, 96,  170, 0.75, 13 ),
						array( 'gift',         52, 30,  200, 0.70, 8 ),
						array( 'sparkles',     42, 206, 150, 1.00, 0 ),
						array( 'credit-card',  56, 188, 40,  0.60, -10 ),
					);
					foreach ( $decor as $d ) {
						list( $d_icon, $d_size, $d_bottom, $d_right, $d_op, $d_rot ) = $d;
						printf(
							'<span class="shopbar-hf-decor-item" style="bottom:%2$dpx;right:%3$dpx;opacity:%4$.2f;transform:scale(%5$.2f) rotate(%6$ddeg)">%1$s</span>',
							shopbar_hf_render_icon( $d_icon, $d_size ), // phpcs:ignore
							$d_bottom,
							$d_right,
							( $decor_opacity * $d_op ),
							$decor_size,
							$d_rot
						);
					}
					?>
				</div>
			<?php endif; ?>
		</div>

		</div>
	</div>
</section>

<style>
	.shopbar-hf-<?php echo esc_attr( $id ); ?> {
		width: 100%;
		max-width: 100%;
		overflow: hidden;
		overflow-x: clip;
		box-sizing: border-box;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> *,
	.shopbar-hf-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-hf-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-inner {
		max-width: 1350px;
		margin: 0 auto;
		width: 100%;
		padding: 0 24px;
	}

	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-grid {
		display: flex;
		align-items: stretch;
		gap: 20px;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-grid--full { flex-wrap: wrap; }

	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-sidebar {
		width: 244px;
		flex-shrink: 0;
		background: #fff;
		border: 1px solid #E8E4DF;
		border-radius: 16px;
		padding: 10px 0;
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-sidebar-title {
		margin: 4px 18px 8px;
		font-size: 13px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.6px;
		color: #9C9792;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cats {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat-link {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 10px 18px;
		font-size: 14px;
		font-weight: 500;
		color: #1C1C1C;
		text-decoration: none;
		transition: background .2s ease, color .2s ease;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat-icon-wrap {
		width: 22px;
		height: 22px;
		display: inline-flex;
		align-items: center;
		justify-content: center;
		color: #6B6560;
		flex-shrink: 0;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat-link:hover { background: #F8F9FA; color: #0072FF; }
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat--all { margin-top: 4px; border-top: 1px solid #F0EDE9; padding-top: 4px; }
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat-link--all { font-weight: 700; }

	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-banner {
		position: relative;
		flex: 1 1 auto;
		min-height: 420px;
		border-radius: 16px;
		overflow: hidden;
		display: flex;
		align-items: center;
	}
	
	<?php if ( $show_overlay ) : ?>
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-banner::before {
		content: "";
		position: absolute;
		inset: 0;
		background: <?php echo esc_attr( $overlay_color ); ?>;
		opacity: <?php echo esc_attr( $overlay_opacity ); ?>;
		z-index: 1;
		pointer-events: none;
	}
	<?php endif; ?>
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-text {
		position: relative;
		z-index: 2;
		max-width: 52%;
		padding: 44px 40px;
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-eyebrow {
		display: inline-block;
		font-size: 13px;
		font-weight: 600;
		letter-spacing: 0.3px;
		color: #FF3D81;
		margin-bottom: 14px;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-title {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		font-size: 40px;
		line-height: 1.12em;
		font-weight: 800;
		letter-spacing: -0.02em;
		color: #FFFFFF;
		margin: 0 0 14px;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-desc {
		font-size: 15px;
		line-height: 1.6;
		color: #F5F5F5;
		margin: 0 0 24px;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-btn {
		display: inline-flex;
		align-items: center;
		gap: 8px;
		background: #FFFFFF;
		color: #1C1C1C;
		font-weight: 600;
		font-size: 14px;
		padding: 13px 26px;
		border-radius: 8px;
		text-decoration: none;
		white-space: nowrap;
		transition: background .2s ease, color .2s ease, transform .2s ease;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-btn:hover { transform: translateY(-1px); }
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-btn svg,
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-btn i { width: 16px; height: 16px; font-size: 16px; color: #1C1C1C; fill: #1C1C1C; }

	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-badge {
		position: absolute;
		top: 36px;
		right: 36px;
		width: 92px;
		height: 92px;
		border-radius: 50%;
		background: #FF3D81;
		color: #fff;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		text-align: center;
		line-height: 1.2;
		font-weight: 700;
		box-shadow: 0 10px 28px rgba(255, 61, 129, 0.35);
		border: 4px solid rgba(255,255,255,0.55);
		z-index: 3;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-badge small { font-size: 10px; letter-spacing: 1px; opacity: .9; }
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-badge strong { font-size: 22px; }

	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-decor {
		position: absolute;
		inset: 0;
		z-index: 1;
		pointer-events: none;
		color: #1C1C1C;
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-decor-item {
		position: absolute;
		line-height: 0;
		filter: drop-shadow(0 4px 10px rgba(0,0,0,0.18));
	}
	.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-decor-item svg {
		display: block;
		stroke-width: 1.5;
	}

	/* ── Responsive ──
	*/
	@media (max-width: 1024px) {
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-grid { flex-direction: column !important; align-items: stretch; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-sidebar { width: 100% !important; max-width: 100% !important; flex-shrink: 1 !important; }
		/* Category list as a compact, wrapping chip row (no hidden/truncated items). */
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cats {
			display: flex;
			flex-wrap: wrap;
			align-items: center;
			gap: 4px 8px;
			padding: 0 12px 12px;
		}
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cats li { flex: 0 0 auto; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat-link { padding: 8px 12px; border-radius: 8px; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat--all {
			margin-top: 0;
			border-top: 0;
			padding-top: 0;
			border-left: 1px solid #F0EDE9;
			margin-left: 2px;
			padding-left: 8px;
		}
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-sidebar-title { margin: 10px 18px 4px; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-text { max-width: 60%; padding: 36px 30px; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-title { font-size: 34px !important; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-decor { transform: scale(0.85); transform-origin: bottom right; }
	}
	@media (max-width: 768px) {
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-banner { min-height: 360px !important; }
		/* Override the inline max-width so the text block can use the full banner width. */
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-text { max-width: 100% !important; padding: 30px 24px; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-title { font-size: 28px !important; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-badge { width: 76px !important; height: 76px !important; top: 16px !important; right: 16px !important; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-badge strong { font-size: 18px; }
		/* Keep the badge from covering the title once the text uses the full width. */
		.shopbar-hf-<?php echo esc_attr( $id ); ?>.shopbar-hf--badge .shopbar-hf-text { padding-right: 108px; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-decor { display: none; }
		/* On small screens the categories stack vertically, one full-width
		   item per row (same structure as the desktop sidebar). */
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cats { display: block; padding: 0; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cats li { width: 100%; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat-link { width: 100%; padding: 11px 18px; border-radius: 0; white-space: normal; }
		.shopbar-hf-<?php echo esc_attr( $id ); ?> .shopbar-hf-cat--all {
			margin-top: 4px;
			border-top: 1px solid #F0EDE9;
			padding-top: 4px;
			border-left: 0;
			margin-left: 0;
			padding-left: 0;
		}
	}
</style>
