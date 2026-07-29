<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Categories extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-categories';
	}

	public function get_title() {
		return __( 'Categories', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'categories', 'shop', 'grid', 'collection', 'cards', 'zen' ];
	}

	protected function register_controls() {

		// ─── Content: Section Head ──────────────────────────────────
		$this->start_controls_section(
			'section_head',
			[
				'label' => esc_html__( 'Section Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop by Category', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter heading', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'section_subtext',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Find exactly what you need from our curated collections', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter sub text', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		// ─── Content: Category Cards ────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Categories', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'cat_image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'cat_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Electronics', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter label', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'cat_link',
			[
				'label' => esc_html__( 'Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Category Cards', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'cat_label' => esc_html__( 'Electronics', 'spiraclethemes-site-library' ),
					],
					[
						'cat_label' => esc_html__( 'Home & Living', 'spiraclethemes-site-library' ),
					],
					[
						'cat_label' => esc_html__( 'Fashion', 'spiraclethemes-site-library' ),
					],
					[
						'cat_label' => esc_html__( 'Beauty', 'spiraclethemes-site-library' ),
					],
					[
						'cat_label' => esc_html__( 'Accessories', 'spiraclethemes-site-library' ),
					],
					[
						'cat_label' => esc_html__( 'Sports', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ cat_label }}}',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'cat_image_size',
				'default' => 'medium_large',
				'exclude' => [ 'custom' ],
			]
		);

		$this->end_controls_section();


		// ─── Style: Layout ─────────────────────────────────────────
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 8,
				'step' => 1,
				'default' => 6,
				'tablet_default' => 3,
				'mobile_default' => 2,
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'card_aspect',
			[
				'label' => esc_html__( 'Card Aspect Ratio', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4 / 5',
				'options' => [
					'4 / 5'  => esc_html__( '4:5 (Portrait)', 'spiraclethemes-site-library' ),
					'1 / 1'  => esc_html__( '1:1 (Square)', 'spiraclethemes-site-library' ),
					'3 / 4'  => esc_html__( '3:4 (Portrait)', 'spiraclethemes-site-library' ),
					'2 / 3'  => esc_html__( '2:3 (Tall)', 'spiraclethemes-site-library' ),
					'16 / 9' => esc_html__( '16:9 (Wide)', 'spiraclethemes-site-library' ),
					'4 / 3'  => esc_html__( '4:3 (Landscape)', 'spiraclethemes-site-library' ),
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 12 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrap_max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1280 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 40,
					'right' => 0,
					'bottom' => 40,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'head_spacing',
			[
				'label' => esc_html__( 'Heading Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 26 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ───────────────────────────────────────────
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
				'default' => '#F6F6F6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-cat-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_size',
			[
				'label' => esc_html__( 'Border Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'label' => esc_html__( 'Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cat-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_hover_shadow',
				'label' => esc_html__( 'Hover Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cat-card:hover',
			]
		);

		$this->add_control(
			'hover_lift',
			[
				'label' => esc_html__( 'Lift on Hover', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card:hover' => 'transform: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'translateY(-2px)',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'card_transition',
			[
				'label' => esc_html__( 'Transition (sec)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 2, 'step' => 0.05 ] ],
				'default' => [ 'unit' => 'px', 'size' => 0.2 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card' => 'transition: transform {{SIZE}}s ease, box-shadow {{SIZE}}s ease;',
					'{{WRAPPER}} .shopzen-cat-card img' => 'transition: transform {{SIZE}}s ease;',
				],
			]
		);

		$this->add_control(
			'corner_accent_heading',
			[
				'label' => esc_html__( 'Corner Accent', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_corner_accent',
			[
				'label' => esc_html__( 'Show Corner Accent', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card::before' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'block',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'corner_accent_color',
			[
				'label' => esc_html__( 'Corner Accent Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card::before' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'show_corner_accent' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ───────────────────────────────────────────
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_hover_zoom',
			[
				'label' => esc_html__( 'Zoom on Hover', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card:hover img' => 'transform: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'scale(1.06)',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'image_overlay',
			[
				'label' => esc_html__( 'Hover Overlay', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(30,63,42,0.18)',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-card' => 'box-shadow: inset 0 0 0 2000px transparent;',
					'{{WRAPPER}} .shopzen-cat-card:hover' => 'box-shadow: inset 0 0 0 2000px {{VALUE}};',
				],
				'condition' => [
					'image_overlay' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Label ───────────────────────────────────────────
		$this->start_controls_section(
			'section_label_style',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cat-label',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 11 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.2 ] ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.4 ] ],
				],
			]
		);

		$this->add_control(
			'label_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-label' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1F2937',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-label' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'label_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 999 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-label' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 6,
					'right' => 14,
					'bottom' => 6,
					'left' => 14,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'label_position',
			[
				'label' => esc_html__( 'Vertical Position (px from bottom)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 10 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-label' => 'bottom: {{SIZE}}{{UNIT}};',
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
				'name' => 'heading_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cat-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 34 ] ],
					'font_weight' => [ 'default' => 800 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.1 ] ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => -0.5 ] ],
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_align',
			[
				'label' => esc_html__( 'Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
					'right' => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-right' ],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-head' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'decorators_heading',
			[
				'label' => esc_html__( 'Decorators (•••)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_decorators',
			[
				'label' => esc_html__( 'Show Decorators', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-title::before' => 'display: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cat-title::after' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'inline-block',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'decorator_color',
			[
				'label' => esc_html__( 'Decorator Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-title::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-cat-title::after' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_decorators' => 'yes',
				],
			]
		);

		$this->add_control(
			'subtext_heading',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtext_typography',
				'label' => esc_html__( 'Sub Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cat-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
				],
			]
		);

		$this->add_control(
			'subtext_color',
			[
				'label' => esc_html__( 'Sub Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtext_max_width',
			[
				'label' => esc_html__( 'Sub Text Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 240, 'max' => 800 ] ],
				'default' => [ 'unit' => 'px', 'size' => 560 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cat-sub' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/categories/template/view.php';
	}
}
