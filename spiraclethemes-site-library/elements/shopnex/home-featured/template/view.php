<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Home Featured Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings();
$id = $this->get_id();

// Settings
$hero_tag            = $settings['hero_tag'] ?? '';
$hero_title          = $settings['hero_title'] ?? '';
$hero_description    = $settings['hero_description'] ?? '';
$primary_btn_text    = $settings['primary_btn_text'] ?? '';
$primary_btn_url     = $settings['primary_btn_url'] ?? [];
$secondary_btn_text  = $settings['secondary_btn_text'] ?? '';
$secondary_btn_url   = $settings['secondary_btn_url'] ?? [];
$show_scroll         = $settings['show_scroll_indicator'] ?? 'yes';
$hero_image          = $settings['hero_image'] ?? [];

// Build button URLs
$primary_link    = ! empty( $primary_btn_url['url'] ) ? esc_url( $primary_btn_url['url'] ) : '#';
$primary_target  = ! empty( $primary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$primary_nofollow = ! empty( $primary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

$secondary_link    = ! empty( $secondary_btn_url['url'] ) ? esc_url( $secondary_btn_url['url'] ) : '#';
$secondary_target  = ! empty( $secondary_btn_url['is_external'] ) ? ' target="_blank"' : '';
$secondary_nofollow = ! empty( $secondary_btn_url['nofollow'] ) ? ' rel="nofollow"' : '';

// Image URL
$image_url = '';
if ( ! empty( $hero_image['id'] ) ) {
    $image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $hero_image['id'], 'hero_image_size', $settings );
} elseif ( ! empty( $hero_image['url'] ) ) {
    $image_url = esc_url( $hero_image['url'] );
}
?>

<div class="shopnex-hero-section shopnex-hero-section-<?php echo esc_attr( $id ); ?>">
    <div class="shopnex-hero">
        <?php if ( ! empty( $image_url ) ) : ?>
            <img
                class="shopnex-hero-image"
                src="<?php echo esc_url( $image_url ); ?>"
                alt="<?php echo esc_attr( $hero_title ); ?>"
                loading="eager"
            >
        <?php endif; ?>
        <div class="shopnex-hero-overlay"></div>
        <div class="shopnex-hero-content">
            <?php if ( ! empty( $hero_tag ) ) : ?>
                <span class="shopnex-hero-tag"><?php echo esc_html( $hero_tag ); ?></span>
            <?php endif; ?>

            <?php if ( ! empty( $hero_title ) ) : ?>
                <h1 class="shopnex-hero-title"><?php echo wp_kses_post( nl2br( esc_html( $hero_title ) ) ); ?></h1>
            <?php endif; ?>

            <?php if ( ! empty( $hero_description ) ) : ?>
                <p class="shopnex-hero-desc"><?php echo esc_html( $hero_description ); ?></p>
            <?php endif; ?>

            <div class="shopnex-hero-buttons">
                <?php if ( ! empty( $primary_btn_text ) ) : ?>
                    <a href="<?php echo esc_url( $primary_link ); ?>" class="shopnex-btn shopnex-btn-primary"<?php echo esc_attr( $primary_target . $primary_nofollow ); ?>>
                        <?php echo esc_html( $primary_btn_text ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( ! empty( $secondary_btn_text ) ) : ?>
                    <a href="<?php echo esc_url( $secondary_link ); ?>" class="shopnex-btn shopnex-btn-outline"<?php echo esc_attr( $secondary_target . $secondary_nofollow ); ?>>
                        <?php echo esc_html( $secondary_btn_text ); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if ( 'yes' === $show_scroll ) : ?>
            <div class="shopnex-scroll-indicator">
                <span><?php esc_html_e( 'Scroll', 'spiraclethemes-site-library' ); ?></span>
                <div class="shopnex-scroll-line"></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .shopnex-hero-section .shopnex-hero {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        min-height: 580px;
        display: flex;
        align-items: center;
        background: #F3EFEA;
        margin-bottom: 60px;
    }
    .shopnex-hero-section .shopnex-hero-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 1.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .shopnex-hero-section .shopnex-hero:hover .shopnex-hero-image {
        transform: scale(1.03);
    }
    .shopnex-hero-section .shopnex-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg,
            rgba(28, 28, 28, 0.45) 0%,
            rgba(28, 28, 28, 0.15) 40%,
            rgba(28, 28, 28, 0) 65%,
            rgba(28, 28, 28, 0.08) 100%);
        z-index: 1;
    }
    .shopnex-hero-section .shopnex-hero-content {
        position: relative;
        z-index: 2;
        padding: 60px;
        max-width: 560px;
    }
    .shopnex-hero-section .shopnex-hero-tag {
        display: inline-block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #fff;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.35);
        padding: 8px 16px;
        border-radius: 50px;
        margin-bottom: 24px;
        font-weight: 500;
        backdrop-filter: blur(4px);
    }
    .shopnex-hero-section .shopnex-hero-title {
        font-size: clamp(36px, 5vw, 56px);
        font-weight: 500;
        color: #fff;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 20px;
    }
    .shopnex-hero-section .shopnex-hero-desc {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.6;
        margin-bottom: 32px;
        font-weight: 350;
        max-width: 400px;
    }
    .shopnex-hero-section .shopnex-hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }
    .shopnex-hero-section .shopnex-btn {
        display: inline-block;
        padding: 14px 32px;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 0.03em;
        text-decoration: none;
        border-radius: 50px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        border: none;
        text-align: center;
    }
    .shopnex-hero-section .shopnex-btn-primary {
        background: #fff;
        color: #1C1C1C;
    }
    .shopnex-hero-section .shopnex-btn-primary:hover {
        background: #F0ECE6;
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
    }
    .shopnex-hero-section .shopnex-btn-outline {
        background: transparent;
        color: #fff;
        border: 1.5px solid rgba(255, 255, 255, 0.5);
    }
    .shopnex-hero-section .shopnex-btn-outline:hover {
        background: rgba(255, 255, 255, 0.12);
        border-color: #fff;
    }
    .shopnex-hero-section .shopnex-scroll-indicator {
        position: absolute;
        bottom: 32px;
        right: 60px;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        opacity: 0.7;
        animation: shopnex-float 3s ease-in-out infinite;
    }
    .shopnex-hero-section .shopnex-scroll-indicator span {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #fff;
        font-weight: 500;
    }
    .shopnex-hero-section .shopnex-scroll-line {
        width: 1px;
        height: 40px;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 1px;
        animation: shopnex-scroll-line-pulse 3s ease-in-out infinite;
    }
    @keyframes shopnex-float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(8px); }
    }
    @keyframes shopnex-scroll-line-pulse {
        0%, 100% { height: 40px; opacity: 0.5; }
        50% { height: 55px; opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .shopnex-hero-section .shopnex-hero-content {
            padding: 40px;
            max-width: 480px;
        }
    }
    @media (max-width: 768px) {
        .shopnex-hero-section .shopnex-hero {
            min-height: 440px;
            margin-bottom: 40px;
            border-radius: 10px;
        }
        .shopnex-hero-section .shopnex-hero-content {
            padding: 28px;
            max-width: 100%;
        }
        .shopnex-hero-section .shopnex-hero-title {
            font-size: 32px;
        }
        .shopnex-hero-section .shopnex-hero-desc {
            font-size: 14px;
        }
        .shopnex-hero-section .shopnex-scroll-indicator {
            display: none;
        }
        .shopnex-hero-section .shopnex-btn-outline {
            display: none;
        }
    }
    @media (max-width: 480px) {
        .shopnex-hero-section .shopnex-hero {
            min-height: 380px;
        }
        .shopnex-hero-section .shopnex-hero-content {
            padding: 20px;
        }
        .shopnex-hero-section .shopnex-hero-title {
            font-size: 28px;
        }
    }
</style>
