<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Pawwell_BrowseCategories extends Widget_Base {

	public function get_name() {
		return 'pawwell-elementor-browse-categories';
	}

	public function get_title() {
		return __( 'Browse by Category', 'spiraclethemes-site-library' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'pawwell-elementor' ];
	}

	public function get_script_depends() {
		return [];
	}

	public function get_keywords() {
		return [ 'category', 'browse', 'shop', 'pet', 'pawwell', 'grid' ];
	}

	protected function register_controls() {

		// ─── Section Heading ────────────────────────────────────────
		$this->start_controls_section(
			'section_heading',
			[
				'label' => esc_html__( 'Section Heading', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label' => esc_html__( 'Eyebrow Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Browse by Category', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Shop for Every Pet', 'spiraclethemes-site-library' ),
			]
		);

		$this->add_control(
			'show_view_all',
			[
				'label' => esc_html__( 'Show View All Link', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'view_all_text',
			[
				'label' => esc_html__( 'View All Text', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'View all', 'spiraclethemes-site-library' ),
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->add_control(
			'view_all_url',
			[
				'label' => esc_html__( 'View All URL', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'spiraclethemes-site-library' ),
				'show_external' => true,
				'default' => [
					'url' => '#',
					'is_external' => false,
					'nofollow' => false,
				],
				'condition' => [
					'show_view_all' => 'yes',
				],
			]
		);

		$this->end_controls_section();


		// ─── Categories ─────────────────────────────────────────────
		$this->start_controls_section(
			'section_categories',
			[
				'label' => esc_html__( 'Categories', 'spiraclethemes-site-library' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'cat_icon',
			[
				'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-dog',
					'library' => 'fa-solid',
				],
				'recommended' => [ 'fa-solid' => [ 'dog', 'cat', 'paw', 'fish', 'feather', 'carrot', 'pills', 'prescription-bottle', 'gift', 'shopping-bag' ] ],
			]
		);

		$repeater->add_control(
			'cat_icon_bg',
			[
				'label' => esc_html__( 'Icon Background', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#F4E0DA',
			]
		);

		$repeater->add_control(
			'cat_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
			]
		);

		$repeater->add_control(
			'cat_name',
			[
				'label' => esc_html__( 'Name', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Dogs', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'cat_count',
			[
				'label' => esc_html__( 'Subtitle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Food, treats & gear', 'spiraclethemes-site-library' ),
			]
		);

		$repeater->add_control(
			'cat_link',
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

		$this->add_control(
			'categories',
			[
				'label' => esc_html__( 'Category Items', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'cat_name' => esc_html__( 'Dogs', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Food, treats & gear', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-dog', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#F4E0DA',
						'cat_icon_color' => '#C45B3E',
					],
					[
						'cat_name' => esc_html__( 'Cats', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Wet food, litter & toys', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-cat', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#E8EFE3',
						'cat_icon_color' => '#5E7350',
					],
					[
						'cat_name' => esc_html__( 'Health & Wellness', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Supplements & vitamins', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-pills', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#E8F0FE',
						'cat_icon_color' => '#3b6db4',
					],
					[
						'cat_name' => esc_html__( 'Grooming', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Shampoos & brushes', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-prescription-bottle', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#E0F4F4',
						'cat_icon_color' => '#2a9d9d',
					],
					[
						'cat_name' => esc_html__( 'Birds', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Seed, cages & perches', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-feather', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#F5ECD5',
						'cat_icon_color' => '#D4A853',
					],
					[
						'cat_name' => esc_html__( 'Aquatic', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Tanks & fish food', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-fish', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#F0E8F5',
						'cat_icon_color' => '#8b5cb6',
					],
					[
						'cat_name' => esc_html__( 'Small Pets', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'For rabbits & rodents', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-carrot', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#FFE8E8',
						'cat_icon_color' => '#d65a5a',
					],
					[
						'cat_name' => esc_html__( 'Toys & Accessories', 'spiraclethemes-site-library' ),
						'cat_count' => esc_html__( 'Beds, collars & more', 'spiraclethemes-site-library' ),
						'cat_icon' => [ 'value' => 'fas fa-gift', 'library' => 'fa-solid' ],
						'cat_icon_bg' => '#F5F0E8',
						'cat_icon_color' => '#a88a5c',
					],
				],
				'title_field' => '{{{ cat_name }}}',
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

		$this->add_control(
			'section_bg',
			[
				'label' => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc' => 'background: {{VALUE}};',
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
				'description' => esc_html__( 'Stretch the borders edge-to-edge across the full viewport. Off = borders span the content width only.', 'spiraclethemes-site-library' ),
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

		$this->add_responsive_control(
			'columns',
			[
				'label' => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'6' => '6',
				],
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				],
			]
		);

		$this->add_responsive_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Gap (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
				'default' => [ 'unit' => 'px', 'size' => 24 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-grid' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'section_padding',
			[
				'label' => esc_html__( 'Section Padding (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 160 ] ],
				'default' => [ 'unit' => 'px', 'size' => 100 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-inner' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Avatar ──────────────────────────────────────────
		$this->start_controls_section(
			'section_avatar_style',
			[
				'label' => esc_html__( 'Avatar', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'avatar_size',
			[
				'label' => esc_html__( 'Avatar Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 60, 'max' => 180 ] ],
				'default' => [ 'unit' => 'px', 'size' => 120 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-avatar' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatar_radius',
			[
				'label' => esc_html__( 'Border Radius (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 0, 'max' => 90 ] ],
				'default' => [ 'unit' => 'px', 'size' => 28 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-avatar' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'avatar_hover_circle',
			[
				'label' => esc_html__( 'Hover to Circle', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
				'label_off' => esc_html__( 'No', 'spiraclethemes-site-library' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size (px)', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [ 'px' => [ 'min' => 14, 'max' => 72 ] ],
				'default' => [ 'unit' => 'px', 'size' => 44 ],
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-avatar i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pawwell-bc-avatar svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
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
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-bc-title',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 44 ] ],
					'font_weight' => [ 'default' => 400 ],
				],
			]
		);

		$this->add_responsive_control(
			'heading_align',
			[
				'label' => esc_html__( 'Heading Alignment', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'spiraclethemes-site-library' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-heading' => 'text-align: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-bc-title' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .pawwell-bc-eyebrow' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'view_all_color',
			[
				'label' => esc_html__( 'View All Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#C45B3E',
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-viewall' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();


		// ─── Style: Text ────────────────────────────────────────────
		$this->start_controls_section(
			'section_text_style',
			[
				'label' => esc_html__( 'Category Text', 'spiraclethemes-site-library' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'name_typography',
				'label' => esc_html__( 'Name Typography', 'spiraclethemes-site-library' ),
				'selector' => '{{WRAPPER}} .pawwell-bc-name',
				'fields_options' => [
					'typography' => [ 'default' => 'yes' ],
					'font_size' => [ 'default' => [ 'size' => 15 ] ],
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
					'{{WRAPPER}} .pawwell-bc-name' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'count_color',
			[
				'label' => esc_html__( 'Subtitle Color', 'spiraclethemes-site-library' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#8A8A8A',
				'selectors' => [
					'{{WRAPPER}} .pawwell-bc-count' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		require SPIR_SITE_LIBRARY_PATH . '/elements/pawwell/browse-categories/template/view.php';
	}
}
