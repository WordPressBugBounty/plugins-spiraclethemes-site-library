<?php
/**
 * Journey / Timeline Widget for Shopnex Theme
 *
 * A vertical timeline section displaying company milestones
 * with year markers, titles, and descriptions.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_Journey extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-journey';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Journey / Timeline', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-time-line';
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
        return array( 'journey', 'timeline', 'milestones', 'history', 'about', 'shopnex' );
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
                'default'     => esc_html__( 'Our Journey', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'section_title',
            array(
                'label'       => esc_html__( 'Section Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Milestones', 'spiraclethemes-site-library' ),
                'label_block' => true,
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

        // ─── Timeline Items ───
        $this->start_controls_section(
            'section_timeline',
            array(
                'label' => esc_html__( 'Timeline Items', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'timeline_year',
            array(
                'label'       => esc_html__( 'Year', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '2018', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'timeline_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'The first collection', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'timeline_description',
            array(
                'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'A brief description of this milestone or event in the company journey.', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'timeline_list',
            array(
                'label'       => esc_html__( 'Timeline Items', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'timeline_year'        => '2018',
                        'timeline_title'       => 'The first collection',
                        'timeline_description' => 'Elin Bergström launches the label from a small atelier with a debut capsule of 12 handcrafted pieces. The collection sells out within weeks, igniting a loyal following.',
                    ),
                    array(
                        'timeline_year'        => '2019',
                        'timeline_title'       => 'Designer partnerships',
                        'timeline_description' => 'Collaborations with emerging designers and textile artisans across India and Italy are established. Our signature draped blazer becomes an instant bestseller.',
                    ),
                    array(
                        'timeline_year'        => '2021',
                        'timeline_title'       => 'Sustainable by design',
                        'timeline_description' => 'We commit to 100% sustainably sourced fabrics and carbon-neutral operations. All packaging transitions to recycled materials. Our first sustainability report is published.',
                    ),
                    array(
                        'timeline_year'        => '2023',
                        'timeline_title'       => 'Flagship boutique',
                        'timeline_description' => 'We open our first flagship boutique — an immersive space where customers can experience the collection, explore styling, and discover the craft behind every garment.',
                    ),
                    array(
                        'timeline_year'        => '2026',
                        'timeline_title'       => 'Global runway',
                        'timeline_description' => 'Now shipping to 30+ countries with 50+ designer labels. Our community spans over 25,000 happy customers worldwide — and we\'re just getting started.',
                    ),
                ),
                'title_field' => '{{{ timeline_year }}} — {{{ timeline_title }}}',
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
            'timeline_max_width',
            array(
                'label'      => esc_html__( 'Timeline Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 400,
                        'max' => 1200,
                    ),
                    '%'  => array(
                        'min' => 50,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 800,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_margin_bottom',
            array(
                'label'      => esc_html__( 'Bottom Margin', 'spiraclethemes-site-library' ),
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
                    '{{WRAPPER}} .shopnex-journey-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_spacing',
            array(
                'label'      => esc_html__( 'Item Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 10,
                        'max' => 80,
                    ),
                ),
                'default'    => array(
                    'size' => 40,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline-item' => 'padding-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-journey-tag',
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
                    '{{WRAPPER}} .shopnex-journey-tag' => 'color: {{VALUE}};',
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
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 12,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-journey-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-journey-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 40, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.15, 'unit' => 'px' ),
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
                    '{{WRAPPER}} .shopnex-journey-title' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'header_spacing',
            array(
                'label'      => esc_html__( 'Header Bottom Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 50,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-journey-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Year Style ───
        $this->start_controls_section(
            'section_year_style',
            array(
                'label' => esc_html__( 'Year', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'year_typography',
                'selector' => '{{WRAPPER}} .shopnex-timeline-year',
                'default'  => array(
                    'font_size'      => array( 'size' => 12, 'unit' => 'px' ),
                    'font_weight'    => '600',
                    'letter_spacing' => array( 'size' => 0.8, 'unit' => 'px' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'year_color',
            array(
                'label'     => esc_html__( 'Year Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline-year' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'year_spacing',
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
                    'size' => 6,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline-year' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Item Title Style ───
        $this->start_controls_section(
            'section_item_title_style',
            array(
                'label' => esc_html__( 'Item Title', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'item_title_typography',
                'selector' => '{{WRAPPER}} .shopnex-timeline-item h4',
                'default'  => array(
                    'font_size'      => array( 'size' => 18, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.1, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                ),
            )
        );

        $this->add_control(
            'item_title_color',
            array(
                'label'     => esc_html__( 'Title Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline-item h4' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_title_spacing',
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
                    'size' => 6,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline-item h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Description Style ───
        $this->start_controls_section(
            'section_description_style',
            array(
                'label' => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .shopnex-timeline-item p',
                'default'  => array(
                    'font_size'   => array( 'size' => 14, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.6, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label'     => esc_html__( 'Description Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline-item p' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'description_max_width',
            array(
                'label'      => esc_html__( 'Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range'      => array(
                    'px' => array(
                        'min' => 200,
                        'max' => 800,
                    ),
                    '%'  => array(
                        'min' => 50,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 560,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline-item p' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Timeline Line & Dot Style ───
        $this->start_controls_section(
            'section_line_style',
            array(
                'label' => esc_html__( 'Timeline Line & Dots', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'line_color',
            array(
                'label'     => esc_html__( 'Line Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#E8E4DF',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline' => 'border-left-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'line_width',
            array(
                'label'      => esc_html__( 'Line Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 5,
                    ),
                ),
                'default'    => array(
                    'size' => 1.5,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline' => 'border-left-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'dot_color',
            array(
                'label'     => esc_html__( 'Dot Border Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline-dot' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'dot_active_color',
            array(
                'label'     => esc_html__( 'First Dot Fill Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline-item:first-child .shopnex-timeline-dot' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'dot_bg_color',
            array(
                'label'     => esc_html__( 'Dot Background (non-active)', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#FBF9F6',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-timeline-dot' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'dot_size',
            array(
                'label'      => esc_html__( 'Dot Size', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 6,
                        'max' => 24,
                    ),
                ),
                'default'    => array(
                    'size' => 12,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'dot_border_width',
            array(
                'label'      => esc_html__( 'Dot Border Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 5,
                    ),
                ),
                'default'    => array(
                    'size' => 2,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-timeline-dot' => 'border-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Background Style ───
        $this->start_controls_section(
            'section_background_style',
            array(
                'label' => esc_html__( 'Background', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'section_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-journey-section' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_padding',
            array(
                'label'      => esc_html__( 'Section Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => '0',
                    'right'  => '0',
                    'bottom' => '0',
                    'left'   => '0',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-journey-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/journey/template/view.php';
    }
}
