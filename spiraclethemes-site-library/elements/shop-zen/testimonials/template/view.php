<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Testimonials Section
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings       = $this->get_settings_for_display();
$id             = $this->get_id();
$heading_before = $settings['heading_before'] ?? '';
$heading_highlight = $settings['heading_highlight'] ?? '';
$subtext        = $settings['subtext'] ?? '';
$view_all_text  = $settings['view_all_text'] ?? '';
$view_all_link  = $settings['view_all_link'] ?? [];
$hide_view_all  = $settings['hide_view_all'] ?? '';
$testimonials   = $settings['testimonials'] ?? [];

$view_all_href       = ! empty( $view_all_link['url'] ) ? $view_all_link['url'] : '';
$view_all_target     = ! empty( $view_all_link['is_external'] ) ? ' target="_blank"' : '';
$view_all_nofollow   = ! empty( $view_all_link['nofollow'] ) ? ' rel="nofollow"' : '';
$view_all_attr_str   = trim( $view_all_target . ' ' . $view_all_nofollow );

/**
 * Render stars.
 */
$shopzen_testi_stars = function ( $rating ) {
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
<section class="shopzen-testi shopzen-testi-<?php echo esc_attr( $id ); ?>" id="shopzen-testi-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-testi-wrap">

		<div class="shopzen-testi-left">
			<?php if ( ! empty( $heading_before ) || ! empty( $heading_highlight ) ) : ?>
				<h2 class="shopzen-testi-title">
					<?php if ( ! empty( $heading_before ) ) : ?>
						<?php echo esc_html( $heading_before ); ?>
					<?php endif; ?>
					<?php if ( ! empty( $heading_highlight ) ) : ?>
						<span class="shopzen-testi-green"><?php echo esc_html( $heading_highlight ); ?></span>
					<?php endif; ?>
				</h2>
			<?php endif; ?>

			<?php if ( ! empty( $subtext ) ) : ?>
				<p class="shopzen-testi-sub"><?php echo esc_html( $subtext ); ?></p>
			<?php endif; ?>

			<?php if ( 'yes' !== $hide_view_all && ! empty( $view_all_href ) && ! empty( $view_all_text ) ) : ?>
				<a class="shopzen-testi-link" href="<?php echo esc_url( $view_all_href ); ?>" <?php echo esc_attr( $view_all_attr_str ); ?>>
					<?php echo esc_html( $view_all_text ); ?> →
				</a>
			<?php endif; ?>
		</div>

		<div class="shopzen-testi-right">
			<div class="shopzen-testi-cards">

				<?php foreach ( $testimonials as $item ) :
					$avatar   = $item['testi_avatar'] ?? [];
					$name     = $item['testi_name'] ?? '';
					$verified = $item['testi_verified'] ?? 'yes';
					$rating   = isset( $item['testi_rating'] ) ? (float) $item['testi_rating'] : 0;
					$quote    = $item['testi_quote'] ?? '';

					$img_id  = $avatar['id'] ?? '';
					$img_url = $avatar['url'] ?? '';
					$alt     = $name;
					?>
					<div class="shopzen-testi-card">
						<div class="shopzen-testi-top">
							<div class="shopzen-testi-user">
								<div class="shopzen-testi-avatar">
									<?php if ( ! empty( $img_id ) ) :
										echo wp_get_attachment_image( absint( $img_id ), [ 200, 200 ], false, [ 'alt' => esc_attr( $alt ) ] );
									elseif ( ! empty( $img_url ) ) : ?>
										<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy">
									<?php endif; ?>
								</div>
								<div class="shopzen-testi-name">
									<?php echo esc_html( $name ); ?>
									<?php if ( 'yes' === $verified ) : ?>
										<span class="shopzen-testi-verified">
											<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 12l4 4 10-10"></path></svg>
										</span>
									<?php endif; ?>
								</div>
							</div>
							<div class="shopzen-testi-tstars"><?php echo esc_html( $shopzen_testi_stars( $rating ) ); ?></div>
						</div>
						<?php if ( ! empty( $quote ) ) : ?>
							<p class="shopzen-testi-quote"><?php echo esc_html( $quote ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>

			</div>

		</div>

	</div>
</section>

<style>
	.shopzen-testi-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
		padding: 56px 0 40px;
		background: #FCFCFB;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> *,
	.shopzen-testi-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-testi-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-wrap {
		max-width: 1240px;
		margin: 0 auto;
		padding: 0 16px;
		display: grid;
		grid-template-columns: var(--shopzen-testi-left, 30%) 1fr;
		gap: 40px;
		align-items: center;
	}

	/* Left panel */
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-title {
		font-family: Outfit, sans-serif;
		font-size: 38px;
		font-weight: 800;
		line-height: 1.1em;
		margin: 0 0 12px;
		color: #1A202C;
		letter-spacing: -0.5px;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-green {
		color: #4A6B3F;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-sub {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 500;
		color: #6B7280;
		max-width: 240px;
		margin: 0 0 18px;
		line-height: 1.5;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-link {
		font-family: Inter, sans-serif;
		font-weight: 700;
		color: #3A5F3F;
		font-size: 13px;
		display: inline-flex;
		align-items: center;
		gap: 4px;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		text-decoration: none;
		transition: 0.2s;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-link:hover {
		text-decoration: underline;
		text-underline-offset: 3px;
	}

	/* Right panel */
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-cards {
		display: grid;
		grid-template-columns: repeat(3, minmax(0, 1fr));
		gap: 16px;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-card {
		background: #fff;
		border: 1px solid #E5E7EB;
		border-radius: 16px;
		padding: 24px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
		transition: 0.25s;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-top {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		margin-bottom: 16px;
		gap: 8px;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-user {
		display: flex;
		align-items: center;
		gap: 12px;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-avatar {
		width: 48px;
		height: 48px;
		border-radius: 50%;
		overflow: hidden;
		flex-shrink: 0;
		border: 1px solid #E5E7EB;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-avatar img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-name {
		display: flex;
		align-items: center;
		gap: 6px;
		font-family: Inter, sans-serif;
		font-weight: 700;
		font-size: 14px;
		color: #111827;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-verified {
		width: 16px;
		height: 16px;
		background: #3B82F6;
		border-radius: 50%;
		display: grid;
		place-items: center;
		color: #fff;
		flex-shrink: 0;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-tstars {
		color: #F59E0B;
		font-size: 15px;
		letter-spacing: 1px;
		white-space: nowrap;
	}
	.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-quote {
		color: #374151;
		font-size: 15px;
		line-height: 1.55;
		font-weight: 500;
		font-style: italic;
		margin: 0;
		font-family: Inter, sans-serif;
	}

	/* Responsive */
	@media (max-width: 1100px) {
		.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-wrap {
			grid-template-columns: 1fr !important;
			gap: 28px;
		}
		.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-cards {
			grid-template-columns: repeat(2, minmax(0, 1fr));
		}
	}
	@media (max-width: 768px) {
		.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-cards {
			grid-template-columns: 1fr;
		}
		.shopzen-testi-<?php echo esc_attr( $id ); ?> .shopzen-testi-title {
			font-size: 30px;
		}
	}
</style>
