<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Our Story
 *
 * An editorial "Our Story" block for the Shopbar theme: a warm-accent
 * eyebrow, a Fraunces display headline, a description, a checklist of
 * brand promises, an optional experience badge overlaid on the image,
 * and an optional founder signature. Mirrors the story section of the
 * Shopbar design spec.
 *
 * @since 1.0.0
 */
class Shopbar_Our_Story extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-our-story';
	}

	public function get_title() {
		return __( 'Our Story', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-favorite';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'story', 'about', 'brand', 'founder', 'our-story', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Our Story ───────────────────────────────────────
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Our Story', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_label',
			[
				'label'       => esc_html__( 'Eyebrow Label', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Who We Are', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Built by Shoppers, for Shoppers', 'spiraclethemes-site-library' ),
				'rows'        => 2,
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Shopbar started as a small online store with a big idea: shopping for quality products shouldn\'t be complicated or overpriced. Today, we serve tens of thousands of customers worldwide, but our founding principle hasn\'t changed — put the customer first, always.', 'spiraclethemes-site-library' ),
				'rows'        => 4,
			]
		);

		$this->end_controls_section();


		// ─── Content: Feature List ────────────────────────────────────
		$this->start_controls_section(
			'section_list',
			[
				'label' => esc_html__( 'Feature List', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => esc_html__( 'Hand-picked products from verified, trusted brands', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'features',
			[
				'label'       => esc_html__( 'Promises', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[ 'text' => 'Hand-picked products from verified, trusted brands' ],
					[ 'text' => 'Transparent pricing with no hidden fees, ever' ],
					[ 'text' => 'Fast, reliable shipping and hassle-free 30-day returns' ],
					[ 'text' => 'Dedicated 24/7 customer support that actually cares' ],
				],
				'title_field' => '{{{ text }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Experience Badge ────────────────────────────────
		$this->start_controls_section(
			'section_badge',
			[
				'label' => esc_html__( 'Experience Badge', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label'        => esc_html__( 'Show Badge', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'badge_number',
			[
				'label'       => esc_html__( 'Number', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '10+', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_label',
			[
				'label'       => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Years of Experience', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_position',
			[
				'label'                => esc_html__( 'Position', 'spiraclethemes-site-library' ),
				'type'                 => Controls_Manager::CHOOSE,
				'default'              => 'br',
				'options'              => [
					'tl' => [ 'title' => esc_html__( 'Top Left', 'spiraclethemes-site-library' ),     'icon' => 'eicon-arrow-up-left' ],
					'tr' => [ 'title' => esc_html__( 'Top Right', 'spiraclethemes-site-library' ),    'icon' => 'eicon-arrow-up-right' ],
					'bl' => [ 'title' => esc_html__( 'Bottom Left', 'spiraclethemes-site-library' ),  'icon' => 'eicon-arrow-down-left' ],
					'br' => [ 'title' => esc_html__( 'Bottom Right', 'spiraclethemes-site-library' ), 'icon' => 'eicon-arrow-down-right' ],
				],
				'prefix_class'         => 'shopbar-os-badge-pos-',
				'toggle'               => false,
				'condition'            => [ 'show_badge' => 'yes' ],
				'render_type'          => 'template',
			]
		);

		$this->end_controls_section();


		// ─── Content: Founder ─────────────────────────────────────────
		$this->start_controls_section(
			'section_founder',
			[
				'label' => esc_html__( 'Founder', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_founder',
			[
				'label'        => esc_html__( 'Show Founder', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'founder_image',
			[
				'label'     => esc_html__( 'Avatar', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [ 'show_founder' => 'yes' ],
			]
		);

		$this->add_control(
			'founder_name',
			[
				'label'       => esc_html__( 'Name', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Daniel Carter', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_founder' => 'yes' ],
			]
		);

		$this->add_control(
			'founder_role',
			[
				'label'       => esc_html__( 'Role', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Founder & CEO', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_founder' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Image ───────────────────────────────────────────
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'image_alt',
			[
				'label'       => esc_html__( 'Image Alt Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Our store', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'description' => esc_html__( 'Descriptive text for accessibility and SEO.', 'spiraclethemes-site-library' ),
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

		$this->add_control(
			'image_position',
			[
				'label'         => esc_html__( 'Image Position', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'left',
				'options'       => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-h-align-left' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),  'icon' => 'eicon-h-align-right' ],
					'hidden' => [ 'title' => esc_html__( 'Hidden', 'spiraclethemes-site-library' ), 'icon' => 'eicon-ban' ],
				],
				'prefix_class'  => 'shopbar-os-media-',
				'toggle'        => false,
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'         => esc_html__( 'Content Alignment', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::CHOOSE,
				'default'       => 'left',
				'options'       => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
				],
				'prefix_class'  => 'shopbar-os-align-',
				'toggle'        => false,
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 60 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-row' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_padding',
			[
				'label'      => esc_html__( 'Section Padding Y (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 75 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-row' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Eyebrow Label ─────────────────────────────────────
		$this->start_controls_section(
			'section_style_label',
			[
				'label' => esc_html__( 'Eyebrow Label', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'label_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-label',
				'fields_options' => [
					'typography'     => [ 'default' => 'yes' ],
					'font_family'    => [ 'default' => 'DM Mono' ],
					'font_size'      => [ 'default' => [ 'size' => 13 ] ],
					'font_weight'    => [ 'default' => 600 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 2 ] ],
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'title_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 38 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.15 ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Description ───────────────────────────────────────
		$this->start_controls_section(
			'section_style_desc',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'desc_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-desc',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.7 ] ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_width',
			[
				'label'      => esc_html__( 'Max Width (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 280, 'max' => 760 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 540 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Feature List ──────────────────────────────────────
		$this->start_controls_section(
			'section_style_list',
			[
				'label' => esc_html__( 'Feature List', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#5A8A6A',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-check' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_icon_size',
			[
				'label'      => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 12, 'max' => 32 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 18 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-check svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'list_typography',
				'label'          => esc_html__( 'Text Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-list li',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.5 ] ],
				],
			]
		);

		$this->add_control(
			'list_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-list li' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_gap',
			[
				'label'      => esc_html__( 'Row Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 4, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 14 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-list li' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopbar-os-list li:last-child' => 'margin-bottom: 0;',
				],
			]
		);

		$this->add_responsive_control(
			'list_icon_gap',
			[
				'label'      => esc_html__( 'Icon Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 24 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-list li' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Experience Badge ──────────────────────────────────
		$this->start_controls_section(
			'section_style_badge',
			[
				'label'      => esc_html__( 'Experience Badge', 'spiraclethemes-site-library' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition'  => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_offset',
			[
				'label'      => esc_html__( 'Edge Offset (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-media' => '--os-badge-offset: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_radius',
			[
				'label'      => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 12 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 16, 'right' => 22, 'bottom' => 16, 'left' => 22, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'badge_number_typography',
				'label'          => esc_html__( 'Number Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-badge-num',
				'separator'      => 'before',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 28 ] ],
					'font_weight' => [ 'default' => 600 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1 ] ],
				],
			]
		);

		$this->add_control(
			'badge_number_color',
			[
				'label'     => esc_html__( 'Number Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-badge-num' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'badge_label_typography',
				'label'          => esc_html__( 'Label Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-badge-text',
				'separator'      => 'before',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 500 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'badge_label_color',
			[
				'label'     => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-badge-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'badge_shadow',
				'selector' => '{{WRAPPER}} .shopbar-os-badge',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 14,
							'blur'       => 36,
							'spread'     => -14,
							'color'      => 'rgba(28, 28, 28, 0.32)',
							'is_inset'   => '',
						],
					],
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Founder ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_founder',
			[
				'label'      => esc_html__( 'Founder', 'spiraclethemes-site-library' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition'  => [ 'show_founder' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'founder_avatar_size',
			[
				'label'      => esc_html__( 'Avatar Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 36, 'max' => 96 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 52 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-founder-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'founder_avatar_radius',
			[
				'label'      => esc_html__( 'Avatar Radius (%)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => '%', 'size' => 50 ],
				'size_units' => [ '%', 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-founder-avatar' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'founder_name_typography',
				'label'          => esc_html__( 'Name Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-os-founder-name',
				'separator'      => 'before',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 700 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.2 ] ],
				],
			]
		);

		$this->add_control(
			'founder_name_color',
			[
				'label'     => esc_html__( 'Name Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-founder-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'founder_role_color',
			[
				'label'     => esc_html__( 'Role Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9C9792',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-founder-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'founder_divider_color',
			[
				'label'     => esc_html__( 'Divider Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#E8E4DF',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-founder' => 'border-top-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'founder_top_spacing',
			[
				'label'      => esc_html__( 'Top Spacing (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 28 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-founder' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_image',
			[
				'label'      => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition'  => [ 'image_position!' => 'hidden' ],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width (%)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 25, 'max' => 70 ] ],
				'default'    => [ 'unit' => '%', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-media' => 'flex: 0 0 {{SIZE}}%; width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Min Height (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 240, 'max' => 640 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 460 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-media img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 16 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-os-media img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_fit',
			[
				'label'   => esc_html__( 'Image Fit', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover'   => esc_html__( 'Cover', 'spiraclethemes-site-library' ),
					'contain' => esc_html__( 'Contain', 'spiraclethemes-site-library' ),
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-os-media img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .shopbar-os-media img',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 18,
							'blur'       => 48,
							'spread'     => -18,
							'color'      => 'rgba(28, 28, 28, 0.16)',
							'is_inset'   => '',
						],
					],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'image_filters',
				'selector' => '{{WRAPPER}} .shopbar-os-media img',
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
