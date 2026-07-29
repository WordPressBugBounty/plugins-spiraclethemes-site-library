<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Features extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-features';
	}

	public function get_title() {
		return __( 'Features', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-check-circle';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'features', 'trust', 'shipping', 'benefits', 'strip', 'shop', 'zen' ];
	}

	protected function register_controls() {

		// ─── Content Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Features', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'feature_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa-solid fa-box-open',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'box-open', 'truck-fast', 'lock', 'credit-card', 'shield-alt', 'rotate-left', 'clock', 'headset', 'star', 'tag', 'gift' ] ],
			]
		);

		$repeater->add_control(
			'feature_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Free Shipping', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter title', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'feature_text',
			[
				'label' => esc_html__( 'Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Orders over $50', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter text', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'features',
			[
				'label' => esc_html__( 'Feature Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'feature_icon' => [ 'value' => 'fa-solid fa-box-open', 'library' => 'fa-solid' ],
						'feature_title' => esc_html__( 'Free Shipping', 'spiraclethemes-site-library' ),
						'feature_text' => esc_html__( 'Orders over $50', 'spiraclethemes-site-library' ),
					],
					[
						'feature_icon' => [ 'value' => 'fa-solid fa-lock', 'library' => 'fa-solid' ],
						'feature_title' => esc_html__( 'Secure Payment', 'spiraclethemes-site-library' ),
						'feature_text' => esc_html__( '100% protected', 'spiraclethemes-site-library' ),
					],
					[
						'feature_icon' => [ 'value' => 'fa-solid fa-shield-alt', 'library' => 'fa-solid' ],
						'feature_title' => esc_html__( 'Easy Returns', 'spiraclethemes-site-library' ),
						'feature_text' => esc_html__( '30-day policy', 'spiraclethemes-site-library' ),
					],
					[
						'feature_icon' => [ 'value' => 'fa-solid fa-clock', 'library' => 'fa-solid' ],
						'feature_title' => esc_html__( '24/7 Support', 'spiraclethemes-site-library' ),
						'feature_text' => esc_html__( 'Dedicated help', 'spiraclethemes-site-library' ),
					],
					[
						'feature_icon' => [ 'value' => 'fa-solid fa-star', 'library' => 'fa-solid' ],
						'feature_title' => esc_html__( 'Best Prices', 'spiraclethemes-site-library' ),
						'feature_text' => esc_html__( 'Guaranteed', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ feature_title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Style: Layout & Container ─────────────────────────────
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout & Container', 'spiraclethemes-site-library' ),
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
				'default' => 5,
				'tablet_default' => 3,
				'mobile_default' => 2,
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
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
					'{{WRAPPER}} .shopzen-feat-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'feature_padding',
			[
				'label' => esc_html__( 'Item Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 14,
					'right' => 12,
					'bottom' => 14,
					'left' => 12,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-feature' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'feature_gap',
			[
				'label' => esc_html__( 'Icon / Text Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 10 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-feature' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'container_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'container_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'container_border_size',
			[
				'label' => esc_html__( 'Border Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'top_accent_heading',
			[
				'label' => esc_html__( 'Top Accent Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_top_accent',
			[
				'label' => esc_html__( 'Show Top Accent', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'border-top-width: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => '3px',
					'' => '1px',
				],
			]
		);

		$this->add_control(
			'top_accent_color',
			[
				'label' => esc_html__( 'Top Accent Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'border-top-color: {{VALUE}};',
				],
				'condition' => [
					'show_top_accent' => 'yes',
				],
			]
		);

		$this->add_control(
			'container_radius',
			[
				'label' => esc_html__( 'Bottom Corner Radius (px)', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Top corners stay square to match the design; only the bottom corners are rounded.', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-features' => 'border-radius: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_shadow',
				'label' => esc_html__( 'Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-feat-features',
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
			'icon_box_size',
			[
				'label' => esc_html__( 'Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 24, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 34 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 10, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopzen-feat-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_box_bg',
			[
				'label' => esc_html__( 'Box Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4F7F3',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-icon' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-feat-icon' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-feat-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_box_border_color',
			[
				'label' => esc_html__( 'Box Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-icon' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_box_radius',
			[
				'label' => esc_html__( 'Box Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
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
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-feat-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.2 ] ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.35 ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1F2937',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
				'name' => 'text_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-feat-text',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 11 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Divider ─────────────────────────────────────────
		$this->start_controls_section(
			'section_divider_style',
			[
				'label' => esc_html__( 'Divider', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label' => esc_html__( 'Show Dividers Between Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-feature:not(:last-child)::after' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'block',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Divider Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-feature:not(:last-child)::after' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_divider' => 'yes',
				],
			]
		);

		$this->add_control(
			'divider_inset',
			[
				'label' => esc_html__( 'Divider Vertical Inset (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 0, 'max' => 45 ] ],
				'default' => [ 'unit' => '%', 'size' => 15 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-feat-feature:not(:last-child)::after' => 'top: {{SIZE}}%; bottom: {{SIZE}}%;',
				],
				'condition' => [
					'show_divider' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/features/template/view.php';
	}
}
