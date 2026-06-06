<?php
/**
 * Editorial Widget Frontend Render
 *
 * @package Spiracle Themes Site Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$settings = $this->get_settings_for_display();

// Layout classes
$image_position = $settings['layout_position'];
$reverse_class  = ( 'right' === $image_position ) ? ' shopnex-editorial-reversed' : '';

// Image
$image_id   = $settings['editorial_image']['id'];
$image_url  = $settings['editorial_image']['url'];
$image_alt  = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
if ( empty( $image_alt ) ) {
    $image_alt = esc_attr__( 'Editorial image', 'spiraclethemes-site-library' );
}

// Aspect ratio
$aspect_ratio = $settings['image_aspect_ratio'];
$aspect_style = '';
if ( 'auto' !== $aspect_ratio ) {
    $aspect_style = 'aspect-ratio: ' . esc_attr( $aspect_ratio ) . ';';
}

// Image link
$image_link_url    = ! empty( $settings['image_link']['url'] ) ? $settings['image_link']['url'] : '';
$image_link_target = ! empty( $settings['image_link']['is_external'] ) ? '_blank' : '';
$image_link_rel    = ! empty( $settings['image_link']['nofollow'] ) ? 'nofollow' : '';

// Button
$button_url    = ! empty( $settings['button_link']['url'] ) ? $settings['button_link']['url'] : '#';
$button_target = ! empty( $settings['button_link']['is_external'] ) ? '_blank' : '';
$button_rel    = ! empty( $settings['button_link']['nofollow'] ) ? 'nofollow' : '';

// Unique ID for this widget instance
$widget_id = 'shopnex-editorial-' . $this->get_id();

?>

<style>
    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-reversed .shopnex-editorial-grid {
        direction: rtl;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-reversed .shopnex-editorial-content {
        direction: ltr;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-image {
        overflow: hidden;
        background-color: #F3EFEA;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-image:hover img {
        transform: scale(1.04);
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-tag {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-title {
        font-family: 'Playfair Display', serif;
        font-weight: 500;
        letter-spacing: -0.015em;
        line-height: 1.2;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-description {
        line-height: 1.7;
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-btn {
        display: inline-block;
        font-family: 'Inter', sans-serif;
        font-weight: 500;
        letter-spacing: 0.04em;
        text-decoration: none;
        cursor: pointer;
        border: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-grid {
            grid-template-columns: 1fr;
        }

        <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-reversed .shopnex-editorial-grid {
            direction: ltr;
        }

        <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-reversed .shopnex-editorial-content {
            direction: ltr;
        }

        <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-image {
            aspect-ratio: 3 / 2 !important;
        }
    }

    @media (max-width: 768px) {
        <?php echo esc_attr( '.' . $widget_id ); ?> .shopnex-editorial-grid {
            gap: 20px !important;
        }
    }
</style>

<section class="shopnex-editorial-section <?php echo esc_attr( $widget_id ); ?>">
    <div class="shopnex-editorial-grid-wrap<?php echo esc_attr( $reverse_class ); ?>">
        <div class="shopnex-editorial-grid">

            <!-- Image Column -->
            <div class="shopnex-editorial-image-col">
                <div class="shopnex-editorial-image" style="<?php echo esc_attr( $aspect_style ); ?>">
                    <?php if ( ! empty( $image_link_url ) ) : ?>
                        <a href="<?php echo esc_url( $image_link_url ); ?>"
                           <?php if ( $image_link_target ) : ?>target="<?php echo esc_attr( $image_link_target ); ?>"<?php endif; ?>
                           <?php if ( $image_link_rel ) : ?>rel="<?php echo esc_attr( $image_link_rel ); ?>"<?php endif; ?>
                           aria-label="<?php echo esc_attr( $image_alt ); ?>">
                    <?php endif; ?>

                    <?php
                    if ( $image_id ) {
                        echo wp_get_attachment_image( $image_id, 'large', false, array(
                            'alt'    => esc_attr( $image_alt ),
                            'loading' => 'lazy',
                        ) );
                    } else {
                        ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
                        <?php
                    }
                    ?>

                    <?php if ( ! empty( $image_link_url ) ) : ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content Column -->
            <div class="shopnex-editorial-content">
                <?php if ( 'yes' === $settings['show_tag'] && ! empty( $settings['tag_text'] ) ) : ?>
                    <span class="shopnex-editorial-tag"><?php echo esc_html( $settings['tag_text'] ); ?></span>
                <?php endif; ?>

                <?php
                $title_tag = ! empty( $settings['title_size'] ) ? $settings['title_size'] : 'h2';
                if ( ! empty( $settings['title_text'] ) ) : ?>
                    <<?php echo esc_html( $title_tag ); ?> class="shopnex-editorial-title">
                        <?php echo wp_kses_post( nl2br( $settings['title_text'] ) ); ?>
                    </<?php echo esc_html( $title_tag ); ?>>
                <?php endif; ?>

                <?php if ( ! empty( $settings['description_text'] ) ) : ?>
                    <p class="shopnex-editorial-description"><?php echo wp_kses_post( $settings['description_text'] ); ?></p>
                <?php endif; ?>

                <?php if ( 'yes' === $settings['show_button'] && ! empty( $settings['button_text'] ) ) : ?>
                    <a href="<?php echo esc_url( $button_url ); ?>"
                       class="shopnex-editorial-btn"
                       <?php if ( $button_target ) : ?>target="<?php echo esc_attr( $button_target ); ?>"<?php endif; ?>
                       <?php if ( $button_rel ) : ?>rel="<?php echo esc_attr( $button_rel ); ?>"<?php endif; ?>>
                        <?php echo esc_html( $settings['button_text'] ); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
