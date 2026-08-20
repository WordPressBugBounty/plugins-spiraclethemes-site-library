<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Helper: outline SVG icons available for the category list.
 *
 * Returns the icon key -> option label pairs. The matching SVG markup lives
 * in view.php via shopbar_hf_render_icon(). The icons follow the same outline
 * style used throughout the Shopbar theme (stroke based, 24x24 viewBox).
 *
 * @return array
 */
function shopbar_hf_icon_options() {
	return array(
		''           => esc_html__( '— None —', 'spiraclethemes-site-library' ),
		'headphones' => esc_html__( 'Headphones (Electronics)', 'spiraclethemes-site-library' ),
		'shirt'      => esc_html__( 'Shirt (Fashion)', 'spiraclethemes-site-library' ),
		'home'       => esc_html__( 'Home (Home & Kitchen)', 'spiraclethemes-site-library' ),
		'sparkles'   => esc_html__( 'Sparkles (Beauty)', 'spiraclethemes-site-library' ),
		'dumbbell'   => esc_html__( 'Dumbbell (Sports)', 'spiraclethemes-site-library' ),
		'gamepad'    => esc_html__( 'Gamepad (Toys)', 'spiraclethemes-site-library' ),
		'car'        => esc_html__( 'Car (Automotive)', 'spiraclethemes-site-library' ),
		'book'       => esc_html__( 'Book (Stationery)', 'spiraclethemes-site-library' ),
		'bag'        => esc_html__( 'Bag', 'spiraclethemes-site-library' ),
		'watch'      => esc_html__( 'Watch', 'spiraclethemes-site-library' ),
		'gift'       => esc_html__( 'Gift', 'spiraclethemes-site-library' ),
		'heart'      => esc_html__( 'Heart', 'spiraclethemes-site-library' ),
		'baby'       => esc_html__( 'Baby', 'spiraclethemes-site-library' ),
		'paw'        => esc_html__( 'Paw (Pets)', 'spiraclethemes-site-library' ),
		'grid'       => esc_html__( 'Grid (All Categories)', 'spiraclethemes-site-library' ),
	);
}

class Shopbar_Home_Featured extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-home-featured';
	}

	public function get_title() {
		return __( 'Home Featured', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-image-rollover';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'hero', 'banner', 'categories', 'shop', 'featured', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Categories ────────────────────────────────────
		$this->start_controls_section(
			'section_categories',
			[
				'label' => esc_html__( 'Category Sidebar', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_sidebar',
			[
				'label' => esc_html__( 'Show Category Sidebar', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sidebar_title',
			[
				'label' => esc_html__( 'Sidebar Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop by Category', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_sidebar' => 'yes',
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'headphones',
				'options' => shopbar_hf_icon_options(),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Electronics', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'link',
			[
				'label' => esc_html__( 'Link', 'spiraclethemes-site-library' ),
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

		$default_cats = [
			[ 'icon' => 'headphones', 'label' => __( 'Electronics', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'shirt',      'label' => __( 'Fashion & Apparel', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'home',       'label' => __( 'Home & Kitchen', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'sparkles',   'label' => __( 'Beauty & Personal Care', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'dumbbell',   'label' => __( 'Sports & Outdoors', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'gamepad',    'label' => __( 'Toys & Games', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'car',        'label' => __( 'Automotive', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'book',       'label' => __( 'Books & Stationery', 'spiraclethemes-site-library' ) ],
		];

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Categories', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default_cats,
				'title_field' => '{{{ label }}}',
				'condition' => [
					'show_sidebar' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_see_all',
			[
				'label' => esc_html__( 'Show "See All Categories" Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'show_sidebar' => 'yes',
				],
			]
		);

		$this->add_control(
			'see_all_text',
			[
				'label' => esc_html__( '"See All" Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'See All Categories', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_sidebar' => 'yes',
					'show_see_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'see_all_link',
			[
				'label' => esc_html__( '"See All" Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => [
					'show_sidebar' => 'yes',
					'show_see_all' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Content: Banner ────────────────────────────────────────
		$this->start_controls_section(
			'section_banner',
			[
				'label' => esc_html__( 'Banner Content', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow_text',
			[
				'label' => esc_html__( 'Eyebrow Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Summer Collection 2026', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'banner_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Elevate Your Style This Summer', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'banner_description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Discover the latest trends in fashion, made for comfort and elegance.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'btn_text',
			[
				'label' => esc_html__( 'Button Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop Now', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'btn_url',
			[
				'label' => esc_html__( 'Button URL', 'spiraclethemes-site-library' ),
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
				'label' => esc_html__( 'Button Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fa-solid fa-arrow-right',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'arrow-right', 'shopping-bag', 'cart-plus' ] ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Banner Media ──────────────────────────────────
		$this->start_controls_section(
			'section_media',
			[
				'label' => esc_html__( 'Banner Image', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'banner_bg_type',
			[
				'label' => esc_html__( 'Banner Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'gradient' => esc_html__( 'Gradient', 'spiraclethemes-site-library' ),
					'image' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				],
			]
		);

		// ── Gradient background ──
		$this->add_control(
			'gradient_color_1',
			[
				'label' => esc_html__( 'Gradient Color 1', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5F5F5',
				'condition' => [ 'banner_bg_type' => 'gradient' ],
			]
		);

		$this->add_control(
			'gradient_color_2',
			[
				'label' => esc_html__( 'Gradient Color 2', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#EBEBEB',
				'condition' => [ 'banner_bg_type' => 'gradient' ],
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
			'condition' => [ 'banner_bg_type' => 'gradient' ],
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
			'description' => esc_html__( 'Displays a subtle cluster of outline shopping icons in the bottom-right of the banner.', 'spiraclethemes-site-library' ),
			'condition' => [ 'banner_bg_type' => 'gradient' ],
		]
	);

	$this->add_control(
		'decor_color',
		[
			'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
			'condition' => [
				'banner_bg_type' => 'gradient',
				'show_decor_icons' => 'yes',
			],
		]
	);

	$this->add_control(
		'decor_opacity',
		[
			'label' => esc_html__( 'Icon Opacity (%)', 'spiraclethemes-site-library' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
			'default' => [ 'unit' => '%', 'size' => 100 ],
			'condition' => [
				'banner_bg_type' => 'gradient',
				'show_decor_icons' => 'yes',
			],
		]
	);

	$this->add_control(
		'decor_size',
		[
			'label' => esc_html__( 'Icon Size (%)', 'spiraclethemes-site-library' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [ '%' => [ 'min' => 40, 'max' => 200 ] ],
			'default' => [ 'unit' => '%', 'size' => 100 ],
			'condition' => [
				'banner_bg_type' => 'gradient',
				'show_decor_icons' => 'yes',
			],
		]
	);

	// ── Image background ──
	$this->add_control(
		'banner_image',
		[
			'label' => esc_html__( 'Background Image', 'spiraclethemes-site-library' ),
			'type' => Controls_Manager::MEDIA,
			'default' => [
				'url' => Utils::get_placeholder_image_src(),
			],
			'condition' => [ 'banner_bg_type' => 'image' ],
		]
	);

		$this->add_control(
			'overlay_color',
			[
				'label' => esc_html__( 'Image Overlay Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0B0B0F',
				'condition' => [ 'banner_bg_type' => 'image' ],
			]
		);

		$this->add_control(
			'overlay_opacity',
			[
				'label' => esc_html__( 'Overlay Opacity (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 0, 'max' => 100 ] ],
				'default' => [ 'unit' => '%', 'size' => 55 ],
				'condition' => [ 'banner_bg_type' => 'image' ],
			]
		);

		$this->add_control(
			'content_width',
			[
				'label' => esc_html__( 'Content Width (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 30, 'max' => 90 ] ],
				'default' => [ 'unit' => '%', 'size' => 52 ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Discount Badge ────────────────────────────────
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
				'default' => esc_html__( 'UP TO', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_control(
			'badge_main_text',
			[
				'label' => esc_html__( 'Main Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '50%', 'spiraclethemes-site-library' ),
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


		// ─── Style: Layout ──────────────────────────────────────────
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
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
					'{{WRAPPER}} .shopbar-hf-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 28, 'right' => 0, 'bottom' => 28, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'columns_gap',
			[
				'label' => esc_html__( 'Gap Between Sidebar & Banner (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'sidebar_width',
			[
				'label' => esc_html__( 'Sidebar Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 180, 'max' => 320 ] ],
				'default' => [ 'unit' => 'px', 'size' => 244 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-sidebar' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [ 'show_sidebar' => 'yes' ],
			]
		);

		$this->add_responsive_control(
			'banner_min_height',
			[
				'label' => esc_html__( 'Banner Min Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 280, 'max' => 600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 420 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-banner' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'radius',
			[
				'label' => esc_html__( 'Banner Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-banner' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Sidebar ─────────────────────────────────────────
		$this->start_controls_section(
			'section_sidebar_style',
			[
				'label' => esc_html__( 'Category Sidebar', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_sidebar' => 'yes' ],
			]
		);

		$this->add_control(
			'sidebar_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-sidebar' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sidebar_border',
				'label' => esc_html__( 'Border', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-hf-sidebar',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width' => [ 'default' => [ 'top' => '1', 'right' => '1', 'bottom' => '1', 'left' => '1', 'unit' => 'px', 'isLinked' => true ] ],
					'color' => [ 'default' => '#E8E4DF' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cat_typography',
				'label' => esc_html__( 'Item Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-hf-cat-link',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'cat_color',
			[
				'label' => esc_html__( 'Item Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-cat-link' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cat_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-cat-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cat_hover_bg',
			[
				'label' => esc_html__( 'Item Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F8F9FA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-cat-link:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'cat_hover_color',
			[
				'label' => esc_html__( 'Item Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0072FF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-cat-link:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ───────────────────────────────────────────
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title & Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-hf-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 40 ] ],
					'font_weight' => [ 'default' => 800 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.12 ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-hf-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F5F5F5',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Eyebrow Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF3D81',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Button ──────────────────────────────────────────
		$this->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-hf-btn',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'btn_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .shopbar-hf-btn i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_hover_color',
			[
				'label' => esc_html__( 'Hover Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_icon_hover_color',
			[
				'label' => esc_html__( 'Hover Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn:hover svg' => 'color: {{VALUE}}; fill: {{VALUE}};',
					'{{WRAPPER}} .shopbar-hf-btn:hover i' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'btn_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 8 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-btn' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ───────────────────────────────────────────
		$this->start_controls_section(
			'section_badge_style',
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
					'{{WRAPPER}} .shopbar-hf-badge' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopbar-hf-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_size',
			[
				'label' => esc_html__( 'Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 60, 'max' => 160 ] ],
				'default' => [ 'unit' => 'px', 'size' => 92 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-badge' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_top',
			[
				'label' => esc_html__( 'Position Top (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 36 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_position_right',
		[
				'label' => esc_html__( 'Position Right (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 36 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-hf-badge' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shopbar/home-featured/template/view.php';
	}
}
