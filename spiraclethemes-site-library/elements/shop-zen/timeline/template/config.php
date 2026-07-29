<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Timeline extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-timeline';
	}

	public function get_title() {
		return __( 'Timeline', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-time-line';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'timeline', 'journey', 'milestone', 'history', 'about', 'zen' ];
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
				'default' => esc_html__( 'Our Journey', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter heading', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'section_subtext',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'From kitchen table to community favorite', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		// ─── Content: Timeline Items ────────────────────────────────
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Timeline Items', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tl_year',
			[
				'label' => esc_html__( 'Year', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '2018', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'tl_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Started in a garage', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'tl_description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Launched with 3 products and a mission to prove sustainable could be beautiful.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'timeline_items',
			[
				'label' => esc_html__( 'Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tl_year'        => '2018',
						'tl_title'       => esc_html__( 'Started in a garage', 'spiraclethemes-site-library' ),
						'tl_description' => esc_html__( 'Launched with 3 products and a mission to prove sustainable could be beautiful.', 'spiraclethemes-site-library' ),
					],
					[
						'tl_year'        => '2020',
						'tl_title'       => esc_html__( 'Carbon neutral certified', 'spiraclethemes-site-library' ),
						'tl_description' => esc_html__( 'Offset 100% of emissions and switched to plastic-free shipping worldwide.', 'spiraclethemes-site-library' ),
					],
					[
						'tl_year'        => '2022',
						'tl_title'       => esc_html__( 'Opened repair studio', 'spiraclethemes-site-library' ),
						'tl_description' => esc_html__( 'Customers can now send any Natura product back for free repairs for life.', 'spiraclethemes-site-library' ),
					],
					[
						'tl_year'        => '2025',
						'tl_title'       => esc_html__( '1M trees planted', 'spiraclethemes-site-library' ),
						'tl_description' => esc_html__( 'Reached our milestone with Eden Reforestation Projects across 4 continents.', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ tl_year }}} — {{{ tl_title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Style: Section Heading ─────────────────────────────────
		$this->start_controls_section(
			'section_head_style',
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
				'selector' => '{{WRAPPER}} .shopzen-tl-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 36 ] ],
					'font_weight' => [ 'default' => 800 ],
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
					'{{WRAPPER}} .shopzen-tl-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_decorators',
			[
				'label' => esc_html__( 'Show Decorators (•••)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-title::before' => 'display: {{VALUE}};',
					'{{WRAPPER}} .shopzen-tl-title::after' => 'display: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-tl-title::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-tl-title::after' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_decorators' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtext_typography',
				'label' => esc_html__( 'Sub Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-tl-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
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
					'{{WRAPPER}} .shopzen-tl-sub' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'head_spacing',
			[
				'label' => esc_html__( 'Head Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 32 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Timeline ────────────────────────────────────────
		$this->start_controls_section(
			'section_timeline_style',
			[
				'label' => esc_html__( 'Timeline', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'line_color',
			[
				'label' => esc_html__( 'Center Line Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-timeline::before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_gap',
			[
				'label' => esc_html__( 'Item Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'year_typography',
				'label' => esc_html__( 'Year Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-tl-year',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 22 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_control(
			'year_color',
			[
				'label' => esc_html__( 'Year Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-year' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'node_color',
			[
				'label' => esc_html__( 'Node Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-year::after' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'node_bg',
			[
				'label' => esc_html__( 'Node Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-year::after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_title_typography',
				'label' => esc_html__( 'Item Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-tl-content h4',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 18 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_control(
			'item_title_color',
			[
				'label' => esc_html__( 'Item Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-content h4' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'item_desc_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-tl-content p',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
				],
			]
		);

		$this->add_control(
			'item_desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .shopzen-tl-content p' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/timeline/template/view.php';
	}
}
