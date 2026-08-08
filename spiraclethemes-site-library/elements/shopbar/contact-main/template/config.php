<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Helper: outline SVG icon keys for the contact-main side cards
 * (business hours + social media). The matching markup lives in
 * view.php via the local render closure. Icons follow the Shopbar
 * theme outline style (24x24 viewBox, stroke based).
 *
 * @return array
 */
function shopbar_cm_icon_options() {
	return array(
		''         => esc_html__( '— None —', 'spiraclethemes-site-library' ),
		'clock'    => esc_html__( 'Clock (Hours)', 'spiraclethemes-site-library' ),
		'map-pin'  => esc_html__( 'Map Pin', 'spiraclethemes-site-library' ),
		'phone'    => esc_html__( 'Phone', 'spiraclethemes-site-library' ),
		'mail'     => esc_html__( 'Mail', 'spiraclethemes-site-library' ),
		'globe'    => esc_html__( 'Globe', 'spiraclethemes-site-library' ),
	);
}

/**
 * Helper: outline brand SVG icon keys for the social card.
 *
 * @return array
 */
function shopbar_cm_social_icon_options() {
	return array(
		'facebook'  => esc_html__( 'Facebook', 'spiraclethemes-site-library' ),
		'instagram' => esc_html__( 'Instagram', 'spiraclethemes-site-library' ),
		'twitter'   => esc_html__( 'Twitter / X', 'spiraclethemes-site-library' ),
		'youtube'   => esc_html__( 'YouTube', 'spiraclethemes-site-library' ),
		'linkedin'  => esc_html__( 'LinkedIn', 'spiraclethemes-site-library' ),
		'pinterest' => esc_html__( 'Pinterest', 'spiraclethemes-site-library' ),
	);
}

/**
 * Contact Main
 *
 * The form + map block of the Shopbar contact page: a bordered form
 * card on one side (native form or Contact Form 7 shortcode) and a
 * side column holding a Google Map embed, optional business-hours card
 * and optional social card. Mirrors the .contact-main section of the
 * Shopbar design spec.
 *
 * @since 1.0.0
 */
class Shopbar_Contact_Main extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-contact-main';
	}

	public function get_title() {
		return __( 'Contact Main', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-email-field';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'map', 'message', 'cf7', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Contact Form ────────────────────────────────────
		$this->start_controls_section(
			'section_form',
			[
				'label' => esc_html__( 'Contact Form', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'form_source',
			[
				'label'   => esc_html__( 'Form Source', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'native',
				'options' => [
					'native' => esc_html__( 'Native Form', 'spiraclethemes-site-library' ),
					'cf7'    => esc_html__( 'Contact Form 7', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'form_title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Send Us a Message', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'form_description',
			[
				'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Fill out the form below and our team will get back to you as soon as possible.', 'spiraclethemes-site-library' ),
				'rows'        => 3,
			]
		);

		$this->add_control(
			'cf7_shortcode',
			[
				'label'       => esc_html__( 'CF7 Shortcode', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => '[contact-form-7 id="123" title="Contact form"]',
				'description' => esc_html__( 'Paste your Contact Form 7 shortcode. Requires the Contact Form 7 plugin to be active.', 'spiraclethemes-site-library' ),
				'condition'   => [ 'form_source' => 'cf7' ],
			]
		);

		$this->add_control(
			'form_fields_heading',
			[
				'label'     => esc_html__( 'Form Fields', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'form_source' => 'native' ],
			]
		);

		$field_repeater = new Repeater();

		$field_repeater->add_control(
			'field_label',
			[
				'label'       => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Full Name', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$field_repeater->add_control(
			'field_type',
			[
				'label'   => esc_html__( 'Type', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text'     => esc_html__( 'Text', 'spiraclethemes-site-library' ),
					'email'    => esc_html__( 'Email', 'spiraclethemes-site-library' ),
					'tel'      => esc_html__( 'Phone (tel)', 'spiraclethemes-site-library' ),
					'select'   => esc_html__( 'Select', 'spiraclethemes-site-library' ),
					'textarea' => esc_html__( 'Textarea', 'spiraclethemes-site-library' ),
				],
			]
		);

		$field_repeater->add_control(
			'field_placeholder',
			[
				'label'       => esc_html__( 'Placeholder', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'John Doe', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'field_type!' => 'select' ],
			]
		);

		$field_repeater->add_control(
			'field_options',
			[
				'label'       => esc_html__( 'Options (one per line)', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => "Order Inquiry\nReturns & Refunds\nProduct Question\nPartnership\nOther",
				'condition'   => [ 'field_type' => 'select' ],
			]
		);

		$field_repeater->add_control(
			'field_width',
			[
				'label'   => esc_html__( 'Width', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'half',
				'options' => [
					'half' => esc_html__( 'Half', 'spiraclethemes-site-library' ),
					'full' => esc_html__( 'Full', 'spiraclethemes-site-library' ),
				],
			]
		);

		$field_repeater->add_control(
			'field_required',
			[
				'label'        => esc_html__( 'Required', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'form_fields',
			[
				'label'       => esc_html__( 'Fields', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $field_repeater->get_controls(),
				'default'     => [
					[ 'field_label' => 'Full Name',       'field_type' => 'text',     'field_placeholder' => 'John Doe',            'field_width' => 'half', 'field_required' => 'yes' ],
					[ 'field_label' => 'Email Address',   'field_type' => 'email',    'field_placeholder' => 'john@example.com',     'field_width' => 'half', 'field_required' => 'yes' ],
					[ 'field_label' => 'Phone Number',    'field_type' => 'tel',      'field_placeholder' => '+1 (555) 000-0000',    'field_width' => 'half', 'field_required' => '' ],
					[ 'field_label' => 'Subject',         'field_type' => 'select',   'field_width' => 'half', 'field_required' => '' ],
					[ 'field_label' => 'Message',         'field_type' => 'textarea', 'field_placeholder' => 'Tell us how we can help...', 'field_width' => 'full', 'field_required' => 'yes' ],
				],
				'title_field'  => '{{{ field_label }}} <span style="color:#999;">({{{ field_type }}})</span>',
				'condition'    => [ 'form_source' => 'native' ],
			]
		);

		$this->add_control(
			'show_privacy',
			[
				'label'        => esc_html__( 'Privacy Checkbox', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'Hide', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'separator'    => 'before',
				'condition'    => [ 'form_source' => 'native' ],
			]
		);

		$this->add_control(
			'privacy_text',
			[
				'label'       => esc_html__( 'Privacy Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'I agree to the Privacy Policy and consent to being contacted regarding my inquiry.', 'spiraclethemes-site-library' ),
				'rows'        => 2,
				'condition'   => [
					'form_source' => 'native',
					'show_privacy' => 'yes',
				],
			]
		);

		$this->add_control(
			'submit_text',
			[
				'label'       => esc_html__( 'Submit Button Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Send Message', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'separator'   => 'before',
				'condition'   => [ 'form_source' => 'native' ],
			]
		);

		$this->add_control(
			'submit_icon',
			[
				'label'        => esc_html__( 'Submit Button Icon', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Show', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'Hide', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'form_source' => 'native' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Contact Map ─────────────────────────────────────
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__( 'Contact Map', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_map',
			[
				'label'        => esc_html__( 'Show Map', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'map_embed',
			[
				'label'       => esc_html__( 'Map Embed Code', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 4,
				'default'     => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.020006121937!2d-122.41941708468226!3d37.77492997975903!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858085a49f0b6d%3A0xdb32b0b93e3ff2b3!2sMarket%20St%2C%20San%20Francisco%2C%20CA!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" loading="lazy" style="border:0;"></iframe>',
				'description' => esc_html__( 'Paste a full Google Maps embed (iframe). From Google Maps choose Share → Embed a map → Copy HTML.', 'spiraclethemes-site-library' ),
				'condition'   => [ 'show_map' => 'yes' ],
			]
		);

		$this->add_control(
			'map_min_height',
			[
				'label'      => esc_html__( 'Min Height (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 180, 'max' => 600 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 280 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-map' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [ 'show_map' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Business Hours ──────────────────────────────────
		$this->start_controls_section(
			'section_hours',
			[
				'label' => esc_html__( 'Business Hours', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_hours',
			[
				'label'        => esc_html__( 'Show Hours Card', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'hours_title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Business Hours', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_hours' => 'yes' ],
			]
		);

		$this->add_control(
			'hours_icon',
			[
				'label'       => esc_html__( 'Title Icon', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'clock',
				'options'     => shopbar_cm_icon_options(),
				'condition'   => [ 'show_hours' => 'yes' ],
			]
		);

		$hours_repeater = new Repeater();

		$hours_repeater->add_control(
			'day',
			[
				'label'       => esc_html__( 'Day / Label', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Monday - Friday', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$hours_repeater->add_control(
			'hours',
			[
				'label'       => esc_html__( 'Hours', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '9:00 AM - 6:00 PM', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$hours_repeater->add_control(
			'is_closed',
			[
				'label'        => esc_html__( 'Closed', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->add_control(
			'hours_rows',
			[
				'label'       => esc_html__( 'Rows', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $hours_repeater->get_controls(),
				'default'     => [
					[ 'day' => 'Monday - Friday', 'hours' => '9:00 AM - 6:00 PM',  'is_closed' => '' ],
					[ 'day' => 'Saturday',        'hours' => '10:00 AM - 4:00 PM', 'is_closed' => '' ],
					[ 'day' => 'Sunday',          'hours' => 'Closed',             'is_closed' => 'yes' ],
				],
				'title_field' => '{{{ day }}} — {{{ hours }}}',
				'condition'   => [ 'show_hours' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Social Media ────────────────────────────────────
		$this->start_controls_section(
			'section_social',
			[
				'label' => esc_html__( 'Social Media', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_social',
			[
				'label'        => esc_html__( 'Show Social Card', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'social_title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Follow Us on Social Media', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_social' => 'yes' ],
			]
		);

		$social_repeater = new Repeater();

		$social_repeater->add_control(
			'icon',
			[
				'label'   => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'facebook',
				'options' => shopbar_cm_social_icon_options(),
			]
		);

		$social_repeater->add_control(
			'link',
			[
				'label'         => esc_html__( 'Link', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => 'https://facebook.com',
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => true,
					'nofollow'    => '',
				],
			]
		);

		$this->add_control(
			'social_items',
			[
				'label'       => esc_html__( 'Items', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $social_repeater->get_controls(),
				'default'     => [
					[ 'icon' => 'facebook',  'link' => [ 'url' => '#', 'is_external' => true ] ],
					[ 'icon' => 'instagram', 'link' => [ 'url' => '#', 'is_external' => true ] ],
					[ 'icon' => 'twitter',   'link' => [ 'url' => '#', 'is_external' => true ] ],
					[ 'icon' => 'youtube',   'link' => [ 'url' => '#', 'is_external' => true ] ],
					[ 'icon' => 'pinterest', 'link' => [ 'url' => '#', 'is_external' => true ] ],
				],
				'title_field' => '{{{ icon }}}',
				'condition'   => [ 'show_social' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ──────────────────────────────────────────
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'side_position',
			[
				'label'         => esc_html__( 'Side Column Position', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'right',
				'options'       => [
					'left'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),  'icon' => 'eicon-h-align-left' ],
					'right' => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ), 'icon' => 'eicon-h-align-right' ],
				],
				'toggle'        => false,
				'prefix_class'  => 'shopbar-cm-side-',
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Form / Side Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 40 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-row' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label'      => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 0, 'right' => 24, 'bottom' => 70, 'left' => 24, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_max_width',
			[
				'label'        => esc_html__( 'Full Width', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'full',
				'default'      => '',
				'separator'    => 'before',
				'description'  => esc_html__( 'Stretch edge-to-edge. Off to contain within the content width.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'content_width',
			[
				'label'      => esc_html__( 'Content Width (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 960, 'max' => 1600 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 1350 ],
				'condition'  => [ 'content_max_width!' => 'full' ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Form Card ─────────────────────────────────────────
		$this->start_controls_section(
			'section_style_form_card',
			[
				'label' => esc_html__( 'Form Card', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'form_card_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-form' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'form_card_border',
				'selector'       => '{{WRAPPER}} .shopbar-cm-form',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#E8E4DF' ],
				],
			]
		);

		$this->add_control(
			'form_card_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-form' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_card_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 44, 'right' => 44, 'bottom' => 44, 'left' => 44, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_card_shadow',
				'selector' => '{{WRAPPER}} .shopbar-cm-form',
			]
		);

		$this->add_control(
			'form_flex',
			[
				'label'      => esc_html__( 'Form Width Weight', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 1, 'max' => 4 ] ],
				'step'       => 0.1,
				'default'    => [ 'unit' => 'px', 'size' => 1.2 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-form' => 'flex: {{SIZE}} 1 0;',
					'{{WRAPPER}} .shopbar-cm-side' => 'flex: 1 1 0;',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Form Title ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_form_title',
			[
				'label' => esc_html__( 'Form Title', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'form_title_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-form-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 26 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.25 ] ],
				],
			]
		);

		$this->add_control(
			'form_title_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-form-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-form-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Form Description ──────────────────────────────────
		$this->start_controls_section(
			'section_style_form_desc',
			[
				'label' => esc_html__( 'Form Description', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'form_desc_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-form-desc',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
				],
			]
		);

		$this->add_control(
			'form_desc_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-form-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'form_desc_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 26 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-form-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Field Labels ──────────────────────────────────────
		$this->start_controls_section(
			'section_style_label',
			[
				'label' => esc_html__( 'Field Labels', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'label_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-label',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Inputs ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__( 'Inputs', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'input_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-field input, {{WRAPPER}} .shopbar-cm-field select, {{WRAPPER}} .shopbar-cm-field textarea',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.5 ] ],
				],
			]
		);

		$this->add_control(
			'input_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-field input, {{WRAPPER}} .shopbar-cm-field select, {{WRAPPER}} .shopbar-cm-field textarea' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-field input, {{WRAPPER}} .shopbar-cm-field select, {{WRAPPER}} .shopbar-cm-field textarea' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'input_border',
				'selector'       => '{{WRAPPER}} .shopbar-cm-field input, {{WRAPPER}} .shopbar-cm-field select, {{WRAPPER}} .shopbar-cm-field textarea',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#DDDDDD' ],
				],
			]
		);

		$this->add_control(
			'input_focus_border',
			[
				'label'     => esc_html__( 'Focus Border Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-field input:focus, {{WRAPPER}} .shopbar-cm-field select:focus, {{WRAPPER}} .shopbar-cm-field textarea:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-field input, {{WRAPPER}} .shopbar-cm-field select, {{WRAPPER}} .shopbar-cm-field textarea' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 13, 'right' => 16, 'bottom' => 13, 'left' => 16, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-field input, {{WRAPPER}} .shopbar-cm-field select, {{WRAPPER}} .shopbar-cm-field textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_gap',
			[
				'label'      => esc_html__( 'Field Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-fields' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'textarea_height',
			[
				'label'      => esc_html__( 'Textarea Min Height (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 80, 'max' => 320 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 130 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-field textarea' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Submit Button ─────────────────────────────────────
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Submit Button', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'button_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-submit',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1 ] ],
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_hover',
			[
				'label'     => esc_html__( 'Background (Hover)', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-submit:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-submit' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 15, 'right' => 34, 'bottom' => 15, 'left' => 34, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Map ───────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_map',
			[
				'label'     => esc_html__( 'Map', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_map' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'map_border',
				'selector'       => '{{WRAPPER}} .shopbar-cm-map',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#E8E4DF' ],
				],
			]
		);

		$this->add_control(
			'map_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-map' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Side Cards (Hours + Social) ───────────────────────
		$this->start_controls_section(
			'section_style_cards',
			[
				'label' => esc_html__( 'Side Cards', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours, {{WRAPPER}} .shopbar-cm-social' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'card_border',
				'selector'       => '{{WRAPPER}} .shopbar-cm-hours, {{WRAPPER}} .shopbar-cm-social',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#E8E4DF' ],
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-hours, {{WRAPPER}} .shopbar-cm-social' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 28, 'right' => 30, 'bottom' => 28, 'left' => 30, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-hours, {{WRAPPER}} .shopbar-cm-social' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'side_gap',
			[
				'label'      => esc_html__( 'Side Items Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-side' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Hours Title ───────────────────────────────────────
		$this->start_controls_section(
			'section_style_hours_title',
			[
				'label'     => esc_html__( 'Hours Title', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hours' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'hours_title_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-hours-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 18 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'hours_title_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours-title svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'hours_title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-hours-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Hours Rows ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_hours_rows',
			[
				'label'     => esc_html__( 'Hours Rows', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hours' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'hours_row_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-hours-row',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
				],
			]
		);

		$this->add_control(
			'hours_day_color',
			[
				'label'     => esc_html__( 'Day Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours-day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_val_color',
			[
				'label'     => esc_html__( 'Hours Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_closed_color',
			[
				'label'     => esc_html__( 'Closed Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#C44A4A',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours-row--closed .shopbar-cm-hours-val' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F2F2F2',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-hours-row' => 'border-bottom-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Social Icons ──────────────────────────────────────
		$this->start_controls_section(
			'section_style_social',
			[
				'label'     => esc_html__( 'Social Icons', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_social' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'social_title_typography',
				'label'          => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-cm-social-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 700 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'social_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-social-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-social-link svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_bg',
			[
				'label'     => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F5F5F5',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-social-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_hover_bg',
			[
				'label'     => esc_html__( 'Icon Hover Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-social-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cm-social-link:hover svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_icon_size',
			[
				'label'      => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 28 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-social-link svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_box',
			[
				'label'      => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 32, 'max' => 64 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 40 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-social-link' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_radius',
			[
				'label'      => esc_html__( 'Icon Box Radius (%)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-social-link' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_icon_gap',
			[
				'label'      => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-cm-social-icons' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		require __DIR__ . '/view.php';
	}

	protected function content_template() {}
}
