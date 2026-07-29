<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Schemes\Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Shop_Zen_Products_Grid extends Widget_Base {

	public function get_name() {
		return 'shopzen-elementor-products-grid';
	}

	public function get_title() {
		return __( 'Products Grid', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'shopzen-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'products', 'shop', 'grid', 'bestsellers', 'featured', 'zen', 'woocommerce' ];
	}

	protected function register_controls() {

		// ─── Content: Section Head ──────────────────────────────────
		$this->start_controls_section(
			'section_head',
			[
				'label' => esc_html__( 'Section Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'product_type',
			[
				'label' => esc_html__( 'Product Type', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'best_sellers',
				'options' => [
					'best_sellers'    => esc_html__( 'Best Sellers', 'spiraclethemes-site-library' ),
					'featured'        => esc_html__( 'Featured Products', 'spiraclethemes-site-library' ),
					'latest'          => esc_html__( 'Latest Products', 'spiraclethemes-site-library' ),
					'top_rated'       => esc_html__( 'Top Rated', 'spiraclethemes-site-library' ),
					'on_sale'         => esc_html__( 'On Sale', 'spiraclethemes-site-library' ),
					'custom'          => esc_html__( 'Custom (Manual)', 'spiraclethemes-site-library' ),
				],
				'description' => esc_html__( 'Choose the source/label for this product grid. The same widget can be reused for Best Sellers, Featured, Latest, etc.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'section_heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Best Sellers', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter heading', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => esc_html__( 'View All Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View All', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'View All Label', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'view_all_link',
			[
				'label' => esc_html__( 'View All Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-shop.com/all', 'spiraclethemes-site-library' ),
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


		// ─── Content: Products ─────────────────────────────────────
		$this->start_controls_section(
			'section_products',
			[
				'label' => esc_html__( 'Products', 'spiraclethemes-site-library' ),
			]
		);

		// WooCommerce source notice (graceful fallback when WC is inactive)
		$this->add_control(
			'woo_source_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<div style="background:#F0F7F2;border:1px solid #C8D9C3;border-radius:8px;padding:12px 14px;font-size:12px;color:#3A5F3F;line-height:1.6;"><strong>WooCommerce:</strong> When WooCommerce is active and "Product Type" is not "Custom", products are pulled automatically using the chosen query. If WooCommerce is inactive or "Product Type" is "Custom", the manual products below are used as a fallback.</div>',
				'separator' => 'after',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'prod_image',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=700&auto=format&fit=crop',
				],
			]
		);

		$repeater->add_control(
			'prod_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Product Name', 'spiraclethemes-site-library' ),
				'placeholder' => esc_html__( 'Enter product title', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'prod_link',
			[
				'label' => esc_html__( 'Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-product.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
			]
		);

		$repeater->add_control(
			'prod_badge_type',
			[
				'label' => esc_html__( 'Badge Type', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'sale',
				'options' => [
					'none' => esc_html__( 'No Badge', 'spiraclethemes-site-library' ),
					'sale' => esc_html__( 'Sale (discount %)', 'spiraclethemes-site-library' ),
					'new'  => esc_html__( 'New', 'spiraclethemes-site-library' ),
				],
			]
		);

		$repeater->add_control(
			'prod_badge_text',
			[
				'label' => esc_html__( 'Badge Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => '-20%',
				'placeholder' => esc_html__( 'e.g. -20% or New', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'condition' => [
					'prod_badge_type' => [ 'sale', 'new' ],
				],
			]
		);

		$repeater->add_control(
			'prod_price',
			[
				'label' => esc_html__( 'Price', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => '$79.99',
				'placeholder' => esc_html__( 'e.g. $79.99', 'spiraclethemes-site-library' ),
				'label_block' => true,
				'dynamic' => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'prod_old_price',
			[
				'label' => esc_html__( 'Old Price', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => '$99.99',
				'placeholder' => esc_html__( 'e.g. $99.99 (leave empty for no strike-through)', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'prod_rating',
			[
				'label' => esc_html__( 'Rating (0-5)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'default' => 4.8,
			]
		);

		$repeater->add_control(
			'prod_reviews',
			[
				'label' => esc_html__( 'Reviews Count', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'step' => 1,
				'default' => 128,
			]
		);

		$repeater->add_control(
			'prod_in_stock',
			[
				'label' => esc_html__( 'Show "IN STOCK" Tag', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'products',
			[
				'label' => esc_html__( 'Products', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'prod_image'    => [ 'url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=700&auto=format&fit=crop' ],
						'prod_title'    => esc_html__( 'Wireless Headphones', 'spiraclethemes-site-library' ),
						'prod_badge_type' => 'sale',
						'prod_badge_text' => '-20%',
						'prod_price'     => '$79.99',
						'prod_old_price' => '$99.99',
						'prod_rating'   => 4.8,
						'prod_reviews'  => 128,
						'prod_in_stock' => 'yes',
					],
					[
						'prod_image'    => [ 'url' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=700&auto=format&fit=crop' ],
						'prod_title'    => esc_html__( 'Ceramic Planter', 'spiraclethemes-site-library' ),
						'prod_badge_type' => 'new',
						'prod_badge_text' => 'New',
						'prod_price'     => '$24.99',
						'prod_old_price' => '',
						'prod_rating'   => 4.9,
						'prod_reviews'  => 89,
						'prod_in_stock' => 'yes',
					],
					[
						'prod_image'    => [ 'url' => 'https://images.unsplash.com/photo-1600369672770-985fd30004eb?w=700&auto=format&fit=crop' ],
						'prod_title'    => esc_html__( 'Linen Throw Blanket', 'spiraclethemes-site-library' ),
						'prod_badge_type' => 'sale',
						'prod_badge_text' => '-20%',
						'prod_price'     => '$39.99',
						'prod_old_price' => '$49.99',
						'prod_rating'   => 4.7,
						'prod_reviews'  => 203,
						'prod_in_stock' => 'yes',
					],
					[
						'prod_image'    => [ 'url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=700&auto=format&fit=crop' ],
						'prod_title'    => esc_html__( 'Running Sneakers', 'spiraclethemes-site-library' ),
						'prod_badge_type' => 'sale',
						'prod_badge_text' => '-25%',
						'prod_price'     => '$59.99',
						'prod_old_price' => '$79.99',
						'prod_rating'   => 4.8,
						'prod_reviews'  => 156,
						'prod_in_stock' => 'yes',
					],
					[
						'prod_image'    => [ 'url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=700&auto=format&fit=crop' ],
						'prod_title'    => esc_html__( 'Minimalist Watch', 'spiraclethemes-site-library' ),
						'prod_badge_type' => 'sale',
						'prod_badge_text' => '-13%',
						'prod_price'     => '$129.99',
						'prod_old_price' => '$149.99',
						'prod_rating'   => 4.9,
						'prod_reviews'  => 94,
						'prod_in_stock' => 'yes',
					],
					[
						'prod_image'    => [ 'url' => 'https://images.unsplash.com/photo-1599901860904-17e6ed7083a0?w=700&auto=format&fit=crop' ],
						'prod_title'    => esc_html__( 'Yoga Mat', 'spiraclethemes-site-library' ),
						'prod_badge_type' => 'new',
						'prod_badge_text' => 'New',
						'prod_price'     => '$29.99',
						'prod_old_price' => '',
						'prod_rating'   => 5.0,
						'prod_reviews'  => 211,
						'prod_in_stock' => 'yes',
					],
				],
				'title_field' => '{{{ prod_title }}}',
				'condition' => [
					'product_type' => 'custom',
				],
			]
		);

		$this->add_control(
			'woo_product_count',
			[
				'label' => esc_html__( 'Number of Products (WooCommerce)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 24,
				'step' => 1,
				'default' => 6,
				'condition' => [
					'product_type' => [ 'best_sellers', 'featured', 'latest', 'top_rated', 'on_sale' ],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'prod_image_size',
				'default' => 'medium_large',
				'exclude' => [ 'custom' ],
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
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 6,
				'step' => 1,
				'default' => 6,
				'tablet_default' => 3,
				'mobile_default' => 2,
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 12 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrap_max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 600, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1280 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-head' => 'max-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .shopzen-pg-grid' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'top'    => 40,
					'right'  => 0,
					'bottom' => 40,
					'left'   => 0,
					'unit'   => 'px',
					'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_dotted_bg',
			[
				'label' => esc_html__( 'Dotted Background Texture', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg' => 'background-image: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'radial-gradient(rgba(0,0,0,0.035) 1px, transparent 1px)',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'section_bg_color',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FCFCFB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Head ───────────────────────────────────────────
		$this->start_controls_section(
			'section_head_style',
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
				'selector' => '{{WRAPPER}} .shopzen-pg-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Outfit' ],
					'font_size' => [ 'default' => [ 'size' => 34 ] ],
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
					'{{WRAPPER}} .shopzen-pg-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'head_spacing',
			[
				'label' => esc_html__( 'Head Bottom Spacing (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-head' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();


		// ─── Style: View All Button ────────────────────────────────
		$this->start_controls_section(
			'section_viewall_style',
			[
				'label' => esc_html__( 'View All Link', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'viewall_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pg-viewall',
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
				'label' => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-viewall' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'viewall_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-viewall' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'viewall_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-viewall' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'viewall_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 999 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-viewall' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'viewall_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 6, 'right' => 12, 'bottom' => 6, 'left' => 12,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-viewall' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ───────────────────────────────────────────
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
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-pg-product' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'card_border_size',
			[
				'label' => esc_html__( 'Border Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 10 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'card_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_shadow',
				'label' => esc_html__( 'Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pg-product',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'card_hover_shadow',
				'label' => esc_html__( 'Hover Box Shadow', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pg-product:hover',
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
					'{{WRAPPER}} .shopzen-pg-product:hover' => 'transform: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'translateY(-3px)',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'card_transition',
			[
				'label' => esc_html__( 'Transition (sec)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 2, 'step' => 0.05 ] ],
				'default' => [ 'unit' => 'px', 'size' => 0.2 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product' => 'transition: transform {{SIZE}}s ease, box-shadow {{SIZE}}s ease;',
					'{{WRAPPER}} .shopzen-pg-product img' => 'transition: transform {{SIZE}}s ease;',
				],
			]
		);

		$this->add_control(
			'corner_accent_heading',
			[
				'label' => esc_html__( 'Corner Accent', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_corner_accent',
			[
				'label' => esc_html__( 'Show Corner Accent', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product::before' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'block',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'corner_accent_color',
			[
				'label' => esc_html__( 'Corner Accent Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product::before' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'show_corner_accent' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Image ──────────────────────────────────────────
		$this->start_controls_section(
			'section_image_style',
			[
				'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_aspect',
			[
				'label' => esc_html__( 'Aspect Ratio', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1 / 1',
				'options' => [
					'1 / 1'  => esc_html__( '1:1 (Square)', 'spiraclethemes-site-library' ),
					'4 / 5'  => esc_html__( '4:5 (Portrait)', 'spiraclethemes-site-library' ),
					'3 / 4'  => esc_html__( '3:4 (Portrait)', 'spiraclethemes-site-library' ),
					'4 / 3'  => esc_html__( '4:3 (Landscape)', 'spiraclethemes-site-library' ),
					'16 / 9' => esc_html__( '16:9 (Wide)', 'spiraclethemes-site-library' ),
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-img' => 'aspect-ratio: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_bg',
			[
				'label' => esc_html__( 'Image Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F8F8F6',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-img' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'image_hover_zoom',
			[
				'label' => esc_html__( 'Zoom on Hover', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-product:hover .shopzen-pg-img img' => 'transform: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'scale(1.06)',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'show_in_stock',
			[
				'label' => esc_html__( 'Show "IN STOCK" Tag', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-instock' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'inline-block',
					'' => 'none',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'in_stock_color',
			[
				'label' => esc_html__( 'In Stock Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#065F46',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-instock' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_in_stock' => 'yes',
				],
			]
		);

		$this->add_control(
			'in_stock_bg',
			[
				'label' => esc_html__( 'In Stock Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-instock' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_in_stock' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Badge ──────────────────────────────────────────
		$this->start_controls_section(
			'section_badge_style',
			[
				'label' => esc_html__( 'Badge', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badge_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pg-badge',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 10 ] ],
					'font_weight' => [ 'default' => 800 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'unit' => 'px', 'size' => 0.3 ] ],
				],
			]
		);

		$this->add_control(
			'badge_bg',
			[
				'label' => esc_html__( 'Background Color (Sale)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-badge:not(.new)' => 'background: {{VALUE}};',
					'{{WRAPPER}} .shopzen-pg-badge:not(.new)' => 'border-color: rgba(0,0,0,0.08);',
				],
			]
		);

		$this->add_control(
			'badge_new_bg',
			[
				'label' => esc_html__( 'Background Color (New)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3A5F3F',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-badge.new' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .shopzen-pg-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 999 ] ],
				'default' => [ 'unit' => 'px', 'size' => 999 ],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-badge' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 4, 'right' => 7, 'bottom' => 4, 'left' => 7,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


	// ─── Style: Wishlist (Shop Zen Pro Addons) ────────────────
	if ( shopzen_is_wishlist_available() ) {

	$this->start_controls_section(
		'section_wishlist_style',
		[
			'label' => esc_html__( 'Wishlist', 'spiraclethemes-site-library' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);

		$this->add_control(
			'show_wishlist',
			[
				'label' => esc_html__( 'Show Wishlist Button', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-wishlist' => 'display: {{VALUE}};',
				],
				'selectors_dictionary' => [
					'yes' => 'grid',
					'' => 'none',
				],
			]
		);

		$this->add_control(
			'wishlist_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-wishlist' => 'background: {{VALUE}};',
				],
				'condition' => [
					'show_wishlist' => 'yes',
				],
			]
		);

		$this->add_control(
			'wishlist_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-wishlist' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_wishlist' => 'yes',
				],
			]
		);

		$this->add_control(
			'wishlist_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E5E7EB',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-wishlist' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'show_wishlist' => 'yes',
				],
			]
		);

		$this->add_control(
			'wishlist_active_color',
			[
				'label' => esc_html__( 'Active / Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E11D48',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-wishlist:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-pg-wishlist.active' => 'color: {{VALUE}};',
					'{{WRAPPER}} .shopzen-pg-wishlist.active svg' => 'fill: {{VALUE}};',
				],
				'condition' => [
				'show_wishlist' => 'yes',
			],
		]
	);

	$this->end_controls_section();

	} // End if shopzen_is_wishlist_available().


	// ─── Style: Info ───────────────────────────────────────────
		$this->start_controls_section(
			'section_info_style',
			[
				'label' => esc_html__( 'Product Info', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pg-ptitle',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 700 ],
					'line_height' => [ 'default' => [ 'unit' => 'em', 'size' => 1.3 ] ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#111827',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-ptitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => esc_html__( 'Stars Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F59E0B',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-stars' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'rating_text_color',
			[
				'label' => esc_html__( 'Rating Text Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B7280',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-rating' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Price Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopzen-pg-price-now',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_family' => [ 'default' => 'Inter' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
					'font_weight' => [ 'default' => 800 ],
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E3F2A',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-price-now' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label' => esc_html__( 'Old Price Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#9CA3AF',
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-price-old' => 'color: {{VALUE}};',
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
					'top' => 10, 'right' => 11, 'bottom' => 13, 'left' => 11,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopzen-pg-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Build WooCommerce product query args based on the selected product type.
	 *
	 * @param string $type  One of best_sellers|featured|latest|top_rated|on_sale.
	 * @param int    $count Number of products to fetch.
	 * @return array WC_Query args, or empty array if WC is not available.
	 */
	private function get_woo_query_args( $type, $count ) {
		if ( ! function_exists( 'wc_get_products' ) ) {
			return [];
		}

		$args = [
			'status'   => 'publish',
			'limit'    => absint( $count ),
			'paginate' => false,
			'orderby'  => 'date',
			'order'    => 'DESC',
		];

		switch ( $type ) {
			case 'featured':
				$args['featured'] = true;
				break;
			case 'latest':
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
				break;
			case 'top_rated':
				$args['orderby'] = 'meta_value_num';
				$args['meta_key'] = '_wc_average_rating';
				$args['order']   = 'DESC';
				break;
			case 'on_sale':
				$args['on_sale'] = true;
				break;
			case 'best_sellers':
			default:
				$args['orderby']  = 'meta_value_num';
				$args['meta_key'] = 'total_sales';
				$args['order']    = 'DESC';
				break;
		}

		return $args;
	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/shop-zen/products-grid/template/view.php';
	}
}
