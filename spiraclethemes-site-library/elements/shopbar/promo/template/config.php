<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Promo Banner
 *
 * A single (or grid of) editorial promotional banner(s) for the Shopbar theme.
 * Warm cream canvas, Fraunces display headline, warm-accent eyebrow pill, an
 * optional product image and a decorative ghost watermark — all on-brand.
 *
 * @since 1.0.0
 */
class Shopbar_Promo extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-promo';
	}

	public function get_title() {
		return __( 'Promo Banner', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-price-table';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'promo', 'deal', 'offer', 'banner', 'sale', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Promo Items ────────────────────────────────────
		$this->start_controls_section(
			'section_promo',
			[
				'label' => esc_html__( 'Promo Banners', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'tag',
			[
				'label'       => esc_html__( 'Eyebrow Tag', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Limited Time', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Mid-Season Sale', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Refresh your space with up to 40% off selected favourites. Ends soon.', 'spiraclethemes-site-library' ),
				'rows'        => 3,
			]
		);

		$repeater->add_control(
			'show_price',
			[
				'label'        => esc_html__( 'Show Price', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$repeater->add_control(
			'price_now',
			[
				'label'       => esc_html__( 'Price (Now)', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '$129', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_price' => 'yes' ],
			]
		);

		$repeater->add_control(
			'price_old',
			[
				'label'       => esc_html__( 'Price (Old)', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '$199', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition'   => [ 'show_price' => 'yes' ],
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Button Text', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Shop the Sale', 'spiraclethemes-site-library' ),
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
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
			]
		);

		$repeater->add_control(
			'image',
			[
				'label'   => esc_html__( 'Product Image', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'ghost_text',
			[
				'label'       => esc_html__( 'Watermark Text (optional)', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'A large faded word or percentage shown behind the content.', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '40%', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$default_items = [
			[
				'tag'         => __( 'Limited Time', 'spiraclethemes-site-library' ),
				'title'       => __( 'Mid-Season Sale', 'spiraclethemes-site-library' ),
				'description' => __( 'Refresh your space with up to 40% off selected favourites. Ends soon.', 'spiraclethemes-site-library' ),
				'show_price'  => 'yes',
				'price_now'   => '$129',
				'price_old'   => '$199',
				'button_text' => __( 'Shop the Sale', 'spiraclethemes-site-library' ),
				'ghost_text'  => '40%',
			],
		];

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Promo Banners', 'spiraclethemes-site-library' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => $default_items,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ─────────────────────────────────────────
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
				'type'            => Controls_Manager::SLIDER,
				'size_units'      => [ '' ],
				'range'           => [ '' => [ 'min' => 1, 'max' => 3, 'step' => 1 ] ],
				'default'         => [ 'unit' => '', 'size' => 1 ],
				'tablet_default'  => [ 'unit' => '', 'size' => 1 ],
				'mobile_default'  => [ 'unit' => '', 'size' => 1 ],
				'selectors'       => [
					'{{WRAPPER}} .shopbar-pm-grid' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'media_position',
			[
				'label'   => esc_html__( 'Image Position', 'spiraclethemes-site-library' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'right',
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-h-align-left' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),  'icon' => 'eicon-h-align-right' ],
					'hidden' => [ 'title' => esc_html__( 'Hidden', 'spiraclethemes-site-library' ), 'icon' => 'eicon-ban' ],
				],
				'prefix_class' => 'shopbar-pm-media-',
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
				'prefix_class' => 'shopbar-pm-align-',
				'toggle'       => false,
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label'      => esc_html__( 'Card Min Height (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [ 'px' => [ 'min' => 200, 'max' => 600 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 340 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-card' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label'      => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label'      => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 24 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ─────────────────────────────────────────────
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
				'default'   => '#F3EFEA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-card' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'card_border',
				'selector' => '{{WRAPPER}} .shopbar-pm-card',
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label'      => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 10 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'card_shadow',
				'selector' => '{{WRAPPER}} .shopbar-pm-card',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical'   => 10,
							'blur'       => 34,
							'spread'     => -12,
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
					'top' => 44, 'right' => 48, 'bottom' => 44, 'left' => 48, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Watermark ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_ghost',
			[
				'label' => esc_html__( 'Watermark', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ghost_color',
			[
				'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-ghost' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ghost_opacity',
			[
				'label'      => esc_html__( 'Opacity (%)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ '' => [ 'min' => 0, 'max' => 30 ] ],
				'default'    => [ 'unit' => '', 'size' => 6 ],
				'size_units' => [ '' ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-ghost' => 'opacity: calc({{SIZE}} / 100);',
				],
				'description' => esc_html__( 'Set as a percentage of opacity (0–30%).', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'ghost_size',
			[
				'label'      => esc_html__( 'Font Size (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 80, 'max' => 360 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 200 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-ghost' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Eyebrow Tag ──────────────────────────────────────
		$this->start_controls_section(
			'section_style_tag',
			[
				'label' => esc_html__( 'Eyebrow Tag', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'tag_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-tag' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tag_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-tag' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'tag_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-pm-tag',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 600 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.8 ] ],
				],
			]
		);

		$this->add_control(
			'tag_radius',
			[
				'label'      => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-tag' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ────────────────────────────────────────────
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
				'selector'       => '{{WRAPPER}} .shopbar-pm-title',
				'fields_options' => [
					'typography'    => [ 'default' => 'yes' ],
					'font_family'   => [ 'default' => 'Fraunces' ],
					'font_size'     => [ 'default' => [ 'size' => 38 ] ],
					'font_weight'   => [ 'default' => 600 ],
					'line_height'   => [ 'default' => [ 'unit' => 'em', 'size' => 1.1 ] ],
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
					'{{WRAPPER}} .shopbar-pm-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Description ──────────────────────────────────────
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
				'selector'       => '{{WRAPPER}} .shopbar-pm-desc',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.6 ] ],
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
					'{{WRAPPER}} .shopbar-pm-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Price ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'price_typography',
				'label'          => esc_html__( 'Price Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-pm-price-now',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 28 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label'     => esc_html__( 'Price Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-price-now' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_old_color',
			[
				'label'     => esc_html__( 'Old Price Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-price-old' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Button ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_button',
			[
				'label' => esc_html__( 'Button', 'spiraclethemes-site-library' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'btn_bg',
			[
				'label'     => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_bg',
			[
				'label'     => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_color',
			[
				'label'     => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-btn-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_hover_color',
			[
				'label'     => esc_html__( 'Icon Hover Color', 'spiraclethemes-site-library' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-btn:hover .shopbar-pm-btn-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'btn_typography',
				'label'          => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector'       => '{{WRAPPER}} .shopbar-pm-btn',
				'separator'      => 'before',
				'fields_options' => [
					'typography'  => [ 'default' => 'yes' ],
					'font_size'   => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'btn_radius',
			[
				'label'      => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default'    => [ 'unit' => 'px', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label'      => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default'    => [
					'top' => 14, 'right' => 26, 'bottom' => 14, 'left' => 26, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_image',
			[
				'label'      => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'condition'  => [ 'media_position!' => 'hidden' ],
			]
		);

		$this->add_responsive_control(
			'image_width',
			[
				'label'      => esc_html__( 'Image Width (%)', 'spiraclethemes-site-library' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [ '%' => [ 'min' => 20, 'max' => 65 ] ],
				'default'    => [ 'unit' => '%', 'size' => 50 ],
				'selectors'  => [
					'{{WRAPPER}} .shopbar-pm-media' => 'flex: 0 0 {{SIZE}}%; width: {{SIZE}}%;',
					'{{WRAPPER}} .shopbar-pm-content' => 'flex-basis: calc(100% - {{SIZE}}%);',
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
					'cover'   => esc_html__( 'Cover (Edge-to-Edge)', 'spiraclethemes-site-library' ),
					'contain' => esc_html__( 'Contain', 'spiraclethemes-site-library' ),
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pm-media img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'image_filters',
				'selector' => '{{WRAPPER}} .shopbar-pm-media img',
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
