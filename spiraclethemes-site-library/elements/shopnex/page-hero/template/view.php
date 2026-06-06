<?php
/**
 * Page Hero Widget View for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id        = ! empty( $widget_id ) ? $widget_id : '';
$settings         = ! empty( $settings ) ? $settings : array();

// Content variables
$tag_text         = ! empty( $settings['tag_text'] ) ? $settings['tag_text'] : '';
$show_tag         = ! empty( $settings['show_tag'] ) && 'yes' === $settings['show_tag'];
$title            = ! empty( $settings['title'] ) ? $settings['title'] : '';
$title_tag        = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h1';
$description      = ! empty( $settings['description'] ) ? $settings['description'] : '';
$show_description = ! empty( $settings['show_description'] ) && 'yes' === $settings['show_description'];

// Background image
$bg_image_url     = ! empty( $settings['background_image']['url'] ) ? esc_url( $settings['background_image']['url'] ) : '';
$enable_zoom      = ! empty( $settings['enable_zoom_effect'] ) && 'yes' === $settings['enable_zoom_effect'];

// Overlay
$show_overlay     = ! empty( $settings['show_overlay'] ) && 'yes' === $settings['show_overlay'];
$overlay_from     = ! empty( $settings['overlay_color'] ) ? $settings['overlay_color'] : 'rgba(28,28,28,0.55)';
$overlay_to       = ! empty( $settings['overlay_color_to'] ) ? $settings['overlay_color_to'] : 'rgba(28,28,28,0)';
$overlay_stop     = ! empty( $settings['overlay_stop']['size'] ) ? intval( $settings['overlay_stop']['size'] ) : 55;

// Validate title tag
$allowed_tags     = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p' );
$title_tag        = in_array( $title_tag, $allowed_tags, true ) ? $title_tag : 'h1';

// Build overlay gradient
$overlay_gradient = "linear-gradient(to top, {$overlay_from} 0%, {$overlay_to} {$overlay_stop}%)";
?>

<div class="shopnex-page-hero shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?>">
    <?php if ( $bg_image_url ) : ?>
        <img class="shopnex-page-hero-bg<?php echo $enable_zoom ? ' shopnex-page-hero-bg--zoom' : ''; ?>" 
             src="<?php echo esc_url( $bg_image_url ); ?>" 
             alt="<?php echo esc_attr( $title ); ?>"
             loading="eager">
    <?php endif; ?>

    <?php if ( $show_overlay ) : ?>
        <div class="shopnex-page-hero-overlay" style="background: <?php echo esc_attr( $overlay_gradient ); ?>;"></div>
    <?php endif; ?>

    <div class="shopnex-page-hero-content">
        <?php if ( $show_tag && $tag_text ) : ?>
            <span class="shopnex-page-hero-tag"><?php echo esc_html( $tag_text ); ?></span>
        <?php endif; ?>

        <?php if ( $title ) : ?>
            <<?php echo esc_attr( $title_tag ); ?> class="shopnex-page-hero-title">
                <?php echo esc_html( $title ); ?>
            </<?php echo esc_attr( $title_tag ); ?>>
        <?php endif; ?>

        <?php if ( $show_description && $description ) : ?>
            <p class="shopnex-page-hero-desc"><?php echo wp_kses_post( nl2br( $description ) ); ?></p>
        <?php endif; ?>
    </div>
</div>

<style>
.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> {
    position: relative;
    overflow: hidden;
    min-height: 480px;
    display: flex;
    align-items: flex-end;
    background: #F3EFEA;
    border-radius: 16px;
    margin-bottom: 70px;
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-bg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-bg--zoom:hover {
    transform: scale(1.03);
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-content {
    position: relative;
    z-index: 2;
    padding: 50px 60px;
    max-width: 600px;
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-tag {
    display: inline-block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #fff;
    background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.3);
    padding: 8px 16px;
    border-radius: 50px;
    margin-bottom: 20px;
    font-weight: 500;
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(34px, 5vw, 52px);
    font-weight: 500;
    color: #fff;
    line-height: 1.15;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
}

.shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-desc {
    font-size: 16px;
    color: rgba(255,255,255,0.85);
    line-height: 1.6;
    font-weight: 350;
    max-width: 440px;
    margin: 0;
}

/* Responsive */
@media (max-width: 1024px) {
    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-content {
        padding: 40px;
    }
}

@media (max-width: 768px) {
    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> {
        min-height: 380px;
        border-radius: 10px;
        margin-bottom: 40px;
    }

    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-content {
        padding: 28px;
    }

    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-title {
        font-size: 30px;
    }

    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-desc {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> {
        min-height: 320px;
    }

    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-content {
        padding: 20px;
    }

    .shopnex-page-hero-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-hero-title {
        font-size: 26px;
    }
}
</style>
