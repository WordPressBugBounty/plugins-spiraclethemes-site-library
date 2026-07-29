<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Page_Title extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-page-title';
	}

	public function get_title() {
		return __( 'Page Title', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'page title', 'hero', 'heading', 'about', 'zen', 'banner' ];
	}

	protected function register_controls() {

		// ─── Content ───────────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'pill_text',
			[
				'label' => esc_html__( 'Pill Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Since 2018', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter pill text', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'show_pill',
			[
				'label' => esc_html__( 'Show Pill', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'title_before',
			[
				'label' => esc_html__( 'Title (First Line)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Rooted in Nature,', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_highlight',
			[
				'label' => esc_html__( 'Title (Highlight Line)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Designed for Life', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'subtext',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'We create modern essentials that feel good, do good, and last longer. Thoughtfully sourced, beautifully made, and designed to elevate your everyday — without costing the earth.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => esc_html__( 'Title Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => false,
					'nofollow' => false,
				],
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
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 90, 'right' => 16, 'bottom' => 100, 'left' => 16,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => esc_html__( 'Content Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 400, 'max' => 1200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 860 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-center' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F9F7F2',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'dotted_texture',
			[
				'label' => esc_html__( 'Dotted Texture', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'dot_color',
			[
				'label' => esc_html__( 'Dot Texture Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(58,95,63,0.07)',
				'condition' => [
					'dotted_texture' => 'yes',
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
					'{{WRAPPER}} .shopzen-pt-center' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'flex',
					'' => 'block',
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
					'{{WRAPPER}} .shopzen-pt-center::before' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'show_corner_accent' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Pill ───────────────────────────────────────────
		$this->start_controls_section(
			'section_pill_style',
			[
				'label' => esc_html__( 'Pill', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_pill' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'pill_typography',
				'label' => esc_html__( 'Pill Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pt-pill',
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
			'pill_bg',
			[
				'label' => esc_html__( 'Pill Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-pill' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_color',
			[
				'label' => esc_html__( 'Pill Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3F4A3C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-pill' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_border_color',
			[
				'label' => esc_html__( 'Pill Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-pill' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pill_dot_color',
			[
				'label' => esc_html__( 'Pill Dot Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8BA888',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-pill-dot' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pill_dot_size',
			[
				'label' => esc_html__( 'Pill Dot Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 2, 'max' => 16 ] ],
				'default' => [ 'unit' => 'px', 'size' => 6 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-pill-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pill_spacing',
			[
				'label' => esc_html__( 'Pill Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-pill' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ───────────────────────────────────────────
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pt-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 64 ] ],
					'font_weight' => [ 'default' => 800 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.05 ] ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => -0.5 ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'highlight_color',
			[
				'label' => esc_html__( 'Highlight Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4A6B3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-green' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Title Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Sub Text ───────────────────────────────────────
		$this->start_controls_section(
			'section_subtext_style',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtext_typography',
				'label' => esc_html__( 'Sub Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pt-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 17 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.65 ] ],
				],
			]
		);

		$this->add_control(
			'subtext_color',
			[
				'label' => esc_html__( 'Sub Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtext_max_width',
			[
				'label' => esc_html__( 'Sub Text Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 200, 'max' => 900 ] ],
				'default' => [ 'unit' => 'px', 'size' => 640 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pt-sub' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/page-title/template/view.php';
	}
}
