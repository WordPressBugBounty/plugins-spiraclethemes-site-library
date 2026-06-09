<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Info Boxes Widget View for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Layout variables
$info_boxes_list    = ! empty( $settings['info_boxes_list'] ) ? $settings['info_boxes_list'] : array();
$show_border_top    = ! empty( $settings['show_border_top'] ) && 'yes' === $settings['show_border_top'];
$show_border_bottom = ! empty( $settings['show_border_bottom'] ) && 'yes' === $settings['show_border_bottom'];

// Build classes
$box_classes = array( 'shopnex-info-boxes' );
$box_classes[] = 'shopnex-info-boxes-' . esc_attr( $widget_id );
if ( $show_border_top ) {
    $box_classes[] = 'has-border-top';
}
if ( $show_border_bottom ) {
    $box_classes[] = 'has-border-bottom';
}
$strip_class = implode( ' ', $box_classes );

if ( empty( $info_boxes_list ) ) {
    return;
}
?>

<div class="<?php echo esc_attr( $strip_class ); ?>">
    <?php foreach ( $info_boxes_list as $index => $item ) :
        $box_icon_type      = ! empty( $item['box_icon_type'] ) ? $item['box_icon_type'] : 'emoji';
        $box_icon           = ! empty( $item['box_icon'] ) ? $item['box_icon'] : '';
        $box_elementor_icon = ! empty( $item['box_elementor_icon'] ) ? $item['box_elementor_icon'] : array();
        $box_title          = ! empty( $item['box_title'] ) ? $item['box_title'] : '';
        $box_description    = ! empty( $item['box_description'] ) ? $item['box_description'] : '';
    ?>
        <div class="shopnex-info-box-item">
            <?php if ( 'elementor' === $box_icon_type && ! empty( $box_elementor_icon['value'] ) ) : ?>
                <span class="shopnex-info-box-icon shopnex-info-box-icon--elementor">
                    <?php \Elementor\Icons_Manager::render_icon( $box_elementor_icon, array( 'aria-hidden' => 'true' ) ); ?>
                </span>
            <?php elseif ( $box_icon ) : ?>
                <span class="shopnex-info-box-icon shopnex-info-box-icon--emoji"><?php echo esc_html( $box_icon ); ?></span>
            <?php endif; ?>
            <?php if ( $box_title ) : ?>
                <h4 class="shopnex-info-box-title"><?php echo esc_html( $box_title ); ?></h4>
            <?php endif; ?>
            <?php if ( $box_description ) : ?>
                <p class="shopnex-info-box-description"><?php echo esc_html( $box_description ); ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<style>
.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    padding: 50px 0;
    margin: 10px 0;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?>.has-border-top {
    border-top: 1px solid #F0EDE9;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?>.has-border-bottom {
    border-bottom: 1px solid #F0EDE9;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-item {
    text-align: center;
    padding: 20px;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-icon {
    font-size: 28px;
    margin-bottom: 14px;
    display: block;
    opacity: 0.8;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-icon--elementor i,
.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-icon--elementor svg {
    font-size: 28px;
    width: 1em;
    height: 1em;
    display: inline-block;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-title {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    color: #1C1C1C;
}

.shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-description {
    font-size: 13px;
    color: #6B6560;
    line-height: 1.5;
    max-width: 240px;
    margin: 0 auto;
}

/* Responsive - Tablet */
@media (max-width: 1024px) {
    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        padding: 40px 0;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-icon {
        font-size: 24px;
        margin-bottom: 12px;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-title {
        font-size: 16px;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-description {
        font-size: 13px;
        max-width: 280px;
    }
}

/* Responsive - Mobile */
@media (max-width: 767px) {
    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> {
        grid-template-columns: 1fr !important;
        width: 100% !important;
        gap: 0 !important;
        padding: 25px 0 !important;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-item {
        padding: 20px 15px;
        width: 100%;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-icon {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-title {
        font-size: 16px;
    }

    .shopnex-info-boxes-<?php echo esc_attr( $widget_id ); ?> .shopnex-info-box-description {
        font-size: 13px;
        max-width: 100%;
        margin: 0 auto;
    }
}
</style>
