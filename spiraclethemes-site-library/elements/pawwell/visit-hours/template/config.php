<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_VisitHours extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-visit-hours';
	}

	public function get_title() {
		return __( 'Visit & Hours', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-clock-o';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'visit', 'hours', 'map', 'location', 'store', 'open', 'pawwell' ];
	}

	protected function register_controls() {

		// ─── Hours Card Section ─────────────────────────────────────
		$this->start_controls_section(
			'section_hours',
			[
				'label' => esc_html__( 'Hours Card', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Visit Us', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Stop By the PawWell Store', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Come meet the team, bring your pet for a treat, and browse our full range of products in person.', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'day',
			[
				'label' => esc_html__( 'Day', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'0' => esc_html__( 'Sunday', 'spiraclethemes-site-library' ),
					'1' => esc_html__( 'Monday', 'spiraclethemes-site-library' ),
					'2' => esc_html__( 'Tuesday', 'spiraclethemes-site-library' ),
					'3' => esc_html__( 'Wednesday', 'spiraclethemes-site-library' ),
					'4' => esc_html__( 'Thursday', 'spiraclethemes-site-library' ),
					'5' => esc_html__( 'Friday', 'spiraclethemes-site-library' ),
					'6' => esc_html__( 'Saturday', 'spiraclethemes-site-library' ),
				],
			]
		);

		$repeater->add_control(
			'is_closed',
			[
				'label' => esc_html__( 'Closed', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$repeater->add_control(
			'hours',
			[
				'label' => esc_html__( 'Hours', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ),
				'condition' => [ 'is_closed' => '' ],
			]
		);

		$this->add_control(
			'hours',
			[
				'label' => esc_html__( 'Opening Hours', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'day' => '0', 'hours' => esc_html__( '10AM – 6PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
					[ 'day' => '1', 'hours' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
					[ 'day' => '2', 'hours' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
					[ 'day' => '3', 'hours' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
					[ 'day' => '4', 'hours' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
					[ 'day' => '5', 'hours' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
					[ 'day' => '6', 'hours' => esc_html__( '9AM – 8PM', 'spiraclethemes-site-library' ), 'is_closed' => 'no' ],
				],
				'title_field' => '<# var days=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]; #>{{{ days[day] || "—" }}}',
			]
		);

		$this->end_controls_section();


		// ─── Address Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_address',
			[
				'label' => esc_html__( 'Address', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'address_label',
			[
				'label' => esc_html__( 'Address Label', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Flagship Store', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'address_text',
			[
				'label' => esc_html__( 'Address', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "123 PawWell Ave,\nSan Francisco, CA 94103", 'spiraclethemes-site-library' ),
			]
		);

		$this->end_controls_section();


		// ─── Map Section ────────────────────────────────────────────
		$this->start_controls_section(
			'section_map',
			[
				'label' => esc_html__( 'Map', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_map',
			[
				'label' => esc_html__( 'Show Map', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'map_embed',
			[
				'label' => esc_html__( 'Map Embed URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'Paste the embed src URL from Google Maps "Share > Embed a map" or OpenStreetMap export.', 'spiraclethemes-site-library' ),
				'default' => 'https://www.openstreetmap.org/export/embed.html?bbox=-122.4194%2C37.7749%2C-122.3994%2C37.7849&layer=mapnik',
				'condition' => [ 'show_map' => 'yes' ],
				'dynamic' => [ 'active' => true ],
			]
		);

		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => '2col',
				'options' => [
					'2col' => [ 'title' => esc_html__( 'Map + Hours', 'spiraclethemes-site-library' ), 'icon' => 'eicon-columns' ],
					'1col' => [ 'title' => esc_html__( 'Hours Only', 'spiraclethemes-site-library' ), 'icon' => 'eicon-single-post' ],
				],
			]
		);

		$this->add_control(
			'map_position',
			[
				'label' => esc_html__( 'Map Position', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'left',
				'options' => [
					'left'  => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ), 'icon' => 'eicon-h-align-left' ],
					'right' => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ), 'icon' => 'eicon-h-align-right' ],
				],
				'condition' => [ 'layout' => '2col' ],
			]
		);

		$this->end_controls_section();


		// ─── Section Style ─────────────────────────────────────────
		$this->start_controls_section(
			'section_section_style',
			[
				'label' => esc_html__( 'Section', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'hours_card_bg',
			[
				'label' => esc_html__( 'Hours Card Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-hours' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-vh-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Hours Card Text ────────────────────────────────
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Hours Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-vh-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.7)',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-desc' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'day_color',
			[
				'label' => esc_html__( 'Day Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(255,255,255,0.85)',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-day' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'time_color',
			[
				'label' => esc_html__( 'Time Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'closed_color',
			[
				'label' => esc_html__( 'Closed Time Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-row.closed .pawwell-vh-time' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'today_badge_bg',
			[
				'label' => esc_html__( 'Today Badge Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(123,143,107,0.2)',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-badge' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'today_badge_color',
			[
				'label' => esc_html__( 'Today Badge Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#B5CD9A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-vh-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$template = SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/visit-hours/template/view.php';
		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}
