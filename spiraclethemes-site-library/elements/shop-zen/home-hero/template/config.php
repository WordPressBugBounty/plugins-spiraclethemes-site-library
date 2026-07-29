<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_HomeHero extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-home-hero';
	}

	public function get_title() {
		return __( 'Home Hero', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'hero', 'banner', 'shop', 'zen', 'landing', 'cta' ];
	}

	protected function register_controls() {

		// ─── Content Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow_text',
			[
				'label' => esc_html__( 'Eyebrow / Pill Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'New Collection', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter pill text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Elevate Your', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter title', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_title_accent',
			[
				'label' => esc_html__( 'Title Accent (Highlighted Part)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Everyday', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter accent text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_title_accent_newline',
			[
				'label' => esc_html__( 'Place Accent on New Line', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-title .green' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'block',
					'' => 'inline-block',
				],
			]
		);

		$this->add_control(
			'hero_description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Modern essentials, crafted for comfort, quality & style.', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter description', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'primary_btn_text',
			[
				'label' => esc_html__( 'Primary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop Now', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter button text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'primary_btn_url',
			[
				'label' => esc_html__( 'Primary Button URL', 'spiraclethemes-site-library' ),
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
			'primary_btn_icon',
			[
				'label' => esc_html__( 'Primary Button Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa-solid fa-arrow-right',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'arrow-right', 'shopping-bag', 'cart-plus' ] ],
			]
		);

		$this->add_control(
			'secondary_btn_text',
			[
				'label' => esc_html__( 'Secondary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Explore Collections', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter button text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'secondary_btn_url',
			[
				'label' => esc_html__( 'Secondary Button URL', 'spiraclethemes-site-library' ),
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

		$this->end_controls_section();


		// ─── Sale Badge Section ─────────────────────────────────────
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Sale Badge', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_sale_badge',
			[
				'label' => esc_html__( 'Show Sale Badge', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'badge_top_text',
			[
				'label' => esc_html__( 'Top Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'UP TO', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_sale_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_main_text',
			[
				'label' => esc_html__( 'Main Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '40%', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_sale_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_bottom_text',
			[
				'label' => esc_html__( 'Bottom Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'OFF', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_sale_badge' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Background & Layout ────────────────────────────
		$this->start_controls_section(
			'section_bg_style',
			[
				'label' => esc_html__( 'Background & Layout', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'hero_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F9F7F2',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dot_pattern_color',
			[
				'label' => esc_html__( 'Dot Pattern Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => true,
				'default' => 'rgba(58,95,63,0.07)',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh' => 'background-image: radial-gradient({{VALUE}} 1px, transparent 1px), radial-gradient(rgba(58,95,63,0.04) 1px, transparent 1px); background-size: 20px 20px, 10px 10px; background-position: 0 0, 10px 10px;',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 80,
					'right' => 0,
					'bottom' => 100,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_max_width',
			[
				'label' => esc_html__( 'Content Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1280 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_max_width',
			[
				'label' => esc_html__( 'Heading Block Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 480, 'max' => 1200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 860 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-center' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
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
					'{{WRAPPER}} .shopzen-hh' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .shopzen-hh-center' => 'align-items: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'left' => 'flex-start',
					'center' => 'center',
					'right' => 'flex-end',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Eyebrow ────────────────────────────────────────
		$this->start_controls_section(
			'section_eyebrow_style',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'eyebrow_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-hh-pill',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3F4A3C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-pill' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eyebrow_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-pill' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eyebrow_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-pill' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-hh-pill-dot' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ──────────────────────────────────────────
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
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-hh-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 68 ] ],
					'font_weight' => [ 'default' => 800 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.02 ] ],
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
					'{{WRAPPER}} .shopzen-hh-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Accent (Highlighted) Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4A6B3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-title .green' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_decor_color',
			[
				'label' => esc_html__( 'Accent Decorator Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-title .green::after' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Description ────────────────────────────────────
		$this->start_controls_section(
			'section_desc_style',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-hh-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4B5563',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desc_max_width',
			[
				'label' => esc_html__( 'Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 240, 'max' => 800 ] ],
				'default' => [ 'unit' => 'px', 'size' => 560 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sub' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Buttons ────────────────────────────────────────
		$this->start_controls_section(
			'section_buttons_style',
			[
				'label' => esc_html__( 'Buttons', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-hh-cta a',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
				],
			]
		);

		$this->add_control(
			'primary_btn_bg',
			[
				'label' => esc_html__( 'Primary Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-primary' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_color',
			[
				'label' => esc_html__( 'Primary Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-primary' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-hh-btn-primary i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-hh-btn-primary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_hover_bg',
			[
				'label' => esc_html__( 'Primary Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#163322',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-primary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_radius',
			[
				'label' => esc_html__( 'Primary Border Radius', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-primary' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_color',
			[
				'label' => esc_html__( 'Secondary Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1F2937',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_border_color',
			[
				'label' => esc_html__( 'Secondary Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D1D5DB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-link' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_hover_color',
			[
				'label' => esc_html__( 'Secondary Hover Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1F2937',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-btn-link:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Sale Badge ────────────────────────────────────
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => esc_html__( 'Sale Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_sale_badge' => 'yes',
				],
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_radius',
			[
				'label' => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 50 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'border-radius: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'badge_size',
			[
				'label' => esc_html__( 'Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 60, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 104 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_position_heading',
			[
				'label' => esc_html__( 'Position', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'badge_position_top',
			[
				'label' => esc_html__( 'Top (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 28 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_right',
			[
				'label' => esc_html__( 'Right (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 72 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-hh-sale-badge' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/home-hero/template/view.php';
	}
}
