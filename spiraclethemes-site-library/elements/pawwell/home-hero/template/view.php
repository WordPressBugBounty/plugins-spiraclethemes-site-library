<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Home Hero Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings();
$id       = $this->get_id();

$eyebrow_text      = $settings['eyebrow_text'] ?? '';
$hero_title        = $settings['hero_title'] ?? '';
$hero_title_accent = $settings['hero_title_accent'] ?? '';
$hero_description  = $settings['hero_description'] ?? '';
$primary_btn_text  = $settings['primary_btn_text'] ?? '';
$primary_btn_url   = $settings['primary_btn_url'] ?? [];
$secondary_btn_text = $settings['secondary_btn_text'] ?? '';
$secondary_btn_url  = $settings['secondary_btn_url'] ?? [];
$stats             = $settings['stats'] ?? [];
$floating_cards    = $settings['floating_cards'] ?? [];
$show_floating     = $settings['show_floating_cards'] ?? 'yes';
$show_floating_mobile = $settings['show_floating_cards_mobile'] ?? 'yes';
$hero_image        = $settings['hero_image'] ?? [];

$primary_link     = ! empty( $primary_btn_url['url'] ) ? esc_url( $primary_btn_url['url'] ) : '#';
$primary_target   = ! empty( $primary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$primary_nofollow = ! empty( $primary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

$secondary_link     = ! empty( $secondary_btn_url['url'] ) ? esc_url( $secondary_btn_url['url'] ) : '#';
$secondary_target   = ! empty( $secondary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$secondary_nofollow = ! empty( $secondary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

$image_url = '';
if ( ! empty( $hero_image['id'] ) ) {
    $image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $hero_image['id'], 'hero_image_size', $settings );
} elseif ( ! empty( $hero_image['url'] ) ) {
    $image_url = esc_url( $hero_image['url'] );
}

$title_html = '';
if ( ! empty( $hero_title ) ) {
    $title_html .= nl2br( esc_html( $hero_title ) );
}
if ( ! empty( $hero_title_accent ) ) {
    if ( ! empty( $title_html ) ) {
        $title_html .= '<br>';
    }
    $title_html .= '<span class="accent">' . esc_html( $hero_title_accent ) . '</span>';
}
?>

<section class="pawwell-hh pawwell-hh-<?php echo esc_attr( $id ); ?>" id="pawwell-hh-<?php echo esc_attr( $id ); ?>">
	<div class="pawwell-hh-shapes">
		<span class="pawwell-hh-blob pawwell-hh-blob-1"></span>
		<span class="pawwell-hh-blob pawwell-hh-blob-2"></span>
		<span class="pawwell-hh-blob pawwell-hh-blob-3"></span>
	</div>

	<div class="pawwell-hh-content">
		<div class="pawwell-hh-left">
			<div class="pawwell-hh-heading">
				<?php if ( ! empty( $eyebrow_text ) ) : ?>
					<span class="pawwell-hh-eyebrow">
						<?php
						if ( ! empty( $settings['eyebrow_icon']['value'] ) ) {
							\Elementor\Icons_Manager::render_icon( $settings['eyebrow_icon'], [ 'aria-hidden' => 'true' ] );
						}
						?>
						<?php echo esc_html( $eyebrow_text ); ?>
						<span class="pawwell-hh-dot"></span>
					</span>
				<?php endif; ?>

				<?php if ( ! empty( $title_html ) ) : ?>
					<h1 class="pawwell-hh-title"><?php echo wp_kses_post( $title_html ); ?></h1>
				<?php endif; ?>

				<?php if ( ! empty( $hero_description ) ) : ?>
					<p class="pawwell-hh-sub"><?php echo esc_html( $hero_description ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $primary_btn_text ) || ! empty( $secondary_btn_text ) ) : ?>
				<div class="pawwell-hh-ctas">
					<?php if ( ! empty( $primary_btn_text ) ) : ?>
						<a href="<?php echo esc_url( $primary_link ); ?>" class="pawwell-hh-btn pawwell-hh-btn-primary"<?php echo esc_attr( $primary_target . $primary_nofollow ); ?>>
							<?php echo esc_html( $primary_btn_text ); ?>
							<?php
							if ( ! empty( $settings['primary_btn_icon']['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $settings['primary_btn_icon'], [ 'aria-hidden' => 'true' ] );
							}
							?>
						</a>
					<?php endif; ?>

					<?php if ( ! empty( $secondary_btn_text ) ) : ?>
						<a href="<?php echo esc_url( $secondary_link ); ?>" class="pawwell-hh-btn pawwell-hh-btn-secondary"<?php echo esc_attr( $secondary_target . $secondary_nofollow ); ?>>
							<?php echo esc_html( $secondary_btn_text ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $stats ) ) : ?>
				<div class="pawwell-hh-stats">
					<?php foreach ( $stats as $stat ) :
						$stat_value  = $stat['stat_value'] ?? '';
						$stat_suffix = $stat['stat_suffix'] ?? '';
						$stat_label  = $stat['stat_label'] ?? '';
						if ( '' === $stat_value && '' === $stat_label ) {
							continue;
						}
						?>
						<div class="pawwell-hh-stat">
							<div class="pawwell-hh-stat-value">
								<?php echo esc_html( $stat_value ); ?><span class="pawwell-hh-stat-suffix"><?php echo esc_html( $stat_suffix ); ?></span>
							</div>
							<div class="pawwell-hh-stat-label"><?php echo esc_html( $stat_label ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="pawwell-hh-right">
		<?php if ( ! empty( $image_url ) ) : ?>
			<div class="pawwell-hh-image-wrap">
				<div class="pawwell-hh-image-inner">
					<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $hero_title ) ); ?>" loading="eager">
				</div>
			</div>
		<?php endif; ?>

			<?php if ( 'yes' === $show_floating && ! empty( $floating_cards ) && ! empty( $image_url ) ) : ?>
				<?php foreach ( $floating_cards as $card ) :
					$f_title  = $card['float_title'] ?? '';
					$f_meta   = $card['float_meta'] ?? '';
					$f_pos    = $card['float_position'] ?? 'top-right';
					$f_bg     = $card['float_icon_bg'] ?? '#e3f7f0';
					$f_color  = $card['float_icon_color'] ?? '#1abc9c';
					if ( '' === $f_title && '' === $f_meta ) {
						continue;
					}
					?>
					<div class="pawwell-hh-float pawwell-hh-float-<?php echo esc_attr( $f_pos ); ?>">
						<span class="pawwell-hh-float-icon" style="background:<?php echo esc_attr( $f_bg ); ?>;color:<?php echo esc_attr( $f_color ); ?>">
							<?php
							if ( ! empty( $card['float_icon']['value'] ) ) {
								\Elementor\Icons_Manager::render_icon( $card['float_icon'], [ 'aria-hidden' => 'true' ] );
							}
							?>
						</span>
						<span class="pawwell-hh-float-body">
							<?php if ( ! empty( $f_title ) ) : ?>
								<span class="pawwell-hh-float-name"><?php echo esc_html( $f_title ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $f_meta ) ) : ?>
								<span class="pawwell-hh-float-meta"><?php echo esc_html( $f_meta ); ?></span>
							<?php endif; ?>
						</span>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<style>
	.pawwell-hh-<?php echo esc_attr( $id ); ?> {
		position: relative;
		min-height: 700px;
		display: flex;
		align-items: center;
		overflow: hidden;
		overflow-x: clip;
		width: 100%;
		max-width: 100%;
		background: #FAF6F1;
		--pwhh-terracotta-light: #F4E0DA;
		--pwhh-sage-light: #E8EFE3;
		box-sizing: border-box;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> *,
	.pawwell-hh-<?php echo esc_attr( $id ); ?> *::before,
	.pawwell-hh-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-shapes {
		position: absolute;
		inset: 0;
		pointer-events: none;
		z-index: 0;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob {
		position: absolute;
		border-radius: 50%;
		filter: blur(80px);
		opacity: 0.5;
		display: block;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-1 {
		width: 600px;
		height: 600px;
		background: var(--pwhh-terracotta-light);
		top: -10%;
		right: -5%;
		animation: pawwell-hh-float1 20s ease-in-out infinite;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-2 {
		width: 500px;
		height: 500px;
		background: var(--pwhh-sage-light);
		bottom: -10%;
		left: -5%;
		animation: pawwell-hh-float2 18s ease-in-out infinite;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-3 {
		width: 300px;
		height: 300px;
		background: #F5ECD5;
		top: 40%;
		left: 40%;
		animation: pawwell-hh-float3 22s ease-in-out infinite;
	}
	@keyframes pawwell-hh-float1 {
		0%, 100% { transform: translate(0, 0) scale(1); }
		33% { transform: translate(-30px, 40px) scale(1.05); }
		66% { transform: translate(20px, -20px) scale(0.95); }
	}
	@keyframes pawwell-hh-float2 {
		0%, 100% { transform: translate(0, 0) scale(1); }
		33% { transform: translate(40px, -30px) scale(1.08); }
		66% { transform: translate(-20px, 20px) scale(0.96); }
	}
	@keyframes pawwell-hh-float3 {
		0%, 100% { transform: translate(0, 0) scale(1); }
		50% { transform: translate(-40px, -40px) scale(1.1); }
	}

	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-content {
		position: relative;
		z-index: 2;
		max-width: 1380px;
		margin: 0 auto;
		padding: 60px 32px;
		width: 100%;
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 60px;
		align-items: center;
		overflow-wrap: break-word;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-left { padding: 20px 0; min-width: 0; max-width: 100%; }

	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-eyebrow {
		display: inline-flex;
		align-items: center;
		gap: 10px;
		background: #fff;
		border: 1px solid #E8E2DA;
		padding: 8px 16px 8px 10px;
		border-radius: 999px;
		font-weight: 600;
		color: #2D2D2D;
		box-shadow: 0 2px 8px rgba(30,30,30,.04);
		margin-bottom: 28px;
		max-width: 100%;
		flex-wrap: wrap;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-eyebrow i,
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-eyebrow svg {
		width: 16px;
		height: 16px;
		font-size: 16px;
		color: #C45B3E;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-dot {
		width: 6px;
		height: 6px;
		background: #7B8F6B;
		border-radius: 50%;
		animation: pawwell-hh-pulse 2s ease-in-out infinite;
	}
	@keyframes pawwell-hh-pulse {
		0%, 100% { opacity: 1; transform: scale(1); }
		50% { opacity: 0.5; transform: scale(1.3); }
	}

	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-title {
		line-height: 1.05;
		letter-spacing: -0.02em;
		color: #1E1E1E;
		margin: 0 0 24px;
		font-weight: 400;
		overflow-wrap: break-word;
		word-break: break-word;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-title .accent {
		color: #C45B3E;
		position: relative;
		display: inline-block;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-title .accent::after {
		content: '';
		position: absolute;
		bottom: 4px;
		left: 0;
		width: 100%;
		height: 12px;
		background: #F4E0DA;
		z-index: -1;
		border-radius: 4px;
		transform: rotate(-1deg);
	}

	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-sub {
		color: #8A8A8A;
		max-width: 480px;
		margin: 0 0 32px;
		line-height: 1.7;
	}

	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-ctas {
		display: flex;
		gap: 14px;
		flex-wrap: wrap;
		margin-bottom: 40px;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		padding: 14px 28px;
		border-radius: 999px;
		font-weight: 600;
		letter-spacing: 0.01em;
		transition: transform .25s cubic-bezier(.16,1,.3,1), background .25s, color .25s, box-shadow .25s;
		border: 2px solid transparent;
		white-space: nowrap;
		cursor: pointer;
		text-decoration: none;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn i,
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn svg {
		width: 18px;
		height: 18px;
		font-size: 18px;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn-primary {
		background: #1E1E1E;
		color: #fff;
		box-shadow: 0 4px 16px rgba(30,30,30,.2);
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn-primary:hover {
		background: #2D2D2D;
		transform: translateY(-2px);
		box-shadow: 0 8px 24px rgba(30,30,30,.25);
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn-secondary {
		background: transparent;
		color: #1E1E1E;
		border-color: #E8E2DA;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn-secondary:hover {
		border-color: #1E1E1E;
		background: #1E1E1E;
		color: #fff;
		transform: translateY(-2px);
	}

	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stats {
		display: flex;
		gap: 40px;
		flex-wrap: wrap;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stat { position: relative; }
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stat:not(:last-child)::after {
		content: '';
		position: absolute;
		right: -20px;
		top: 50%;
		transform: translateY(-50%);
		width: 1px;
		height: 36px;
		background: #E8E2DA;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stat-value {
		font-weight: 700;
		color: #1E1E1E;
		letter-spacing: -0.02em;
		line-height: 1.1;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stat-label {
		font-size: 13px;
		color: #8A8A8A;
		margin-top: 4px;
	}

	/* Hero right */
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-right {
		position: relative;
		display: flex;
		justify-content: center;
		align-items: center;
		min-width: 0;
		max-width: 100%;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap {
		position: relative;
		width: 460px;
		max-width: 100%;
		flex: 0 0 auto;
		aspect-ratio: 1 / 1;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-inner {
		position: absolute;
		inset: 0;
		width: 100%;
		height: 100%;
		overflow: hidden;
		border-radius: 50% !important;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-inner img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		display: block;
	}

	/* Floating cards */
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float {
		position: absolute;
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 24px 64px rgba(30,30,30,.10);
		padding: 14px 16px;
		border: 1px solid rgba(0,0,0,.04);
		z-index: 5;
		display: flex;
		align-items: center;
		gap: 12px;
		animation: pawwell-hh-gentle-float 6s ease-in-out infinite;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-top-right {
		top: 30px;
		right: 0;
		animation-delay: 0s;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-left {
		bottom: 80px;
		left: 0;
		animation-delay: -2s;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-right {
		bottom: -10px;
		right: 20px;
		animation-delay: -4s;
	}
	@keyframes pawwell-hh-gentle-float {
		0%, 100% { transform: translateY(0); }
		50% { transform: translateY(-8px); }
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon {
		width: 40px;
		height: 40px;
		border-radius: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		flex-shrink: 0;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon i,
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon svg {
		width: 22px;
		height: 22px;
		font-size: 22px;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-body {
		display: flex;
		flex-direction: column;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-name {
		font-weight: 700;
		font-size: 13px;
		color: #1E1E1E;
	}
	.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-meta {
		font-size: 12px;
		color: #8A8A8A;
		margin-top: 2px;
	}

	/* Responsive */
	@media (max-width: 1080px) {
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-content { gap: 40px; }
		#pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap { width: 380px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-1 { width: 440px; height: 440px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-2 { width: 380px; height: 380px; }
	}
	@media (max-width: 920px) {
		.pawwell-hh-<?php echo esc_attr( $id ); ?> { min-height: auto; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-content {
			grid-template-columns: 1fr;
			gap: 36px;
			padding: 56px 28px;
			max-width: 640px;
			text-align: center;
		}
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-left { padding: 0; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-right { order: -1; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-eyebrow { margin-left: auto; margin-right: auto; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-sub { margin-left: auto; margin-right: auto; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-ctas { justify-content: center; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stats { justify-content: center; gap: 32px; }
		#pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap { width: 320px; margin: 0 auto; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-right { width: fit-content; margin-inline: auto; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float { padding: 10px 12px; gap: 10px; border-radius: 10px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon { width: 32px; height: 32px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon i,
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon svg { width: 17px; height: 17px; font-size: 17px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-name { font-size: 12px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-meta { font-size: 11px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-top-right { top: 18px; right: -12px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-left { bottom: 40px; left: -12px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-right { bottom: 0; right: 12px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-shapes { display: none; }
	}
	@media (max-width: 768px) {
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-content { padding: 48px 24px; }
		#pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap { width: 280px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-eyebrow { margin-bottom: 20px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-title { margin-bottom: 18px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-sub { margin-bottom: 26px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-ctas { margin-bottom: 32px; }
	}
	@media (max-width: 640px) {
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-content { padding: 40px 20px; gap: 30px; }
		#pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap { width: 240px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float { padding: 8px 10px; gap: 8px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon { width: 28px; height: 28px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon i,
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-icon svg { width: 15px; height: 15px; font-size: 15px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-name { font-size: 11px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-meta { font-size: 10px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-top-right { top: 12px; right: -8px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-left { bottom: 28px; left: -8px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-right { bottom: -6px; right: 8px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stats {
			flex-direction: column;
			gap: 16px;
			align-items: center;
		}
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stat:not(:last-child)::after { display: none; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-btn {
			width: 100%;
			padding: 13px 24px;
		}
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-ctas { gap: 12px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-1 { width: 280px; height: 280px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-blob-2 { width: 240px; height: 240px; }
	}
	@media (max-width: 480px) {
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-content { padding: 32px 16px; }
		#pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap { width: 200px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-top-right { top: 8px; right: -4px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-left { bottom: 22px; left: -4px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float-bottom-right { bottom: -8px; right: 4px; }
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-eyebrow {
			padding: 7px 14px 7px 9px;
			margin-bottom: 18px;
		}
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-stat-label { font-size: 12px; }
	}
	@media (max-width: 380px) {
		#pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-image-wrap { width: 170px; }
	}
</style>

<?php if ( 'yes' !== $show_floating_mobile ) : ?>
<style>
	@media (max-width: 920px) {
		.pawwell-hh-<?php echo esc_attr( $id ); ?> .pawwell-hh-float { display: none !important; }
	}
</style>
<?php endif; ?>
