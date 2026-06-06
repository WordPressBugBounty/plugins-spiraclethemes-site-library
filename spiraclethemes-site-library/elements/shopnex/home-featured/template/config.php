<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shopnex_HomeFeatured extends Widget_Base {

	public function get_name() {
		return 'shopnex-elementor-home-featured';
	} 

	public function get_title() {
		return __( 'Home Featured', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_categories() {
		return [ 'shopnex-elementor' ];
	}

	public function get_script_depends() {
		return [];
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
			'hero_tag',
			[
				'label' => esc_html__( 'Tag Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'New Season 2026', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter tag text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Define Your Style', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter title', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Thoughtfully designed furniture and home objects that bring calm to everyday living.', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter description', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'primary_btn_text',
			[
				'label' => esc_html__( 'Primary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop New Arrivals', 'spiraclethemes-site-library' ),
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
			'secondary_btn_text',
			[
				'label' => esc_html__( 'Secondary Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View Lookbook', 'spiraclethemes-site-library' ),
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

		$this->add_control(
			'show_scroll_indicator',
			[
				'label' => esc_html__( 'Show Scroll Indicator', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Background Image Section ──────────────────────────────
		$this->start_controls_section(
			'section_background',
			[
				'label' => esc_html__( 'Background Image', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_image',
			[
				'label' => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'hero_image_size',
				'default' => 'large',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'min_height',
			[
				'label' => esc_html__( 'Min Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 580,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Overlay Settings ──────────────────────────────────────
		$this->start_controls_section(
			'section_overlay',
			[
				'label' => esc_html__( 'Overlay', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(28, 28, 28, 0.45)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-overlay' => 'background: linear-gradient(135deg, {{VALUE}} 0%, rgba(28, 28, 28, 0.15) 40%, rgba(28, 28, 28, 0) 65%, rgba(28, 28, 28, 0.08) 100%);',
				],
			]
		);

		$this->end_controls_section();


		// ─── Tag Style ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_tag_style',
			[
				'label' => esc_html__( 'Tag', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'tag_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopnex-hero-tag',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 11 ] ],
					'font_weight' => [ 'default' => 500 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 1 ] ],
				],
			]
		);

		$this->add_responsive_control(
			'tag_font_size',
			[
				'label' => esc_html__( 'Font Size', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 32,
					],
					'em' => [
						'min' => 0.5,
						'max' => 2,
					],
					'rem' => [
						'min' => 0.5,
						'max' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-tag' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, 0.2)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-tag' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, 0.35)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-tag' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Title Style ───────────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .shopnex-hero-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 56 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_responsive_control(
			'title_font_size',
			[
				'label' => esc_html__( 'Font Size', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vw' ],
				'range' => [
					'px' => [
						'min' => 16,
						'max' => 120,
					],
					'em' => [
						'min' => 1,
						'max' => 8,
					],
					'rem' => [
						'min' => 1,
						'max' => 8,
					],
					'vw' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin Bottom (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 60,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Description Style ─────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .shopnex-hero-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 350 ],
				],
			]
		);

		$this->add_responsive_control(
			'desc_font_size',
			[
				'label' => esc_html__( 'Font Size', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 40,
					],
					'em' => [
						'min' => 0.5,
						'max' => 3,
					],
					'rem' => [
						'min' => 0.5,
						'max' => 3,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-desc' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, 0.85)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Buttons Style ─────────────────────────────────────────
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
				'selector' => '{{WRAPPER}} .shopnex-hero .shopnex-btn',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_responsive_control(
			'btn_font_size',
			[
				'label' => esc_html__( 'Font Size', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 32,
					],
					'em' => [
						'min' => 0.5,
						'max' => 2,
					],
					'rem' => [
						'min' => 0.5,
						'max' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero .shopnex-btn' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_bg',
			[
				'label' => esc_html__( 'Primary Button Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopnex-btn-primary' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_color',
			[
				'label' => esc_html__( 'Primary Button Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopnex-btn-primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_bg_hover',
			[
				'label' => esc_html__( 'Primary Button Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F0ECE6',
				'selectors' => [
					'{{WRAPPER}} .shopnex-btn-primary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_color',
			[
				'label' => esc_html__( 'Secondary Button Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .shopnex-btn-outline' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_border',
			[
				'label' => esc_html__( 'Secondary Button Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255, 255, 255, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .shopnex-btn-outline' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_border_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero .shopnex-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'btn_padding',
			[
				'label' => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 14,
					'right' => 32,
					'bottom' => 14,
					'left' => 32,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero .shopnex-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Content Position ──────────────────────────────────────
		$this->start_controls_section(
			'section_content_position',
			[
				'label' => esc_html__( 'Content Position', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 60,
					'right' => 40,
					'bottom' => 60,
					'left' => 60,
					'unit' => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_max_width',
			[
				'label' => esc_html__( 'Content Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 300,
						'max' => 900,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 560,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero-content' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hero_border_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'hero_margin_bottom',
			[
				'label' => esc_html__( 'Margin Bottom (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 120,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .shopnex-hero' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/home-featured/template/view.php';
	}
}
