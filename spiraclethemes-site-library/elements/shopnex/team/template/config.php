<?php
/**
 * Team Widget for Shopnex Theme
 *
 * A team section displaying team members in a card grid layout
 * with avatar images, names, and roles.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_Team extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-team';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Team', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-person';
    }

    /**
     * Get widget categories
     */
    public function get_categories() {
        return array( 'shopnex-elementor' );
    }

    /**
     * Get widget keywords
     */
    public function get_keywords() {
        return array( 'team', 'members', 'people', 'staff', 'grid', 'avatar', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Section Header ───
        $this->start_controls_section(
            'section_header',
            array(
                'label' => esc_html__( 'Section Header', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'section_tag',
            array(
                'label'       => esc_html__( 'Section Tag', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'The People', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'section_title',
            array(
                'label'       => esc_html__( 'Section Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Meet our team', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'section_subtitle',
            array(
                'label'       => esc_html__( 'Section Subtitle', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'A small, dedicated group of designers, stylists, and visionaries shaping the future of fashion.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 3,
            )
        );

        $this->add_control(
            'show_header',
            array(
                'label'        => esc_html__( 'Show Section Header', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

        // ─── Team Members ───
        $this->start_controls_section(
            'section_team',
            array(
                'label' => esc_html__( 'Team Members', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'member_image',
            array(
                'label'   => esc_html__( 'Avatar Image', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $repeater->add_control(
            'member_name',
            array(
                'label'       => esc_html__( 'Name', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Team Member', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'member_role',
            array(
                'label'       => esc_html__( 'Role / Position', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Designer', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'team_list',
            array(
                'label'       => esc_html__( 'Team Members', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'member_name' => 'Elin Bergström',
                        'member_role' => 'Founder & Creative Director',
                    ),
                    array(
                        'member_name' => 'Marcus Lindgren',
                        'member_role' => 'Head of Design',
                    ),
                    array(
                        'member_name' => 'Sofia Henriksen',
                        'member_role' => 'Production Lead',
                    ),
                    array(
                        'member_name' => 'Oskar Nyman',
                        'member_role' => 'Brand & Communications',
                    ),
                ),
                'title_field' => '{{{ member_name }}}',
            )
        );

        $this->end_controls_section();

        // ─── Layout Section ───
        $this->start_controls_section(
            'section_layout',
            array(
                'label' => esc_html__( 'Layout', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'       => esc_html__( 'Columns', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => '4',
                'options'     => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'selectors'   => array(
                    '{{WRAPPER}} .shopnex-team-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ),
            )
        );

        $this->add_responsive_control(
            'grid_gap',
            array(
                'label'      => esc_html__( 'Grid Gap', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 28,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_margin_bottom',
            array(
                'label'      => esc_html__( 'Section Bottom Margin', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 120,
                    ),
                ),
                'default'    => array(
                    'size' => 0,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Section Tag Style ───
        $this->start_controls_section(
            'section_tag_style',
            array(
                'label' => esc_html__( 'Section Tag', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'tag_typography',
                'selector' => '{{WRAPPER}} .shopnex-team-tag',
                'default'  => array(
                    'font_size'      => array( 'size' => 11, 'unit' => 'px' ),
                    'font_weight'    => '600',
                    'letter_spacing' => array( 'size' => 1, 'unit' => 'px' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'tag_color',
            array(
                'label'     => esc_html__( 'Tag Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-team-tag' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'tag_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 12,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Section Title Style ───
        $this->start_controls_section(
            'section_title_style',
            array(
                'label' => esc_html__( 'Section Title', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .shopnex-team-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 40, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.3, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-team-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'title_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 12,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Section Subtitle Style ───
        $this->start_controls_section(
            'section_subtitle_style',
            array(
                'label' => esc_html__( 'Section Subtitle', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .shopnex-team-subtitle',
                'default'  => array(
                    'font_size'   => array( 'size' => 15, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'subtitle_color',
            array(
                'label'     => esc_html__( 'Subtitle Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-team-subtitle' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'subtitle_max_width',
            array(
                'label'      => esc_html__( 'Subtitle Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 800,
                    ),
                ),
                'default'    => array(
                    'size' => 480,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-subtitle' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'header_bottom_spacing',
            array(
                'label'      => esc_html__( 'Header Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 50,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Avatar Style ───
        $this->start_controls_section(
            'section_avatar_style',
            array(
                'label' => esc_html__( 'Avatar', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'avatar_bg_color',
            array(
                'label'     => esc_html__( 'Avatar Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-team-avatar' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'avatar_border_radius',
            array(
                'label'      => esc_html__( 'Avatar Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                    '%'  => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'default'    => array(
                    'size' => 10,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-avatar' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'avatar_spacing',
            array(
                'label'      => esc_html__( 'Avatar Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 16,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-avatar' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'avatar_grayscale',
            array(
                'label'        => esc_html__( 'Grayscale Filter', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => esc_html__( 'Apply a subtle grayscale filter that is removed on hover.', 'spiraclethemes-site-library' ),
            )
        );

        $this->add_control(
            'avatar_hover_zoom',
            array(
                'label'        => esc_html__( 'Hover Zoom Effect', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

        // ─── Card Style ───
        $this->start_controls_section(
            'section_card_style',
            array(
                'label' => esc_html__( 'Card', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_hover_lift',
            array(
                'label'        => esc_html__( 'Hover Lift Effect', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

        // ─── Member Name Style ───
        $this->start_controls_section(
            'section_name_style',
            array(
                'label' => esc_html__( 'Member Name', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .shopnex-team-name',
                'default'  => array(
                    'font_size'      => array( 'size' => 17, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.1, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'name_color',
            array(
                'label'     => esc_html__( 'Name Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-team-name' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'name_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'default'    => array(
                    'size' => 2,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-team-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Member Role Style ───
        $this->start_controls_section(
            'section_role_style',
            array(
                'label' => esc_html__( 'Member Role', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'role_typography',
                'selector' => '{{WRAPPER}} .shopnex-team-role',
                'default'  => array(
                    'font_size'      => array( 'size' => 12, 'unit' => 'px' ),
                    'font_weight'    => '400',
                    'letter_spacing' => array( 'size' => 0.3, 'unit' => 'px' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'role_color',
            array(
                'label'     => esc_html__( 'Role Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C9792',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-team-role' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/team/template/view.php';
    }
}
