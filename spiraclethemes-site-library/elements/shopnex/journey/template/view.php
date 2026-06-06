<?php
/**
 * Journey / Timeline Widget View for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Content variables
$section_tag   = ! empty( $settings['section_tag'] ) ? $settings['section_tag'] : '';
$section_title = ! empty( $settings['section_title'] ) ? $settings['section_title'] : '';
$show_header   = ! empty( $settings['show_header'] ) && 'yes' === $settings['show_header'];
$timeline_list = ! empty( $settings['timeline_list'] ) ? $settings['timeline_list'] : array();

if ( empty( $timeline_list ) ) {
    return;
}
?>

<div class="shopnex-journey-section shopnex-journey-<?php echo esc_attr( $widget_id ); ?>">
    <?php if ( $show_header ) : ?>
        <div class="shopnex-journey-header">
            <?php if ( $section_tag ) : ?>
                <span class="shopnex-journey-tag"><?php echo esc_html( $section_tag ); ?></span>
            <?php endif; ?>
            <?php if ( $section_title ) : ?>
                <h2 class="shopnex-journey-title"><?php echo esc_html( $section_title ); ?></h2>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="shopnex-timeline">
        <?php foreach ( $timeline_list as $index => $item ) :
            $year  = ! empty( $item['timeline_year'] ) ? $item['timeline_year'] : '';
            $title = ! empty( $item['timeline_title'] ) ? $item['timeline_title'] : '';
            $desc  = ! empty( $item['timeline_description'] ) ? $item['timeline_description'] : '';
        ?>
            <div class="shopnex-timeline-item">
                <div class="shopnex-timeline-dot"></div>
                <?php if ( $year ) : ?>
                    <div class="shopnex-timeline-year"><?php echo esc_html( $year ); ?></div>
                <?php endif; ?>
                <?php if ( $title ) : ?>
                    <h4><?php echo esc_html( $title ); ?></h4>
                <?php endif; ?>
                <?php if ( $desc ) : ?>
                    <p><?php echo esc_html( $desc ); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> {
    margin-bottom: 70px;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-journey-header {
    text-align: center;
    margin-bottom: 50px;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-journey-tag {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #B8977E;
    font-weight: 600;
    margin-bottom: 12px;
    display: block;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-journey-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3.5vw, 40px);
    font-weight: 500;
    letter-spacing: -0.015em;
    color: #1C1C1C;
    margin-bottom: 12px;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    padding-left: 40px;
    border-left: 1.5px solid #E8E4DF;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-item {
    position: relative;
    padding-bottom: 40px;
    padding-left: 32px;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-item:last-child {
    padding-bottom: 0;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-dot {
    position: absolute;
    left: -38px;
    top: 6px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #FBF9F6;
    border: 2px solid #B8977E;
    z-index: 1;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-item:first-child .shopnex-timeline-dot {
    background: #B8977E;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-year {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #B8977E;
    font-weight: 600;
    margin-bottom: 6px;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-item h4 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    color: #1C1C1C;
}

.shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-item p {
    font-size: 14px;
    color: #6B6560;
    line-height: 1.6;
    max-width: 560px;
}

/* Responsive */
@media (max-width: 768px) {
    .shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline {
        padding-left: 30px;
    }

    .shopnex-journey-<?php echo esc_attr( $widget_id ); ?> .shopnex-timeline-dot {
        left: -33px;
    }
}
</style>
