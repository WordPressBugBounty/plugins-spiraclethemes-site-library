<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_Stats extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-stats';
	}

	public function get_title() {
		return __( 'Stats Banner', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'stats', 'counter', 'numbers', 'banner', 'metrics', 'pawwell' ];
	}

	protected function register_controls() {

		// ─── Stats Section ──────────────────────────────────────────
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
				'label' => esc_html__( 'Value (number)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 50,
				'min' => 0,
				'step' => 0.1,
			]
		);

		$repeater->add_control(
			'stat_prefix',
			[
				'label' => esc_html__( 'Prefix', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$repeater->add_control(
			'stat_suffix',
			[
				'label' => esc_html__( 'Suffix', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'K+',
			]
		);

		$repeater->add_control(
			'stat_decimals',
			[
				'label' => esc_html__( 'Decimals', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0,
				'min' => 0,
				'max' => 3,
			]
		);

		$repeater->add_control(
			'stat_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Happy Pet Parents', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'stat_accent',
			[
				'label' => esc_html__( 'Accent (highlight value)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => '',
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Stat Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'stat_value' => 50,
						'stat_prefix' => '',
						'stat_suffix' => 'K+',
						'stat_decimals' => 0,
						'stat_label' => 'Happy Pet Parents',
						'stat_accent' => '',
					],
					[
						'stat_value' => 500,
						'stat_prefix' => '',
						'stat_suffix' => '+',
						'stat_decimals' => 0,
						'stat_label' => 'Vet-Approved Products',
						'stat_accent' => '',
					],
					[
						'stat_value' => 25,
						'stat_prefix' => '',
						'stat_suffix' => '+',
						'stat_decimals' => 0,
						'stat_label' => 'Expert Veterinarians',
						'stat_accent' => '',
					],
					[
						'stat_value' => 4.9,
						'stat_prefix' => '',
						'stat_suffix' => '★',
						'stat_decimals' => 1,
						'stat_label' => 'Average Rating',
						'stat_accent' => 'yes',
					],
				],
				'title_field' => '{{{ stat_label }}}',
			]
		);

		$this->end_controls_section();


		// ─── Style: Banner ──────────────────────────────────────────
		$this->start_controls_section(
			'section_banner_style',
			[
				'label' => esc_html__( 'Banner', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'banner_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 56, 'right' => 60, 'bottom' => 56, 'left' => 60,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-banner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'banner_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-banner' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'banner_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-banner' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_blobs',
			[
				'label' => esc_html__( 'Decorative Blobs', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'blob1_color',
			[
				'label' => esc_html__( 'Blob 1 Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'condition' => [
					'show_blobs' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-banner::before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'blob2_color',
			[
				'label' => esc_html__( 'Blob 2 Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#7B8F6B',
				'condition' => [
					'show_blobs' => 'yes',
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-banner::after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Section ─────────────────────────────────────────
		$this->start_controls_section(
			'section_section_style',
			[
				'label' => esc_html__( 'Outer Section', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'section_padding',
			[
				'label' => esc_html__( 'Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 100, 'right' => 0, 'bottom' => 100, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pawwell-st' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'show_border_top',
			[
				'label' => esc_html__( 'Top Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'show_border_bottom',
			[
				'label' => esc_html__( 'Bottom Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'full_width_border',
			[
				'label' => esc_html__( 'Full Width Border', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
				'description' => esc_html__( 'Stretch the borders edge-to-edge across the full section. Off = borders span the content width only.', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[ 'name' => 'show_border_top', 'operator' => '===', 'value' => 'yes' ],
						[ 'name' => 'show_border_bottom', 'operator' => '===', 'value' => 'yes' ],
					],
				],
			]
		);

		$this->add_control(
			'border_width',
			[
				'label' => esc_html__( 'Border Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 1, 'max' => 10 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1 ],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[ 'name' => 'show_border_top', 'operator' => '===', 'value' => 'yes' ],
						[ 'name' => 'show_border_bottom', 'operator' => '===', 'value' => 'yes' ],
					],
				],
			]
		);

		$this->add_control(
			'max_width',
			[
				'label' => esc_html__( 'Container Max Width (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 960, 'max' => 1600 ] ],
				'default' => [ 'unit' => 'px', 'size' => 1380 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
				'default' => [ 'unit' => 'px', 'size' => 32 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Stat Value ──────────────────────────────────────
		$this->start_controls_section(
			'section_value_style',
			[
				'label' => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'value_typography',
				'label' => esc_html__( 'Value Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-st-value',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 48 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'value_color',
			[
				'label' => esc_html__( 'Value Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-value' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Accent Value Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-value.pawwell-st-accent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Label ───────────────────────────────────────────
		$this->start_controls_section(
			'section_label_style',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'label' => esc_html__( 'Label Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-st-label',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 14 ] ],
					'font_weight' => [ 'default' => 500 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 0.06 ] ],
				],
			]
		);

		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .pawwell-st-label' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/stats/template/view.php';
	}
}
