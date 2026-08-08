<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Map Section Widget
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Map settings
$map_type         = ! empty( $settings['map_type'] ) ? $settings['map_type'] : 'placeholder';
$placeholder_text = ! empty( $settings['placeholder_text'] ) ? $settings['placeholder_text'] : '';

// Embed URL
$map_embed_url = '';
if ( ! empty( $settings['map_embed_url']['url'] ) ) {
    $raw_url = $settings['map_embed_url']['url'];

    // Check if the user pasted a full <iframe> embed code instead of just the URL
    if ( preg_match( '/<iframe[^>]+src=["\']([^"\']+)["\']/i', $raw_url, $matches ) ) {
        $map_embed_url = esc_url( $matches[1] );
    } else {
        $map_embed_url = esc_url( $raw_url );
    }
}

// Overlay card settings
$show_overlay_card     = ! empty( $settings['show_overlay_card'] ) && 'yes' === $settings['show_overlay_card'];
$card_title            = ! empty( $settings['card_title'] ) ? $settings['card_title'] : '';
$card_address          = ! empty( $settings['card_address'] ) ? $settings['card_address'] : '';
$directions_text       = ! empty( $settings['directions_text'] ) ? $settings['directions_text'] : '';
$show_directions_arrow = ! empty( $settings['show_directions_arrow'] ) && 'yes' === $settings['show_directions_arrow'];

// Directions URL
$directions_url    = '#';
$directions_target = '_self';
if ( ! empty( $settings['directions_url']['url'] ) ) {
    $directions_url    = esc_url( $settings['directions_url']['url'] );
    $directions_target = ! empty( $settings['directions_url']['is_external'] ) ? '_blank' : '_self';
}
?>

<div class="shopnex-map-wrapper shopnex-map-<?php echo esc_attr( $widget_id ); ?>">
    <div class="shopnex-map-section">

        <?php if ( 'embed' === $map_type && $map_embed_url ) : ?>
            <!-- Google Maps Embed -->
            <iframe
                src="<?php echo esc_url( $map_embed_url ); ?>"
                width="100%"
                height="100%"
                style="border:0; display:block;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="<?php esc_attr_e( 'Location Map', 'spiraclethemes-site-library' ); ?>"
            ></iframe>
        <?php else : ?>
            <!-- Map Placeholder -->
            <div class="shopnex-map-placeholder">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                <?php if ( $placeholder_text ) : ?>
                    <span><?php echo esc_html( $placeholder_text ); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( $show_overlay_card ) : ?>
            <!-- Overlay Card -->
            <div class="shopnex-map-overlay-card">
                <?php if ( $card_title ) : ?>
                    <h4><?php echo esc_html( $card_title ); ?></h4>
                <?php endif; ?>

                <?php if ( $card_address ) : ?>
                    <p><?php echo nl2br( esc_html( $card_address ) ); ?></p>
                <?php endif; ?>

                <?php if ( $directions_text ) : ?>
                    <a href="<?php echo esc_url( $directions_url ); ?>" class="shopnex-map-directions-link"<?php echo '_blank' === $directions_target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                        <?php echo esc_html( $directions_text ); ?>
                        <?php if ( $show_directions_arrow ) : ?>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<style>
.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-section {
    border-radius: 16px;
    overflow: hidden;
    background-color: #F3EFEA;
    position: relative;
    height: 400px;
    margin-bottom: 70px;
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-section iframe {
    width: 100%;
    height: 100%;
    display: block;
    border: 0;
}

/* Placeholder */
.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #9C9792;
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-placeholder svg {
    opacity: 0.4;
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-placeholder span {
    font-size: 13px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

/* Overlay Card */
.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-overlay-card {
    position: absolute;
    bottom: 28px;
    left: 28px;
    background-color: #FFFFFF;
    border-radius: 10px;
    padding: 20px 24px;
    box-shadow: 0 12px 40px rgba(28, 28, 28, 0.08);
    max-width: 320px;
    z-index: 2;
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-overlay-card h4 {
    font-family: 'Playfair Display', serif;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 4px;
    color: #1C1C1C;
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-overlay-card p {
    font-size: 13px;
    color: #6B6560;
    line-height: 1.5;
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-directions-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    color: #1C1C1C;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-top: 10px;
    transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-directions-link:hover {
    color: #B8977E;
}

/* Responsive */
@media (max-width: 768px) {
    .shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-section {
        height: 300px;
    }

    .shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-overlay-card {
        left: 16px;
        right: 16px;
        bottom: 16px;
        max-width: none;
    }
}

@media (max-width: 480px) {
    .shopnex-map-<?php echo esc_attr( $widget_id ); ?> .shopnex-map-section {
        height: 260px;
        border-radius: 10px;
    }
}
</style>
