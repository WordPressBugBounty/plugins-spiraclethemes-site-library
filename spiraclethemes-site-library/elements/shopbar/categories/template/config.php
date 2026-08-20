<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shopbar_Categories extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-categories';
	}

	public function get_title() {
		return __( 'Categories', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-product-categories';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'categories', 'shop', 'grid', 'collection', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Categories ────────────────────────────────────
		$this->start_controls_section(
			'section_categories',
			[
				'label' => esc_html__( 'Categories', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Electronics', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle / Offer', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Up to 40% Off', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'badge',
			[
				'label' => esc_html__( 'Badge (optional)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
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

		$default_categories = [
			[ 'title' => __( 'Electronics', 'spiraclethemes-site-library' ),    'subtitle' => __( 'Up to 40% Off', 'spiraclethemes-site-library' ) ],
			[ 'title' => __( 'Fashion', 'spiraclethemes-site-library' ),         'subtitle' => __( 'New Collection', 'spiraclethemes-site-library' ) ],
			[ 'title' => __( 'Home & Kitchen', 'spiraclethemes-site-library' ),  'subtitle' => __( 'Best Deals', 'spiraclethemes-site-library' ) ],
			[ 'title' => __( 'Beauty', 'spiraclethemes-site-library' ),          'subtitle' => __( 'Top Picks', 'spiraclethemes-site-library' ) ],
			[ 'title' => __( 'Sports', 'spiraclethemes-site-library' ),          'subtitle' => __( 'Up to 30% Off', 'spiraclethemes-site-library' ) ],
			[ 'title' => __( 'Toys & Games', 'spiraclethemes-site-library' ),    'subtitle' => __( 'Fun For All', 'spiraclethemes-site-library' ) ],
		];

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Category Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default_categories,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Section Header ────────────────────────────────
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_header',
			[
				'label' => esc_html__( 'Show Header', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'header_eyebrow',
			[
				'label' => esc_html__( 'Eyebrow / Pre-title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Browse Collections', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_header' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'header_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop by Category', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_header' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'header_desc',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Explore our most popular departments and find exactly what you need.', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_header' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'header_align',
			[
				'label' => esc_html__( 'Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'start'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
					'end'    => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),  'icon' => 'eicon-text-align-right' ],
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-head' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
				],
				'condition' => [ 'show_header' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ────────────────────────────────────────
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range' => [ '' => [ 'min' => 1, 'max' => 6, 'step' => 1 ] ],
				'default' => [ 'unit' => '', 'size' => 6 ],
				'tablet_default' => [ 'unit' => '', 'size' => 3 ],
				'mobile_default' => [ 'unit' => '', 'size' => 2 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-grid' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label' => esc_html__( 'Image Fit', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'cover',
				'options' => [
					'contain' => [ 'title' => esc_html__( 'Contain', 'spiraclethemes-site-library' ), 'icon' => 'eicon-image' ],
					'cover'   => [ 'title' => esc_html__( 'Cover', 'spiraclethemes-site-library' ),   'icon' => 'eicon-full-screen' ],
				],
				'toggle' => false,
			]
		);

		$this->add_control(
			'show_arrow',
			[
				'label' => esc_html__( 'Show Arrow CTA', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Style: Section Header ──────────────────────────────────
		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_header' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_eyebrow_typography',
				'label' => esc_html__( 'Eyebrow Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12.5 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
				],
			]
		);

		$this->add_control(
			'header_eyebrow_color',
			[
				'label' => esc_html__( 'Eyebrow Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-heading',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 30 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_control(
			'header_title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_desc_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'header_desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'header_spacing',
			[
				'label' => esc_html__( 'Header Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default' => [ 'unit' => 'px', 'size' => 28 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Cards ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Cards', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'selector' => '{{WRAPPER}} .shopbar-cg-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#E8E2DA' ],
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'selector' => '{{WRAPPER}} .shopbar-cg-card',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical' => 6,
							'blur' => 22,
							'spread' => -8,
							'color' => 'rgba(28, 28, 28, 0.08)',
							'is_inset' => '',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow_hover',
				'label' => esc_html__( 'Hover Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-card:hover',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical' => 18,
							'blur' => 40,
							'spread' => -12,
							'color' => 'rgba(184, 151, 126, 0.22)',
							'is_inset' => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__( 'Body Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 16, 'right' => 14, 'bottom' => 16, 'left' => 14, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_bg',
			[
				'label' => esc_html__( 'Stage Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F3EFEA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-media' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_height',
			[
				'label' => esc_html__( 'Image Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 60, 'max' => 400 ] ],
				'default' => [ 'unit' => 'px', 'size' => 150 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-media' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_zoom',
			[
				'label' => esc_html__( 'Hover Zoom', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 100, 'max' => 130 ] ],
				'default' => [ 'unit' => 'px', 'size' => 110 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card:hover .shopbar-cg-img' => 'transform: scale(calc({{SIZE}} / 100));',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card:hover .shopbar-cg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Subtitle ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => esc_html__( 'Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-badge' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_radius',
			[
				'label' => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 30 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_spacing',
			[
				'label' => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 4, 'right' => 10, 'bottom' => 4, 'left' => 10, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cg-badge',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 11 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Arrow ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_arrow',
			[
				'label' => esc_html__( 'Arrow CTA', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_arrow' => 'yes' ],
			]
		);

		$this->add_control(
			'arrow_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-arrow' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card:hover .shopbar-cg-arrow' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-card:hover .shopbar-cg-arrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrow_size',
			[
				'label' => esc_html__( 'Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 24, 'max' => 72 ] ],
				'default' => [ 'unit' => 'px', 'size' => 38 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'arrow_radius',
			[
				'label' => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 30 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cg-arrow' => 'border-radius: {{SIZE}}{{UNIT}};',
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
