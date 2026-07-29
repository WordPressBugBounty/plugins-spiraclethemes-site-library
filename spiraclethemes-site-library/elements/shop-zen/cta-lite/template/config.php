<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_CTA_Lite extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-cta-lite';
	}

	public function get_title() {
		return __( 'CTA Lite', 'spiraclethemes-site-library' );
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
		return [ 'cta', 'call to action', 'banner', 'subscribe', 'shop', 'zen' ];
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
			'icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-envelope',
					'library' => 'fa-regular',
				],
				'description' => esc_html__( 'Icon shown in the white rounded box on the left. Defaults to an envelope (matches the original newsletter design).', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Subscribe & Get 10% OFF', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'subtext',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Join our community for exclusive deals and early access to new collections.', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		// Primary CTA button
		$this->add_control(
			'cta_text',
			[
				'label' => esc_html__( 'Primary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop Now', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'cta_link',
			[
				'label' => esc_html__( 'Primary Button Link', 'spiraclethemes-site-library' ),
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

		// Secondary CTA button
		$this->add_control(
			'cta2_text',
			[
				'label' => esc_html__( 'Secondary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Learn More', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'cta2_link',
			[
				'label' => esc_html__( 'Secondary Button Link', 'spiraclethemes-site-library' ),
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
			'show_cta2',
			[
				'label' => esc_html__( 'Show Secondary Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_leaf_deco',
			[
				'label' => esc_html__( 'Show Leaf Decoration', 'spiraclethemes-site-library' ),
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
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1240 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'bar_padding',
			[
				'label' => esc_html__( 'Bar Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 20, 'right' => 22, 'bottom' => 20, 'left' => 22,
					'unit' => 'px', 'isLinked' => false,
				],
			'selectors' => [
					'{{WRAPPER}} .shopzen-cta .shopzen-cta-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
			]
		);

		$this->add_responsive_control(
			'bar_gap',
			[
				'label' => esc_html__( 'Inner Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
			'selectors' => [
					'{{WRAPPER}} .shopzen-cta .shopzen-cta-inner' => 'gap: {{SIZE}}{{UNIT}};',
			],
			]
		);

		$this->add_control(
			'bar_bg',
			[
				'label' => esc_html__( 'Bar Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#DDE6DA',
			'selectors' => [
					'{{WRAPPER}} .shopzen-cta .shopzen-cta-inner' => 'background: {{VALUE}};',
			],
			'separator' => 'before',
			]
		);

		$this->add_control(
			'bar_border_color',
		[
				'label' => esc_html__( 'Bar Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C8D9C3',
			'selectors' => [
					'{{WRAPPER}} .shopzen-cta .shopzen-cta-inner' => 'border-color: {{VALUE}};',
			],
			]
		);

		$this->add_control(
			'bar_radius',
			[
				'label' => esc_html__( 'Bar Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
			'selectors' => [
					'{{WRAPPER}} .shopzen-cta .shopzen-cta-inner' => 'border-radius: {{SIZE}}{{UNIT}};',
			],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'bar_shadow',
				'label' => esc_html__( 'Bar Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cta .shopzen-cta-inner',
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

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 32, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 44 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 12, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 22 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopzen-cta-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_border_color',
			[
				'label' => esc_html__( 'Icon Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label' => esc_html__( 'Icon Box Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 11 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_left_gap',
			[
				'label' => esc_html__( 'Icon Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 13 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-left' => 'gap: {{SIZE}}{{UNIT}};',
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
				'name' => 'heading_typography',
				'label' => esc_html__( 'Heading Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cta-heading',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 18 ] ],
					'font_weight' => [ 'default' => 800 ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => -0.3 ] ],
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Heading Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1A202C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtext_typography',
				'label' => esc_html__( 'Sub Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cta-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'subtext_color',
			[
				'label' => esc_html__( 'Sub Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3F4A3C',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-sub' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: Buttons ─────────────────────────────────────────
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
				'label' => esc_html__( 'Button Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-cta-btn',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.3 ] ],
				],
			]
		);

		// Primary button
		$this->add_control(
			'primary_btn_heading',
			[
				'label' => esc_html__( 'Primary Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'primary_btn_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-primary' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#13261A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-primary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'primary_btn_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 11, 'right' => 26, 'bottom' => 11, 'left' => 26,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Secondary button
		$this->add_control(
			'secondary_btn_heading',
			[
				'label' => esc_html__( 'Secondary Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'secondary_btn_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-secondary' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_border',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C8D9C3',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-secondary' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'secondary_btn_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 11, 'right' => 26, 'bottom' => 11, 'left' => 26,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn-secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Shared button shape
		$this->add_control(
			'btn_radius',
			[
				'label' => esc_html__( 'Button Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 999 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'btn_group_gap',
			[
				'label' => esc_html__( 'Button Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default' => [ 'unit' => 'px', 'size' => 10 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-right' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Leaf Decoration ─────────────────────────────────
		$this->start_controls_section(
			'section_deco_style',
			[
				'label' => esc_html__( 'Leaf Decoration', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'leaf_color',
			[
				'label' => esc_html__( 'Leaf Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-leaf' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'leaf_opacity',
			[
				'label' => esc_html__( 'Leaf Opacity', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 1, 'step' => 0.01 ] ],
				'default' => [ 'unit' => 'px', 'size' => 0.12 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-cta-leaf' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/cta-lite/template/view.php';
	}
}
