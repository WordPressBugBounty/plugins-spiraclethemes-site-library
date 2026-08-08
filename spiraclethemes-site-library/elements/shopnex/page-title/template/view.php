<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Page Title Widget
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id      = ! empty( $widget_id ) ? $widget_id : '';
$settings       = ! empty( $settings ) ? $settings : array();
$title          = ! empty( $settings['title'] ) ? $settings['title'] : '';
$title_tag      = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h1';
$subtitle       = ! empty( $settings['subtitle'] ) ? $settings['subtitle'] : '';
$show_subtitle  = ! empty( $settings['show_subtitle'] ) && 'yes' === $settings['show_subtitle'];
$show_separator = ! empty( $settings['show_separator'] ) && 'yes' === $settings['show_separator'];

// Validate title tag
$allowed_tags = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p' );
$title_tag    = in_array( $title_tag, $allowed_tags, true ) ? $title_tag : 'h1';
?>

<div class="shopnex-page-title-wrapper shopnex-page-title-<?php echo esc_attr( $widget_id ); ?>">
    <?php if ( $title ) : ?>
        <<?php echo esc_attr( $title_tag ); ?> class="shopnex-page-title-heading">
            <?php echo esc_html( $title ); ?>
        </<?php echo esc_attr( $title_tag ); ?>>
    <?php endif; ?>

    <?php if ( $show_separator ) : ?>
        <div class="shopnex-page-title-separator"></div>
    <?php endif; ?>

    <?php if ( $show_subtitle && $subtitle ) : ?>
        <p class="shopnex-page-title-subtitle"><?php echo wp_kses_post( nl2br( $subtitle ) ); ?></p>
    <?php endif; ?>
</div>

<style>
.shopnex-page-title-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-title-heading {
    font-family: 'Playfair Display', serif;
    font-size: clamp(30px, 4vw, 44px);
    font-weight: 500;
    letter-spacing: -0.02em;
    color: #1C1C1C;
    margin: 0 0 8px 0;
    line-height: 1.2;
}

.shopnex-page-title-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-title-separator {
    width: 40px;
    height: 2px;
    background-color: #B8977E;
    border-radius: 2px;
    margin-top: 16px;
}

.shopnex-page-title-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-title-subtitle {
    font-size: 15px;
    color: #6B6560;
    max-width: 520px;
    line-height: 1.6;
    margin: 0;
    font-weight: 400;
    letter-spacing: -0.01em;
}

/* Responsive */
@media (max-width: 768px) {
    .shopnex-page-title-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-title-heading {
        font-size: 28px;
    }

    .shopnex-page-title-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-title-subtitle {
        font-size: 14px;
        max-width: 100%;
    }
}

@media (max-width: 480px) {
    .shopnex-page-title-<?php echo esc_attr( $widget_id ); ?> .shopnex-page-title-heading {
        font-size: 26px;
    }
}
</style>
