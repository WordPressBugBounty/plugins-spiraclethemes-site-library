<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_HomeHero extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-home-hero';
	}

	public function get_title() {
		return __( 'Home Hero', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'hero', 'banner', 'pawwell', 'pet', 'shop', 'landing' ];
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
			'eyebrow_icon',
			[
				'label' => esc_html__( 'Eyebrow Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-paw',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'paw', 'heart', 'star', 'shield-alt' ] ],
			]
		);

		$this->add_control(
			'eyebrow_text',
			[
				'label' => esc_html__( 'Eyebrow Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Trusted by 50,000+ pet parents', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter eyebrow text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Healthy Pets,', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter title', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_title_accent',
			[
				'label' => esc_html__( 'Title Accent (Highlighted Part)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Happy Hearts', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter accent text', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Shop premium nutrition, vet-approved supplements, grooming essentials, and playful accessories — everything your furry family member deserves, in one place.', 'spiraclethemes-site-library' ),
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
					'value' => 'fas fa-arrow-right',
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
				'default' => esc_html__( 'Book Vet Visit', 'spiraclethemes-site-library' ),
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


		// ─── Stats Section ─────────────────────────────────────────
		$this->start_controls_section(
			'section_stats',
			[
				'label' => esc_html__( 'Stats', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'stat_value',
			[
				'label' => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '500', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'stat_suffix',
			[
				'label' => esc_html__( 'Suffix', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => '+',
			]
		);

		$repeater->add_control(
			'stat_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Vet-Approved Products', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'stats',
			[
				'label' => esc_html__( 'Stats Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'stat_value' => '500',
						'stat_suffix' => '+',
						'stat_label' => esc_html__( 'Vet-Approved Products', 'spiraclethemes-site-library' ),
					],
					[
						'stat_value' => '4.9',
						'stat_suffix' => '★',
						'stat_label' => esc_html__( 'Average Rating', 'spiraclethemes-site-library' ),
					],
					[
						'stat_value' => '24',
						'stat_suffix' => '/7',
						'stat_label' => esc_html__( 'Pet Care Support', 'spiraclethemes-site-library' ),
					],
				],
				'title_field' => '{{{ stat_value }}}{{{ stat_suffix }}} — {{{ stat_label }}}',
			]
		);

		$this->end_controls_section();


		// ─── Image & Floating Cards ────────────────────────────────
		$this->start_controls_section(
			'section_image',
			[
				'label' => esc_html__( 'Image & Floating Cards', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'hero_image',
			[
				'label' => esc_html__( 'Hero Image', 'spiraclethemes-site-library' ),
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
			'show_floating_cards',
			[
				'label' => esc_html__( 'Show Floating Cards', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_floating_cards_mobile',
			[
				'label' => esc_html__( 'Show Floating Cards on Tablet & Mobile', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_floating_cards' => 'yes',
				],
			]
		);

		$float_repeater = new Repeater();

		$float_repeater->add_control(
			'float_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-shield-alt',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'shield-alt', 'truck', 'heart', 'star', 'paw', 'leaf', 'medal' ] ],
			]
		);

		$float_repeater->add_control(
			'float_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e3f7f0',
			]
		);

		$float_repeater->add_control(
			'float_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1abc9c',
			]
		);

		$float_repeater->add_control(
			'float_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Vet Approved', 'spiraclethemes-site-library' ),
			]
		);

		$float_repeater->add_control(
			'float_meta',
			[
				'label' => esc_html__( 'Meta', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '★★★★★ Certified', 'spiraclethemes-site-library' ),
			]
		);

		$float_repeater->add_control(
			'float_position',
			[
				'label' => esc_html__( 'Position', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top-right',
				'options' => [
					'top-right' => esc_html__( 'Top Right', 'spiraclethemes-site-library' ),
					'bottom-left' => esc_html__( 'Bottom Left', 'spiraclethemes-site-library' ),
					'bottom-right' => esc_html__( 'Bottom Right', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'floating_cards',
			[
				'label' => esc_html__( 'Floating Cards', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $float_repeater->get_controls(),
				'default' => [
					[
						'float_title' => esc_html__( 'Vet Approved', 'spiraclethemes-site-library' ),
						'float_meta' => esc_html__( '★★★★★ Certified', 'spiraclethemes-site-library' ),
						'float_position' => 'top-right',
					],
					[
						'float_icon' => [ 'value' => 'fas fa-truck', 'library' => 'fa-solid' ],
						'float_icon_bg' => '#F4E0DA',
						'float_icon_color' => '#C45B3E',
						'float_title' => esc_html__( 'Free Delivery', 'spiraclethemes-site-library' ),
						'float_meta' => esc_html__( 'Orders over $49', 'spiraclethemes-site-library' ),
						'float_position' => 'bottom-left',
					],
				],
				'title_field' => '{{{ float_title }}}',
				'condition' => [
					'show_floating_cards' => 'yes',
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
				'default' => '#FAF6F1',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blob_1_color',
			[
				'label' => esc_html__( 'Blob 1 Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4E0DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-blob-1' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blob_2_color',
			[
				'label' => esc_html__( 'Blob 2 Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8EFE3',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-blob-2' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blob_3_color',
			[
				'label' => esc_html__( 'Blob 3 Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5ECD5',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-blob-3' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_blobs',
			[
				'label' => esc_html__( 'Show Background Blobs', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-blob' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'block',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'min_height',
			[
				'label' => esc_html__( 'Min Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 400,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 700,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_wrap_size',
			[
				'label' => esc_html__( 'Image Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 240,
						'max' => 600,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 460,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-image-wrap' => 'width: {{SIZE}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .pawwell-hh-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2D2D2D',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eyebrow_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-eyebrow i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-hh-eyebrow svg' => 'fill: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-hh-eyebrow' => 'background: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .pawwell-hh-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 68 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
			'heading_align',
			[
				'label' => esc_html__( 'Heading Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Accent (Highlighted) Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-title .accent' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-hh-title .accent::after' => 'background: {{VALUE}}30;',
				],
			]
		);

		$this->add_control(
			'accent_highlight_color',
			[
				'label' => esc_html__( 'Accent Underline Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4E0DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-title .accent::after' => 'background: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .pawwell-hh-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 18 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-sub' => 'color: {{VALUE}};',
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
				'selector' => '{{WRAPPER}} .pawwell-hh .pawwell-hh-btn',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'primary_btn_bg',
			[
				'label' => esc_html__( 'Primary Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-primary' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-hh-btn-primary' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-hh-btn-primary i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-hh-btn-primary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_icon_color',
			[
				'label' => esc_html__( 'Primary Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-primary i' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pawwell-hh-btn-primary svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'primary_btn_hover',
			[
				'label' => esc_html__( 'Primary Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#2D2D2D',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-primary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_color',
			[
				'label' => esc_html__( 'Secondary Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-secondary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_border',
			[
				'label' => esc_html__( 'Secondary Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-secondary' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_hover_bg',
			[
				'label' => esc_html__( 'Secondary Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-secondary:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondary_btn_hover_color',
			[
				'label' => esc_html__( 'Secondary Hover Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-btn-secondary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh .pawwell-hh-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Stats ──────────────────────────────────────────
		$this->start_controls_section(
			'section_stats_style',
			[
				'label' => esc_html__( 'Stats', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'stat_value_typography',
				'label' => esc_html__( 'Value Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-hh-stat-value',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 28 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'stat_value_color',
			[
				'label' => esc_html__( 'Value Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-stat-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stat_label_color',
			[
				'label' => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-hh-stat-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/home-hero/template/view.php';
	}
}
