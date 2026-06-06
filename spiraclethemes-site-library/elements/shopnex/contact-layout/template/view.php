<?php
/**
 * Contact Layout Widget View for Shopnex Theme
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$widget_id         = ! empty( $widget_id ) ? $widget_id : '';
$settings          = ! empty( $settings ) ? $settings : array();

// Form settings
$form_heading      = ! empty( $settings['form_heading'] ) ? $settings['form_heading'] : '';
$form_subheading   = ! empty( $settings['form_subheading'] ) ? $settings['form_subheading'] : '';
$form_shortcode    = ! empty( $settings['form_shortcode'] ) ? $settings['form_shortcode'] : '';
$submit_button_text = ! empty( $settings['submit_button_text'] ) ? $settings['submit_button_text'] : '';
$form_note         = ! empty( $settings['form_note'] ) ? $settings['form_note'] : '';

// Card: Visit Us
$show_card_visit   = ! empty( $settings['show_card_visit'] ) && 'yes' === $settings['show_card_visit'];
$card_visit_title  = ! empty( $settings['card_visit_title'] ) ? $settings['card_visit_title'] : '';
$card_visit_address = ! empty( $settings['card_visit_address'] ) ? $settings['card_visit_address'] : '';

// Card: Contact Us
$show_card_contact = ! empty( $settings['show_card_contact'] ) && 'yes' === $settings['show_card_contact'];
$card_contact_title = ! empty( $settings['card_contact_title'] ) ? $settings['card_contact_title'] : '';
$card_contact_email = ! empty( $settings['card_contact_email'] ) ? $settings['card_contact_email'] : '';
$card_contact_phone = ! empty( $settings['card_contact_phone'] ) ? $settings['card_contact_phone'] : '';

// Card: Studio Hours
$show_card_hours   = ! empty( $settings['show_card_hours'] ) && 'yes' === $settings['show_card_hours'];
$card_hours_title  = ! empty( $settings['card_hours_title'] ) ? $settings['card_hours_title'] : '';
$card_hours_items  = ! empty( $settings['card_hours_items'] ) ? $settings['card_hours_items'] : '';

// Parse hours items
$hours_lines = array();
if ( $card_hours_items ) {
    $lines = explode( "\n", $card_hours_items );
    foreach ( $lines as $line ) {
        $line = trim( $line );
        if ( empty( $line ) ) {
            continue;
        }
        $parts = explode( '|', $line, 2 );
        $hours_lines[] = array(
            'day'   => trim( $parts[0] ),
            'hours' => isset( $parts[1] ) ? trim( $parts[1] ) : '',
        );
    }
}

// Icons
$card_visit_icon   = ! empty( $settings['card_visit_icon'] ) ? $settings['card_visit_icon'] : array();
$card_contact_icon = ! empty( $settings['card_contact_icon'] ) ? $settings['card_contact_icon'] : array();
$card_hours_icon   = ! empty( $settings['card_hours_icon'] ) ? $settings['card_hours_icon'] : array();

// Check if any sidebar card is visible
$has_sidebar = $show_card_visit || $show_card_contact || $show_card_hours;
?>

<div class="shopnex-contact-wrapper shopnex-contact-<?php echo esc_attr( $widget_id ); ?>">
    <div class="shopnex-contact-layout">

        <!-- Contact Form -->
        <div class="shopnex-contact-form-wrapper">
            <?php if ( $form_heading ) : ?>
                <h2 class="shopnex-contact-form-heading"><?php echo esc_html( $form_heading ); ?></h2>
            <?php endif; ?>

            <?php if ( $form_subheading ) : ?>
                <p class="shopnex-contact-form-subheading"><?php echo esc_html( $form_subheading ); ?></p>
            <?php endif; ?>

            <?php if ( $form_shortcode ) : ?>
                <div class="shopnex-contact-form-content">
                    <?php echo do_shortcode( $form_shortcode ); ?>
                </div>
            <?php else : ?>
                <!-- Placeholder form for preview -->
                <div class="shopnex-contact-form-content">
                    <div class="shopnex-contact-form-grid">
                        <div class="shopnex-contact-form-group">
                            <label class="shopnex-contact-form-label"><?php esc_html_e( 'First Name', 'spiraclethemes-site-library' ); ?></label>
                            <input type="text" class="shopnex-contact-form-input" placeholder="<?php esc_attr_e( 'First Name', 'spiraclethemes-site-library' ); ?>">
                        </div>
                        <div class="shopnex-contact-form-group">
                            <label class="shopnex-contact-form-label"><?php esc_html_e( 'Last Name', 'spiraclethemes-site-library' ); ?></label>
                            <input type="text" class="shopnex-contact-form-input" placeholder="<?php esc_attr_e( 'Last Name', 'spiraclethemes-site-library' ); ?>">
                        </div>
                        <div class="shopnex-contact-form-group shopnex-contact-full-width">
                            <label class="shopnex-contact-form-label"><?php esc_html_e( 'Email Address', 'spiraclethemes-site-library' ); ?></label>
                            <input type="email" class="shopnex-contact-form-input" placeholder="<?php esc_attr_e( 'Email Address', 'spiraclethemes-site-library' ); ?>">
                        </div>
                        <div class="shopnex-contact-form-group shopnex-contact-full-width">
                            <label class="shopnex-contact-form-label"><?php esc_html_e( 'Message', 'spiraclethemes-site-library' ); ?></label>
                            <textarea class="shopnex-contact-form-textarea" placeholder="<?php esc_attr_e( 'Tell us how we can help…', 'spiraclethemes-site-library' ); ?>"></textarea>
                        </div>
                    </div>
                    <div class="shopnex-contact-form-submit-row">
                        <?php if ( $form_note ) : ?>
                            <span class="shopnex-contact-form-note"><?php echo esc_html( $form_note ); ?></span>
                        <?php endif; ?>
                        <?php if ( $submit_button_text ) : ?>
                            <button type="button" class="shopnex-contact-submit-btn">
                                <?php echo esc_html( $submit_button_text ); ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Contact Sidebar -->
        <?php if ( $has_sidebar ) : ?>
        <div class="shopnex-contact-sidebar">

            <?php if ( $show_card_visit ) : ?>
            <div class="shopnex-contact-info-card">
                <div class="shopnex-contact-info-icon">
                    <?php
                    if ( ! empty( $card_visit_icon['value'] ) ) {
                        \Elementor\Icons_Manager::render_icon( $card_visit_icon, array( 'aria-hidden' => 'true' ) );
                    }
                    ?>
                </div>
                <?php if ( $card_visit_title ) : ?>
                    <h4><?php echo esc_html( $card_visit_title ); ?></h4>
                <?php endif; ?>
                <?php if ( $card_visit_address ) : ?>
                    <p><?php echo nl2br( esc_html( $card_visit_address ) ); ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ( $show_card_contact ) : ?>
            <div class="shopnex-contact-info-card">
                <div class="shopnex-contact-info-icon">
                    <?php
                    if ( ! empty( $card_contact_icon['value'] ) ) {
                        \Elementor\Icons_Manager::render_icon( $card_contact_icon, array( 'aria-hidden' => 'true' ) );
                    }
                    ?>
                </div>
                <?php if ( $card_contact_title ) : ?>
                    <h4><?php echo esc_html( $card_contact_title ); ?></h4>
                <?php endif; ?>
                <p>
                    <?php if ( $card_contact_email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $card_contact_email ); ?>"><?php echo esc_html( $card_contact_email ); ?></a><br>
                    <?php endif; ?>
                    <?php if ( $card_contact_phone ) : ?>
                        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $card_contact_phone ) ); ?>"><?php echo esc_html( $card_contact_phone ); ?></a>
                    <?php endif; ?>
                </p>
            </div>
            <?php endif; ?>

            <?php if ( $show_card_hours ) : ?>
            <div class="shopnex-contact-info-card">
                <div class="shopnex-contact-info-icon">
                    <?php
                    if ( ! empty( $card_hours_icon['value'] ) ) {
                        \Elementor\Icons_Manager::render_icon( $card_hours_icon, array( 'aria-hidden' => 'true' ) );
                    }
                    ?>
                </div>
                <?php if ( $card_hours_title ) : ?>
                    <h4><?php echo esc_html( $card_hours_title ); ?></h4>
                <?php endif; ?>
                <?php if ( ! empty( $hours_lines ) ) : ?>
                    <ul class="shopnex-contact-hours-list">
                        <?php foreach ( $hours_lines as $item ) : ?>
                            <li>
                                <span class="day"><?php echo esc_html( $item['day'] ); ?></span>
                                <span><?php echo esc_html( $item['hours'] ); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</div>

<style>
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 56px;
    align-items: flex-start;
    margin-bottom: 70px;
}

/* Form Wrapper */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-wrapper {
    background-color: #FFFFFF;
    border-radius: 16px;
    padding: 40px;
    border: 1px solid #F0EDE9;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-heading {
    font-family: 'Playfair Display', serif;
    font-size: 24px;
    font-weight: 500;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    color: #1C1C1C;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-subheading {
    font-size: 14px;
    color: #6B6560;
    margin-bottom: 28px;
    line-height: 1.5;
}

/* Form Grid */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-full-width {
    grid-column: 1 / -1;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-label {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9C9792;
    font-weight: 500;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-input,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-textarea {
    padding: 14px 16px;
    border: 1.5px solid #E8E4DF;
    border-radius: 6px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    background: #FBF9F6;
    color: #1C1C1C;
    outline: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    letter-spacing: 0.01em;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-input:focus,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-textarea:focus {
    border-color: #1C1C1C;
    box-shadow: 0 0 0 3px rgba(28, 28, 28, 0.03);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-input::placeholder,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-textarea::placeholder {
    color: #9C9792;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-textarea {
    resize: vertical;
    min-height: 140px;
    line-height: 1.6;
}

/* Submit Row */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-submit-row {
    margin-top: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-note {
    font-size: 12px;
    color: #9C9792;
    line-height: 1.5;
    max-width: 260px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-submit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 32px;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.04em;
    border-radius: 50px;
    background-color: #1C1C1C;
    color: #fff;
    border: none;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    gap: 8px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-submit-btn:hover {
    background-color: #333;
    box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
    transform: translateY(-2px);
    color: #fff;
}

/* Sidebar */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-sidebar {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

/* Info Card */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-card {
    background-color: #FFFFFF;
    border-radius: 10px;
    padding: 28px;
    border: 1px solid #F0EDE9;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-card:hover {
    box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
    transform: translateY(-2px);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-icon {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background-color: #F3EFEA;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    color: #B8977E;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-icon i,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-icon svg {
    font-size: 18px;
    width: 18px;
    height: 18px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-card h4 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    font-weight: 500;
    letter-spacing: -0.01em;
    margin-bottom: 6px;
    color: #1C1C1C;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-card p {
    font-size: 14px;
    color: #6B6560;
    line-height: 1.6;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-card a {
    color: #6B6560;
    text-decoration: none;
    transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-info-card a:hover {
    color: #1C1C1C;
}

/* Hours List */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-hours-list {
    list-style: none;
    margin-top: 8px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-hours-list li {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #6B6560;
    padding: 6px 0;
    border-bottom: 1px solid #F0EDE9;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-hours-list li:last-child {
    border-bottom: none;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-hours-list .day {
    font-weight: 500;
    color: #1C1C1C;
}

/* Contact Form 7 Styles */
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7 {
    margin: 0;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form {
    margin: 0;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form > p {
    margin: 0 0 18px 0;
    padding: 0;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form > p:last-of-type {
    margin-bottom: 0;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form label {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #9C9792;
    font-weight: 500;
    margin-bottom: 6px;
    line-height: 1.5;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .wpcf7-form-control-wrap {
    display: block;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input[type="text"],
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input[type="email"],
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input[type="tel"],
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input[type="url"],
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input[type="number"],
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input[type="date"],
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form select,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form textarea {
    width: 100%;
    padding: 14px 16px;
    border: 1.5px solid #E8E4DF;
    border-radius: 6px;
    font-size: 14px;
    font-family: 'Inter', sans-serif;
    background: #FBF9F6;
    color: #1C1C1C;
    outline: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    letter-spacing: 0.01em;
    box-sizing: border-box;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form input:focus,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form textarea:focus,
.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form select:focus {
    border-color: #1C1C1C;
    box-shadow: 0 0 0 3px rgba(28, 28, 28, 0.03);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form textarea {
    resize: vertical;
    min-height: 140px;
    line-height: 1.6;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .wpcf7-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 32px;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.04em;
    border-radius: 50px;
    background-color: #1C1C1C;
    color: #fff;
    border: none;
    cursor: pointer;
    font-family: 'Inter', sans-serif;
    gap: 8px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin-top: 6px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .wpcf7-submit:hover {
    background-color: #333;
    box-shadow: 0 4px 20px rgba(28, 28, 28, 0.06);
    transform: translateY(-2px);
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .wpcf7-spinner {
    margin: 0;
    vertical-align: middle;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .wpcf7-response-output {
    margin: 18px 0 0 0;
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 14px;
    line-height: 1.5;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .wpcf7-not-valid-tip {
    font-size: 12px;
    color: #e74c3c;
    margin-top: 4px;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .hidden-fields-container {
    display: none;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7 .screen-reader-response {
    display: none;
}

.shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-content .wpcf7-form .akismet-fields-container {
    display: none !important;
}

/* Responsive */
@media (max-width: 1024px) {
    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-layout {
        grid-template-columns: 1fr 340px;
        gap: 32px;
    }
}

@media (max-width: 768px) {
    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-layout {
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-wrapper {
        padding: 24px;
    }

    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-grid {
        grid-template-columns: 1fr;
    }

    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-submit-row {
        flex-direction: column;
        align-items: stretch;
    }

    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-note {
        max-width: 100%;
    }
}

@media (max-width: 480px) {
    .shopnex-contact-<?php echo esc_attr( $widget_id ); ?> .shopnex-contact-form-wrapper {
        padding: 20px;
    }
}
</style>
