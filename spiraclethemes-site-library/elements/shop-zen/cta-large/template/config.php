<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_CTA_Large extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-cta-large';
	}

	public function get_title() {
		return __( 'CTA Large', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'cta', 'call to action', 'banner', 'about', 'shop', 'zen' ];
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
			'heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Join us in building better everyday', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'subtext',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Shop our collection of modern essentials, or read our annual impact report to see exactly where your money goes.', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop Collection', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'spiraclethemes-site-library' ),
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
			'show_arrow',
			[
				'label' => esc_html__( 'Show Arrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_deco',
			[
				'label' => esc_html__( 'Show Decorative Circle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
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
			'wrap_max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 400, 'max' => 1400 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1000 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'top' => 64, 'right' => 0, 'bottom' => 64, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Box Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 48, 'right' => 32, 'bottom' => 48, 'left' => 32,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'box_bg',
			[
				'label' => esc_html__( 'Box Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Box Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0f2316',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'box_radius',
			[
				'label' => esc_html__( 'Box Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'label' => esc_html__( 'Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-bcta-box',
			]
		);

		$this->end_controls_section();


		// ─── Style: Text ───────────────────────────────────────────
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
				'name' => 'heading_typography',
				'label' => esc_html__( 'Heading Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-bcta-heading',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 32 ] ],
					'font_weight' => [ 'default' => 800 ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => -0.5 ] ],
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Heading Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 10 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtext_typography',
				'label' => esc_html__( 'Sub Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-bcta-sub',
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
			'subtext_color',
			[
				'label' => esc_html__( 'Sub Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#CBD5CE',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtext_max_width',
			[
				'label' => esc_html__( 'Sub Text Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 200, 'max' => 800 ] ],
				'default' => [ 'unit' => 'px', 'size' => 520 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-sub' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'subtext_spacing',
			[
				'label' => esc_html__( 'Sub Text Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 22 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-sub' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Button ──────────────────────────────────────────
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'label' => esc_html__( 'Button Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-bcta-btn',
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

		$this->add_control(
			'button_bg',
			[
				'label' => esc_html__( 'Button Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-btn' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => esc_html__( 'Button Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg',
			[
				'label' => esc_html__( 'Button Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F8FAF6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-btn:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Button Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 13, 'right' => 26, 'bottom' => 13, 'left' => 26,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_radius',
			[
				'label' => esc_html__( 'Button Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 999 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Decoration ──────────────────────────────────────
		$this->start_controls_section(
			'section_deco_style',
			[
				'label' => esc_html__( 'Decorative Circle', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_deco' => 'yes',
				],
			]
		);

		$this->add_control(
			'deco_color',
			[
				'label' => esc_html__( 'Circle Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.08)',
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box::before' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'deco_size',
			[
				'label' => esc_html__( 'Circle Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 40, 'max' => 400 ] ],
				'default' => [ 'unit' => 'px', 'size' => 160 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box::before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'deco_offset',
			[
				'label' => esc_html__( 'Circle Offset (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
				'default' => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-bcta-box::before' => 'top: -{{SIZE}}{{UNIT}}; right: -{{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/cta-large/template/view.php';
	}
}
