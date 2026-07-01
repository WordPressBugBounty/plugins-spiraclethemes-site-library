<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_PageTitle extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-page-title';
	}

	public function get_title() {
		return __( 'Page Title', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-heading';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'page', 'title', 'hero', 'breadcrumb', 'inner', 'header', 'pawwell' ];
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
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Our Story Since 2018', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'On a Mission to Enrich Pet Lives', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'accent_word',
			[
				'label' => esc_html__( 'Accent Word (highlighted part of title)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Enrich Pet Lives', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "We believe every pet deserves access to premium nutrition, expert veterinary care, and products that genuinely improve their quality of life. That's why we built PawWell — a trusted home for pet parents who want the very best.", 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Breadcrumb Section ─────────────────────────────────────
		$this->start_controls_section(
			'section_breadcrumb',
			[
				'label' => esc_html__( 'Breadcrumb', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_breadcrumb',
			[
				'label' => esc_html__( 'Show Breadcrumb', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'home_text',
			[
				'label' => esc_html__( 'Home Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Home', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'home_url',
			[
				'label' => esc_html__( 'Home URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://', 'spiraclethemes-site-library' ),
				'default' => [
					'url' => '/',
				],
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->add_control(
			'current_text',
			[
				'label' => esc_html__( 'Current Page Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'About', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_breadcrumb' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Stats Section ──────────────────────────────────────────
		$this->start_controls_section(
			'section_stats',
			[
				'label' => esc_html__( 'Stats', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_stats',
			[
				'label' => esc_html__( 'Show Stats', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'stat_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-paw',
					'library' => 'fa-solid',
				],
			]
		);

		$repeater->add_control(
			'stat_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4E0DA',
			]
		);

		$repeater->add_control(
			'stat_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
			]
		);

		$repeater->add_control(
			'stat_value',
			[
				'label' => esc_html__( 'Value', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '50,000+', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'stat_label',
			[
				'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'pets cared for', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'stats',
			[
				'label' => esc_html__( 'Stat Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'stat_value' => '50,000+',
						'stat_label' => 'pets cared for',
						'stat_icon_bg' => '#F4E0DA',
						'stat_icon_color' => '#C45B3E',
						'stat_icon' => [ 'value' => 'fas fa-paw', 'library' => 'fa-solid' ],
					],
					[
						'stat_value' => 'Award',
						'stat_label' => 'pet care excellence',
						'stat_icon_bg' => '#E8EFE3',
						'stat_icon_color' => '#5E7350',
						'stat_icon' => [ 'value' => 'fas fa-award', 'library' => 'fa-solid' ],
					],
				],
				'title_field' => '{{{ stat_value }}}',
				'condition' => [
					'show_stats' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Section ─────────────────────────────────────────
		$this->start_controls_section(
			'section_section_style',
			[
				'label' => esc_html__( 'Section', 'spiraclethemes-site-library' ),
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
					'top' => 56, 'right' => 0, 'bottom' => 56, 'left' => 0,
					'unit' => 'px', 'isLinked' => false,
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FAF6F1',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt' => 'background: {{VALUE}};',
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
				'default' => 'yes',
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
					'{{WRAPPER}} .pawwell-pt-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'show_blobs',
			[
				'label' => esc_html__( 'Show Decorative Blobs', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();


		// ─── Style: Breadcrumb ──────────────────────────────────────
		$this->start_controls_section(
			'section_crumb_style',
			[
				'label' => esc_html__( 'Breadcrumb', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crumb_typography',
				'label' => esc_html__( 'Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pt-crumb',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
				],
			]
		);

		$this->add_control(
			'crumb_color',
			[
				'label' => esc_html__( 'Link Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-crumb a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'crumb_current_color',
			[
				'label' => esc_html__( 'Current Page Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-crumb .current' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Title ───────────────────────────────────────────
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
				'name' => 'eyebrow_typography',
				'label' => esc_html__( 'Eyebrow Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pt-eyebrow',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 700 ],
					'text_transform' => [ 'default' => 'uppercase' ],
					'letter_spacing' => [ 'default' => [ 'size' => 1.5 ] ],
				],
			]
		);

		$this->add_control(
			'eyebrow_color',
			[
				'label' => esc_html__( 'Eyebrow Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pt-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 56 ] ],
					'font_weight' => [ 'default' => 400 ],
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
					'{{WRAPPER}} .pawwell-pt-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accent_color',
			[
				'label' => esc_html__( 'Accent Word Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-accent' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Subtitle Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pt-sub',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 17 ] ],
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
					'{{WRAPPER}} .pawwell-pt-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Stat Cards ──────────────────────────────────────
		$this->start_controls_section(
			'section_stat_style',
			[
				'label' => esc_html__( 'Stat Cards', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'stat_bg',
			[
				'label' => esc_html__( 'Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-stat' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stat_border_color',
			[
				'label' => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E2DA',
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-stat' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'stat_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-stat' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'stat_icon_box_size',
			[
				'label' => esc_html__( 'Icon Box Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 32, 'max' => 100 ] ],
				'default' => [ 'unit' => 'px', 'size' => 48 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-stat-ic' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'stat_icon_radius',
			[
				'label' => esc_html__( 'Icon Box Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
				'default' => [ 'unit' => 'px', 'size' => 14 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-pt-stat-ic' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'stat_value_typography',
				'label' => esc_html__( 'Value Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pt-stat-text strong',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 22 ] ],
					'font_weight' => [ 'default' => 800 ],
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
					'{{WRAPPER}} .pawwell-pt-stat-text strong' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'stat_label_typography',
				'label' => esc_html__( 'Label Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-pt-stat-text span',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
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
					'{{WRAPPER}} .pawwell-pt-stat-text span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/page-title/template/view.php';
	}
}
