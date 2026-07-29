<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
/**
 * Contact Wrap Section - Frontend Render (Shop Zen)
 *
 * Two-panel contact layout: left = contact form card, right = info cards
 * stack (email, phone, chat, visit) plus optional map card.
 *
 * @package spiraclethemes-site-library
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$settings = $this->get_settings_for_display();
$id       = $this->get_id();

// Form card.
$form_heading = $settings['form_heading'] ?? '';
$form_lead    = $settings['form_lead'] ?? '';
$form_source  = $settings['form_source'] ?? 'builtin';
$cf7_shortcode = $settings['cf7_shortcode'] ?? '';
// Built-in form fields (only used when form_source == 'builtin').
$show_name    = $settings['show_name'] ?? 'yes';
$show_email   = $settings['show_email'] ?? 'yes';
$show_topic   = $settings['show_topic'] ?? 'yes';
$show_order   = $settings['show_order'] ?? 'yes';
$show_message = $settings['show_message'] ?? 'yes';
$topic_options = $settings['topic_options'] ?? '';
$submit_text  = $settings['submit_text'] ?? '';
$form_note    = $settings['form_note'] ?? '';
$submit_link  = $settings['submit_link'] ?? [];

// Info cards.
$info_cards = $settings['info_cards'] ?? [];

// Map card.
$show_map      = $settings['show_map'] ?? 'yes';
$map_title     = $settings['map_title'] ?? '';
$map_text      = $settings['map_text'] ?? '';
$map_embed_url = $settings['map_embed_url'] ?? [];
$map_address   = $settings['map_address'] ?? '';

$submit_href       = ! empty( $submit_link['url'] ) ? $submit_link['url'] : '';
$submit_target     = ! empty( $submit_link['is_external'] ) ? ' target="_blank"' : '';
$submit_nofollow   = ! empty( $submit_link['nofollow'] ) ? ' rel="nofollow"' : '';
$submit_attr_str   = trim( $submit_target . ' ' . $submit_nofollow );

// Parse topic options (one per line).
$topic_lines = array_filter( array_map( 'trim', explode( "\n", $topic_options ) ) );

// Form unique id scoped to this widget instance.
$form_id = 'shopzen-cw-form-' . esc_attr( $id );
?>
<section class="shopzen-cw shopzen-cw-<?php echo esc_attr( $id ); ?>" id="shopzen-cw-<?php echo esc_attr( $id ); ?>">
	<div class="shopzen-cw-wrap">

		<!-- Contact form card -->
		<div class="shopzen-cw-card">
			<?php if ( ! empty( $form_heading ) ) : ?>
				<h2 class="shopzen-cw-card-title"><?php echo esc_html( $form_heading ); ?></h2>
			<?php endif; ?>
			<?php if ( ! empty( $form_lead ) ) : ?>
				<p class="shopzen-cw-card-lead"><?php echo esc_html( $form_lead ); ?></p>
			<?php endif; ?>

		<?php if ( 'cf7' === $form_source && ! empty( $cf7_shortcode ) ) : ?>
			<div class="shopzen-cw-form-cf7">
				<?php
				// Only process Contact Form 7 shortcodes to prevent arbitrary shortcode execution.
				if ( preg_match( '/^\[contact-form-7\s+.*\]$/', trim( $cf7_shortcode ) ) ) {
					echo do_shortcode( $cf7_shortcode ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				} else {
					echo '<p class="shopzen-cw-form-note">' . esc_html__( 'Invalid Contact Form 7 shortcode.', 'spiraclethemes-site-library' ) . '</p>';
				}
				?>
			</div>
			<?php if ( ! empty( $form_note ) ) : ?>
				<p class="shopzen-cw-form-note"><?php echo esc_html( $form_note ); ?></p>
			<?php endif; ?>
		<?php else : ?>
			<?php if ( ! empty( $submit_href ) ) : ?>
				<form class="shopzen-cw-form" method="post" action="<?php echo esc_url( $submit_href ); ?>" <?php echo esc_attr( $submit_attr_str ); ?>>
					<?php wp_nonce_field( 'shopzen_contact_submit_' . $id, 'shopzen_cw_nonce' ); ?>
			<?php else : ?>
				<form class="shopzen-cw-form" id="<?php echo esc_attr( $form_id ); ?>" onsubmit="return false;">
			<?php endif; ?>
				<div class="shopzen-cw-grid">
					<?php if ( 'yes' === $show_name ) : ?>
						<div class="shopzen-cw-field">
							<label for="<?php echo esc_attr( $form_id ); ?>-name"><?php esc_html_e( 'Full Name', 'spiraclethemes-site-library' ); ?></label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-name" name="name" placeholder="<?php esc_attr_e( 'Alex Morgan', 'spiraclethemes-site-library' ); ?>" required>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_email ) : ?>
						<div class="shopzen-cw-field">
							<label for="<?php echo esc_attr( $form_id ); ?>-email"><?php esc_html_e( 'Email', 'spiraclethemes-site-library' ); ?></label>
							<input type="email" id="<?php echo esc_attr( $form_id ); ?>-email" name="email" placeholder="<?php esc_attr_e( 'you@example.com', 'spiraclethemes-site-library' ); ?>" required>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_topic ) : ?>
						<div class="shopzen-cw-field">
							<label for="<?php echo esc_attr( $form_id ); ?>-topic"><?php esc_html_e( 'Topic', 'spiraclethemes-site-library' ); ?></label>
							<select id="<?php echo esc_attr( $form_id ); ?>-topic" name="topic" required>
								<option value=""><?php esc_html_e( 'Choose one', 'spiraclethemes-site-library' ); ?></option>
								<?php foreach ( $topic_lines as $opt ) : ?>
									<option value="<?php echo esc_attr( $opt ); ?>"><?php echo esc_html( $opt ); ?></option>
								<?php endforeach; ?>
							</select>
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_order ) : ?>
						<div class="shopzen-cw-field">
							<label for="<?php echo esc_attr( $form_id ); ?>-order"><?php esc_html_e( 'Order # (optional)', 'spiraclethemes-site-library' ); ?></label>
							<input type="text" id="<?php echo esc_attr( $form_id ); ?>-order" name="order" placeholder="SZ-12345">
						</div>
					<?php endif; ?>
					<?php if ( 'yes' === $show_message ) : ?>
						<div class="shopzen-cw-field full">
							<label for="<?php echo esc_attr( $form_id ); ?>-message"><?php esc_html_e( 'Message', 'spiraclethemes-site-library' ); ?></label>
							<textarea id="<?php echo esc_attr( $form_id ); ?>-message" name="message" placeholder="<?php esc_attr_e( 'Tell us how we can help...', 'spiraclethemes-site-library' ); ?>" required></textarea>
						</div>
					<?php endif; ?>
				</div>
				<button type="submit" class="shopzen-cw-submit">
					<?php echo esc_html( $submit_text ); ?> <span aria-hidden="true">&rarr;</span>
				</button>
				<?php if ( ! empty( $form_note ) ) : ?>
					<p class="shopzen-cw-form-note"><?php echo esc_html( $form_note ); ?></p>
				<?php endif; ?>
			</form>
		<?php endif; ?>
		</div>

		<!-- Info stack -->
		<div class="shopzen-cw-info-wrap">
			<div class="shopzen-cw-info-stack">

				<?php foreach ( $info_cards as $item ) :
					$icon  = $item['info_icon'] ?? [];
					$title = $item['info_title'] ?? '';
					$lines = $item['info_lines'] ?? '';
					?>
					<div class="shopzen-cw-info">
						<?php if ( ! empty( $icon['value'] ) ) : ?>
							<div class="shopzen-cw-info-icon">
								<?php \Elementor\Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?>
							</div>
						<?php endif; ?>
						<div class="shopzen-cw-info-body">
							<?php if ( ! empty( $title ) ) : ?>
								<h4 class="shopzen-cw-info-title"><?php echo esc_html( $title ); ?></h4>
							<?php endif; ?>
							<?php if ( ! empty( $lines ) ) :
								$line_arr = array_filter( array_map( 'trim', explode( "\n", $lines ) ) );
								?>
								<p class="shopzen-cw-info-text">
									<?php foreach ( $line_arr as $idx => $ln ) :
										$trimmed = trim( $ln );
										$is_email = is_email( $trimmed );
										if ( $is_email ) :
											$mailto = sanitize_email( $trimmed );
											?>
											<a href="mailto:<?php echo esc_attr( $mailto ); ?>"><?php echo esc_html( $ln ); ?></a>
										<?php else : ?>
											<?php echo esc_html( $ln ); ?>
										<?php endif; ?>
										<?php if ( $idx < count( $line_arr ) - 1 ) : ?>
											<br>
										<?php endif; ?>
									<?php endforeach; ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>

			</div>

		<?php if ( 'yes' === $show_map ) :
			// Build the Maps embed src: prefer an explicit Embed URL, fall back to address query.
			$map_src = '';
			if ( ! empty( $map_embed_url['url'] ) ) {
				$map_src = esc_url( $map_embed_url['url'] );
			} elseif ( ! empty( $map_address ) ) {
				$map_src = esc_url( 'https://www.google.com/maps?q=' . rawurlencode( $map_address ) . '&output=embed' );
			}
			?>
			<div class="shopzen-cw-map">
				<?php if ( ! empty( $map_src ) ) : ?>
					<div class="shopzen-cw-map-frame">
						<iframe
							src="<?php echo esc_url( $map_src ); ?>"
							title="<?php echo esc_attr( $map_title ? $map_title : __( 'Store location map', 'spiraclethemes-site-library' ) ); ?>"
							loading="lazy"
							referrerpolicy="no-referrer-when-downgrade"
							allowfullscreen></iframe>
					</div>
				<?php else : ?>
					<div class="shopzen-cw-map-frame shopzen-cw-map-empty">
						<?php esc_html_e( 'Add a Google Maps Embed URL or a Map address to display the map.', 'spiraclethemes-site-library' ); ?>
					</div>
				<?php endif; ?>
				<?php if ( ! empty( $map_title ) || ! empty( $map_text ) ) : ?>
					<div class="shopzen-cw-map-content">
						<?php if ( ! empty( $map_title ) ) : ?>
							<h4 class="shopzen-cw-map-title"><?php echo esc_html( $map_title ); ?></h4>
						<?php endif; ?>
						<?php if ( ! empty( $map_text ) ) : ?>
							<p class="shopzen-cw-map-text"><?php echo esc_html( $map_text ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		</div>

	</div>
</section>

<style>
	.shopzen-cw-<?php echo esc_attr( $id ); ?> {
		position: relative;
		width: 100%;
		box-sizing: border-box;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> *,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> *::before,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> *::after { box-sizing: border-box; }

	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-wrap {
		max-width: 1240px;
		margin: 0 auto;
		padding: 0 16px;
		display: grid;
		grid-template-columns: 1.15fr 0.85fr;
		gap: 48px;
	}

	/* Form card */
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-card {
		background: #fff;
		border: 1px solid #E5E7EB;
		border-radius: 14px;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
		padding: 32px;
		position: relative;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-card::before {
		content: '';
		position: absolute;
		top: 10px;
		left: 10px;
		width: 18px;
		height: 18px;
		border-left: 3px solid #3A5F3F;
		border-top: 3px solid #3A5F3F;
		opacity: 0.15;
		border-radius: 3px 0 0 0;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-card-title {
		font-family: Outfit, sans-serif;
		font-size: 26px;
		font-weight: 800;
		margin: 0 0 8px;
		color: #1A202C;
		letter-spacing: -0.02em;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-card-lead {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 500;
		color: #6B7280;
		margin: 0 0 24px;
		line-height: 1.6;
	}

	/* Form */
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-grid {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 16px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field {
		display: flex;
		flex-direction: column;
		gap: 6px;
		margin-bottom: 16px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field.full {
		grid-column: 1 / -1;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field label {
		font-family: Inter, sans-serif;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		color: #374151;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field input,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field select,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field textarea {
		width: 100%;
		padding: 12px 14px;
		border: 1px solid #E5E7EB;
		border-radius: 10px;
		font-family: Inter, sans-serif;
		font-size: 14px;
		transition: 0.2s;
		background: #FCFCFB;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field input:focus,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field select:focus,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field textarea:focus {
		outline: none;
		border-color: #3A5F3F;
		background: #fff;
		box-shadow: 0 0 0 3px rgba(58, 95, 63, 0.1);
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-field textarea {
		min-height: 140px;
		resize: vertical;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-submit {
		background: #1E3F2A;
		color: #fff;
		padding: 13px 24px;
		border: 1px solid #0f2316;
		border-radius: 999px;
		font-family: Inter, sans-serif;
		font-weight: 700;
		font-size: 14px;
		display: inline-flex;
		align-items: center;
		gap: 8px;
		transition: 0.2s;
		box-shadow: 0 4px 14px rgba(30, 63, 42, 0.22);
		text-transform: uppercase;
		letter-spacing: 0.3px;
		width: fit-content;
		cursor: pointer;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-submit:hover {
		transform: translateY(-1px);
		background: #163322;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-note {
		font-family: Inter, sans-serif;
		font-size: 12px;
		font-weight: 500;
		color: #6B7280;
		margin-top: 12px;
		margin-bottom: 0;
	}

	/* Contact Form 7 container */
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 {
		margin: 0;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 p {
		margin: 0 0 16px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 label {
		font-family: Inter, sans-serif;
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		color: #374151;
		display: block;
		margin-bottom: 6px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="text"],
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="email"],
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="tel"],
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="url"],
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="number"],
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="date"],
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 select,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 textarea {
		width: 100%;
		padding: 12px 14px;
		border: 1px solid #E5E7EB;
		border-radius: 10px;
		font-family: Inter, sans-serif;
		font-size: 14px;
		transition: 0.2s;
		background: #FCFCFB;
		box-sizing: border-box;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 textarea {
		min-height: 140px;
		resize: vertical;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input:focus,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 select:focus,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 textarea:focus {
		outline: none;
		border-color: #3A5F3F;
		background: #fff;
		box-shadow: 0 0 0 3px rgba(58, 95, 63, 0.1);
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-submit,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="submit"] {
		background: #1E3F2A;
		color: #fff;
		padding: 13px 24px;
		border: 1px solid #0f2316;
		border-radius: 999px;
		font-family: Inter, sans-serif;
		font-weight: 700;
		font-size: 14px;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		cursor: pointer;
		transition: 0.2s;
		box-shadow: 0 4px 14px rgba(30, 63, 42, 0.22);
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-submit:hover,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 input[type="submit"]:hover {
		background: #163322;
		transform: translateY(-1px);
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-not-valid-tip {
		font-family: Inter, sans-serif;
		font-size: 12px;
		color: #C0392B;
		margin-top: 4px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-response-output {
		font-family: Inter, sans-serif;
		font-size: 13px;
		font-weight: 500;
		margin: 12px 0 0;
		padding: 10px 14px;
		border-radius: 8px;
		border: 1px solid #D4E2D1;
		background: #E9EFE9;
		color: #1A202C;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-validation-errors,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-spam-blocked {
		border-color: #F0C674;
		background: #FFF6E0;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-acceptance-missing,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-invalid-settings {
		border-color: #F0C674;
		background: #FFF6E0;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-form-cf7 .wpcf7-mail-sent-ok {
		border-color: #3A5F3F;
		background: #E9EFE9;
		color: #1E3F2A;
	}

	/* Info stack */
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-wrap {
		display: flex;
		flex-direction: column;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-stack {
		display: flex;
		flex-direction: column;
		gap: 16px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info {
		background: #fff;
		border: 1px solid #E5E7EB;
		border-radius: 14px;
		padding: 22px 20px;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
		display: flex;
		gap: 14px;
		align-items: flex-start;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-icon {
		width: 40px;
		height: 40px;
		border-radius: 10px;
		background: #E9EFE9;
		display: grid;
		place-items: center;
		color: #3A5F3F;
		flex-shrink: 0;
		border: 1px solid #D4E2D1;
		font-size: 16px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-icon i,
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-icon svg {
		font-size: 16px;
		width: 1em;
		height: 1em;
		fill: currentColor;
		color: inherit;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-title {
		font-family: Inter, sans-serif;
		font-size: 15px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.3px;
		margin: 0 0 4px;
		color: #1A202C;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-text {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 500;
		color: #4B5563;
		line-height: 1.5;
		margin: 0;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-text a {
		color: #4B5563;
		text-decoration: none;
		transition: 0.2s;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-info-text a:hover {
		color: #3A5F3F;
		text-decoration: underline;
	}

	/* Map card */
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map {
		background: #fff;
		border: 1px solid #E5E7EB;
		border-radius: 14px;
		overflow: hidden;
		box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
		margin-top: 16px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map-frame {
		height: 220px;
		background: #E9EFE9;
		display: block;
		overflow: hidden;
		position: relative;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map-frame iframe {
		width: 100%;
		height: 100%;
		border: 0;
		display: block;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map-frame.shopzen-cw-map-empty {
		display: grid;
		place-items: center;
		color: #3A5F3F;
		font-family: Inter, sans-serif;
		font-size: 13px;
		font-weight: 500;
		text-align: center;
		padding: 24px;
		line-height: 1.55;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map-content {
		padding: 18px 20px;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map-title {
		font-family: Inter, sans-serif;
		font-size: 14px;
		font-weight: 700;
		text-transform: uppercase;
		letter-spacing: 0.4px;
		margin: 0 0 6px;
		color: #1A202C;
	}
	.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-map-text {
		font-family: Inter, sans-serif;
		font-size: 13px;
		font-weight: 500;
		color: #6B7280;
		margin: 0;
		line-height: 1.55;
	}

	/* Responsive */
	@media (max-width: 1024px) {
		.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-wrap {
			grid-template-columns: 1fr;
			gap: 32px;
		}
	}
	@media (max-width: 768px) {
		.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-grid {
			grid-template-columns: 1fr;
		}
		.shopzen-cw-<?php echo esc_attr( $id ); ?> .shopzen-cw-card {
			padding: 24px;
		}
	}
</style>
