<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Helper: outline SVG icons available as decorative accents on the CTA band.
 *
 * The matching SVG markup lives in view.php via shopbar_cta_render_icon().
 * Icons follow the Shopbar theme outline style (24x24 viewBox, stroke based).
 *
 * @return array
 */
function shopbar_cta_icon_options() {
	return array(
		''           => esc_html__( '— None —', 'spiraclethemes-site-library' ),
		'bag'        => esc_html__( 'Shopping Bag', 'spiraclethemes-site-library' ),
		'cart'       => esc_html__( 'Cart', 'spiraclethemes-site-library' ),
		'tag'        => esc_html__( 'Tag', 'spiraclethemes-site-library' ),
		'gift'       => esc_html__( 'Gift', 'spiraclethemes-site-library' ),
		'credit-card'=> esc_html__( 'Credit Card', 'spiraclethemes-site-library' ),
		'sparkles'   => esc_html__( 'Sparkles', 'spiraclethemes-site-library' ),
		'truck'      => esc_html__( 'Truck', 'spiraclethemes-site-library' ),
		'zap'        => esc_html__( 'Zap', 'spiraclethemes-site-library' ),
		'percent'    => esc_html__( 'Percent', 'spiraclethemes-site-library' ),
	);
}

class Shopbar_CTA extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-cta';
	}

	public function get_title() {
		return __( 'CTA / Call to Action', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'cta', 'call to action', 'banner', 'promo', 'button', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Call to Action ───────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Call to Action', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow_text',
			[
				'label' => esc_html__( 'Eyebrow / Pre-title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Limited Time Offer', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'cta_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Step Into the Season With Up To 40% Off', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'cta_description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Refresh your wardrobe with hand-picked favourites — no code needed, applied automatically at checkout.', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Primary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop the Sale', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'btn_url',
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
			'btn_icon',
			[
				'label' => esc_html__( 'Primary Button Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa-solid fa-arrow-right',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'arrow-right', 'shopping-bag', 'cart-plus', 'tag' ] ],
			]
		);

		$this->add_control(
			'show_secondary_btn',
			[
				'label' => esc_html__( 'Show Secondary Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'secondary_btn_text',
			[
				'label' => esc_html__( 'Secondary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View Lookbook', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_secondary_btn' => 'yes' ],
				'label_block' => true,
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
				'condition' => [ 'show_secondary_btn' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ───────────────────────────────────────
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Content Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'start'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-content' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 30, 'max' => 100 ] ],
				'default' => [ 'unit' => '%', 'size' => 70 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Content: Background ───────────────────────────────────
		$this->start_controls_section(
			'section_background',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'cta_bg_type',
			[
				'label' => esc_html__( 'Background Type', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'gradient',
				'options' => [
					'gradient' => esc_html__( 'Gradient', 'spiraclethemes-site-library' ),
					'solid'    => esc_html__( 'Solid Color', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'solid_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'condition' => [ 'cta_bg_type' => 'solid' ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-band' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'gradient_color_1',
			[
				'label' => esc_html__( 'Gradient Color 1', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'condition' => [ 'cta_bg_type' => 'gradient' ],
			]
		);

		$this->add_control(
			'gradient_color_2',
			[
				'label' => esc_html__( 'Gradient Color 2', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2A2622',
				'condition' => [ 'cta_bg_type' => 'gradient' ],
			]
		);

		$this->add_control(
			'gradient_direction',
			[
				'label' => esc_html__( 'Gradient Direction', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => '135deg',
				'options' => [
					'to right'  => [ 'title' => esc_html__( '→', 'spiraclethemes-site-library' ), 'icon' => 'eicon-arrow-right' ],
					'to bottom' => [ 'title' => esc_html__( '↓', 'spiraclethemes-site-library' ), 'icon' => 'eicon-arrow-down' ],
					'135deg'    => [ 'title' => esc_html__( '↘', 'spiraclethemes-site-library' ), 'icon' => 'eicon-slider-diagonal' ],
					'45deg'     => [ 'title' => esc_html__( '↗', 'spiraclethemes-site-library' ), 'icon' => 'eicon-slider-diagonal' ],
				],
				'toggle' => false,
				'condition' => [ 'cta_bg_type' => 'gradient' ],
			]
		);

		$this->add_control(
			'show_decor_icons',
			[
				'label' => esc_html__( 'Decorative Shopping Icons', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'Hide', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Displays a subtle cluster of outline shopping icons inside the band.', 'spiraclethemes-site-library' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'decor_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'condition' => [ 'show_decor_icons' => 'yes' ],
			]
		);

		$this->add_control(
			'decor_opacity',
			[
				'label' => esc_html__( 'Icon Opacity (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
				'default' => [ 'unit' => '%', 'size' => 100 ],
				'condition' => [ 'show_decor_icons' => 'yes' ],
			]
		);

		$this->add_control(
			'decor_size',
			[
				'label' => esc_html__( 'Icon Size (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 40, 'max' => 200 ] ],
				'default' => [ 'unit' => '%', 'size' => 100 ],
				'condition' => [ 'show_decor_icons' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Discount Badge ───────────────────────────────
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Discount Badge', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => esc_html__( 'Show Badge', 'spiraclethemes-site-library' ),
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
				'default' => esc_html__( 'SAVE', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_main_text',
			[
				'label' => esc_html__( 'Main Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '40%', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_bottom_text',
			[
				'label' => esc_html__( 'Bottom Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'OFF', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_badge' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Style: Band ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_band',
			[
				'label' => esc_html__( 'Band', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Matches the Shopbar header/footer width (1350px by default).', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1350 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'band_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-band' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'band_padding',
			[
				'label' => esc_html__( 'Inner Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 64, 'right' => 48, 'bottom' => 64, 'left' => 48,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-band' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'band_min_height',
			[
				'label' => esc_html__( 'Min Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 160, 'max' => 600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 360 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-band' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'band_shadow',
				'label' => esc_html__( 'Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cta-band',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical' => 24,
							'blur' => 60,
							'spread' => -20,
							'color' => 'rgba(28, 28, 28, 0.25)',
							'is_inset' => '',
						],
					],
				],
			]
		);

		$this->add_control(
			'overflow_hidden',
			[
				'label' => esc_html__( 'Clip Overflow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: Eyebrow ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_eyebrow',
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
				'selector' => '{{WRAPPER}} .shopbar-cta-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12.5 ] ],
					'font_weight' => [ 'default' => 500 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.14 ] ],
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eyebrow_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-eyebrow' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ──────────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .shopbar-cta-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 44 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.1 ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Description ────────────────────────────────────
		$this->start_controls_section(
			'section_style_description',
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
				'selector' => '{{WRAPPER}} .shopbar-cta-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#D9D2C8',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desc_spacing',
			[
				'label' => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 32 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-desc' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Primary Button ─────────────────────────────────
		$this->start_controls_section(
			'section_style_primary_btn',
			[
				'label' => esc_html__( 'Primary Button', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'primary_btn_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cta-btn--primary',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'primary_btn_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .shopbar-cta-btn--primary i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .shopbar-cta-btn--primary:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_hover_color',
			[
				'label' => esc_html__( 'Hover Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'top' => 15, 'right' => 30, 'bottom' => 15, 'left' => 30,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Secondary Button ───────────────────────────────
		$this->start_controls_section(
			'section_style_secondary_btn',
			[
				'label' => esc_html__( 'Secondary Button', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_secondary_btn' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondary_btn_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cta-btn--secondary',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'secondary_btn_border',
				'label' => esc_html__( 'Border', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-cta-btn--secondary',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => 'rgba(255,255,255,0.35)' ],
				],
			]
		);

		$this->add_control(
			'secondary_btn_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.10)',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--secondary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_hover_color',
			[
				'label' => esc_html__( 'Hover Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--secondary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_hover_border',
			[
				'label' => esc_html__( 'Hover Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--secondary:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--secondary' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'top' => 14, 'right' => 29, 'bottom' => 14, 'left' => 29,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-btn--secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ──────────────────────────────────────────
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => esc_html__( 'Discount Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF3D81',
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-badge' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopbar-cta-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_size',
			[
				'label' => esc_html__( 'Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 60, 'max' => 180 ] ],
				'default' => [ 'unit' => 'px', 'size' => 104 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_top',
			[
				'label' => esc_html__( 'Position Top (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 220 ] ],
				'default' => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_right',
			[
				'label' => esc_html__( 'Position Right (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 220 ] ],
				'default' => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-cta-badge' => 'right: {{SIZE}}{{UNIT}};',
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
