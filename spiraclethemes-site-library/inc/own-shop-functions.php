<?php
/**
 *
 * @package spiraclethemes-site-library
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) :
    die;
endif;


/**
 *  Set Import files
 */

if ( ! function_exists( 'spiraclethemes_site_library_own_shop_set_import_files' ) ) :
function spiraclethemes_site_library_own_shop_set_import_files() {

    $returnArray = array();
    for ($i = 1; $i <= 2; $i++) {
        $customizer_ownshop_demo[$i] = spiraclethemes_site_library_api_data('ownshop', 'demo'.$i, 'customizer');
        $widgets_ownshop_demo[$i] = spiraclethemes_site_library_api_data('ownshop', 'demo'.$i, 'widgets');
        $content_ownshop_demo[$i] = spiraclethemes_site_library_api_data('ownshop', 'demo'.$i, 'content');
        $image_ownshop_demo[$i] = spiraclethemes_site_library_api_data('ownshop', 'demo'.$i, 'image');

        $returnArray[] = array(
            'import_file_name'           => esc_html__('Demo'.$i, 'spiraclethemes-site-library'),
            'import_file_url'            => $content_ownshop_demo[$i],
            'import_widget_file_url'     => $widgets_ownshop_demo[$i],
            'import_customizer_file_url' => $customizer_ownshop_demo[$i],    
            'import_preview_image_url'   => $image_ownshop_demo[$i],
            'import_notice'              => esc_html__( '', 'spiraclethemes-site-library' ),
            'preview_url'                => 'https://ownshop.spiraclethemes.com/demo'.$i,
        );
    }
    return $returnArray;
}
endif;
add_filter( 'pt-ocdi/import_files', 'spiraclethemes_site_library_own_shop_set_import_files' );


/**
 *  After Import
 */

if ( ! function_exists( 'spiraclethemes_site_library_own_shop_after_import_setup' ) ) :
function spiraclethemes_site_library_own_shop_after_import_setup( $selected_import ) {
	//Assign menus to their locations
	$main_menu = get_term_by( 'name', 'Primary', 'nav_menu' );
	$category_menu = get_term_by( 'name', 'Category Menu', 'nav_menu' );
	$topbar_menu = get_term_by( 'name', 'Top Bar', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
	      'primary' => $main_menu->term_id,
	      'categorymenu' => $category_menu->term_id,
	      'topbar' => $topbar_menu->term_id,
	    )
	);

    //Assign front & blog page
    $front_page = get_page_by_title( 'Home' );  
    $blog_page = get_page_by_title( 'Blog' );  

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page -> ID );    
    update_option( 'page_for_posts', $blog_page -> ID ); 
    
}
endif;
add_action( 'pt-ocdi/after_import', 'spiraclethemes_site_library_own_shop_after_import_setup' );


function spiraclethemes_site_library_own_shop_check_pro_plugin() {
    if ( ! function_exists( 'ocdi_register_plugins' ) ) :
        function ocdi_register_plugins( $plugins ) {
         
            // List of plugins used by all theme demos.
            $theme_plugins = [
                [ 
                  'name'     => 'Elementor Website Builder',
                  'slug'     => 'elementor',
                  'required' => true,
                ],
                [ 
                  'name'     => 'WooCommerce',
                  'slug'     => 'woocommerce',
                  'required' => true,
                ],
                [ 
                  'name'     => 'Contact Form 7',
                  'slug'     => 'contact-form-7',
                  'required' => true,
                ],
            ];
         
            return array_merge( $plugins, $theme_plugins );
        }
    endif;
    add_filter( 'ocdi/register_plugins', 'ocdi_register_plugins' );
}
add_action( 'admin_init', 'spiraclethemes_site_library_own_shop_check_pro_plugin' );



/**
 *  List All| Featured | New | Popular Products functions
 */


if( !function_exists('spiraclethemes_site_library_own_shop_listprod') ) {
    function spiraclethemes_site_library_own_shop_listprod($atts, $content = null) {
        $atts = shortcode_atts(array(
            'prod_options'        => '',
            'prod_count'          => '8',
            'prod_columns_count'  => '4',
            'prod_display_tabs'   => 'true',
        ), $atts);

        $prod_options        = sanitize_text_field($atts['prod_options']);
        $prod_count          = absint($atts['prod_count']);
        $prod_columns_count  = absint($atts['prod_columns_count']);
        $prod_display_tabs   = ($atts['prod_display_tabs'] === 'true' || $atts['prod_display_tabs'] === '1') ? 'true' : 'false';
       
        $arr='';
        if($prod_options != '' && $prod_options != 'all') {
            $str = str_replace(' ', '', $prod_options);
            $arr = explode(',', $str);
        }
        
        ?>
            <div class="list-products-section">
                <div class="tabbable-panel">
                    <div class="tabbable-line">
                        <?php
                            if( true==$prod_display_tabs ) :
                                ?>
                                    <ul class="nav nav-tabs ">
                                        <?php
                                            $tabcount=0;
                                            if (in_array("all", $arr)) :
                                                $tabcount++;
                                                if($tabcount==1) :
                                                    ?><li class="active"><?php
                                                else :
                                                    ?><li><?php
                                                endif;
                                                ?><a href="#tab_default_<?php echo esc_attr( $tabcount ); ?>" data-toggle="tab"><?php esc_html_e('All','spiraclethemes-site-library'); ?></a></li><?php
                                            endif;
                                            if (in_array("featured", $arr)) :
                                                $tabcount++;
                                                if($tabcount==1) :
                                                    ?><li class="active"><?php
                                                else :
                                                    ?><li><?php
                                                endif;
                                                ?><a href="#tab_default_<?php echo esc_attr( $tabcount ); ?>" data-toggle="tab"><?php esc_html_e('Featured','spiraclethemes-site-library'); ?></a></li><?php
                                            endif;
                                            if (in_array("new", $arr)) :
                                                $tabcount++;
                                                if($tabcount==1) :
                                                    ?><li class="active"><?php
                                                else :
                                                    ?><li><?php
                                                endif;
                                                ?><a href="#tab_default_<?php echo esc_attr( $tabcount ); ?>" data-toggle="tab"><?php esc_html_e('New','spiraclethemes-site-library'); ?></a></li><?php
                                            endif;
                                            if (in_array("popular", $arr)) :
                                                $tabcount++;
                                                if($tabcount==1) :
                                                    ?><li class="active"><?php
                                                else :
                                                    ?><li><?php
                                                endif;
                                                ?><a href="#tab_default_<?php echo esc_attr( $tabcount ); ?>" data-toggle="tab"><?php esc_html_e('Popular','spiraclethemes-site-library'); ?></a></li><?php
                                            endif;
                                        ?>
                                    </ul>
                                <?php
                            endif;
                        ?>
                        <div class="tab-content">
                            <?php
                                $tabcount=0;
                                if (in_array("all", $arr)) :
                                    $tabcount++;
                                    if($tabcount==1) :
                                        ?><div class="tab-pane active" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    else :
                                        ?><div class="tab-pane" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    endif;
                                    ?>
                                        <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'"]'); ?>
                                        </div>
                                    <?php
                                endif;
                                if (in_array("featured", $arr)) :
                                    $tabcount++;
                                    if($tabcount==1) :
                                        ?><div class="tab-pane active" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    else :
                                        ?><div class="tab-pane" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    endif;
                                    ?>
                                        <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'" visibility="featured"]'); ?>
                                        </div>
                                    <?php
                                endif;
                                if (in_array("new", $arr)) :
                                    $tabcount++;
                                    if($tabcount==1) :
                                        ?><div class="tab-pane active" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    else :
                                        ?><div class="tab-pane" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    endif;
                                    ?>
                                        <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'" orderby="id" order="DESC" visibility="visible"]'); ?>
                                        </div>
                                    <?php
                                endif;
                                if (in_array("popular", $arr)) :
                                    $tabcount++;
                                    if($tabcount==1) :
                                        ?><div class="tab-pane active" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    else :
                                        ?><div class="tab-pane" id="<?php echo esc_attr('tab_default_'.$tabcount); ?>"><?php
                                    endif;
                                    ?>	
                                        <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'" best_selling="true" ]'); ?>
                                        </div>
                                    <?php
                                endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
      
    }
    add_shortcode('listprod', 'spiraclethemes_site_library_own_shop_listprod');
}


/**
 *  List Featured Products functions
 */

 if( !function_exists('spiraclethemes_site_library_own_shop_featuredprod') ) {
    function spiraclethemes_site_library_own_shop_featuredprod($atts, $content = null) {
        $atts = shortcode_atts(array(
            'prod_count'         => '8',
            'prod_columns_count' => '4',
        ), $atts);

        $prod_count         = absint($atts['prod_count']);
        $prod_columns_count = absint($atts['prod_columns_count']);
        
        ?>
            <div class="list-products-section">
                <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'" visibility="featured"]'); ?>
            </div>
        <?php
      
    }
    add_shortcode('featuredprod', 'spiraclethemes_site_library_own_shop_featuredprod');
}


/**
 *  List New Products functions
 */

 if( !function_exists('spiraclethemes_site_library_own_shop_newprod') ) {
    function spiraclethemes_site_library_own_shop_newprod($atts, $content = null) {
        $atts = shortcode_atts(array(
            'prod_count'         => '8',
            'prod_columns_count' => '4',
        ), $atts);

        $prod_count         = absint($atts['prod_count']);
        $prod_columns_count = absint($atts['prod_columns_count']);
        
        ?>
            <div class="list-products-section">
                <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'" orderby="id" order="DESC" visibility="visible"]'); ?>
            </div>
        <?php
      
    }
    add_shortcode('newprod', 'spiraclethemes_site_library_own_shop_newprod');
}


/**
 *  List Popular Products functions
 */

 if( !function_exists('spiraclethemes_site_library_own_shop_popularprod') ) {
    function spiraclethemes_site_library_own_shop_popularprod($atts, $content = null) {
        $atts = shortcode_atts(array(
            'prod_count'         => '8',
            'prod_columns_count' => '4',
        ), $atts);

        $prod_count         = absint($atts['prod_count']);
        $prod_columns_count = absint($atts['prod_columns_count']);
        
        ?>
            <div class="list-products-section">
                <?php echo do_shortcode('[products limit="'.$prod_count.'" columns="'.$prod_columns_count.'" best_selling="true" ]'); ?>
            </div>
        <?php
      
    }
    add_shortcode('popularprod', 'spiraclethemes_site_library_own_shop_popularprod');
}


/**
 *  List Categories
 */
function spiraclethemes_site_library_own_shop_get_categories(){
    $categories = get_categories( [
        'taxonomy'     => 'category',
        'type'         => 'post',
        'child_of'     => 0,
        'parent'       => '',
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => 1,
        'hierarchical' => 1,
        'exclude'      => '',
        'include'      => '',
        'number'       => 0,
        'pad_counts'   => false,
    ]);
    if( $categories ){
        foreach( $categories as $cat ){
            $cat_select[$cat->slug] = $cat->name;
        }
    } else {
        $cat_select = array(''=>'No categories');
    }
    return $cat_select;
}

/**
 *  List Recent Blog functions
 */

 if( !function_exists('spiraclethemes_site_library_own_shop_recentblog') ) {
    function spiraclethemes_site_library_own_shop_recentblog($atts, $content = null) {
        $atts = shortcode_atts(array(
            'posts_count'            => '3',
            'post_cat_slug'          => '',
            'post_display_excerpt'   => 'false',
            'post_display_readmore'  => 'true',
            'post_read_more'         => 'READ MORE',
        ), $atts);

        $posts_count           = absint($atts['posts_count']);
        $post_cat_slug         = sanitize_text_field($atts['post_cat_slug']);
        $post_display_excerpt  = ($atts['post_display_excerpt'] === 'true' || $atts['post_display_excerpt'] === '1') ? 'true' : 'false';
        $post_display_readmore = ($atts['post_display_readmore'] === 'true' || $atts['post_display_readmore'] === '1') ? 'true' : 'false';
        $post_read_more        = sanitize_text_field($atts['post_read_more']);

        $args = array(
            'post_type' => 'post',
            'posts_per_page' => $posts_count,
            'post_status'    => 'publish',
        );
        if($post_cat_slug != '' && $post_cat_slug != 'all'){
            $str = str_replace(' ', '', $post_cat_slug);
            $arr = explode(',', $str);    
            $args['tax_query'][] = array(
              'taxonomy'  => 'category',
              'field'   => 'slug',
              'terms'   => $arr
            );

        }
        $recent = new WP_Query($args);

        ?>
            <div class="latest-posts-wrapper">
                <div class="latest-posts-lists-wrapper">
                    <div class="latest-posts-content">
                        <?php
                            while ( $recent->have_posts() )  : $recent->the_post(); ?>
                                <article class="recent-blog-widget">
                                    <div class="blog-post">
                                        <div class="image">
                                            <?php
                                                if ( has_post_thumbnail()) :
                                                    the_post_thumbnail('full');
                                                else :
                                                    $post_img_url = get_template_directory_uri().'/img/no-image.jpg';
                                                    ?><img src="<?php echo esc_url($post_img_url); ?>" alt="<?php esc_attr_e('post-image','spiraclethemes-site-library'); ?>" /><?php
                                                        
                                                endif;
                                            ?>
                                            <div class="post-date bottom-left">
                                                <div class="post-day"><?php the_time(get_option('date_format')) ?></div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="content">
                                            <h3 class="entry-title">
                                                <?php
                                                    if ( is_sticky() && is_home() ) :
                                                        echo wp_kses_post( "<i class='la la-thumbtack'></i>" );
                                                    endif;
                                                ?>
                                                <a href="<?php echo esc_url( get_permalink()); ?>" rel="bookmark"><?php echo esc_html(get_the_title()); ?></a>
                                            </h3>
                                            <?php
                                                if( true==$post_display_excerpt ) {
                                                    the_excerpt();
                                                    if( true==$post_display_readmore ) {
                                                        ?>
                                                            <div class="read-more">
                                                                <a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html($post_read_more); ?> <i class="la la-long-arrow-alt-right"></i></a>
                                                            </div>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile;
                        ?>
                    </div>
                </div>
            </div>
        <?php
        wp_reset_postdata();
    }
    add_shortcode('recentblog', 'spiraclethemes_site_library_own_shop_recentblog');
}

/**
 * Quick View Functions
 */

/**
 * Add Quick View Button to WooCommerce Product Loop
 */
if( !function_exists('spiraclethemes_site_library_own_shop_add_quick_view_button') ) {
function spiraclethemes_site_library_own_shop_add_quick_view_button() {
    global $product;
    if ( $product && is_a( $product, 'WC_Product' ) ) {
        echo '<a href="#" class="own-shop-quick-view-btn" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product->get_type() ) . '" aria-label="' . esc_attr__( 'Quick View', 'spiraclethemes-site-library' ) . '"></a>';
    }
}
}

/**
 * Enqueue Quick View Scripts
 */
if( !function_exists('spiraclethemes_site_library_own_shop_enqueue_quick_view_scripts') ) {
    function spiraclethemes_site_library_own_shop_enqueue_quick_view_scripts() {
        wp_enqueue_script( 'own-shop-quick-view', plugin_dir_url( __FILE__ ) . '../js/own-shop-quick-view.js', array( 'jquery' ), '1.0.0', true );
        wp_localize_script( 'own-shop-quick-view', 'own_shop_quick_view_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'own_shop_quick_view_nonce' )
        ));
        wp_enqueue_style( 'own-shop-quick-view', plugin_dir_url( __FILE__ ) . '../css/own-shop-quick-view.css', array(), '1.0.0' );
    }
    add_action( 'wp_enqueue_scripts', 'spiraclethemes_site_library_own_shop_enqueue_quick_view_scripts' );
}

/**
 * AJAX Handler for Quick View
 */
if( !function_exists('spiraclethemes_site_library_own_shop_quick_view_ajax_handler') ) {
    function spiraclethemes_site_library_own_shop_quick_view_ajax_handler() {
        check_ajax_referer( 'own_shop_quick_view_nonce', 'nonce' );

        $product_id = intval( $_POST['product_id'] );
        $product = wc_get_product( $product_id );

        if ( !$product ) {
            wp_die( esc_html__( 'Product not found.', 'spiraclethemes-site-library' ) );
        }

        ob_start();
        ?>
        <div class="own-shop-quick-view-modal">
            <div class="quick-view-content">
                <button class="quick-view-close" onclick="closeOwnShopQuickView()" aria-label="Close">
                    <i class="las la-times-circle"></i>
                </button>
                <div class="quick-view-body">
                    <div class="quick-view-images-section">
                        <?php
                        $attachment_ids = $product->get_gallery_image_ids();
                        $main_image_url = has_post_thumbnail( $product_id ) ? get_the_post_thumbnail_url( $product_id, 'large' ) : wc_placeholder_img_src();
                        ?>
                        <img id="quick-view-main-image" class="quick-view-main-image" src="<?php echo esc_url( $main_image_url ); ?>" alt="<?php echo esc_attr( $product->get_name() ); ?>">

                        <?php if ( count( $attachment_ids ) > 1 || has_post_thumbnail( $product_id ) ) : ?>
                        <div class="quick-view-thumbnails">
                            <?php
                            if ( has_post_thumbnail( $product_id ) ) {
                                $thumbnail_url = get_the_post_thumbnail_url( $product_id, 'thumbnail' );
                                echo '<img class="thumbnail active" src="' . esc_url( $thumbnail_url ) . '" alt="Thumbnail" onclick="changeQuickViewImage(\'' . esc_js( $thumbnail_url ) . '\', this)">';
                            }
                            if ( $attachment_ids ) {
                                foreach ( $attachment_ids as $attachment_id ) {
                                    $thumbnail_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
                                    $large_url = wp_get_attachment_image_url( $attachment_id, 'large' );
                                    echo '<img class="thumbnail" src="' . esc_url( $thumbnail_url ) . '" alt="Thumbnail" onclick="changeQuickViewImage(\'' . esc_js( $large_url ) . '\', this)">';
                                }
                            }
                            ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="quick-view-details">
                        <h2 class="quick-view-title"><?php echo esc_html( $product->get_name() ); ?></h2>

                        <div class="quick-view-rating">
                            <?php
                            $rating_count = $product->get_rating_count();
                            $review_count = $product->get_review_count();
                            $average = $product->get_average_rating();
                            ?>
                            <?php echo wc_get_rating_html( $average, $rating_count ); ?>
                            <?php if ( comments_open() && $review_count ) : ?>
                                <span class="modal-reviews"><?php printf( _n( '(%s review)', '(%s reviews)', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?></span>
                            <?php endif ?>
                        </div>

                        <div class="quick-view-price"><?php echo $product->get_price_html(); ?></div>

                        <div class="quick-view-description">
                            <?php echo wp_kses_post( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ); ?>
                        </div>

                        <!-- Stock Status -->
                        <div class="modal-stock"><?php echo esc_html( $product->is_in_stock() ? 'In Stock' : 'Out of Stock' ); ?></div>

                        <div class="quick-view-quantity">
                            <span class="quantity-label"><?php esc_html_e('Quantity:', 'woocommerce'); ?></span>
                            <div class="quantity-input">
                                <button class="quantity-btn" onclick="decreaseQuickViewQuantity()">-</button>
                                <input type="number" class="quantity-value" id="quick-view-quantity" value="1" min="1" readonly>
                                <button class="quantity-btn" onclick="increaseQuickViewQuantity()">+</button>
                            </div>
                        </div>

                        <button class="modal-add-to-cart" onclick="addQuickViewToCart(<?php echo esc_js($product_id); ?>)">
                            <i class="fas fa-shopping-cart"></i> <?php echo esc_html($product->single_add_to_cart_text()); ?>
                        </button>

                        <!-- Meta Information -->
                        <div class="modal-meta">
                            <div><span><?php esc_html_e('SKU:', 'spiraclethemes-site-library'); ?></span> <span><?php echo esc_html( $product->get_sku() ? $product->get_sku() : esc_html__('N/A', 'spiraclethemes-site-library') ); ?></span></div>
                            <div><span><?php esc_html_e('Category:', 'spiraclethemes-site-library'); ?></span>
                                <?php
                                $categories = wp_get_post_terms( $product_id, 'product_cat' );
                                $category_names = array();
                                foreach ( $categories as $category ) {
                                    $category_names[] = esc_html( $category->name );
                                }
                                echo '<span>' . implode( ', ', $category_names ) . '</span>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();

        wp_send_json_success( $content );
    }
    add_action( 'wp_ajax_own_shop_quick_view', 'spiraclethemes_site_library_own_shop_quick_view_ajax_handler' );
    add_action( 'wp_ajax_nopriv_own_shop_quick_view', 'spiraclethemes_site_library_own_shop_quick_view_ajax_handler' );
}

/**
 * AJAX Handler for Quick View Add to Cart
 */
if( !function_exists('spiraclethemes_site_library_own_shop_quick_view_add_to_cart_ajax') ) {
    function spiraclethemes_site_library_own_shop_quick_view_add_to_cart_ajax() {
        check_ajax_referer( 'own_shop_quick_view_nonce', 'security' );

        $product_id = intval( $_POST['product_id'] );
        $quantity = intval( $_POST['quantity'] );
        $variation_id = isset( $_POST['variation_id'] ) ? intval( $_POST['variation_id'] ) : 0;
        $variations = isset( $_POST['variation'] ) ? $_POST['variation'] : array();

        if ( ! $product_id || $quantity < 1 ) {
            wp_send_json_error( __( 'Invalid product or quantity.', 'spiraclethemes-site-library' ) );
        }

        $product = wc_get_product( $product_id );

        if ( ! $product ) {
            wp_send_json_error( __( 'Product not found.', 'spiraclethemes-site-library' ) );
        }

        // Handle variable products
        if ( $product->is_type( 'variable' ) ) {
            if ( ! $variation_id ) {
                wp_send_json_error( __( 'Please select product options.', 'spiraclethemes-site-library' ) );
            }

            $variation = wc_get_product( $variation_id );
            if ( ! $variation || ! $variation->exists() || ! $variation->is_in_stock() ) {
                wp_send_json_error( __( 'Invalid variation selected.', 'spiraclethemes-site-library' ) );
            }

            $product_id = $variation_id;
        }

        // Check if product is in stock
        if ( ! $product->is_in_stock() ) {
            wp_send_json_error( __( 'Sorry, this product is out of stock.', 'spiraclethemes-site-library' ) );
        }

        // Check stock quantity
        if ( ! $product->has_enough_stock( $quantity ) ) {
            wp_send_json_error( sprintf( __( 'Sorry, we do not have enough "%s" in stock to fulfill your order.', 'woocommerce' ), $product->get_name() ) );
        }

        // Add to cart
        $cart_item_key = WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations );

        if ( ! $cart_item_key ) {
            wp_send_json_error( __( 'Failed to add product to cart.', 'spiraclethemes-site-library' ) );
        }

        // Return success response
        wp_send_json_success( array(
            'cart_hash' => WC()->cart->get_cart_hash(),
            'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array() ),
            'cart_url' => wc_get_cart_url(),
            'message' => sprintf( __( '"%s" has been added to your cart.', 'woocommerce' ), $product->get_name() ),
        ) );
    }
    add_action( 'wp_ajax_own_shop_quick_view_add_to_cart', 'spiraclethemes_site_library_own_shop_quick_view_add_to_cart_ajax' );
    add_action( 'wp_ajax_nopriv_own_shop_quick_view_add_to_cart', 'spiraclethemes_site_library_own_shop_quick_view_add_to_cart_ajax' );
}

/**
 * Add Quick View Button to Product Actions
 */
if( !function_exists('spiraclethemes_site_library_own_shop_add_quick_view_to_product_loop') ) {
    function spiraclethemes_site_library_own_shop_add_quick_view_to_product_loop() {
        add_action( 'woocommerce_after_shop_loop_item', 'spiraclethemes_site_library_own_shop_add_quick_view_button', 15 );
    }
    add_action( 'woocommerce_init', 'spiraclethemes_site_library_own_shop_add_quick_view_to_product_loop' );
}
