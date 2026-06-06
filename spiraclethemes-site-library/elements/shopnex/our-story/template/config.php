<?php
/**
 * Our Story Widget for Shopnex Theme
 *
 * A two-column story section with image on the left and content on the right,
 * featuring a section tag, heading, paragraphs, and a blockquote with citation.
 *
 * @package SpiracleThemes_Site_Library
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Shopnex_OurStory extends \Elementor\Widget_Base {

    /**
     * Get widget name
     */
    public function get_name() {
        return 'shopnex-elementor-our-story';
    }

    /**
     * Get widget title
     */
    public function get_title() {
        return esc_html__( 'Our Story', 'spiraclethemes-site-library' );
    }

    /**
     * Get widget icon
     */
    public function get_icon() {
        return 'eicon-post-content';
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
        return array( 'story', 'about', 'our story', 'narrative', 'brand story', 'shopnex' );
    }

    /**
     * Register widget controls
     */
    protected function register_controls() {

        // ─── Image Section ───
        $this->start_controls_section(
            'section_image',
            array(
                'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'story_image',
            array(
                'label'   => esc_html__( 'Choose Image', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => array(
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ),
            )
        );

        $this->add_control(
            'enable_image_zoom',
            array(
                'label'        => esc_html__( 'Enable Hover Zoom', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_responsive_control(
            'image_aspect_ratio',
            array(
                'label'       => esc_html__( 'Aspect Ratio', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::SELECT,
                'default'     => '4-5',
                'options'     => array(
                    '4-5'  => esc_html__( '4:5 (Portrait)', 'spiraclethemes-site-library' ),
                    '1-1'  => esc_html__( '1:1 (Square)', 'spiraclethemes-site-library' ),
                    '3-4'  => esc_html__( '3:4 (Portrait)', 'spiraclethemes-site-library' ),
                    '3-2'  => esc_html__( '3:2 (Landscape)', 'spiraclethemes-site-library' ),
                    '16-9' => esc_html__( '16:9 (Wide)', 'spiraclethemes-site-library' ),
                ),
            )
        );

        $this->add_responsive_control(
            'image_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'default'    => array(
                    'top'    => '16',
                    'right'  => '16',
                    'bottom' => '16',
                    'left'   => '16',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Content Section ───
        $this->start_controls_section(
            'section_content',
            array(
                'label' => esc_html__( 'Content', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'tag_text',
            array(
                'label'       => esc_html__( 'Tag Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Our Story', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'show_tag',
            array(
                'label'        => esc_html__( 'Show Tag', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'title',
            array(
                'label'       => esc_html__( 'Title', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( 'Where Style Meets Soul', 'spiraclethemes-site-library' ),
                'label_block' => true,
            )
        );

        $this->add_control(
            'title_tag',
            array(
                'label'   => esc_html__( 'Title HTML Tag', 'spiraclethemes-site-library' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => array(
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'p'  => 'P',
                ),
            )
        );

        $this->add_control(
            'description_1',
            array(
                'label'       => esc_html__( 'Paragraph 1', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Our label was born from a passion for clothing that empowers and inspires. What began as a small atelier in 2018 — with just a sewing machine, a vision, and an obsession with fabric and form — has grown into a brand worn by those who believe fashion should feel as good as it looks.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 5,
            )
        );

        $this->add_control(
            'description_2',
            array(
                'label'       => esc_html__( 'Paragraph 2', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Today, we collaborate with skilled artisans and textile mills across the globe — from hand-loom weavers in India to master tailors in Italy — to craft garments that honor traditional craftsmanship while embracing bold, contemporary design. Every piece goes through months of refinement before it earns a place in our collection.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 5,
            )
        );

        $this->end_controls_section();

        // ─── Blockquote Section ───
        $this->start_controls_section(
            'section_blockquote',
            array(
                'label' => esc_html__( 'Blockquote', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'show_blockquote',
            array(
                'label'        => esc_html__( 'Show Blockquote', 'spiraclethemes-site-library' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'spiraclethemes-site-library' ),
                'label_off'    => esc_html__( 'No', 'spiraclethemes-site-library' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'blockquote_text',
            array(
                'label'       => esc_html__( 'Quote Text', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'We don\'t chase trends — we create them. Great style isn\'t about following the crowd; it\'s about wearing what makes you feel unmistakably you.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 4,
                'condition'   => array(
                    'show_blockquote' => 'yes',
                ),
            )
        );

        $this->add_control(
            'blockquote_citation',
            array(
                'label'       => esc_html__( 'Citation', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__( '— Elin Bergström, Founder & Creative Director', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'condition'   => array(
                    'show_blockquote' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Additional Paragraph ───
        $this->start_controls_section(
            'section_extra_content',
            array(
                'label' => esc_html__( 'Additional Content', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'description_3',
            array(
                'label'       => esc_html__( 'Paragraph 3 (After Blockquote)', 'spiraclethemes-site-library' ),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'default'     => esc_html__( 'Our commitment extends beyond aesthetics. We source only sustainably managed timber, use natural oils and finishes, and package every order in recycled and recyclable materials. We believe that beautiful design and responsible practice are inseparable.', 'spiraclethemes-site-library' ),
                'label_block' => true,
                'rows'        => 5,
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
            'grid_gap',
            array(
                'label'      => esc_html__( 'Gap', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 120,
                    ),
                ),
                'default'    => array(
                    'size' => 56,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story' => 'gap: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .shopnex-our-story' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'content_padding',
            array(
                'label'      => esc_html__( 'Content Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', 'em', '%' ),
                'default'    => array(
                    'top'    => '20',
                    'right'  => '0',
                    'bottom' => '20',
                    'left'   => '0',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'content_max_width',
            array(
                'label'      => esc_html__( 'Content Max Width', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
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
                    '{{WRAPPER}} .shopnex-our-story-content p' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Tag Style ───
        $this->start_controls_section(
            'section_tag_style',
            array(
                'label'     => esc_html__( 'Tag', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_tag' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'tag_typography',
                'selector' => '{{WRAPPER}} .shopnex-our-story-tag',
                'default'  => array(
                    'font_size'      => array( 'size' => 11, 'unit' => 'px' ),
                    'font_weight'    => '600',
                    'letter_spacing' => array( 'size' => 0.1, 'unit' => 'em' ),
                    'text_transform' => 'uppercase',
                ),
            )
        );

        $this->add_control(
            'tag_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-tag' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .shopnex-our-story-tag' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-our-story-title',
                'default'  => array(
                    'font_size'      => array( 'size' => 36, 'unit' => 'px' ),
                    'font_weight'    => '500',
                    'letter_spacing' => array( 'size' => -0.3, 'unit' => 'px' ),
                    'font_family'    => 'Playfair Display',
                    'line_height'    => array( 'size' => 1.2, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'title_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-title' => 'color: {{VALUE}};',
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
                        'max' => 60,
                    ),
                ),
                'default'    => array(
                    'size' => 20,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .shopnex-our-story-content p',
                'default'  => array(
                    'font_size'   => array( 'size' => 15, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'line_height' => array( 'size' => 1.75, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'description_color',
            array(
                'label'     => esc_html__( 'Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#6B6560',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-content p' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'description_spacing',
            array(
                'label'      => esc_html__( 'Paragraph Spacing', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => array( 'px' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 40,
                    ),
                ),
                'default'    => array(
                    'size' => 18,
                    'unit' => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-content p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Blockquote Style ───
        $this->start_controls_section(
            'section_blockquote_style',
            array(
                'label'     => esc_html__( 'Blockquote', 'spiraclethemes-site-library' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'show_blockquote' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'blockquote_typography',
                'selector' => '{{WRAPPER}} .shopnex-our-story-blockquote',
                'default'  => array(
                    'font_size'   => array( 'size' => 19, 'unit' => 'px' ),
                    'font_weight' => '400',
                    'font_style'  => 'italic',
                    'font_family' => 'Playfair Display',
                    'line_height' => array( 'size' => 1.5, 'unit' => '' ),
                ),
            )
        );

        $this->add_control(
            'blockquote_color',
            array(
                'label'     => esc_html__( 'Text Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#1C1C1C',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'blockquote_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote' => 'background: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'blockquote_border_color',
            array(
                'label'     => esc_html__( 'Left Border Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#B8977E',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote' => 'border-color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'blockquote_padding',
            array(
                'label'      => esc_html__( 'Padding', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px' ),
                'default'    => array(
                    'top'    => '14',
                    'right'  => '24',
                    'bottom' => '14',
                    'left'   => '24',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'blockquote_margin',
            array(
                'label'      => esc_html__( 'Margin', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px' ),
                'default'    => array(
                    'top'    => '28',
                    'right'  => '0',
                    'bottom' => '28',
                    'left'   => '0',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'blockquote_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'spiraclethemes-site-library' ),
                'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px' ),
                'default'    => array(
                    'top'    => '0',
                    'right'  => '6',
                    'bottom' => '6',
                    'left'   => '0',
                    'unit'   => 'px',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        // Citation style
        $this->add_control(
            'citation_heading',
            array(
                'label'     => esc_html__( 'Citation', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            array(
                'name'     => 'citation_typography',
                'selector' => '{{WRAPPER}} .shopnex-our-story-blockquote cite',
                'default'  => array(
                    'font_size'      => array( 'size' => 13, 'unit' => 'px' ),
                    'font_weight'    => '400',
                    'letter_spacing' => array( 'size' => 0.02, 'unit' => 'em' ),
                ),
            )
        );

        $this->add_control(
            'citation_color',
            array(
                'label'     => esc_html__( 'Citation Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#9C9792',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-blockquote cite' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        // ─── Image Style ───
        $this->start_controls_section(
            'section_image_style',
            array(
                'label' => esc_html__( 'Image', 'spiraclethemes-site-library' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'image_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'spiraclethemes-site-library' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#F3EFEA',
                'selectors' => array(
                    '{{WRAPPER}} .shopnex-our-story-image' => 'background: {{VALUE}};',
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

        include SPIR_SITE_LIBRARY_PATH . '/elements/shopnex/our-story/template/view.php';
    }
}
