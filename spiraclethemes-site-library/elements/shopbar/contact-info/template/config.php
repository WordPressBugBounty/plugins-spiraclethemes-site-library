<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Helper: outline SVG icons available for the contact info cards.
 *
 * The matching SVG markup lives in view.php via shopbar_ci_render_icon().
 * Icons follow the Shopbar theme outline style (24x24 viewBox, stroke based).
 *
 * @return array
 */
function shopbar_ci_icon_options() {
	return array(
		''             => esc_html__( '— None —', 'spiraclethemes-site-library' ),
		'map-pin'      => esc_html__( 'Map Pin (Address)', 'spiraclethemes-site-library' ),
		'phone'        => esc_html__( 'Phone', 'spiraclethemes-site-library' ),
		'mail'         => esc_html__( 'Mail (Email)', 'spiraclethemes-site-library' ),
		'chat'         => esc_html__( 'Chat (Live Chat)', 'spiraclethemes-site-library' ),
		'clock'        => esc_html__( 'Clock (Hours)', 'spiraclethemes-site-library' ),
		'headset'      => esc_html__( 'Headset (Support)', 'spiraclethemes-site-library' ),
		'send'         => esc_html__( 'Send (Message)', 'spiraclethemes-site-library' ),
		'globe'        => esc_html__( 'Globe (Website)', 'spiraclethemes-site-library' ),
		'sparkles'     => esc_html__( 'Sparkles', 'spiraclethemes-site-library' ),
	);
}

/**
 * Contact Info
 *
 * A centered contact hero (warm-accent eyebrow, Fraunces display headline,
 * short description) followed by a responsive grid of contact info cards.
 * Each card holds an outline SVG icon in a rounded tile, a title, a subtitle
 * and a bold highlight line. Mirrors the contact-hero + contact-info sections
 * of the Shopbar design spec.
 *
 * @since 1.0.0
 */
class Shopbar_Contact_Info extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-contact-info';
	}

	public function get_title() {
		return __( 'Contact Info', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-contact';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'contact', 'info', 'address', 'phone', 'email', 'hero', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Hero ────────────────────────────────────────────
		$this->start_controls_section(
			'section_hero',
			[
				'label' => esc_html__( 'Contact Hero', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_hero',
			[
				'label'        => esc_html__( 'Show Hero', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'section_label',
			[
				'label'       => esc_html__( 'Eyebrow Label', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get In Touch', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_hero' => 'yes' ],
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( "We'd Love to Hear From You", 'spiraclethemes-site-library' ),
				'rows'        => 3,
				'condition'   => [ 'show_hero' => 'yes' ],
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Have a question about an order, a product, or just want to say hi? Our team is ready to help you every step of the way.', 'spiraclethemes-site-library' ),
				'rows'        => 4,
				'condition'   => [ 'show_hero' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Contact Cards ───────────────────────────────────
		$this->start_controls_section(
			'section_cards',
			[
				'label' => esc_html__( 'Contact Cards', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			[
				'label'       => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'map-pin',
				'options'     => shopbar_ci_icon_options(),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Visit Us', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '1234 Market Street, Suite 500', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'highlight',
			[
				'label'       => esc_html__( 'Highlight Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'San Francisco, CA 94103', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'         => esc_html__( 'Link', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default'       => [
					'url'         => '',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$default_cards = [
			[ 'icon' => 'map-pin', 'title' => __( 'Visit Us',  'spiraclethemes-site-library' ), 'subtitle' => __( '1234 Market Street, Suite 500', 'spiraclethemes-site-library' ), 'highlight' => __( 'San Francisco, CA 94103', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'phone',   'title' => __( 'Call Us',   'spiraclethemes-site-library' ), 'subtitle' => __( 'Mon - Fri, 9am - 6pm PST',       'spiraclethemes-site-library' ), 'highlight' => __( '+1 (800) 123-4567',     'spiraclethemes-site-library' ) ],
			[ 'icon' => 'mail',    'title' => __( 'Email Us',  'spiraclethemes-site-library' ), 'subtitle' => __( 'We reply within 24 hours',      'spiraclethemes-site-library' ), 'highlight' => __( 'support@shopbar.com',  'spiraclethemes-site-library' ) ],
			[ 'icon' => 'chat',    'title' => __( 'Live Chat', 'spiraclethemes-site-library' ), 'subtitle' => __( 'Instant support available',     'spiraclethemes-site-library' ), 'highlight' => __( 'Chat with us now',      'spiraclethemes-site-library' ) ],
		];

		$this->add_control(
			'cards',
			[
				'label'       => esc_html__( 'Cards', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $default_cards,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ──────────────────────────────────────────
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label'           => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type'            => Controls_Manager::NUMBER,
				'min'             => 1,
				'max'             => 6,
				'default'         => 4,
				'desktop_default' => 4,
				'tablet_default'  => 2,
				'mobile_default'  => 1,
				'selectors'       => [
					'{{WRAPPER}} .shopbar-ci-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'hero_spacing',
			[
				'label'      => esc_html__( 'Hero Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-hero' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Eyebrow ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_eyebrow',
			[
				'label'     => esc_html__( 'Eyebrow Label', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hero' => 'yes' ],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'eyebrow_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ci-label',
				'fields_options' => [
					'typography'     => [ 'default' => 'yes' ],
					'font_family'    => [ 'default' => 'DM Mono' ],
					'font_size'      => [ 'default' => [ 'size' => 13 ] ],
					'font_weight'    => [ 'default' => 600 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 2 ] ],
					'line_height'    => [ 'default' => [ 'unit' => 'em', 'size' => 1.2 ] ],
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Hero Title ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_hero_title',
			[
				'label'     => esc_html__( 'Hero Title', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hero' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'hero_title_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ci-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 40 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.2 ] ],
				],
			]
		);

		$this->add_control(
			'hero_title_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Hero Description ──────────────────────────────────
		$this->start_controls_section(
			'section_style_hero_desc',
			[
				'label'     => esc_html__( 'Hero Description', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_hero' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'hero_desc_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ci-desc',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.7 ] ],
				],
			]
		);

		$this->add_control(
			'hero_desc_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'hero_desc_width',
			[
				'label'      => esc_html__( 'Max Width (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 280, 'max' => 900 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 640 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ──────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Card', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'           => 'card_border',
				'selector'       => '{{WRAPPER}} .shopbar-ci-card',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#E8E4DF' ],
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'           => 'card_shadow_hover',
				'label'          => esc_html__( 'Hover Shadow', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ci-card:hover',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 10,
							'blur'       => 30,
							'spread'     => 0,
							'color'      => 'rgba(28, 28, 28, 0.08)',
							'is_inset'   => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'card_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 32, 'right' => 26, 'bottom' => 32, 'left' => 26, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Icon ──────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-icon svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label'      => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 14, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_bg',
			[
				'label'     => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#F3EFEA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tile_size',
			[
				'label'      => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 96 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 60 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label'      => esc_html__( 'Icon Box Radius (%)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card Title ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card_title',
			[
				'label' => esc_html__( 'Card Title', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'card_title_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ci-card-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 18 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'card_title_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-card-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'card_title_spacing',
			[
				'label'      => esc_html__( 'Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ci-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card Text ─────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card_text',
			[
				'label' => esc_html__( 'Card Text', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'card_text_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ci-subtitle',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Subtitle Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'highlight_color',
			[
				'label'     => esc_html__( 'Highlight Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-highlight' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'highlight_weight',
			[
				'label'     => esc_html__( 'Highlight Weight', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '600',
				'options'   => [
					'400' => esc_html__( 'Normal (400)', 'spiraclethemes-site-library' ),
					'500' => esc_html__( 'Medium (500)', 'spiraclethemes-site-library' ),
					'600' => esc_html__( 'Semibold (600)', 'spiraclethemes-site-library' ),
					'700' => esc_html__( 'Bold (700)', 'spiraclethemes-site-library' ),
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-ci-highlight' => 'font-weight: {{VALUE}};',
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
