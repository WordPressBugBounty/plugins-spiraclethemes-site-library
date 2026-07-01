<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_TrustStrip extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-trust-strip';
	}

	public function get_title() {
		return __( 'Trust Strip', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-banner';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'trust', 'strip', 'features', 'shipping', 'pawwell', 'badges' ];
	}

	protected function register_controls() {

		// ─── Items Section ──────────────────────────────────────────
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Trust Items', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-truck',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'truck', 'undo', 'stethoscope', 'shield-alt', 'lock', 'headset', 'award', 'leaf' ] ],
			]
		);

		$repeater->add_control(
			'item_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4E0DA',
			]
		);

		$repeater->add_control(
			'item_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
			]
		);

		$repeater->add_control(
			'item_title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Free Shipping', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'item_subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'On orders over $49', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'item_title' => esc_html__( 'Free Shipping', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( 'On orders over $49', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#F4E0DA',
						'item_icon_color' => '#C45B3E',
						'item_icon' => [ 'value' => 'fas fa-truck', 'library' => 'fa-solid' ],
					],
					[
						'item_title' => esc_html__( 'Easy Returns', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( '30-day money back', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#E8EFE3',
						'item_icon_color' => '#5E7350',
						'item_icon' => [ 'value' => 'fas fa-undo', 'library' => 'fa-solid' ],
					],
					[
						'item_title' => esc_html__( 'Vet Consultation', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( 'Free first session', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#F5ECD5',
						'item_icon_color' => '#D4A853',
						'item_icon' => [ 'value' => 'fas fa-stethoscope', 'library' => 'fa-solid' ],
					],
					[
						'item_title' => esc_html__( 'Secure Payment', 'spiraclethemes-site-library' ),
						'item_subtitle' => esc_html__( '100% protected', 'spiraclethemes-site-library' ),
						'item_icon_bg' => '#E8EFE8',
						'item_icon_color' => '#5E7350',
						'item_icon' => [ 'value' => 'fas fa-shield-alt', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ item_title }}}',
			]
		);

		$this->add_control(
			'show_dividers',
			[
				'label' => esc_html__( 'Show Dividers', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Style: Strip ───────────────────────────────────────────
		$this->start_controls_section(
			'section_strip_style',
			[
				'label' => esc_html__( 'Strip', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'strip_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'border_top',
			[
				'label' => esc_html__( 'Border Top', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'border_bottom',
			[
				'label' => esc_html__( 'Border Bottom', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'full_width',
			[
				'label' => esc_html__( 'Full Width', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'description' => esc_html__( 'Stretch the strip to full viewport width.', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'strip_padding',
			[
				'label' => esc_html__( 'Vertical Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 22 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts-item' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Icon ────────────────────────────────────────────
		$this->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 12, 'max' => 48 ] ],
				'default' => [ 'unit' => 'px', 'size' => 22 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pawwell-ts-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_box_size',
			[
				'label' => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 28, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 44 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 12 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Text ────────────────────────────────────────────
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-ts-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 700 ],
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
					'{{WRAPPER}} .pawwell-ts-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-ts-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 12 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-ts-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/trust-strip/template/view.php';
	}
}
