<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_WhyChooseUs extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-why-choose-us';
	}

	public function get_title() {
		return __( 'Why Choose Us', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-favorite';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'why', 'choose', 'values', 'features', 'benefits', 'pawwell', 'services' ];
	}

	protected function register_controls() {

		// ─── Heading Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Why Pet Parents Love Us', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'More Than Just a Store', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "We're your partner in keeping your pets healthy, happy, and thriving", 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Value Cards Section ────────────────────────────────────
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Value Cards', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-stethoscope',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'stethoscope', 'clipboard-list', 'sync', 'paw', 'heart', 'shield-alt', 'truck', 'leaf', 'medal', 'users' ] ],
			]
		);

		$repeater->add_control(
			'item_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8F0FE',
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2D9CDB',
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Online Vet Consultations', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'item_subtitle',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Connect with licensed veterinarians from home. Get expert advice, prescriptions, and peace of mind — available 24/7.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title' => esc_html__( 'Online Vet Consultations', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( 'Connect with licensed veterinarians from home. Get expert advice, prescriptions, and peace of mind — available 24/7.', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#E8F0FE',
						'item_icon_color' => '#2D9CDB',
						'item_icon' => [ 'value' => 'fas fa-stethoscope', 'library' => 'fa-solid' ],
					],
					[
						'item_title' => esc_html__( 'Personalized Pet Profiles', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( 'Create profiles for each pet to get tailored nutrition plans, vaccination reminders, and product recommendations.', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#E8EFE3',
						'item_icon_color' => '#5E7350',
						'item_icon' => [ 'value' => 'fas fa-clipboard-list', 'library' => 'fa-solid' ],
					],
					[
						'item_title' => esc_html__( 'Auto-Refill Subscriptions', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( 'Never run out of essentials. Subscribe and save 15% on recurring orders with flexible, cancel-anytime plans.', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#F4E0DA',
						'item_icon_color' => '#C45B3E',
						'item_icon' => [ 'value' => 'fas fa-sync', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Boxes Per Row', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'columns_help',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'The number of rows is determined automatically by the total items divided by boxes per row.', 'spiraclethemes-site-library' ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->end_controls_section();


		// ─── Style: Section ─────────────────────────────────────────
		$this->start_controls_section(
			'section_section_style',
			[
				'label' => esc_html__( 'Section', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 80, 'right' => 32, 'bottom' => 80, 'left' => 32,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FAF7F2',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_border_top',
			[
				'label' => esc_html__( 'Top Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'show_border_bottom',
			[
				'label' => esc_html__( 'Bottom Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'full_width_border',
			[
				'label' => esc_html__( 'Full Width Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
				'description' => esc_html__( 'Stretch the borders edge-to-edge across the full section. Off = borders span the content width only.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[ 'name' => 'show_border_top', 'operator' => '===', 'value' => 'yes' ],
						[ 'name' => 'show_border_bottom', 'operator' => '===', 'value' => 'yes' ],
					],
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[ 'name' => 'show_border_top', 'operator' => '===', 'value' => 'yes' ],
						[ 'name' => 'show_border_bottom', 'operator' => '===', 'value' => 'yes' ],
					],
				],
			]
		);

		$this->add_control(
			'max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 960, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1280 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Heading ─────────────────────────────────────────
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eyebrow_typography',
				'label' => esc_html__( 'Eyebrow Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-wcu-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 1.5 ] ],
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Eyebrow Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-wcu-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 36 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_responsive_control(
			'heading_align',
			[
				'label' => esc_html__( 'Heading Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-right',
					],
				],
			'default' => 'center',
			'selectors' => [
				'{{WRAPPER}} .pawwell-wcu-head' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
			],
		]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-wcu-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 44 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ────────────────────────────────────────────
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-card' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 38, 'right' => 26, 'bottom' => 38, 'left' => 26,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_align',
			[
				'label' => esc_html__( 'Text Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-card' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .pawwell-wcu-icon' => 'justify-content: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'left' => 'flex-start',
					'center' => 'center',
				],
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label' => esc_html__( 'Hover Effect', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Style: Icon ────────────────────────────────────────────
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_box_size',
			[
				'label' => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 36, 'max' => 120 ] ],
				'default' => [ 'unit' => 'px', 'size' => 68 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 14, 'max' => 56 ] ],
				'default' => [ 'unit' => 'px', 'size' => 32 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pawwell-wcu-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Text ────────────────────────────────────────────
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-wcu-value-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 18 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-value-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_sub_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-wcu-value-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'item_sub_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-wcu-value-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/why-choose-us/template/view.php';
	}
}
