<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Testimonials extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-testimonials';
	}

	public function get_title() {
		return __( 'Testimonials', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'testimonials', 'reviews', 'feedback', 'ratings', 'shop', 'zen' ];
	}

	protected function register_controls() {

		// ─── Content: Heading Panel ────────────────────────────────
		$this->start_controls_section(
			'section_left',
			[
				'label' => esc_html__( 'Heading Panel', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'heading_before',
			[
				'label' => esc_html__( 'Heading (Before Highlight)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Loved by', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'heading_highlight',
			[
				'label' => esc_html__( 'Heading (Highlight)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Thousands', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'subtext',
			[
				'label' => esc_html__( 'Sub Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Real reviews from our happy customers.', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => esc_html__( 'View All Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View all reviews', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'view_all_link',
			[
				'label' => esc_html__( 'View All Link', 'spiraclethemes-site-library' ),
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
			'hide_view_all',
			[
				'label' => esc_html__( 'Hide View All Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->end_controls_section();


		// ─── Content: Testimonial Cards ────────────────────────────
		$this->start_controls_section(
			'section_cards',
			[
				'label' => esc_html__( 'Testimonial Cards', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'testi_avatar',
			[
				'label' => esc_html__( 'Avatar', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200',
				],
			]
		);

		$repeater->add_control(
			'testi_name',
			[
				'label' => esc_html__( 'Name', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Sarah J.', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'testi_verified',
			[
				'label' => esc_html__( 'Show Verified Badge', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater->add_control(
			'testi_rating',
			[
				'label' => esc_html__( 'Rating (0-5)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 5,
			]
		);

		$repeater->add_control(
			'testi_quote',
			[
				'label' => esc_html__( 'Quote', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( '"The quality exceeded my expectations. Fast shipping and beautiful packaging!"', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'testimonials',
			[
				'label' => esc_html__( 'Testimonial Cards', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'testi_avatar' => [ 'url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200' ],
						'testi_name'    => esc_html__( 'Sarah J.', 'spiraclethemes-site-library' ),
						'testi_verified' => 'yes',
						'testi_rating'  => 5,
						'testi_quote'   => esc_html__( '"The quality exceeded my expectations. Fast shipping and beautiful packaging! I\'ll definitely be ordering again."', 'spiraclethemes-site-library' ),
					],
					[
						'testi_avatar' => [ 'url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200' ],
						'testi_name'    => esc_html__( 'Michael T.', 'spiraclethemes-site-library' ),
						'testi_verified' => 'yes',
						'testi_rating'  => 5,
						'testi_quote'   => esc_html__( '"Sustainable and stylish. I\'ve replaced most of my daily essentials with Natura products. Love the mission!"', 'spiraclethemes-site-library' ),
					],
					[
						'testi_avatar' => [ 'url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200' ],
						'testi_name'    => esc_html__( 'Priya S.', 'spiraclethemes-site-library' ),
						'testi_verified' => 'yes',
						'testi_rating'  => 5,
						'testi_quote'   => esc_html__( '"Customer service is amazing. They helped me find the perfect gift in minutes. The yoga mat is my favorite!"', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ testi_name }}}',
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
					'top' => 56, 'right' => 0, 'bottom' => 40, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FCFCFB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
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
					'{{WRAPPER}} .shopzen-testi-wrap' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'panels_gap',
			[
				'label' => esc_html__( 'Panel Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 40 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-wrap' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'left_panel_width',
			[
				'label' => esc_html__( 'Left Panel Width (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [ '%' => [ 'min' => 15, 'max' => 50, 'step' => 1 ] ],
				'default' => [ 'unit' => '%', 'size' => 30 ],
				'tablet_default' => [ 'unit' => '%', 'size' => 100 ],
				'mobile_default' => [ 'unit' => '%', 'size' => 100 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-wrap' => '--shopzen-testi-left: {{SIZE}}{{UNIT}};',
				],
				'description' => esc_html__( 'Width of the left (heading) panel. Cards panel fills the rest. On tablet/mobile it stacks to 100%.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_responsive_control(
			'cards_gap',
			[
				'label' => esc_html__( 'Cards Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-cards' => 'gap: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .shopzen-testi-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 38 ] ],
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
					'{{WRAPPER}} .shopzen-testi-title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-testi-green' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Heading Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 12 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtext_typography',
				'label' => esc_html__( 'Sub Text Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-testi-sub',
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
					'{{WRAPPER}} .shopzen-testi-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'subtext_max_width',
			[
				'label' => esc_html__( 'Sub Text Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 160, 'max' => 600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 240 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-sub' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'subtext_spacing',
			[
				'label' => esc_html__( 'Sub Text Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-sub' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'viewall_typography',
				'label' => esc_html__( 'View All Link Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-testi-link',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.3 ] ],
				],
			]
		);

		$this->add_control(
			'viewall_color',
			[
				'label' => esc_html__( 'View All Link Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-link' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: Cards ───────────────────────────────────────────
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
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-card' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-testi-card' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label' => esc_html__( 'Card Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 24, 'right' => 24, 'bottom' => 24, 'left' => 24,
					'unit' => 'px', 'isLinked' => true,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'label' => esc_html__( 'Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-testi-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_hover_shadow',
				'label' => esc_html__( 'Hover Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-testi-card:hover',
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
					'{{WRAPPER}} .shopzen-testi-card:hover' => 'transform: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'translateY(-4px)',
					'' => 'none',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Reviewer ────────────────────────────────────────
		$this->start_controls_section(
			'section_reviewer_style',
			[
				'label' => esc_html__( 'Reviewer', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Avatar Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 32, 'max' => 96 ] ],
				'default' => [ 'unit' => 'px', 'size' => 48 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatar_border_color',
			[
				'label' => esc_html__( 'Avatar Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-avatar' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => esc_html__( 'Name Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-testi-name',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Name Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'verified_bg',
			[
				'label' => esc_html__( 'Verified Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3B82F6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-verified' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'verified_color',
			[
				'label' => esc_html__( 'Verified Badge Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-verified' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Quote & Stars ───────────────────────────────────
		$this->start_controls_section(
			'section_quote_style',
			[
				'label' => esc_html__( 'Quote & Stars', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'stars_color',
			[
				'label' => esc_html__( 'Stars Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F59E0B',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-tstars' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'stars_size',
			[
				'label' => esc_html__( 'Stars Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 10, 'max' => 28 ] ],
				'default' => [ 'unit' => 'px', 'size' => 15 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-tstars' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'quote_typography',
				'label' => esc_html__( 'Quote Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-testi-quote',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'quote_color',
			[
				'label' => esc_html__( 'Quote Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#374151',
				'selectors' => [
					'{{WRAPPER}} .shopzen-testi-quote' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/testimonials/template/view.php';
	}
}