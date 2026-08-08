<?php

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Helper: outline SVG icons available for the features bar.
 *
 * The matching SVG markup lives in view.php via shopbar_fb_render_icon().
 * Icons follow the Shopbar theme outline style (24x24 viewBox, stroke based).
 *
 * @return array
 */
function shopbar_fb_icon_options() {
	return array(
		''            => esc_html__( '— None —', 'spiraclethemes-site-library' ),
		'truck'       => esc_html__( 'Truck (Shipping)', 'spiraclethemes-site-library' ),
		'returns'     => esc_html__( 'Rotate (Returns)', 'spiraclethemes-site-library' ),
		'credit-card' => esc_html__( 'Credit Card (Payment)', 'spiraclethemes-site-library' ),
		'headset'     => esc_html__( 'Headset (Support)', 'spiraclethemes-site-library' ),
		'shield'      => esc_html__( 'Shield Check', 'spiraclethemes-site-library' ),
		'clock'       => esc_html__( 'Clock', 'spiraclethemes-site-library' ),
		'wallet'      => esc_html__( 'Wallet', 'spiraclethemes-site-library' ),
		'lock'        => esc_html__( 'Lock', 'spiraclethemes-site-library' ),
		'badge'       => esc_html__( 'Badge Check', 'spiraclethemes-site-library' ),
		'gift'        => esc_html__( 'Gift', 'spiraclethemes-site-library' ),
		'zap'         => esc_html__( 'Zap', 'spiraclethemes-site-library' ),
		'phone'       => esc_html__( 'Phone', 'spiraclethemes-site-library' ),
		'mail'        => esc_html__( 'Mail', 'spiraclethemes-site-library' ),
		'tag'         => esc_html__( 'Tag', 'spiraclethemes-site-library' ),
		'sparkles'    => esc_html__( 'Sparkles', 'spiraclethemes-site-library' ),
	);
}

class Shopbar_Features extends Widget_Base {

	public function get_name() {
		return 'shopbar-elementor-features';
	}

	public function get_title() {
		return __( 'Features Bar', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'shopbar-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'features', 'services', 'benefits', 'shipping', 'support', 'shopbar' ];
	}

	protected function register_controls() {

		// ─── Content: Features ──────────────────────────────────────
		$this->start_controls_section(
			'section_features',
			[
				'label' => esc_html__( 'Features', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'truck',
				'options' => shopbar_fb_icon_options(),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Free Shipping', 'spiraclethemes-site-library' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'On orders over $49', 'spiraclethemes-site-library' ),
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

		$default_features = [
			[ 'icon' => 'truck',       'title' => __( 'Free Shipping', 'spiraclethemes-site-library' ),  'subtitle' => __( 'On orders over $49', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'returns',     'title' => __( 'Easy Returns', 'spiraclethemes-site-library' ),    'subtitle' => __( '30 days return policy', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'credit-card', 'title' => __( 'Secure Payment', 'spiraclethemes-site-library' ),  'subtitle' => __( '100% secure checkout', 'spiraclethemes-site-library' ) ],
			[ 'icon' => 'headset',     'title' => __( '24/7 Support', 'spiraclethemes-site-library' ),    'subtitle' => __( 'Dedicated support', 'spiraclethemes-site-library' ) ],
		];

		$this->add_control(
			'features',
			[
				'label' => esc_html__( 'Feature Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => $default_features,
				'title_field' => '{{{ title }}}',
			]
		);

		$this->end_controls_section();


		// ─── Content: Layout ────────────────────────────────────────
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
				'mobile_default' => [ 'unit' => '', 'size' => 1 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-grid' => 'grid-template-columns: repeat({{SIZE}}, minmax(0, 1fr));',
				],
			]
		);

		$this->add_control(
			'item_layout',
			[
				'label' => esc_html__( 'Item Layout', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => [
						'title' => esc_html__( 'Icon Left', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-flex eicon-align-start-h',
					],
					'vertical' => [
						'title' => esc_html__( 'Icon Top', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-flex eicon-align-start-v',
					],
				],
				'prefix_class' => 'shopbar-fb-layout-',
				'toggle' => false,
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'start'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),   'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-item' => 'text-align: {{VALUE}}; justify-content: {{VALUE}};',
					'{{WRAPPER}} .shopbar-fb-item--vertical' => 'align-items: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => esc_html__( 'Column Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-grid' => 'column-gap: {{SIZE}}{{UNIT}}; --fb-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => esc_html__( 'Row Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 16 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Container ───────────────────────────────────────
		$this->start_controls_section(
			'section_style_container',
			[
				'label' => esc_html__( 'Container', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'box_bg',
			[
				'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_border',
				'selector' => '{{WRAPPER}} .shopbar-fb',
				'fields_options' => [
					'border' => [ 'default' => 'solid' ],
					'width'  => [ 'default' => [ 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1, 'unit' => 'px' ] ],
					'color'  => [ 'default' => '#E8E2DA' ],
				],
			]
		);

		$this->add_control(
			'box_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 18 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .shopbar-fb',
				'fields_options' => [
					'box_shadow' => [
						'default' => [
							'horizontal' => 0,
							'vertical' => 8,
							'blur' => 28,
							'spread' => -8,
							'color' => 'rgba(28, 28, 28, 0.10)',
							'is_inset' => '',
						],
					],
				],
			]
		);

		$this->add_responsive_control(
			'box_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 26, 'right' => 30, 'bottom' => 26, 'left' => 30, 'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'enable_bar',
			[
				'label' => esc_html__( 'Wrap in Container Card', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_divider',
			[
				'label' => esc_html__( 'Show Separators', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'divider_color',
			[
				'label' => esc_html__( 'Separator Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'condition' => [ 'show_divider' => 'yes' ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-item::after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Icon ────────────────────────────────────────────
		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-icon svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Hover Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-item:hover .shopbar-fb-icon svg' => 'color: {{VALUE}}; stroke: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 14, 'max' => 56 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tile_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F3EFEA',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tile_hover_bg',
			[
				'label' => esc_html__( 'Icon Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B8977E',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-item:hover .shopbar-fb-icon' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'tile_size',
			[
				'label' => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 36, 'max' => 96 ] ],
				'default' => [ 'unit' => 'px', 'size' => 54 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'tile_radius',
			[
				'label' => esc_html__( 'Icon Box Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 48 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ───────────────────────────────────────────
		$this->start_controls_section(
			'section_style_title',
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
				'selector' => '{{WRAPPER}} .shopbar-fb-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 16 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1C1C1C',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Subtitle ────────────────────────────────────────
		$this->start_controls_section(
			'section_style_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .shopbar-fb-subtitle',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#6B6560',
				'selectors' => [
					'{{WRAPPER}} .shopbar-fb-subtitle' => 'color: {{VALUE}};',
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
