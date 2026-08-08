<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Stats Strip Widget
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Layout variables
$stats_list         = ! empty( $settings['stats_list'] ) ? $settings['stats_list'] : array();
$show_border_top    = ! empty( $settings['show_border_top'] ) && 'yes' === $settings['show_border_top'];
$show_border_bottom = ! empty( $settings['show_border_bottom'] ) && 'yes' === $settings['show_border_bottom'];
$show_dividers      = ! empty( $settings['show_dividers'] ) && 'yes' === $settings['show_dividers'];

// Build border classes
$border_classes = array( 'shopnex-stats-strip' );
$border_classes[] = 'shopnex-stats-strip-' . esc_attr( $widget_id );
if ( $show_border_top ) {
    $border_classes[] = 'has-border-top';
}
if ( $show_border_bottom ) {
    $border_classes[] = 'has-border-bottom';
}
if ( $show_dividers ) {
    $border_classes[] = 'has-dividers';
}
$strip_class = implode( ' ', $border_classes );

if ( empty( $stats_list ) ) {
    return;
}
?>

<div class="<?php echo esc_attr( $strip_class ); ?>">
    <?php foreach ( $stats_list as $index => $item ) :
        $stat_number = ! empty( $item['stat_number'] ) ? $item['stat_number'] : '';
        $stat_suffix = ! empty( $item['stat_suffix'] ) ? $item['stat_suffix'] : '';
        $stat_label  = ! empty( $item['stat_label'] ) ? $item['stat_label'] : '';
    ?>
        <div class="shopnex-stat-item">
            <?php if ( $stat_number ) : ?>
                <div class="shopnex-stat-number">
                    <?php echo esc_html( $stat_number ); ?>
                    <?php if ( $stat_suffix ) : ?>
                        <span class="shopnex-stat-accent"><?php echo esc_html( $stat_suffix ); ?></span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if ( $stat_label ) : ?>
                <div class="shopnex-stat-label"><?php echo esc_html( $stat_label ); ?></div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<style>
.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    margin-bottom: 70px;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?>.has-border-top {
    border-top: 1px solid #F0EDE9;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?>.has-border-bottom {
    border-bottom: 1px solid #F0EDE9;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> .shopnex-stat-item {
    text-align: center;
    padding: 40px 20px;
    position: relative;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?>.has-dividers .shopnex-stat-item:not(:last-child)::after {
    content: '';
    position: absolute;
    right: 0;
    top: 20%;
    height: 60%;
    width: 1px;
    background: #F0EDE9;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> .shopnex-stat-number {
    font-family: 'Playfair Display', serif;
    font-size: clamp(32px, 4vw, 44px);
    font-weight: 500;
    color: #1C1C1C;
    letter-spacing: -0.02em;
    line-height: 1;
    margin-bottom: 8px;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> .shopnex-stat-number .shopnex-stat-accent {
    color: #B8977E;
}

.shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> .shopnex-stat-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #9C9792;
    font-weight: 500;
}

/* Responsive */
@media (max-width: 768px) {
    .shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> {
        grid-template-columns: repeat(2, 1fr);
    }

    .shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> .has-dividers .shopnex-stat-item:nth-child(2)::after {
        display: none;
    }
}

@media (max-width: 480px) {
    .shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?> {
        grid-template-columns: 1fr;
    }

    .shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?>.has-dividers .shopnex-stat-item:not(:last-child)::after {
        display: none;
    }

    .shopnex-stats-strip-<?php echo esc_attr( $widget_id ); ?>.has-dividers .shopnex-stat-item:not(:last-child) {
        border-bottom: 1px solid #F0EDE9;
    }
}
</style>
