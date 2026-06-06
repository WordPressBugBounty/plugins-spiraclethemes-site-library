<?php
/**
 * Info Boxes Widget for Shopnex Theme
 *
 * A horizontal strip of info/value boxes displaying icon, title, and description
 * in a responsive grid layout with optional borders.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_InfoBoxes extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-info-boxes';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Info Boxes', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-info-box';
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
        return array( 'info', 'boxes', 'values', 'features', 'icons', 'strip', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Info Box Items ───
        $this->start_controls_section(
            'section_info_boxes',
            array(
                'label' => esc_html__( 'Info Boxes', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'box_icon_type',
            array(
                'label'       => esc_html__( 'Icon Type', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::CHOOSE,
                'default'     => 'elementor',
                'label_block' => false,
                'options'     => array(
                    'elementor' => array(
                        'title' => esc_html__( 'Icon Library', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-icons',
                    ),
                    'emoji'     => array(
                        'title' => esc_html__( 'Emoji / Text', 'spiraclethemes-site-library' ),
                        'icon'  => 'eicon-emoji',
                    ),
                ),
                'toggle'      => false,
            )
        );

        $repeater->add_control(
            'box_elementor_icon',
            array(
                'label'            => esc_html__( 'Icon', 'spiraclethemes-site-library' ),
                'type'             => \Elementor\Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'          => array(
                    'value'   => 'fas fa-leaf',
                    'library' => 'fa-solid',
                ),
                'condition'        => array(
                    'box_icon_type' => 'elementor',
                ),
            )
        );

        $repeater->add_control(
            'box_icon',
            array(
                'label'       => esc_html__( 'Icon (Emoji or Text)', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => '🌿',
                'label_block' => true,
                'description' => esc_html__( 'Enter an emoji character or HTML entity for the icon.', 'spiraclethemes-site-library' ),
                'condition'   => array(
                    'box_icon_type' => 'emoji',
                ),
            )
        );

        $repeater->add_control(
            'box_title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Premium Fabrics', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $repeater->add_control(
            'box_description',
            array(
                'label'       => esc_html__( 'Description', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Crafted from the finest fabrics for lasting comfort and effortless style.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 3,
            )
        );

        $this->add_control(
            'info_boxes_list',
            array(
                'label'       => esc_html__( 'Info Box Items', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'box_icon_type'     => 'emoji',
                        'box_icon'          => '🌿',
                        'box_title'         => 'Sustainable Materials',
                        'box_description'   => 'Every piece is crafted using responsibly sourced, natural materials.',
                    ),
                    array(
                        'box_icon_type'     => 'emoji',
                        'box_icon'          => '✋',
                        'box_title'         => 'Artisan Crafted',
                        'box_description'   => 'Made in small batches by skilled artisans with generations of expertise.',
                    ),
                    array(
                        'box_icon_type'     => 'emoji',
                        'box_icon'          => '📦',
                        'box_title'         => 'Carbon Neutral Shipping',
                        'box_description'   => 'All orders shipped with 100% carbon-offset delivery worldwide.',
                    ),
                ),
                'title_field' => '{{{ box_icon }}} {{{ box_title }}}',
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
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'selectors'   => array(
                    '{{WRAPPER}} .shopnex-info-boxes' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
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
                        'max' => 80,
                    ),
                ),
                'default'    => array(
                    'size' => 40,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-boxes' => 'gap: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_padding',
            array(
                'label'      => esc_html__( 'Item Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em' ),
                'default'    => array(
                    'top'    => '20',
                    'right'  => '20',
                    'bottom' => '20',
                    'left'   => '20',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-box-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'section_padding_vertical',
            array(
                'label'      => esc_html__( 'Section Padding (Vertical)', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 120,
                    ),
                ),
                'default'    => array(
                    'size' => 50,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-boxes' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'show_border_top',
            array(
                'label'        => esc_html__( 'Top Border', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'show_border_bottom',
            array(
                'label'        => esc_html__( 'Bottom Border', 'spiraclethemes-site-library' ),
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

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'icon_typography',
                'selector' => '{{WRAPPER}} .shopnex-info-box-icon',
                'default'  => array(
                    'font_size' => array( 'size' => 28, 'unit' => 'px' ),
                ),
            )
        );

        $this->add_responsive_control(
            'icon_spacing',
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
                    'size' => 14,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'icon_opacity',
            array(
                'label'      => esc_html__( 'Opacity', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'range'      => array(
                    'px' => array(
                        'min'  => 0.1,
                        'max'  => 1,
                        'step' => 0.05,
                    ),
                ),
                'default'    => array(
                    'size' => 0.8,
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-box-icon' => 'opacity: {{SIZE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Title Style ───
        $this->start_controls_section(
            'section_title_style',
            array(
                'label' => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .shopnex-info-box-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 18, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.1, 'unit' => 'px' ),
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
                    '{{WRAPPER}} .shopnex-info-box-title' => 'color: {{VALUE}};',
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
                        'max' => 30,
                    ),
                ),
                'default'    => array(
                    'size' => 6,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-info-box-description',
                'default'  => array(
                    'font_size'   => array( 'size' => 13, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
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
                    '{{WRAPPER}} .shopnex-info-box-description' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'description_max_width',
            array(
                'label'      => esc_html__( 'Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 600,
                    ),
                ),
                'default'    => array(
                    'size' => 240,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-info-box-description' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Border Style ───
        $this->start_controls_section(
            'section_border_style',
            array(
                'label' => esc_html__( 'Borders', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'border_color',
            array(
                'label'     => esc_html__( 'Border Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F0EDE9',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-info-boxes' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'border_width',
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
                    '{{WRAPPER}} .shopnex-info-boxes' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
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
            'strip_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-info-boxes' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend
     */
    protected function render() {
        $settings  = $this->get_settings_for_display();
        $widget_id = $this->get_id();

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/info-boxes/template/view.php';
    }
}
