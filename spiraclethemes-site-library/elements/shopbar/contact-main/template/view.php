<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonprefixedVariableFound
/**
 * Contact Main
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Render an outline SVG icon by key.
 *
 * @param string $key Icon key.
 * @return string SVG markup (empty string when key is empty).
 */
$shopbar_cm_render_icon = function ( $key ) {
	$common = 'viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"';
	$icons  = array(
		'send'      => '<svg width="17" height="17" ' . $common . '><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>',
		'clock'     => '<svg width="18" height="18" ' . $common . '><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
		'map-pin'   => '<svg width="18" height="18" ' . $common . '><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
		'phone'     => '<svg width="18" height="18" ' . $common . '><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/></svg>',
		'mail'      => '<svg width="18" height="18" ' . $common . '><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
		'globe'     => '<svg width="18" height="18" ' . $common . '><circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"/></svg>',
		'facebook'  => '<svg width="16" height="16" ' . $common . '><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>',
		'instagram' => '<svg width="16" height="16" ' . $common . '><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>',
		'twitter'   => '<svg width="16" height="16" ' . $common . '><path fill="currentColor" stroke="none" d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
		'youtube'   => '<svg width="16" height="16" ' . $common . '><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>',
		'linkedin'  => '<svg width="16" height="16" ' . $common . '><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>',
		'pinterest' => '<svg width="16" height="16" ' . $common . '><circle cx="12" cy="12" r="10"/><path d="M8 12a4 4 0 1 1 8 0c0 2.2-1.8 4-4 4-.9 0-1.8-.3-2.4-.8L9 18"/><path d="M11.6 11.6 10 17"/></svg>',
	);
	return isset( $icons[ $key ] ) ? $icons[ $key ] : '';
};

/**
 * Allowed tags for the map iframe embed.
 */
$shopbar_cm_iframe_allowed = array(
	'iframe' => array(
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'frameborder'     => true,
		'allow'           => true,
		'allowfullscreen' => true,
		'loading'         => true,
		'referrerpolicy'  => true,
		'title'           => true,
		'style'           => true,
		'class'           => true,
		'name'            => true,
	),
);

$id = $this->get_id();

// ── Settings ──────────────────────────────────────────────────────
$form_source    = $settings['form_source'] ?? 'native';
$form_title     = $settings['form_title'] ?? '';
$form_desc      = $settings['form_description'] ?? '';
$cf7_shortcode  = $settings['cf7_shortcode'] ?? '';
$fields         = $settings['form_fields'] ?? array();
$submit_text    = $settings['submit_text'] ?? '';
$submit_icon    = 'yes' === ( $settings['submit_icon'] ?? '' );
$show_privacy   = 'yes' === ( $settings['show_privacy'] ?? '' );
$privacy_text   = $settings['privacy_text'] ?? '';

$show_map       = 'yes' === ( $settings['show_map'] ?? '' );
$map_embed      = $settings['map_embed'] ?? '';

$show_hours     = 'yes' === ( $settings['show_hours'] ?? '' );
$hours_title    = $settings['hours_title'] ?? '';
$hours_icon     = $settings['hours_icon'] ?? 'clock';
$hours_rows     = $settings['hours_rows'] ?? array();

$show_social    = 'yes' === ( $settings['show_social'] ?? '' );
$social_title   = $settings['social_title'] ?? '';
$social_items   = $settings['social_items'] ?? array();

$has_side       = $show_map || $show_hours || $show_social;
$full_width     = 'full' === ( $settings['content_max_width'] ?? '' );
?>

<section class="shopbar-cm-section shopbar-cm-<?php echo esc_attr( $id ); ?>">
	<div class="shopbar-cm-inner<?php echo $full_width ? ' shopbar-cm-inner--full' : ''; ?>">
		<div class="shopbar-cm-row">

			<!-- ─── Form card ─── -->
			<div class="shopbar-cm-form">
				<?php if ( $form_title ) : ?>
					<h2 class="shopbar-cm-form-title"><?php echo esc_html( $form_title ); ?></h2>
				<?php endif; ?>
				<?php if ( $form_desc ) : ?>
					<p class="shopbar-cm-form-desc"><?php echo esc_html( $form_desc ); ?></p>
				<?php endif; ?>

				<?php if ( 'cf7' === $form_source ) : ?>
					<div class="shopbar-cm-cf7">
						<?php
						if ( ! empty( $cf7_shortcode ) ) {
							// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- do_shortcode output.
							echo do_shortcode( $cf7_shortcode );
						}
						?>
					</div>
				<?php else : ?>
					<form class="shopbar-cm-native-form" method="post" action="">
						<div class="shopbar-cm-fields">
							<?php if ( ! empty( $fields ) && is_array( $fields ) ) :
								foreach ( $fields as $item ) :
									$label       = $item['field_label'] ?? '';
									$type        = $item['field_type'] ?? 'text';
									$placeholder = $item['field_placeholder'] ?? '';
									$width       = $item['field_width'] ?? 'half';
									$required    = 'yes' === ( $item['field_required'] ?? '' );
									$name        = 'shopbar_cm_' . sanitize_title_with_dashes( $label ? $label : $type );
									$req_attr    = $required ? ' required' : '';
									$width_class = 'full' === $width ? ' shopbar-cm-field--full' : ' shopbar-cm-field--half';
							?>
								<div class="shopbar-cm-field<?php echo esc_attr( $width_class ); ?> elementor-repeater-item-<?php echo esc_attr( $item['_id'] ?? '' ); ?>">
									<?php if ( $label ) : ?>
										<label class="shopbar-cm-label" for="<?php echo esc_attr( $name ); ?>">
											<?php echo esc_html( $label ); ?><?php if ( $required ) : ?> <span class="shopbar-cm-required" aria-hidden="true">*</span><?php endif; ?>
										</label>
									<?php endif; ?>

									<?php if ( 'textarea' === $type ) : ?>
										<textarea id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"<?php echo $req_attr; // phpcs:ignore ?>></textarea>
									<?php elseif ( 'select' === $type ) :
										$opts = preg_split( '/\r\n|\r|\n/', $item['field_options'] ?? '' );
									?>
										<select id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>"<?php echo $req_attr; // phpcs:ignore ?>>
											<?php foreach ( $opts as $opt ) :
												$opt = trim( $opt );
												if ( '' === $opt ) {
													continue;
												}
											?>
												<option value="<?php echo esc_attr( $opt ); ?>"><?php echo esc_html( $opt ); ?></option>
											<?php endforeach; ?>
										</select>
									<?php else : ?>
										<input id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" type="<?php echo esc_attr( $type ); ?>" placeholder="<?php echo esc_attr( $placeholder ); ?>"<?php echo $req_attr; // phpcs:ignore ?>>
									<?php endif; ?>
								</div>
							<?php endforeach;
							endif; ?>
						</div>

						<?php if ( $show_privacy && $privacy_text ) : ?>
							<div class="shopbar-cm-privacy">
								<input type="checkbox" id="shopbar-cm-privacy-<?php echo esc_attr( $id ); ?>" name="shopbar_cm_privacy" required>
								<label for="shopbar-cm-privacy-<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $privacy_text ); ?></label>
							</div>
						<?php endif; ?>

						<?php if ( $submit_text ) : ?>
							<button type="submit" class="shopbar-cm-submit">
								<?php if ( $submit_icon ) : ?><span class="shopbar-cm-submit-icon"><?php echo $shopbar_cm_render_icon( 'send' ); // phpcs:ignore ?></span><?php endif; ?>
								<span><?php echo esc_html( $submit_text ); ?></span>
							</button>
						<?php endif; ?>
					</form>
				<?php endif; ?>
			</div>

			<?php if ( $has_side ) : ?>
			<!-- ─── Side column ─── -->
			<div class="shopbar-cm-side">

				<?php if ( $show_map && $map_embed ) : ?>
					<div class="shopbar-cm-map">
						<?php echo wp_kses( $map_embed, $shopbar_cm_iframe_allowed ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $show_hours && ! empty( $hours_rows ) && is_array( $hours_rows ) ) : ?>
					<div class="shopbar-cm-hours">
						<?php if ( $hours_title ) : ?>
							<h3 class="shopbar-cm-hours-title">
								<?php if ( $hours_icon ) : ?><span class="shopbar-cm-hours-icon"><?php echo $shopbar_cm_render_icon( $hours_icon ); // phpcs:ignore ?></span><?php endif; ?>
								<span><?php echo esc_html( $hours_title ); ?></span>
							</h3>
						<?php endif; ?>
						<?php foreach ( $hours_rows as $row ) :
							$day   = $row['day'] ?? '';
							$hrs   = $row['hours'] ?? '';
							$closed = 'yes' === ( $row['is_closed'] ?? '' );
							if ( '' === $day && '' === $hrs ) {
								continue;
							}
						?>
							<div class="shopbar-cm-hours-row<?php echo $closed ? ' shopbar-cm-hours-row--closed' : ''; ?>">
								<span class="shopbar-cm-hours-day"><?php echo esc_html( $day ); ?></span>
								<span class="shopbar-cm-hours-val"><?php echo esc_html( $hrs ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( $show_social && ! empty( $social_items ) && is_array( $social_items ) ) : ?>
					<div class="shopbar-cm-social">
						<?php if ( $social_title ) : ?>
							<h4 class="shopbar-cm-social-title"><?php echo esc_html( $social_title ); ?></h4>
						<?php endif; ?>
						<div class="shopbar-cm-social-icons">
							<?php foreach ( $social_items as $item ) :
								$icon = $item['icon'] ?? '';
								$link = $item['link'] ?? array();
								$url  = ! empty( $link['url'] ) ? $link['url'] : '#';
								$svg  = $shopbar_cm_render_icon( $icon );
								if ( '' === $svg ) {
									continue;
								}
								$target   = ! empty( $link['is_external'] ) ? ' target="_blank"' : '';
								$nofollow = ! empty( $link['nofollow'] ) ? ' rel="nofollow noopener"' : ( $target ? ' rel="noopener"' : '' );
							?>
								<a class="shopbar-cm-social-link" href="<?php echo esc_url( $url ); ?>"<?php echo $target . $nofollow; // phpcs:ignore ?> aria-label="<?php echo esc_attr( ucfirst( $icon ) ); ?>">
									<?php echo $svg; // phpcs:ignore ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<?php endif; ?>

		</div>
	</div>
</section>

<style>
	.shopbar-cm-<?php echo esc_attr( $id ); ?> {
		font-family: var(--font-sans, 'Hanken Grotesk', sans-serif);
		--cm-accent: #B8977E;
		width: 100%;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> *,
	.shopbar-cm-<?php echo esc_attr( $id ); ?> *::before,
	.shopbar-cm-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-inner {
		width: 100%;
		max-width: 1350px;
		margin: 0 auto;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-inner--full { max-width: 100%; }

	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-row {
		display: flex;
		flex-wrap: wrap;
		align-items: stretch;
	}

	/* ── Form card ─────────────────────────────────────── */
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-form {
		flex: 1.2 1 0;
		min-width: 0;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-form-title {
		font-family: var(--font-display, 'Fraunces', serif);
		margin: 0 0 8px;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-form-desc { margin: 0; }

	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-fields {
		display: grid;
		grid-template-columns: 1fr 1fr;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field { min-width: 0; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field--full { grid-column: 1 / -1; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-label { display: block; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-required { color: var(--cm-accent); }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field input,
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field select,
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field textarea {
		width: 100%;
		display: block;
		outline: none;
		transition: border-color .2s ease;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field textarea { resize: vertical; }

	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-privacy {
		display: flex;
		align-items: flex-start;
		gap: 10px;
		font-size: 13px;
		line-height: 1.6em;
		color: #6B6560;
		margin-bottom: 24px;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-privacy input { margin-top: 3px; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-privacy label { line-height: 1.6em; }

	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-submit {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		border: none;
		cursor: pointer;
		white-space: nowrap;
		transition: background-color .3s ease, transform .3s ease, box-shadow .3s ease;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -12px rgba(28, 28, 28, 0.4); }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-submit-icon { display: inline-flex; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-submit svg { width: 17px; height: 17px; stroke: currentColor; }

	/* CF7 passthrough */
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-cf7 .wpcf7-form-control-wrap { display: block; margin-bottom: 16px; }

	/* ── Side column ───────────────────────────────────── */
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-side {
		flex: 1 1 0;
		min-width: 0;
		display: flex;
		flex-direction: column;
	}
	.shopbar-cm-side-left .shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-side { order: -1; }

	/* Map */
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-map {
		flex: 1;
		overflow: hidden;
		display: flex;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-map iframe { width: 100%; height: 100%; min-height: inherit; border: 0; display: block; }

	/* Hours */
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-hours-title {
		display: flex;
		align-items: center;
		gap: 10px;
		margin: 0;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-hours-icon { display: inline-flex; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-hours-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px 0;
		border-bottom: 1px solid #F2F2F2;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-hours-row:last-child { border-bottom: none; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-hours-row--closed .shopbar-cm-hours-val { font-weight: 600; }

	/* Social */
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-social { text-align: center; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-social-title { margin: 0 0 16px; }
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-social-icons {
		display: flex;
		justify-content: center;
		flex-wrap: wrap;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-social-link {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		text-decoration: none;
		transition: background-color .3s ease, color .3s ease, transform .3s ease;
	}
	.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-social-link:hover { transform: translateY(-3px); }

	/* ── Responsive ──────────────────────────────────────
	*/
	@media (max-width: 1024px) {
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-form { flex: 1 1 100% !important; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-side { flex: 1 1 100% !important; order: 0 !important; }
		/* row-gap is what separates the stacked form/side cards (column-gap
		   does not apply across wrapped flex lines and nothing set it before). */
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-row { row-gap: 32px; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-map { min-height: 320px; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-form { padding: 36px 32px !important; }
	}
	@media (max-width: 768px) {
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-inner { padding: 0 16px 48px !important; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-row { row-gap: 24px; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-form { padding: 28px 20px !important; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-hours,
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-social { padding: 22px 18px !important; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-map { min-height: 260px; }
	}
	@media (max-width: 600px) {
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-fields { grid-template-columns: 1fr; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-field--half { grid-column: auto; }
		.shopbar-cm-<?php echo esc_attr( $id ); ?> .shopbar-cm-submit { width: 100%; }
	}
</style>
