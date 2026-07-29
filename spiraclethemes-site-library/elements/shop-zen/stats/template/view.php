<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Stats Section - Frontend Render (Shop Zen)
 *
 * Supports footer elements: avatars, star rating, icon badge, or none.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings     = $this->get_settings_for_display();
$id           = $this->get_id();
$stats        = $settings['stats'] ?? [];
$divider_show = $settings['divider_show'] ?? 'yes';

/**
 * Render 5 unicode stars based on a 0-5 rating.
 */
$shopzen_stat_stars = function ( $rating ) {
	$full  = (int) floor( $rating );
	$half  = ( $rating - $full ) >= 0.25 && ( $rating - $full ) < 0.75;
	if ( ( $rating - $full ) >= 0.75 ) {
		$full++;
		$half = false;
	}
	$empty = 5 - $full - ( $half ? 1 : 0 );
	return str_repeat( '★', $full ) . ( $half ? '⯨' : '' ) . str_repeat( '☆', max( 0, $empty ) );
};
?>
<section class="shopzen-stats shopzen-stats-<?php echo esc_attr( $id ); ?>" id="shopzen-stats-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-stats-wrap">
		<div class="shopzen-stats-inner">

			<?php foreach ( $stats as $item ) :
				$value       = $item['stat_value'] ?? '';
				$label       = $item['stat_label'] ?? '';
				$footer_type = $item['stat_footer_type'] ?? 'none';
				$avatars     = $item['stat_avatars'] ?? [];
				$avatar_count = $item['stat_avatar_count'] ?? 5;
				$stars_val   = $item['stat_stars'] ?? 5;
				$icon        = $item['stat_icon'] ?? [];
				?>

				<div class="shopzen-stat-item">
					<?php if ( ! empty( $value ) ) : ?>
						<div class="shopzen-stat-value"><?php echo esc_html( $value ); ?></div>
					<?php endif; ?>

					<?php if ( ! empty( $label ) ) : ?>
						<div class="shopzen-stat-label"><?php echo esc_html( $label ); ?></div>
					<?php endif; ?>

					<?php if ( 'avatars' === $footer_type ) : ?>
						<div class="shopzen-stat-avatars">
							<?php
							if ( ! empty( $avatars ) ) {
								foreach ( $avatars as $avatar ) :
									$avatar_id = absint( $avatar['id'] );
									?>
									<?php echo wp_get_attachment_image( $avatar_id, [ 32, 32 ], false, [ 'class' => 'shopzen-stat-avatar', 'alt' => esc_attr__( 'Customer avatar', 'spiraclethemes-site-library' ) ] ); ?>
								<?php endforeach;
							} else {
								for ( $i = 1; $i <= absint( $avatar_count ); $i++ ) : ?>
									<img class="shopzen-stat-avatar" src="<?php echo esc_url( 'https://i.pravatar.cc/32?img=' . $i ); ?>" alt="<?php esc_attr_e( 'Customer avatar', 'spiraclethemes-site-library' ); ?>" loading="lazy">
								<?php endfor;
							}
							?>
						</div>

					<?php elseif ( 'stars' === $footer_type ) : ?>
						<div class="shopzen-stat-stars"><?php echo esc_html( $shopzen_stat_stars( (float) $stars_val ) ); ?></div>

					<?php elseif ( 'icon' === $footer_type && ! empty( $icon['value'] ) ) : ?>
						<div class="shopzen-stat-badge">
							<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
						</div>
					<?php endif; ?>
				</div>

			<?php endforeach; ?>

		</div>
	</div>
</section>

<style>
	.shopzen-stats-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
		background: #F0F7F2;
		padding: 32px 0;
		border-top: 1px solid #D1E7D6;
		border-bottom: 1px solid #D1E7D6;
	}
	.shopzen-stats-<?php echo esc_attr( $id ); ?> *,
	.shopzen-stats-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-stats-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stats-wrap {
		max-width: 1240px;
		margin: 0 auto;
		padding: 0 16px;
	}

	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stats-inner {
		display: grid;
		grid-template-columns: repeat(4, minmax(0, 1fr));
		gap: 0;
	}

	/* Stat item */
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item {
		text-align: center;
		padding: 0 20px;
	}
	<?php if ( 'yes' === $divider_show ) : ?>
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item {
		border-right: 1px solid #D1E7D6;
	}
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item:last-child {
		border-right: none;
	}
	<?php endif; ?>

	/* Value */
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-value {
		font-family: Outfit, sans-serif;
		font-size: 32px;
		font-weight: 700;
		color: #1F2937;
		line-height: 1;
	}

	/* Label */
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-label {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 500;
		color: #6B7280;
		margin: 4px 0 12px;
	}

	/* Avatars */
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-avatars {
		display: flex;
		justify-content: center;
	}
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-avatar {
		width: 28px;
		height: 28px;
		border-radius: 50%;
		border: 2px solid #fff;
		margin-left: -8px;
		object-fit: cover;
		display: block;
		box-sizing: border-box;
	}
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-avatar:first-child {
		margin-left: 0;
	}

	/* Stars */
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-stars {
		color: #F59E0B;
		font-size: 16px;
		letter-spacing: 1px;
	}

	/* Icon badge */
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-badge {
		width: 36px;
		height: 36px;
		background: #3A5F3F;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 auto;
		color: #fff;
		font-size: 15px;
	}
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-badge i,
	.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-badge svg {
		width: 16px;
		height: 16px;
	}

	/* Responsive */
	@media (max-width: 1100px) {
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stats-inner {
			grid-template-columns: repeat(2, minmax(0, 1fr));
			row-gap: 28px;
		}
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item {
			border-right: none;
			padding: 16px 20px;
		}
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item:nth-child(1),
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item:nth-child(3) {
			border-right: 1px solid #D1E7D6;
		}
	}
	@media (max-width: 768px) {
		.shopzen-stats-<?php echo esc_attr( $id ); ?> {
			padding: 24px 0;
		}
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stats-inner {
			grid-template-columns: 1fr;
		}
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item {
			border-right: none !important;
			border-bottom: 1px solid #D1E7D6;
			padding: 20px 16px !important;
		}
		.shopzen-stats-<?php echo esc_attr( $id ); ?> .shopzen-stat-item:last-child {
			border-bottom: none;
		}
	}
</style>
