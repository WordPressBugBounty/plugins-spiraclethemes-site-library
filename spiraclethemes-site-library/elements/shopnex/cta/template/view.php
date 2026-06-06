<?php
/**
 * CTA Widget View for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id     = ! empty( $widget_id ) ? $widget_id : '';
$settings      = ! empty( $settings ) ? $settings : array();
$show_tag      = ! empty( $settings['show_tag'] ) && 'yes' === $settings['show_tag'];
$tag_text      = ! empty( $settings['tag_text'] ) ? $settings['tag_text'] : '';
$title         = ! empty( $settings['title'] ) ? $settings['title'] : '';
$description   = ! empty( $settings['description'] ) ? $settings['description'] : '';
$show_button   = ! empty( $settings['show_button'] ) && 'yes' === $settings['show_button'];
$button_text   = ! empty( $settings['button_text'] ) ? $settings['button_text'] : '';
$button_link   = ! empty( $settings['button_link'] ) ? $settings['button_link'] : array();
$bg_type       = ! empty( $settings['bg_type'] ) ? $settings['bg_type'] : 'color';
$bg_image      = ! empty( $settings['bg_image'] ) ? $settings['bg_image'] : array();
$bg_overlay    = ! empty( $settings['bg_overlay_color'] ) ? $settings['bg_overlay_color'] : 'rgba(28, 28, 28, 0.45)';
$is_image_bg   = 'image' === $bg_type && ! empty( $bg_image['url'] );

// Build button link attributes
$btn_href    = ! empty( $button_link['url'] ) ? esc_url( $button_link['url'] ) : '#';
$btn_target  = ! empty( $button_link['is_external'] ) ? ' target="_blank"' : '';
$btn_nofollow = ! empty( $button_link['nofollow'] ) ? ' rel="nofollow"' : '';
?>

<div class="shopnex-cta-wrapper shopnex-cta-<?php echo esc_attr( $widget_id ); ?>">
    <div class="shopnex-cta-section<?php echo $is_image_bg ? ' shopnex-cta-has-image' : ''; ?>">
        <?php if ( $is_image_bg ) : ?>
            <div class="shopnex-cta-bg-image">
                <img src="<?php echo esc_url( $bg_image['url'] ); ?>" alt="<?php echo esc_attr( $title ); ?>">
            </div>
            <div class="shopnex-cta-overlay" style="background-color: <?php echo esc_attr( $bg_overlay ); ?>;"></div>
        <?php endif; ?>

        <div class="shopnex-cta-content">
            <?php if ( $show_tag && $tag_text ) : ?>
                <span class="shopnex-cta-tag"><?php echo esc_html( $tag_text ); ?></span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="shopnex-cta-title"><?php echo wp_kses_post( nl2br( $title ) ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="shopnex-cta-description"><?php echo wp_kses_post( nl2br( $description ) ); ?></p>
            <?php endif; ?>

            <?php if ( $show_button && $button_text ) : ?>
                <a href="<?php echo $btn_href; ?>" class="shopnex-cta-btn"<?php echo $btn_target . $btn_nofollow; ?>>
                    <?php echo esc_html( $button_text ); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-section {
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 40px;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-bg-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-bg-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-section:hover .shopnex-cta-bg-image img {
    transform: scale(1.03);
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-overlay {
    position: absolute;
    inset: 0;
    z-index: 1;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-content {
    position: relative;
    z-index: 2;
    margin: 0 auto;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-tag {
    display: inline-block;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    font-weight: 600;
    color: #B8977E;
    margin-bottom: 12px;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(24px, 3vw, 32px);
    font-weight: 500;
    letter-spacing: -0.015em;
    color: #1C1C1C;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-description {
    font-size: 14px;
    color: #6B6560;
    line-height: 1.5;
    margin: 0 0 24px 0;
    font-weight: 400;
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-btn {
    display: inline-block;
    padding: 13px 28px;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.04em;
    text-decoration: none;
    border-radius: 50px;
    background-color: #1C1C1C;
    color: #fff;
    border: none;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-btn:hover {
    background-color: #333;
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
    color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
    .shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-section {
        padding: 40px 20px !important;
    }

    .shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-title {
        font-size: 24px;
    }

    .shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-description {
        font-size: 14px;
    }

    .shopnex-cta-<?php echo esc_attr( $widget_id ); ?> .shopnex-cta-btn {
        padding: 13px 28px;
        font-size: 13px;
    }
}
</style>
