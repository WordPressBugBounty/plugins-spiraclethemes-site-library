<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Our Story Section - Frontend Render (Shop Zen)
 *
 * Two-column layout: image on one side, heading + paragraphs + inline stats on the other.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings     = $this->get_settings_for_display();
$id           = $this->get_id();
$image        = $settings['image'] ?? [];
$image_position = $settings['image_position'] ?? 'left';
$heading      = $settings['heading'] ?? '';
$paragraphs   = $settings['paragraphs'] ?? [];
$show_stats   = $settings['show_stats'] ?? 'yes';
$story_stats  = $settings['story_stats'] ?? [];

$img_id  = $image['id'] ?? '';
$img_url = $image['url'] ?? '';
$img_alt = ! empty( $image['alt'] ) ? $image['alt'] : esc_attr__( 'Story image', 'spiraclethemes-site-library' );

$content_first = 'right' === $image_position;
?>
<section class="shopzen-story shopzen-story-<?php echo esc_attr( $id ); ?>" id="shopzen-story-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-story-wrap<?php echo $content_first ? ' content-first' : ''; ?>">

		<div class="shopzen-story-img">
			<?php if ( ! empty( $img_id ) ) :
				echo wp_get_attachment_image( absint( $img_id ), 'large', false, [ 'alt' => esc_attr( $img_alt ) ] );
			elseif ( ! empty( $img_url ) ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>" loading="lazy">
			<?php endif; ?>
		</div>

		<div class="shopzen-story-content">
			<?php if ( ! empty( $heading ) ) : ?>
				<h3 class="shopzen-story-heading"><?php echo esc_html( $heading ); ?></h3>
			<?php endif; ?>

			<?php foreach ( $paragraphs as $para ) :
				$text = $para['para_text'] ?? '';
				if ( ! empty( $text ) ) : ?>
					<p class="shopzen-story-para"><?php echo esc_html( $text ); ?></p>
				<?php endif;
			endforeach; ?>

			<?php if ( 'yes' === $show_stats && ! empty( $story_stats ) ) : ?>
				<div class="shopzen-story-stats">
					<?php foreach ( $story_stats as $stat ) :
						$value = $stat['stat_value'] ?? '';
						$label = $stat['stat_label'] ?? '';
						if ( empty( $value ) && empty( $label ) ) continue;
						?>
						<div class="shopzen-story-stat">
							<?php if ( ! empty( $value ) ) : ?>
								<strong><?php echo esc_html( $value ); ?></strong>
							<?php endif; ?>
							<?php if ( ! empty( $label ) ) : ?>
								<span><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</section>

<style>
	.shopzen-story-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> *,
	.shopzen-story-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-story-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap {
		max-width: 1240px;
		margin: 0 auto;
		padding: 0 16px;
		display: grid;
		grid-template-columns: 1.1fr 0.9fr;
		gap: 48px;
		align-items: center;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap.content-first {
		grid-template-columns: 0.9fr 1.1fr;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap.content-first .shopzen-story-img {
		order: 2;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap.content-first .shopzen-story-content {
		order: 1;
	}

	/* Image */
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-img {
		position: relative;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
		border: 1px solid #E5E7EB;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-img img {
		width: 100%;
		height: 520px;
		object-fit: cover;
		display: block;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-img::before {
		content: '';
		position: absolute;
		top: 12px;
		left: 12px;
		width: 32px;
		height: 32px;
		border-left: 3px solid #3A5F3F;
		border-top: 3px solid #3A5F3F;
		opacity: 0.2;
		border-radius: 4px 0 0 0;
		z-index: 2;
		pointer-events: none;
	}

	/* Content */
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-heading {
		font-family: Outfit, sans-serif;
		font-size: 28px;
		margin: 0 0 14px;
		line-height: 1.2em;
		color: #1A202C;
		letter-spacing: -0.02em;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-para {
		font-family: Inter, sans-serif;
		color: #4B5563;
		font-size: 15px;
		margin: 0 0 14px;
		line-height: 1.7em;
		font-weight: 500;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-para:last-of-type {
		margin-bottom: 0;
	}

	/* Stats */
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-stats {
		display: flex;
		gap: 24px;
		margin-top: 24px;
		padding-top: 20px;
		border-top: 1px solid #E5E7EB;
		flex-wrap: wrap;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-stat strong {
		display: block;
		font-family: Outfit, sans-serif;
		font-size: 24px;
		font-weight: 800;
		color: #1E3F2A;
		line-height: 1.2;
	}
	.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-stat span {
		font-family: Inter, sans-serif;
		font-size: 12px;
		color: #6B7280;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		font-weight: 600;
	}

	/* Responsive */
	@media (max-width: 1100px) {
		.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap,
		.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap.content-first {
			grid-template-columns: 1fr;
			gap: 32px;
		}
		.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap.content-first .shopzen-story-img,
		.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-wrap.content-first .shopzen-story-content { order: initial; }
		.shopzen-story-<?php echo esc_attr( $id ); ?> .shopzen-story-img img { height: 400px; }
	}
</style>
