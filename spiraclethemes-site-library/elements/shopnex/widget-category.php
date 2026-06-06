<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}


function shopnex_elementor_widget_categories( $elements_manager ) {

    $categories = [];
    $categories['shopnex-elementor'] =
        [
            'title'  => esc_html__('Shopnex Free', 'spiraclethemes-site-library'),
            'icon'   => 'eicon-font',
        ];

    $old_categories = $elements_manager->get_categories();
    $categories = array_merge($categories, $old_categories);

    $set_categories = function ( $categories ) {
        $this->categories = $categories;
    };

    $set_categories->call( $elements_manager, $categories );

}
add_action( 'elementor/elements/categories_registered', 'shopnex_elementor_widget_categories', 1 );
