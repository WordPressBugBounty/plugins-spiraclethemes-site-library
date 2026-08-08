<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Our Story Widget
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id = ! empty( $widget_id ) ? $widget_id : '';
$settings  = ! empty( $settings ) ? $settings : array();

// Content variables
$tag_text           = ! empty( $settings['tag_text'] ) ? $settings['tag_text'] : '';
$show_tag           = ! empty( $settings['show_tag'] ) && 'yes' === $settings['show_tag'];
$title              = ! empty( $settings['title'] ) ? $settings['title'] : '';
$title_tag          = ! empty( $settings['title_tag'] ) ? $settings['title_tag'] : 'h2';
$description_1      = ! empty( $settings['description_1'] ) ? $settings['description_1'] : '';
$description_2      = ! empty( $settings['description_2'] ) ? $settings['description_2'] : '';
$description_3      = ! empty( $settings['description_3'] ) ? $settings['description_3'] : '';

// Blockquote
$show_blockquote    = ! empty( $settings['show_blockquote'] ) && 'yes' === $settings['show_blockquote'];
$blockquote_text    = ! empty( $settings['blockquote_text'] ) ? $settings['blockquote_text'] : '';
$blockquote_cite    = ! empty( $settings['blockquote_citation'] ) ? $settings['blockquote_citation'] : '';

// Image
$story_image_url    = ! empty( $settings['story_image']['url'] ) ? esc_url( $settings['story_image']['url'] ) : '';
$enable_zoom        = ! empty( $settings['enable_image_zoom'] ) && 'yes' === $settings['enable_image_zoom'];
$image_aspect       = ! empty( $settings['image_aspect_ratio'] ) ? $settings['image_aspect_ratio'] : '4-5';

// Validate title tag
$allowed_tags       = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p' );
$title_tag          = in_array( $title_tag, $allowed_tags, true ) ? $title_tag : 'h2';

// Map aspect ratio to CSS value
$aspect_ratio_map = array(
    '4-5'  => '4 / 5',
    '1-1'  => '1 / 1',
    '3-4'  => '3 / 4',
    '3-2'  => '3 / 2',
    '16-9' => '16 / 9',
);
$aspect_css = isset( $aspect_ratio_map[ $image_aspect ] ) ? $aspect_ratio_map[ $image_aspect ] : '4 / 5';
?>

<div class="shopnex-our-story shopnex-our-story-<?php echo esc_attr( $widget_id ); ?>">
    <?php if ( $story_image_url ) : ?>
        <div class="shopnex-our-story-image">
            <img src="<?php echo esc_url( $story_image_url ); ?>" 
                 alt="<?php echo esc_attr( $title ); ?>"
                 loading="lazy">
        </div>
    <?php endif; ?>

    <div class="shopnex-our-story-content">
        <?php if ( $show_tag && $tag_text ) : ?>
            <span class="shopnex-our-story-tag"><?php echo esc_html( $tag_text ); ?></span>
        <?php endif; ?>

        <?php if ( $title ) : ?>
            <<?php echo esc_attr( $title_tag ); ?> class="shopnex-our-story-title">
                <?php echo esc_html( $title ); ?>
            </<?php echo esc_attr( $title_tag ); ?>>
        <?php endif; ?>

        <?php if ( $description_1 ) : ?>
            <p><?php echo wp_kses_post( nl2br( $description_1 ) ); ?></p>
        <?php endif; ?>

        <?php if ( $description_2 ) : ?>
            <p><?php echo wp_kses_post( nl2br( $description_2 ) ); ?></p>
        <?php endif; ?>

        <?php if ( $show_blockquote && $blockquote_text ) : ?>
            <blockquote class="shopnex-our-story-blockquote">
                <?php echo wp_kses_post( nl2br( $blockquote_text ) ); ?>
                <?php if ( $blockquote_cite ) : ?>
                    <cite><?php echo esc_html( $blockquote_cite ); ?></cite>
                <?php endif; ?>
            </blockquote>
        <?php endif; ?>

        <?php if ( $description_3 ) : ?>
            <p><?php echo wp_kses_post( nl2br( $description_3 ) ); ?></p>
        <?php endif; ?>
    </div>
</div>

<style>
.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 56px;
    align-items: center;
    margin-bottom: 70px;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-image {
    aspect-ratio: <?php echo esc_attr( $aspect_css ); ?>;
    border-radius: 16px;
    overflow: hidden;
    background: #F3EFEA;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    display: block;
}

<?php if ( $enable_zoom ) : ?>
.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-image:hover img {
    transform: scale(1.04);
}
<?php endif; ?>

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-content {
    padding: 20px 0;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-tag {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: #B8977E;
    font-weight: 600;
    margin-bottom: 12px;
    display: block;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(26px, 3.5vw, 36px);
    font-weight: 500;
    letter-spacing: -0.015em;
    margin-bottom: 20px;
    line-height: 1.2;
    color: #1C1C1C;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-content p {
    font-size: 15px;
    color: #6B6560;
    line-height: 1.75;
    margin-bottom: 18px;
    max-width: 480px;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-blockquote {
    border-left: 3px solid #B8977E;
    padding: 14px 24px;
    margin: 28px 0;
    font-style: italic;
    font-family: 'Playfair Display', serif;
    font-size: 19px;
    color: #1C1C1C;
    background: #F3EFEA;
    border-radius: 0 6px 6px 0;
    line-height: 1.5;
}

.shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-blockquote cite {
    display: block;
    font-size: 13px;
    font-style: normal;
    font-family: 'Inter', sans-serif;
    color: #9C9792;
    margin-top: 8px;
    letter-spacing: 0.02em;
}

/* Responsive */
@media (max-width: 1024px) {
    .shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> {
        gap: 40px;
    }
}

@media (max-width: 768px) {
    .shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-image {
        aspect-ratio: 3 / 2;
    }

    .shopnex-our-story-<?php echo esc_attr( $widget_id ); ?> .shopnex-our-story-content {
        padding: 0;
    }
}
</style>
