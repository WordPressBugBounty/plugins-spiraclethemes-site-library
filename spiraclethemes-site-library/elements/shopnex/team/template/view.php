<?php
/**
 * Team Widget View for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Content variables
$team_list       = ! empty( $settings['team_list'] ) ? $settings['team_list'] : array();
$show_header     = ! empty( $settings['show_header'] ) && 'yes' === $settings['show_header'];
$section_tag     = ! empty( $settings['section_tag'] ) ? $settings['section_tag'] : '';
$section_title   = ! empty( $settings['section_title'] ) ? $settings['section_title'] : '';
$section_subtitle = ! empty( $settings['section_subtitle'] ) ? $settings['section_subtitle'] : '';

// Hover effect variables
$card_hover_lift  = ! empty( $settings['card_hover_lift'] ) && 'yes' === $settings['card_hover_lift'];
$avatar_grayscale = ! empty( $settings['avatar_grayscale'] ) && 'yes' === $settings['avatar_grayscale'];
$avatar_hover_zoom = ! empty( $settings['avatar_hover_zoom'] ) && 'yes' === $settings['avatar_hover_zoom'];

if ( empty( $team_list ) ) {
    return;
}
?>

<div class="shopnex-team-section shopnex-team-<?php echo esc_attr( $widget_id ); ?>">
    <?php if ( $show_header ) : ?>
        <div class="shopnex-team-header">
            <?php if ( $section_tag ) : ?>
                <span class="shopnex-team-tag"><?php echo esc_html( $section_tag ); ?></span>
            <?php endif; ?>
            <?php if ( $section_title ) : ?>
                <h2 class="shopnex-team-title"><?php echo esc_html( $section_title ); ?></h2>
            <?php endif; ?>
            <?php if ( $section_subtitle ) : ?>
                <p class="shopnex-team-subtitle"><?php echo esc_html( $section_subtitle ); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="shopnex-team-grid">
        <?php foreach ( $team_list as $index => $item ) :
            $name  = ! empty( $item['member_name'] ) ? $item['member_name'] : '';
            $role  = ! empty( $item['member_role'] ) ? $item['member_role'] : '';
            $image = ! empty( $item['member_image']['url'] ) ? $item['member_image']['url'] : '';
            $alt   = $name ? esc_attr( $name ) : esc_attr__( 'Team member', 'spiraclethemes-site-library' );
        ?>
            <div class="shopnex-team-card">
                <?php if ( $image ) : ?>
                    <div class="shopnex-team-avatar">
                        <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
                    </div>
                <?php endif; ?>
                <?php if ( $name ) : ?>
                    <h4 class="shopnex-team-name"><?php echo esc_html( $name ); ?></h4>
                <?php endif; ?>
                <?php if ( $role ) : ?>
                    <span class="shopnex-team-role"><?php echo esc_html( $role ); ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.shopnex-team-<?php echo esc_attr( $widget_id ); ?> {
    margin-bottom: 70px;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-header {
    text-align: center;
    margin-bottom: 50px;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-tag {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #B8977E;
    font-weight: 600;
    margin-bottom: 12px;
    display: block;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(28px, 3.5vw, 40px);
    font-weight: 500;
    letter-spacing: -0.015em;
    color: #1C1C1C;
    margin-bottom: 12px;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-subtitle {
    font-size: 15px;
    color: #6B6560;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.5;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 28px;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-card {
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

<?php if ( $card_hover_lift ) : ?>
.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-card:hover {
    transform: translateY(-4px);
}
<?php endif; ?>

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-avatar {
    width: 100%;
    aspect-ratio: 1;
    border-radius: 10px;
    overflow: hidden;
    background: #F3EFEA;
    margin-bottom: 16px;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1),
                filter 0.4s cubic-bezier(0.4, 0, 0.2, 1);
<?php if ( $avatar_grayscale ) : ?>
    filter: grayscale(20%);
<?php endif; ?>
}

<?php if ( $avatar_hover_zoom ) : ?>
.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-card:hover .shopnex-team-avatar img {
    transform: scale(1.05);
}
<?php endif; ?>

<?php if ( $avatar_grayscale ) : ?>
.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-card:hover .shopnex-team-avatar img {
    filter: grayscale(0%);
}
<?php endif; ?>

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-name {
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    font-weight: 500;
    letter-spacing: -0.01em;
    margin-bottom: 2px;
    color: #1C1C1C;
}

.shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-role {
    font-size: 12px;
    color: #9C9792;
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

/* Responsive */
@media (max-width: 1024px) {
    .shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

@media (max-width: 480px) {
    .shopnex-team-<?php echo esc_attr( $widget_id ); ?> .shopnex-team-grid {
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
}
</style>
