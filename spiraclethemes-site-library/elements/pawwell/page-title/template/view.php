<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Page Title - Frontend Render
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings          = $this->get_settings();
$id                = $this->get_id();
$eyebrow           = $settings['eyebrow'] ?? '';
$title             = $settings['title'] ?? '';
$accent_word       = $settings['accent_word'] ?? '';
$subtitle          = $settings['subtitle'] ?? '';
$show_crumb        = $settings['show_breadcrumb'] ?? 'yes';
$show_stats        = $settings['show_stats'] ?? 'yes';
$show_blobs        = $settings['show_blobs'] ?? 'yes';
$home_text         = $settings['home_text'] ?? '';
$home_url          = $settings['home_url']['url'] ?? '#';
$current_text      = $settings['current_text'] ?? '';
$stats             = $settings['stats'] ?? [];
$show_border_top   = $settings['show_border_top'] ?? 'no';
$show_border_bottom = $settings['show_border_bottom'] ?? 'yes';
$full_width_border = $settings['full_width_border'] ?? 'no';
$border_color      = $settings['border_color'] ?? '#E8E2DA';
$border_width      = isset( $settings['border_width']['size'] ) ? absint( $settings['border_width']['size'] ) : 1;

// Border flags
$wrap_class  = 'pawwell-pt pawwell-pt-' . esc_attr( $id );
$wrap_class .= 'yes' === $show_border_top ? ' pawwell-pt-bt' : '';
$wrap_class .= 'yes' === $show_border_bottom ? ' pawwell-pt-bb' : '';
$wrap_class .= ( 'yes' === $show_border_top || 'yes' === $show_border_bottom ) && 'yes' === $full_width_border ? ' pawwell-pt-fullwidth' : '';

// Build the title with the accent word highlighted.
$render_title = esc_html( $title );
if ( '' !== $accent_word && '' !== $title ) {
	$safe_accent = esc_html( $accent_word );
	$pattern     = preg_quote( $safe_accent, '/' );
	if ( preg_match( '/' . $pattern . '/i', $render_title ) ) {
		$render_title = preg_replace(
			'/' . $pattern . '/i',
			'<span class="pawwell-pt-accent">' . $safe_accent . '</span>',
			$render_title,
			1
		);
	} else {
		$render_title .= ' <span class="pawwell-pt-accent">' . $safe_accent . '</span>';
	}
}
?>
<section class="<?php echo esc_attr( $wrap_class ); ?>">
	<?php if ( 'yes' === $show_blobs ) : ?>
		<div class="pawwell-pt-blob pawwell-pt-blob-1"></div>
		<div class="pawwell-pt-blob pawwell-pt-blob-2"></div>
	<?php endif; ?>

	<div class="pawwell-pt-inner">
		<?php if ( 'yes' === $show_crumb ) : ?>
			<nav class="pawwell-pt-crumb" aria-label="Breadcrumb">
				<a href="<?php echo esc_url( $home_url ); ?>"><?php echo esc_html( $home_text ); ?></a>
				<span class="pawwell-pt-sep" aria-hidden="true">/</span>
				<span class="current"><?php echo esc_html( $current_text ); ?></span>
			</nav>
		<?php endif; ?>

		<div class="pawwell-pt-row">
			<div class="pawwell-pt-text">
				<?php if ( ! empty( $eyebrow ) ) : ?>
					<div class="pawwell-pt-eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
				<?php endif; ?>
				<?php if ( ! empty( $title ) ) : ?>
					<h1 class="pawwell-pt-title"><?php echo wp_kses( $render_title, [ 'span' => [ 'class' => true ] ] ); ?></h1>
				<?php endif; ?>
				<?php if ( ! empty( $subtitle ) ) : ?>
					<p class="pawwell-pt-sub"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( 'yes' === $show_stats && ! empty( $stats ) ) : ?>
				<div class="pawwell-pt-stats">
					<?php foreach ( $stats as $stat ) :
						$s_value = $stat['stat_value'] ?? '';
						$s_label = $stat['stat_label'] ?? '';
						$s_bg    = $stat['stat_icon_bg'] ?? '#F4E0DA';
						$s_color = $stat['stat_icon_color'] ?? '#C45B3E';
						if ( '' === $s_value && '' === $s_label ) {
							continue;
						}
						?>
						<div class="pawwell-pt-stat">
							<div class="pawwell-pt-stat-ic" style="background:<?php echo esc_attr( $s_bg ); ?>;color:<?php echo esc_attr( $s_color ); ?>">
								<?php
								if ( ! empty( $stat['stat_icon']['value'] ) ) {
									\Elementor\Icons_Manager::render_icon( $stat['stat_icon'], [ 'aria-hidden' => 'true' ] );
								}
								?>
							</div>
							<div class="pawwell-pt-stat-text">
								<?php if ( ! empty( $s_value ) ) : ?>
									<strong><?php echo esc_html( $s_value ); ?></strong>
								<?php endif; ?>
								<?php if ( ! empty( $s_label ) ) : ?>
									<span><?php echo esc_html( $s_label ); ?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<style>
	.pawwell-pt-<?php echo esc_attr( $id ); ?> {
		position: relative;
		border: 0 solid <?php echo esc_attr( $border_color ); ?>;
		overflow: hidden;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?>.pawwell-pt-bt { border-top-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?>.pawwell-pt-bb { border-bottom-width: <?php echo esc_attr( $border_width ); ?>px; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?>.pawwell-pt-fullwidth {
		width: 100vw;
		margin-left: calc(50% - 50vw);
		margin-right: calc(50% - 50vw);
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-blob {
		position: absolute;
		border-radius: 50%;
		filter: blur(80px);
		opacity: 0.5;
		z-index: 0;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-blob-1 {
		width: 500px; height: 500px;
		background: #F4E0DA;
		top: -15%; right: -5%;
		animation: pawwell-pt-float1 20s ease-in-out infinite;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-blob-2 {
		width: 400px; height: 400px;
		background: #E8EFE3;
		bottom: -20%; left: -5%;
		animation: pawwell-pt-float2 18s ease-in-out infinite;
	}
	@keyframes pawwell-pt-float1 {
		0%, 100% { transform: translate(0, 0) scale(1); }
		33% { transform: translate(-30px, 40px) scale(1.05); }
		66% { transform: translate(20px, -20px) scale(0.95); }
	}
	@keyframes pawwell-pt-float2 {
		0%, 100% { transform: translate(0, 0) scale(1); }
		33% { transform: translate(40px, -30px) scale(1.08); }
		66% { transform: translate(-20px, 20px) scale(0.96); }
	}

	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-inner {
		position: relative;
		z-index: 1;
		margin: 0 auto;
		padding: 0 32px;
	}

	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-crumb {
		display: flex;
		align-items: center;
		gap: 8px;
		font-size: 13px;
		color: #8A8A8A;
		margin-bottom: 22px;
		flex-wrap: wrap;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-crumb a {
		color: #8A8A8A;
		display: inline-flex;
		align-items: center;
		gap: 6px;
		text-decoration: none;
		transition: color .2s;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-crumb a:hover { color: #C45B3E; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-sep { opacity: 0.5; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-crumb .current { color: #1E1E1E; font-weight: 600; }

	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-row {
		display: flex;
		align-items: flex-end;
		justify-content: space-between;
		gap: 40px;
		flex-wrap: wrap;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-text { max-width: 680px; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-eyebrow { margin-bottom: 12px; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-title {
		font-size: clamp(34px, 4.8vw, 56px);
		line-height: 1.04;
		letter-spacing: -0.02em;
		font-weight: 400;
		margin: 0;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-accent { color: #C45B3E; }
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-sub {
		line-height: 1.7;
		margin-top: 18px;
		max-width: 560px;
	}

	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stats {
		display: flex;
		gap: 28px;
		flex-wrap: wrap;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stat {
		border: 1px solid #E8E2DA;
		padding: 18px 24px;
		box-shadow: 0 2px 8px rgba(30,30,30,.04);
		display: flex;
		align-items: center;
		gap: 14px;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stat-ic {
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stat-ic i,
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stat-ic svg {
		width: 26px;
		height: 26px;
		font-size: 26px;
		color: inherit;
		fill: currentColor;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stat-text strong {
		display: block;
		font-size: 22px;
		font-weight: 800;
		line-height: 1.1;
	}
	.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-stat-text span {
		font-size: 13px;
		color: #8A8A8A;
	}

	/* Responsive */
	@media (max-width: 920px) {
		.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-row {
			flex-direction: column;
			align-items: flex-start;
			gap: 24px;
		}
	}
	@media (max-width: 640px) {
		.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-inner { padding: 0 20px; }
		.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-title { font-size: 32px; }
		.pawwell-pt-<?php echo esc_attr( $id ); ?> .pawwell-pt-sub { font-size: 15px; }
	}
</style>
