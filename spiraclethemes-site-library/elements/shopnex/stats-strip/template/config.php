<?php
/**
 * Stats Strip Widget for Shopnex Theme
 *
 * A horizontal stats strip section displaying key metrics/numbers
 * in a grid layout with dividers between items.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_StatsStrip extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-stats-strip';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Stats Strip', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-counter';
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
        return array( 'stats', 'counter', 'numbers', 'metrics', 'strip', 'statistics', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Stats Items ───
        $this->start_controls_section(
            'section_stats',
            array(
                'label' => esc_html__( 'Stats Items', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'stat_number',
            array(
                'label'       => esc_html__( 'Number', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '8', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'description' => esc_html__( 'The main number value (e.g., 8, 24, 12, 100)', 'spiraclethemes-site-library' ),
            )
        );

        $repeater->add_control(
            'stat_suffix',
            array(
                'label'       => esc_html__( 'Suffix / Accent Character', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '+', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'description' => esc_html__( 'Optional suffix displayed in accent color (e.g., +, k, %). Leave empty for none.', 'spiraclethemes-site-library' ),
            )
        );

        $repeater->add_control(
            'stat_label',
            array(
                'label'       => esc_html__( 'Label', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Years in fashion', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'stats_list',
            array(
                'label'       => esc_html__( 'Stat Items', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'stat_number' => '8',
                        'stat_suffix' => '+',
                        'stat_label'  => 'Years of craft',
                    ),
                    array(
                        'stat_number' => '24',
                        'stat_suffix' => '',
                        'stat_label'  => 'Artisan partners',
                    ),
                    array(
                        'stat_number' => '12',
                        'stat_suffix' => 'k',
                        'stat_label'  => 'Happy homes',
                    ),
                    array(
                        'stat_number' => '100',
                        'stat_suffix' => '%',
                        'stat_label'  => 'Carbon neutral',
                    ),
                ),
                'title_field' => '{{{ stat_number }}}{{{ stat_suffix }}} — {{{ stat_label }}}',
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
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ),
                'selectors'   => array(
                    '{{WRAPPER}} .shopnex-stats-strip' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
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
                    'top'    => '40',
                    'right'  => '20',
                    'bottom' => '40',
                    'left'   => '20',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-stat-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-stats-strip' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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

        $this->add_control(
            'show_dividers',
            array(
                'label'        => esc_html__( 'Show Dividers Between Items', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->end_controls_section();

        // ─── Number Style ───
        $this->start_controls_section(
            'section_number_style',
            array(
                'label' => esc_html__( 'Number', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'number_typography',
                'selector' => '{{WRAPPER}} .shopnex-stat-number',
                'default'  => array(
                    'font_size'      => array( 'size' => 44, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.4, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                    'line_height'    => array( 'size' => 1, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'number_color',
            array(
                'label'     => esc_html__( 'Number Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-stat-number' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'suffix_color',
            array(
                'label'     => esc_html__( 'Suffix / Accent Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-stat-number .shopnex-stat-accent' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'number_spacing',
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
                    'size' => 8,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-stat-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Label Style ───
        $this->start_controls_section(
            'section_label_style',
            array(
                'label' => esc_html__( 'Label', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .shopnex-stat-label',
                'default'  => array(
                    'font_size'      => array( 'size' => 12, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => 0.8, 'unit' => 'px' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'label_color',
            array(
                'label'     => esc_html__( 'Label Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C9792',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-stat-label' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Border & Divider Style ───
        $this->start_controls_section(
            'section_border_style',
            array(
                'label' => esc_html__( 'Borders & Dividers', 'spiraclethemes-site-library' ),
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
                    '{{WRAPPER}} .shopnex-stats-strip'                              => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .shopnex-stat-item:not(:last-child)::after'       => 'background: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-stats-strip' => 'border-top-width: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'divider_width',
            array(
                'label'      => esc_html__( 'Divider Width', 'spiraclethemes-site-library' ),
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
                    '{{WRAPPER}} .shopnex-stat-item:not(:last-child)::after' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'divider_height',
            array(
                'label'      => esc_html__( 'Divider Height (%)', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( '%' ),
                'range'      => array(
                    '%' => array(
                        'min' => 10,
                        'max' => 100,
                    ),
                ),
                'default'    => array(
                    'size' => 60,
                    'unit' => '%',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-stat-item:not(:last-child)::after' => 'height: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-stats-strip' => 'background: {{VALUE}};',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/stats-strip/template/view.php';
    }
}
