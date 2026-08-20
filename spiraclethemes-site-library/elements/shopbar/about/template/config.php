<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * About Hero
 *
 * An editorial "Our Story" intro block for the Shopbar theme: a warm-accent
 * eyebrow, a Fraunces display headline, a short description, a primary
 * (filled) and optional secondary (ghost) button, paired with an optional
 * image. Mirrors the about-hero section of the Shopbar design spec.
 *
 * @since 1.0.0
 */
class Shopbar_About extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-about';
	}

	public function get_title() {
		return __( 'About Hero', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-info-circle-o';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'about', 'story', 'hero', 'intro', 'mission', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Story ───────────────────────────────────────────
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
				'default'     => esc_html__( 'Our Story', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'We Help You Shop Smarter, Not Harder.', 'spiraclethemes-site-library' ),
				'rows'        => 3,
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Since 2015, Shopbar has been on a mission to bring top-quality products at honest prices to shoppers everywhere. Smart choices, fast delivery, happy you — that\'s the promise we keep every single day.', 'spiraclethemes-site-library' ),
				'rows'        => 4,
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
				'default'     => esc_html__( 'Shopping bags', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'description' => esc_html__( 'Descriptive text for accessibility and SEO.', 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Content: Buttons ─────────────────────────────────────────
		$this->start_controls_section(
			'section_buttons',
			[
				'label' => esc_html__( 'Buttons', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'primary_btn_text',
			[
				'label'       => esc_html__( 'Primary Button Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Shop Now', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'primary_btn_url',
			[
				'label'         => esc_html__( 'Primary Link', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$this->add_control(
			'show_secondary_btn',
			[
				'label'        => esc_html__( 'Show Secondary Button', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'secondary_btn_text',
			[
				'label'       => esc_html__( 'Secondary Button Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Meet the Team', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_secondary_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'secondary_btn_url',
			[
				'label'         => esc_html__( 'Secondary Link', 'spiraclethemes-site-library' ),
				'type'          => Controls_Manager::URL,
				'placeholder'   => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default'       => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'condition'   => [ 'show_secondary_btn' => 'yes' ],
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
				'label'   => esc_html__( 'Image Position', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-h-align-left' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),  'icon' => 'eicon-h-align-right' ],
					'hidden' => [ 'title' => esc_html__( 'Hidden', 'spiraclethemes-site-library' ), 'icon' => 'eicon-ban' ],
				],
				'prefix_class' => 'shopbar-ab-media-',
				'toggle'       => false,
			]
		);

		$this->add_control(
			'content_align',
			[
				'label'   => esc_html__( 'Content Alignment', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
				],
				'prefix_class' => 'shopbar-ab-align-',
				'toggle'       => false,
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
					'{{WRAPPER}} .shopbar-ab-row' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_padding',
			[
				'label'      => esc_html__( 'Section Padding Y (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 70 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-row' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .shopbar-ab-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'label_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ab-label',
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
				'selector'       => '{{WRAPPER}} .shopbar-ab-title',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Fraunces' ],
					'font_size'   => [ 'default' => [ 'size' => 44 ] ],
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
					'{{WRAPPER}} .shopbar-ab-title' => 'color: {{VALUE}};',
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
				'selector'       => '{{WRAPPER}} .shopbar-ab-desc',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 16 ] ],
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
					'{{WRAPPER}} .shopbar-ab-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'desc_width',
			[
				'label'      => esc_html__( 'Max Width (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 280, 'max' => 760 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 520 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-desc' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Primary Button ────────────────────────────────────
		$this->start_controls_section(
			'section_style_primary',
			[
				'label' => esc_html__( 'Primary Button', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'primary_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_border',
			[
				'label'     => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--primary' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_hover_bg',
			[
				'label'     => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--primary:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'primary_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ab-btn--primary',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'primary_radius',
			[
				'label'      => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-btn--primary' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'primary_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 14, 'right' => 28, 'bottom' => 14, 'left' => 28, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-btn--primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Secondary Button ──────────────────────────────────
		$this->start_controls_section(
			'section_style_secondary',
			[
				'label'     => esc_html__( 'Secondary Button', 'spiraclethemes-site-library' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_secondary_btn' => 'yes' ],
			]
		);

		$this->add_control(
			'secondary_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_border',
			[
				'label'     => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#DDDDDD',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_hover_bg',
			[
				'label'     => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_hover_color',
			[
				'label'     => esc_html__( 'Hover Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'secondary_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-ab-btn--secondary',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'secondary_radius',
			[
				'label'      => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 8 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'secondary_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 14, 'right' => 28, 'bottom' => 14, 'left' => 28, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-btn--secondary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .shopbar-ab-media' => 'flex: 0 0 {{SIZE}}%; width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'image_height',
			[
				'label'      => esc_html__( 'Min Height (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 240, 'max' => 640 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 430 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-ab-media img' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .shopbar-ab-media img' => 'border-radius: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .shopbar-ab-media img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .shopbar-ab-media img',
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
				'selector' => '{{WRAPPER}} .shopbar-ab-media img',
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
