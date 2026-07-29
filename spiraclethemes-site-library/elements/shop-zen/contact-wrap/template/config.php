<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Contact_Wrap extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-contact-wrap';
	}

	public function get_title() {
		return __( 'Contact Wrap', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-contact';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'message', 'email', 'phone', 'map', 'zen' ];
	}

	protected function register_controls() {

		// ─── Content: Form Card ─────────────────────────────────────
		$this->start_controls_section(
			'section_form',
			[
				'label' => esc_html__( 'Form Card', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'form_heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send us a message', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'form_lead',
			[
				'label' => esc_html__( 'Lead Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Fill out the form and our care team will get back to you shortly.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'form_source',
			[
				'label' => esc_html__( 'Form Source', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'builtin',
				'options' => [
					'builtin' => esc_html__( 'Built-in Form', 'spiraclethemes-site-library' ),
					'cf7'     => esc_html__( 'Contact Form 7', 'spiraclethemes-site-library' ),
				],
				'description' => esc_html__( 'Use a Contact Form 7 shortcode to render a real, submit-ready form.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'cf7_shortcode',
			[
				'label' => esc_html__( 'Contact Form 7 Shortcode', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'rows' => 2,
				'placeholder' => esc_html__( '[contact-form-7 id="123" title="Contact form"]', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Paste a Contact Form 7 shortcode. Create one under Contact → Contact Forms.', 'spiraclethemes-site-library' ),
				'condition' => [
					'form_source' => 'cf7',
				],
			]
		);

		$this->add_control(
			'show_name',
			[
				'label' => esc_html__( 'Show Name Field', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_email',
			[
				'label' => esc_html__( 'Show Email Field', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_topic',
			[
				'label' => esc_html__( 'Show Topic Dropdown', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'topic_options',
			[
				'label' => esc_html__( 'Topic Options (one per line)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Order Help\nShipping & Returns\nProduct Question\nWholesale / Press\nOther", 'spiraclethemes-site-library' ),
				'rows' => 6,
				'condition' => [
					'show_topic' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_order',
			[
				'label' => esc_html__( 'Show Order # Field', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_message',
			[
				'label' => esc_html__( 'Show Message Field', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'submit_text',
			[
				'label' => esc_html__( 'Submit Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Send Message', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'submit_link',
			[
				'label' => esc_html__( 'Submit Form Action (URL)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-handler.com/submit', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'description' => esc_html__( 'Leave empty for a non-submitting placeholder form.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'form_note',
			[
				'label' => esc_html__( 'Form Note', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'By submitting, you agree to our Privacy Policy. We never share your info.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Info Cards ───────────────────────────────────
		$this->start_controls_section(
			'section_info',
			[
				'label' => esc_html__( 'Info Cards', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'info_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa-regular fa-question-circle',
					'library' => 'fa-regular',
				],
				'recommended' => [
					'fa-regular' => [ 'envelope', 'comment-dots', 'question-circle' ],
					'fa-solid'   => [ 'phone', 'map-marker-alt', 'comment-dots' ],
				],
			]
		);

		$repeater->add_control(
			'info_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Email us', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'info_lines',
			[
				'label' => esc_html__( 'Lines (one per line)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "hello@shopzen.com\nsupport@shopzen.com", 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Lines containing @ and a dot are auto-linked as mailto.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'info_cards',
			[
				'label' => esc_html__( 'Info Cards', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'info_icon'   => [ 'value' => 'fa-regular fa-envelope', 'library' => 'fa-regular' ],
						'info_title'  => esc_html__( 'Email us', 'spiraclethemes-site-library' ),
						'info_lines'  => "hello@shopzen.com\nsupport@shopzen.com",
					],
					[
						'info_icon'   => [ 'value' => 'fa-solid fa-phone', 'library' => 'fa-solid' ],
						'info_title'  => esc_html__( 'Call us', 'spiraclethemes-site-library' ),
						'info_lines'  => esc_html__( "+1 (800) 555-0142\nMon–Fri, 9am–6pm EST", 'spiraclethemes-site-library' ),
					],
					[
						'info_icon'   => [ 'value' => 'fa-regular fa-comment-dots', 'library' => 'fa-regular' ],
						'info_title'  => esc_html__( 'Live chat', 'spiraclethemes-site-library' ),
						'info_lines'  => esc_html__( "Available on site 9am–9pm EST\nAverage reply: 2 minutes", 'spiraclethemes-site-library' ),
					],
					[
						'info_icon'   => [ 'value' => 'fa-solid fa-map-marker-alt', 'library' => 'fa-solid' ],
						'info_title'  => esc_html__( 'Visit', 'spiraclethemes-site-library' ),
						'info_lines'  => esc_html__( "Shop Zen Studio\n124 Greenway Ave, Brooklyn, NY 11201", 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ info_title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Map Card ──────────────────────────────────────
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__( 'Map Card', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_map',
			[
				'label' => esc_html__( 'Show Map Card', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'map_title',
			[
				'label' => esc_html__( 'Map Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Brooklyn Flagship', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'show_map' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_text',
			[
				'label' => esc_html__( 'Map Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Open daily 11am–7pm. Come say hi, see materials in person, and try bestsellers.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'condition' => [
					'show_map' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_embed_url',
			[
				'label' => esc_html__( 'Google Maps Embed URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://www.google.com/maps/embed?pb=...', 'spiraclethemes-site-library' ),
				'description' => wp_kses_post( __( 'Paste the "src" URL from Google Maps → Share → Embed a map. Leave empty to use the address below.', 'spiraclethemes-site-library' ) ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => [
					'show_map' => 'yes',
				],
			]
		);

		$this->add_control(
			'map_address',
			[
				'label' => esc_html__( 'Map Address (fallback)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '124 Greenway Ave, Brooklyn, NY 11201', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Used to build the embed automatically when no Embed URL is provided.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'default' => esc_html__( '124 Greenway Ave, Brooklyn, NY 11201', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_map' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Layout ──────────────────────────────────────────
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'wrap_max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'panels_gap',
			[
				'label' => esc_html__( 'Panels Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 48 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'info_gap',
			[
				'label' => esc_html__( 'Info Cards Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-stack' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Form Card ───────────────────────────────────────
		$this->start_controls_section(
			'section_form_card_style',
			[
				'label' => esc_html__( 'Form Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__( 'Card Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 32, 'right' => 32, 'bottom' => 32, 'left' => 32,
					'unit' => 'px', 'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'label' => esc_html__( 'Card Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-card',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_title_typography',
				'label' => esc_html__( 'Heading Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-card-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 26 ] ],
					'font_weight' => [ 'default' => 800 ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'em', 'size' => -0.02 ] ],
				],
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label' => esc_html__( 'Heading Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_decorator_color',
			[
				'label' => esc_html__( 'Decorator Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card::before' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'card_lead_typography',
				'label' => esc_html__( 'Lead Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-card-lead',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'card_lead_color',
			[
				'label' => esc_html__( 'Lead Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-card-lead' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: Form Fields ────────────────────────────────────
		$this->start_controls_section(
			'section_fields_style',
			[
				'label' => esc_html__( 'Form Fields', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'field_bg',
			[
				'label' => esc_html__( 'Field Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FCFCFB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-field input' => 'background: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-field select' => 'background: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-field textarea' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-field input' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-field select' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-field textarea' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_focus_color',
			[
				'label' => esc_html__( 'Focus Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-field input:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-field select:focus' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-field textarea:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'field_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
				'default' => [ 'unit' => 'px', 'size' => 10 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-field input' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopzen-cw-field select' => 'border-radius: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopzen-cw-field textarea' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_gap',
			[
				'label' => esc_html__( 'Fields Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => esc_html__( 'Label Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-field label',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.4 ] ],
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-field label' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: Submit Button ──────────────────────────────────
		$this->start_controls_section(
			'section_submit_style',
			[
				'label' => esc_html__( 'Submit Button', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'submit_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-submit' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#163322',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-submit:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0f2316',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-submit' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-submit' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'submit_typography',
				'label' => esc_html__( 'Button Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-submit',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.3 ] ],
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Info Cards ────────────────────────────────────
		$this->start_controls_section(
			'section_info_style',
			[
				'label' => esc_html__( 'Info Cards', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'info_bg',
			[
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'info_shadow',
				'label' => esc_html__( 'Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-info',
			]
		);

		$this->add_control(
			'info_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E9EFE9',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-icon' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'info_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_icon_border',
			[
				'label' => esc_html__( 'Icon Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D4E2D1',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'info_title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-info-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.3 ] ],
				],
			]
		);

		$this->add_control(
			'info_title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-title' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'info_text_typography',
				'label' => esc_html__( 'Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-info-text',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.5 ] ],
				],
			]
		);

		$this->add_control(
			'info_text_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-text' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cw-info-text a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'info_link_hover_color',
			[
				'label' => esc_html__( 'Link Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-info-text a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Map Card ───────────────────────────────────────
		$this->start_controls_section(
			'section_map_style',
			[
				'label' => esc_html__( 'Map Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'map_bg',
			[
				'label' => esc_html__( 'Map Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E9EFE9',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-map-frame' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'map_height',
			[
				'label' => esc_html__( 'Map Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 100, 'max' => 500 ] ],
				'default' => [ 'unit' => 'px', 'size' => 220 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-map-frame' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'map_content_bg',
			[
				'label' => esc_html__( 'Content Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-map-content' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'map_title_typography',
				'label' => esc_html__( 'Map Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cw-map-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.4 ] ],
				],
			]
		);

		$this->add_control(
			'map_title_color',
			[
				'label' => esc_html__( 'Map Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-map-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'map_text_color',
			[
				'label' => esc_html__( 'Map Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cw-map-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/contact-wrap/template/view.php';
	}
}
