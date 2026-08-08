<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Values Widget
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Content variables
$values_list    = ! empty( $settings['values_list'] ) ? $settings['values_list'] : array();
$show_header    = ! empty( $settings['show_header'] ) && 'yes' === $settings['show_header'];
$section_tag    = ! empty( $settings['section_tag'] ) ? $settings['section_tag'] : '';
$section_title  = ! empty( $settings['section_title'] ) ? $settings['section_title'] : '';
$section_subtitle = ! empty( $settings['section_subtitle'] ) ? $settings['section_subtitle'] : '';

// Hover effect variables
$card_hover_shadow = ! empty( $settings['card_hover_shadow'] ) && 'yes' === $settings['card_hover_shadow'];
$card_hover_lift   = ! empty( $settings['card_hover_lift'] ) && 'yes' === $settings['card_hover_lift'];

if ( empty( $values_list ) ) {
    return;
}
?>

<div class="shopnex-values-section shopnex-values-<?php echo esc_attr( $widget_id ); ?>">
    <?php if ( $show_header ) : ?>
        <div class="shopnex-values-header">
            <?php if ( $section_tag ) : ?>
                <span class="shopnex-values-tag"><?php echo esc_html( $section_tag ); ?></span>
            <?php endif; ?>
            <?php if ( $section_title ) : ?>
                <h2 class="shopnex-values-title"><?php echo esc_html( $section_title ); ?></h2>
            <?php endif; ?>
            <?php if ( $section_subtitle ) : ?>
                <p class="shopnex-values-subtitle"><?php echo esc_html( $section_subtitle ); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="shopnex-values-grid">
        <?php foreach ( $values_list as $index => $item ) :
            $icon        = ! empty( $item['value_icon'] ) ? $item['value_icon'] : '';
            $icon_type   = ! empty( $item['value_icon_type'] ) ? $item['value_icon_type'] : 'emoji';
            $title       = ! empty( $item['value_title'] ) ? $item['value_title'] : '';
            $description = ! empty( $item['value_description'] ) ? $item['value_description'] : '';
        ?>
            <div class="shopnex-value-card">
                <?php if ( $icon ) : ?>
                    <div class="shopnex-value-icon">
                        <?php if ( 'class' === $icon_type ) : ?>
                            <i class="<?php echo esc_attr( $icon ); ?>"></i>
                        <?php else : ?>
                            <?php echo esc_html( $icon ); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if ( $title ) : ?>
                    <h4 class="shopnex-value-card-title"><?php echo esc_html( $title ); ?></h4>
                <?php endif; ?>
                <?php if ( $description ) : ?>
                    <p class="shopnex-value-card-desc"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.shopnex-values-<?php echo esc_attr( $widget_id ); ?> {
    margin-bottom: 70px;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-header {
    text-align: center;
    margin-bottom: 50px;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-tag {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #B8977E;
    font-weight: 600;
    margin-bottom: 12px;
    display: block;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3.5vw, 40px);
    font-weight: 500;
    letter-spacing: -0.015em;
    color: #1C1C1C;
    margin-bottom: 12px;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-subtitle {
    font-size: 15px;
    color: #6B6560;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.5;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-value-card {
    background: #FFFFFF;
    border-radius: 10px;
    padding: 32px 28px;
    border: 1px solid #F0EDE9;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

<?php if ( $card_hover_shadow ) : ?>
.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-value-card:hover {
    box-shadow: 0 4px 20px rgba(28,28,28,0.06);
}
<?php endif; ?>

<?php if ( $card_hover_lift ) : ?>
.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-value-card:hover {
    transform: translateY(-4px);
}
<?php endif; ?>

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-value-icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: #F3EFEA;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    font-size: 24px;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-value-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: -0.01em;
    margin-bottom: 8px;
    color: #1C1C1C;
}

.shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-value-card-desc {
    font-size: 14px;
    color: #6B6560;
    line-height: 1.6;
}

/* Responsive */
@media (max-width: 1024px) {
    .shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .shopnex-values-<?php echo esc_attr( $widget_id ); ?> .shopnex-values-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
}
</style>
