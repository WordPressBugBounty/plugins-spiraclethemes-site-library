<?php
/**
 * Values Widget for Shopnex Theme
 *
 * A values section displaying core principles in a card grid layout
 * with icons, titles, and descriptions.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_Values extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-values';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Values', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-favorite';
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
        return array( 'values', 'principles', 'cards', 'grid', 'icons', 'shopnex' );
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
                'default'     => esc_html__( 'Our Principles', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'section_title',
            array(
                'label'       => esc_html__( 'Section Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'What guides us', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'section_subtitle',
            array(
                'label'       => esc_html__( 'Section Subtitle', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Three core values shape every decision we make — from the materials we choose to the partnerships we build.', 'spiraclethemes-site-library' ),
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

        // ─── Value Cards ───
        $this->start_controls_section(
            'section_values',
            array(
                'label' => esc_html__( 'Value Cards', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'value_icon',
            array(
                'label'       => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '🌿', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'description' => esc_html__( 'Enter an emoji, HTML entity, or icon class (e.g., 🌿, ✋, ◇, fas fa-leaf)', 'spiraclethemes-site-library' ),
            )
        );

        $repeater->add_control(
            'value_icon_type',
            array(
                'label'   => esc_html__( 'Icon Type', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'emoji',
                'options' => array(
                    'emoji' => esc_html__( 'Emoji / Text', 'spiraclethemes-site-library' ),
                    'class' => esc_html__( 'Icon Class (Font Awesome)', 'spiraclethemes-site-library' ),
                ),
            )
        );

        $repeater->add_control(
            'value_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Sustainability First', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'value_description',
            array(
                'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Every material is responsibly sourced. We use FSC-certified timber, natural oils, and recycled packaging.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 4,
            )
        );

        $this->add_control(
            'values_list',
            array(
                'label'       => esc_html__( 'Value Cards', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'value_icon'        => '🌿',
                        'value_icon_type'   => 'emoji',
                        'value_title'       => 'Sustainability First',
                        'value_description' => 'Every material is responsibly sourced. We use FSC-certified timber, natural oils, and recycled packaging. Our workshop runs on renewable energy, and we offset all shipping emissions.',
                    ),
                    array(
                        'value_icon'        => '✋',
                        'value_icon_type'   => 'emoji',
                        'value_title'       => 'Artisan Craft',
                        'value_description' => 'We partner with 24 artisan workshops across Scandinavia, each with generations of expertise. Every piece is made in small batches, never mass-produced, ensuring individual attention and quality.',
                    ),
                    array(
                        'value_icon'        => '◇',
                        'value_icon_type'   => 'emoji',
                        'value_title'       => 'Timeless Design',
                        'value_description' => 'We reject fast trends. Our designs draw from Scandinavian and Japanese traditions — simple, proportional, and honest. A NORD. piece should feel as relevant in 30 years as it does today.',
                    ),
                ),
                'title_field' => '{{{ value_title }}}',
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
                'default'     => '3',
                'options'     => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'selectors'   => array(
                    '{{WRAPPER}} .shopnex-values-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
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
                    'size' => 24,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-values-grid' => 'gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-values-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-values-tag',
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
                    '{{WRAPPER}} .shopnex-values-tag' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-values-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-values-title',
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
                    '{{WRAPPER}} .shopnex-values-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-values-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-values-subtitle',
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
                    '{{WRAPPER}} .shopnex-values-subtitle' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-values-subtitle' => 'max-width: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-values-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
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
            'card_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FFFFFF',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-value-card' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F0EDE9',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-value-card' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'card_border_width',
            array(
                'label'      => esc_html__( 'Border Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 5,
                    ),
                ),
                'default'    => array(
                    'size' => 1,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-card' => 'border-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'card_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 10,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-card' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_padding',
            array(
                'label'      => esc_html__( 'Card Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => '32',
                    'right'  => '28',
                    'bottom' => '32',
                    'left'   => '28',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'card_hover_shadow',
            array(
                'label'        => esc_html__( 'Hover Shadow Effect', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
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

        // ─── Icon Style ───
        $this->start_controls_section(
            'section_icon_style',
            array(
                'label' => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'icon_bg_color',
            array(
                'label'     => esc_html__( 'Icon Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-value-icon' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_size',
            array(
                'label'      => esc_html__( 'Icon Size', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 16,
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 24,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_box_size',
            array(
                'label'      => esc_html__( 'Icon Box Size', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 30,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 52,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_spacing',
            array(
                'label'      => esc_html__( 'Icon Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 20,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'icon_border_radius',
            array(
                'label'      => esc_html__( 'Icon Border Radius', 'spiraclethemes-site-library' ),
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
                    'size' => 50,
                    'unit' => '%',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-icon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Title Style ───
        $this->start_controls_section(
            'section_card_title_style',
            array(
                'label' => esc_html__( 'Card Title', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'card_title_typography',
                'selector' => '{{WRAPPER}} .shopnex-value-card-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 18, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.1, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'card_title_color',
            array(
                'label'     => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-value-card-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'card_title_spacing',
            array(
                'label'      => esc_html__( 'Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 8,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-value-card-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Card Description Style ───
        $this->start_controls_section(
            'section_card_desc_style',
            array(
                'label' => esc_html__( 'Card Description', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'card_desc_typography',
                'selector' => '{{WRAPPER}} .shopnex-value-card-desc',
                'default'  => array(
                    'font_size'   => array( 'size' => 14, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.6, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'card_desc_color',
            array(
                'label'     => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-value-card-desc' => 'color: {{VALUE}};',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/values/template/view.php';
    }
}
