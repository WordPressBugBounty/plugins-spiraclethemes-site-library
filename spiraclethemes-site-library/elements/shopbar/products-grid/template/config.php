<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shopbar_Products_Grid extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-products-grid';
	}

	public function get_title() {
		return __( 'Products Grid', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'products', 'shop', 'grid', 'bestsellers', 'woocommerce', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Section Header ───────────────────────────────
		$this->start_controls_section(
			'section_header',
			[
				'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_header',
			[
				'label' => esc_html__( 'Show Header', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'header_eyebrow',
			[
				'label' => esc_html__( 'Eyebrow / Pre-title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Top Picks', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_header' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'header_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Bestselling Products', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_header' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_control(
			'header_desc',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Hand-picked favourites our shoppers keep coming back for.', 'spiraclethemes-site-library' ),
				'condition' => [ 'show_header' => 'yes' ],
				'label_block' => true,
			]
		);

		$this->add_responsive_control(
			'header_align',
			[
				'label' => esc_html__( 'Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'start'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
					'end'    => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),  'icon' => 'eicon-text-align-right' ],
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-head' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
				],
				'condition' => [ 'show_header' => 'yes' ],
			]
		);

		$this->end_controls_section();


		// ─── Content: Product Query ────────────────────────────────
		$this->start_controls_section(
			'section_query',
			[
				'label' => esc_html__( 'Product Query', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'prod_count',
			[
				'label' => esc_html__( 'Number of Products', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
				'min' => 1,
				'max' => 24,
			]
		);

		$this->add_control(
			'prod_orderby',
			[
				'label' => esc_html__( 'Order By', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'popularity',
				'options' => [
					'popularity'  => esc_html__( 'Popularity (Best Sellers)', 'spiraclethemes-site-library' ),
					'date'        => esc_html__( 'Newest First', 'spiraclethemes-site-library' ),
					'price'       => esc_html__( 'Price: Low to High', 'spiraclethemes-site-library' ),
					'price-desc'  => esc_html__( 'Price: High to Low', 'spiraclethemes-site-library' ),
					'rating'      => esc_html__( 'Top Rated', 'spiraclethemes-site-library' ),
					'rand'        => esc_html__( 'Random', 'spiraclethemes-site-library' ),
					'title'       => esc_html__( 'Title (A-Z)', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'prod_categories',
			[
				'label' => esc_html__( 'Product Categories', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter category slugs separated by comma. Leave empty for all categories.', 'spiraclethemes-site-library' ),
				'default' => '',
				'placeholder' => esc_html__( 'e.g. electronics, fashion', 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Content: Product Elements ─────────────────────────────
		$this->start_controls_section(
			'section_elements',
			[
				'label' => esc_html__( 'Product Elements', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_badge',
			[
				'label' => esc_html__( 'Show Badge (Sale / New / Stock)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_category',
			[
				'label' => esc_html__( 'Show Category', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_description',
			[
				'label' => esc_html__( 'Show Short Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label' => esc_html__( 'Show Rating', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_price',
			[
				'label' => esc_html__( 'Show Price', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_add_to_cart',
			[
				'label' => esc_html__( 'Show Add to Cart Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		/**
		 * Pro features (Wishlist, Quick View, Compare) are supplied by the
		 * shopbar-pro-addons plugin.
		 */
		$is_pro = $this->is_pro_active();

		$this->add_control(
			'pro_active',
			[
				'type'    => Controls_Manager::HIDDEN,
				'default' => $is_pro ? 'yes' : 'no',
			]
		);

		$this->add_control(
			'pro_actions_heading',
			[
				'type'      => Controls_Manager::RAW_HTML,
				'raw'       => '<div style="font-size:12px;font-weight:600;color:#1C1C1C;text-transform:uppercase;letter-spacing:.05em;">' . esc_html__( 'Image Action Icons', 'spiraclethemes-site-library' ) . '</div>',
				'condition' => [ 'pro_active' => 'yes' ],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_wishlist',
			[
				'label'        => esc_html__( 'Show Wishlist (Pro)', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'pro_active' => 'yes' ],
			]
		);

		$this->add_control(
			'show_quickview',
			[
				'label'        => esc_html__( 'Show Quick View (Pro)', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'pro_active' => 'yes' ],
			]
		);

		$this->add_control(
			'show_compare',
			[
				'label'        => esc_html__( 'Show Compare (Pro)', 'spiraclethemes-site-library' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [ 'pro_active' => 'yes' ],
			]
		);

		$this->add_control(
			'pro_actions_upsell',
			[
				'type'             => Controls_Manager::RAW_HTML,
				'raw'              => '<p style="margin:0 0 6px;">' . esc_html__( 'Wishlist, Quick View and Compare are top-left image overlay icons included in the Shopbar Pro Addons plugin.', 'spiraclethemes-site-library' ) . '</p><a href="https://www.spiraclethemes.com/shopbar-pro-addons/" target="_blank" rel="noopener noreferrer" style="color:#B8977E;font-weight:600;text-decoration:none;">' . esc_html__( 'Get Shopbar Pro Addons &rarr;', 'spiraclethemes-site-library' ) . '</a>',
				'condition'        => [ 'pro_active' => 'no' ],
				'content_classes'  => 'elementor-panel-alert elementor-panel-alert-info',
				'separator'        => 'before',
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
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '' ],
				'range' => [ '' => [ 'min' => 1, 'max' => 6, 'step' => 1 ] ],
				'default' => [ 'unit' => '', 'size' => 4 ],
				'tablet_default' => [ 'unit' => '', 'size' => 2 ],
				'mobile_default' => [ 'unit' => '', 'size' => 2 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-grid' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Section Header ─────────────────────────────────
		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_header' => 'yes' ],
			]
		);

		$this->add_control(
			'header_eyebrow_color',
			[
				'label' => esc_html__( 'Eyebrow Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-heading',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 30 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'header_title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-heading' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_desc_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-head .shopbar-pg-desc',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'header_desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-head .shopbar-pg-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_spacing',
			[
				'label' => esc_html__( 'Header Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 100 ] ],
				'default' => [ 'unit' => 'px', 'size' => 34 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Cards ──────────────────────────────────────────
		$this->start_controls_section(
			'section_style_card',
			[
				'label' => esc_html__( 'Product Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'card_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-card' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'card_border',
				'selector' => '{{WRAPPER}} .shopbar-pg-card',
				'fields_options' => [
					'border' => [ 'default' => 'none' ],
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 10 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-card' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'label' => esc_html__( 'Resting Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-card',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow_hover',
				'label' => esc_html__( 'Hover Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-card:hover',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical' => 12,
							'blur' => 40,
							'spread' => 0,
							'color' => 'rgba(28, 28, 28, 0.08)',
							'is_inset' => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'info_padding',
			[
				'label' => esc_html__( 'Info Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 18, 'right' => 16, 'bottom' => 18, 'left' => 16, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ──────────────────────────────────────────
		$this->start_controls_section(
			'section_style_image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_bg',
			[
				'label' => esc_html__( 'Stage Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F3EFEA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-imglink' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_ratio',
			[
				'label' => esc_html__( 'Aspect Ratio', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1-1',
				'options' => [
					'1-1'  => esc_html__( 'Square (1:1)', 'spiraclethemes-site-library' ),
					'4-3'  => esc_html__( 'Landscape (4:3)', 'spiraclethemes-site-library' ),
					'3-4'  => esc_html__( 'Portrait (3:4)', 'spiraclethemes-site-library' ),
					'auto' => esc_html__( 'Natural', 'spiraclethemes-site-library' ),
				],
			]
		);

		$this->add_control(
			'image_height',
			[
				'label' => esc_html__( 'Fixed Height (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 120, 'max' => 520 ] ],
				'default' => [ 'unit' => 'px', 'size' => 280 ],
				'condition' => [ 'image_ratio' => 'auto' ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-imglink' => 'aspect-ratio: auto; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_zoom',
			[
				'label' => esc_html__( 'Hover Zoom', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 100, 'max' => 130 ] ],
				'default' => [ 'unit' => 'px', 'size' => 105 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-card:hover .shopbar-pg-img' => 'transform: scale(calc({{SIZE}} / 100));',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Product Name ───────────────────────────────────
		$this->start_controls_section(
			'section_style_name',
			[
				'label' => esc_html__( 'Product Name', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-name',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 500 ],
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-card:hover .shopbar-pg-name a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Category, Description & Rating ────────────────
		$this->start_controls_section(
			'section_style_meta',
			[
				'label' => esc_html__( 'Category, Description & Rating', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => esc_html__( 'Category Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-cat',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 400 ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.02 ] ],
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => esc_html__( 'Category Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-cat' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-info .shopbar-pg-desc',
				'condition' => [ 'show_description' => 'yes' ],
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12.5 ] ],
					'font_weight' => [ 'default' => 400 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.45 ] ],
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'condition' => [ 'show_description' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-info .shopbar-pg-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__( 'Star Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFB800',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-rating .star-rating::before' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopbar-pg-rating .star-rating span::before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Price ──────────────────────────────────────────
		$this->start_controls_section(
			'section_style_price',
			[
				'label' => esc_html__( 'Price', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Price Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-price .woocommerce-Price-amount',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-price .woocommerce-Price-amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'price_sale_color',
			[
				'label' => esc_html__( 'Sale Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C44D4D',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-price .price ins .woocommerce-Price-amount' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label' => esc_html__( 'Old Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-price .price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ──────────────────────────────────────────
		$this->start_controls_section(
			'section_style_badge',
			[
				'label' => esc_html__( 'Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'show_badge' => 'yes' ],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-pg-badge',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 10 ] ],
					'font_weight' => [ 'default' => 500 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.07 ] ],
				],
			]
		);

		$this->add_control(
			'badge_text_color',
			[
				'label' => esc_html__( 'Badge Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_sale_bg',
			[
				'label' => esc_html__( '"Sale" Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C44D4D',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-badge.badge-sale' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_new_bg',
			[
				'label' => esc_html__( '"New" Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-badge.badge-new' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_oos_bg',
			[
				'label' => esc_html__( '"Sold Out" Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9C9792',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-badge.badge-oos' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_radius',
			[
				'label' => esc_html__( 'Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 50 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 5, 'right' => 12, 'bottom' => 5, 'left' => 12, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Add to Cart Button ────────────────────────────
		$this->start_controls_section(
			'section_style_actions',
			[
				'label' => esc_html__( 'Add to Cart Button', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'action_size',
			[
				'label' => esc_html__( 'Button Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 28, 'max' => 56 ] ],
				'default' => [ 'unit' => 'px', 'size' => 38 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'action_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'action_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'action_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions button:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'action_hover_color',
			[
				'label' => esc_html__( 'Hover Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// ─── Style: Action Icons (Pro) ────────────────────────────
		// Wishlist / Quick View / Compare render inline in the footer
		// action row (next to add-to-cart), matching the product-carousel
		// card. They only exist when shopbar-pro-addons is active.
		$this->start_controls_section(
			'section_style_tools',
			[
				'label' => esc_html__( 'Action Icons (Pro)', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [ 'pro_active' => 'yes' ],
			]
		);

		$this->add_control(
			'tool_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 26, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 38 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-qv, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tool_radius',
			[
				'label' => esc_html__( 'Radius (%)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ '%' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => '%', 'size' => 50 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-qv, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tool_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 20 ] ],
				'default' => [ 'unit' => 'px', 'size' => 6 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tool_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-qv, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tool_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-qv, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tool_hover_bg',
			[
				'label' => esc_html__( 'Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish:hover, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-qv:hover, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tool_hover_color',
			[
				'label' => esc_html__( 'Hover Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish:hover, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-qv:hover, {{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tool_active_color',
			[
				'label' => esc_html__( 'Wishlist Active Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF3D81',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish.active' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-wish.active svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tool_compare_color',
			[
				'label' => esc_html__( 'Compare Active Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#0072FF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-pg-actions .shopbar-pg-compare.active' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Detect whether the Shopbar Pro Addons plugin is active.
	 *
	 * Wishlist, Quick View and Compare are Pro features supplied by the
	 * shopbar-pro-addons plugin. They are only rendered/styled when this
	 * returns true.
	 *
	 * @return bool
	 */
	private function is_pro_active() {
		return defined( 'SBPA_VERSION' )
			|| class_exists( 'Shopbar_Pro_Addons' )
			|| function_exists( 'sbpa_fs' );
	}

	/**
	 * Check if product is new (published within last 30 days).
	 *
	 * @param WC_Product $product WooCommerce product object.
	 * @return bool
	 */
	private function is_product_new( $product ) {
		$created = get_the_date( 'U', $product->get_id() );
		$now     = current_time( 'U' );
		$days    = 30;
		return ( $now - $created ) <= ( $days * DAY_IN_SECONDS );
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		require __DIR__ . '/view.php';
	}

	protected function content_template() {}
}
