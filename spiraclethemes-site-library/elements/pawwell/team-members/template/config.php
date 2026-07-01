<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_TeamMembers extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-team-members';
	}

	public function get_title() {
		return __( 'Team Members', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-person';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'team', 'members', 'staff', 'people', 'authors', 'pawwell' ];
	}

	protected function register_controls() {

		// ─── Heading Section ────────────────────────────────────────
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The People Behind PawWell', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Meet Our Team', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( "Passionate pet experts dedicated to your furry family's wellbeing", 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'heading_align',
			[
				'label' => esc_html__( 'Heading Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'   => [ 'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-left' ],
					'center' => [ 'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-center' ],
					'right'  => [ 'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ), 'icon' => 'eicon-text-align-right' ],
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-head' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Team Members Section ───────────────────────────────────
		$this->start_controls_section(
			'section_items',
			[
				'label' => esc_html__( 'Team Members', 'spiraclethemes-site-library' ),
			]
		);

		$social_repeater = new Repeater();

		$social_repeater->add_control(
			'network',
			[
				'label' => esc_html__( 'Network', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'x',
				'options' => [
					'x'         => esc_html__( 'X (Twitter)', 'spiraclethemes-site-library' ),
					'linkedin'  => esc_html__( 'LinkedIn', 'spiraclethemes-site-library' ),
					'instagram' => esc_html__( 'Instagram', 'spiraclethemes-site-library' ),
					'facebook'  => esc_html__( 'Facebook', 'spiraclethemes-site-library' ),
					'youtube'   => esc_html__( 'YouTube', 'spiraclethemes-site-library' ),
					'tiktok'    => esc_html__( 'TikTok', 'spiraclethemes-site-library' ),
				],
			]
		);

		$social_repeater->add_control(
			'url',
			[
				'label' => esc_html__( 'Profile URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://x.com/username', 'spiraclethemes-site-library' ),
				'dynamic' => [ 'active' => true ],
				'show_external' => true,
				'default' => [ 'url' => '', 'is_external' => true ],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'member_avatar',
			[
				'label' => esc_html__( 'Photo', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'member_name',
			[
				'label' => esc_html__( 'Name', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Dr. Maya Chen', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'member_role',
			[
				'label' => esc_html__( 'Role / Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Founder & Chief Vet', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'member_bio',
			[
				'label' => esc_html__( 'Bio', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( '15+ years in veterinary medicine. Mom to Bruno, a rescue golden retriever.', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'socials',
			[
				'label' => esc_html__( 'Social Links', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $social_repeater->get_controls(),
				'title_field' => '{{{ network }}}',
				'prevent_empty' => false,
			]
		);

		$this->add_control(
			'items',
			[
				'label' => esc_html__( 'Members', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'member_name' => esc_html__( 'Dr. Maya Chen', 'spiraclethemes-site-library' ),
						'member_role' => esc_html__( 'Founder & Chief Vet', 'spiraclethemes-site-library' ),
						'member_bio'  => esc_html__( '15+ years in veterinary medicine. Mom to Bruno, a rescue golden retriever.', 'spiraclethemes-site-library' ),
						'socials' => [
							[ 'network' => 'x', 'url' => [ 'url' => '#', 'is_external' => true ] ],
							[ 'network' => 'linkedin', 'url' => [ 'url' => '#', 'is_external' => true ] ],
						],
					],
					[
						'member_name' => esc_html__( 'Dr. James Okafor', 'spiraclethemes-site-library' ),
						'member_role' => esc_html__( 'Head of Nutrition', 'spiraclethemes-site-library' ),
						'member_bio'  => esc_html__( 'Pet nutritionist specializing in dietary management. Dad to two siamese cats.', 'spiraclethemes-site-library' ),
						'socials' => [
							[ 'network' => 'x', 'url' => [ 'url' => '#', 'is_external' => true ] ],
							[ 'network' => 'linkedin', 'url' => [ 'url' => '#', 'is_external' => true ] ],
						],
					],
					[
						'member_name' => esc_html__( 'Sofia Ramirez', 'spiraclethemes-site-library' ),
						'member_role' => esc_html__( 'Customer Experience', 'spiraclethemes-site-library' ),
						'member_bio'  => esc_html__( 'Ensures every pet parent feels supported. Proud owner of a parrot named Mango.', 'spiraclethemes-site-library' ),
						'socials' => [
							[ 'network' => 'linkedin', 'url' => [ 'url' => '#', 'is_external' => true ] ],
							[ 'network' => 'instagram', 'url' => [ 'url' => '#', 'is_external' => true ] ],
						],
					],
					[
						'member_name' => esc_html__( 'Liam Foster', 'spiraclethemes-site-library' ),
						'member_role' => esc_html__( 'Operations Director', 'spiraclethemes-site-library' ),
						'member_bio'  => esc_html__( 'Keeps the warehouse running and deliveries fast. Dad to a beagle named Cooper.', 'spiraclethemes-site-library' ),
						'socials' => [
							[ 'network' => 'x', 'url' => [ 'url' => '#', 'is_external' => true ] ],
							[ 'network' => 'linkedin', 'url' => [ 'url' => '#', 'is_external' => true ] ],
						],
					],
				],
				'title_field' => '{{{ member_name }}}',
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Boxes Per Row', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_control(
			'columns_help',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'The number of rows is determined automatically by the total members divided by boxes per row.', 'spiraclethemes-site-library' ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$this->add_control(
			'hover_effect',
			[
				'label' => esc_html__( 'Hover Effect', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'always_show_socials',
			[
				'label' => esc_html__( 'Always Show Socials', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'no',
				'description' => esc_html__( 'Off = social links reveal on hover over the photo.', 'spiraclethemes-site-library' ),
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
				'default' => '#FAF6F1',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-tm-inner' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Heading ─────────────────────────────────────────
		$this->start_controls_section(
			'section_heading_style',
			[
				'label' => esc_html__( 'Heading', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-tm-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-tm-eyebrow' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-tm-sub' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Card ────────────────────────────────────────────
		$this->start_controls_section(
			'section_card_style',
			[
				'label' => esc_html__( 'Member Card', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typo',
				'label' => esc_html__( 'Name Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-tm-name',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 17 ] ],
					'font_weight' => [ 'default' => 700 ],
				],
			]
		);

		$this->add_control(
			'name_color',
			[
				'label' => esc_html__( 'Name Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'role_typo',
				'label' => esc_html__( 'Role Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-tm-role',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 600 ],
				],
			]
		);

		$this->add_control(
			'role_color',
			[
				'label' => esc_html__( 'Role Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-role' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bio_typo',
				'label' => esc_html__( 'Description Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-tm-bio',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 13 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_control(
			'bio_color',
			[
				'label' => esc_html__( 'Bio Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-bio' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'avatar_radius',
			[
				'label' => esc_html__( 'Photo Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
				'default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-avatar' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'social_bg',
			[
				'label' => esc_html__( 'Social Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-socials a' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_color',
			[
				'label' => esc_html__( 'Social Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#1E1E1E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-socials a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'social_hover_bg',
			[
				'label' => esc_html__( 'Social Icon Hover Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-tm-socials a:hover' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$template = SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/team-members/template/view.php';
		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}
