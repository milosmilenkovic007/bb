<?php
// Analysis CPT

function create_analysis_post_type() {
    register_post_type('analysis',
        array(
            'labels' => array(
                'name' => __('Analysis'),
                'singular_name' => __('Analysis'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor'),
        )
    );
}
add_action('init', 'create_analysis_post_type');


// Add Columns CPT

function create_columns_cpt() {
    $labels = array(
        'name'               => 'Columns',
        'singular_name'      => 'Column',
        'menu_name'          => 'Columns',
        'name_admin_bar'     => 'Column',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Column',
        'new_item'           => 'New Column',
        'edit_item'          => 'Edit Column',
        'view_item'          => 'View Column',
        'all_items'          => 'All Columns',
        'search_items'       => 'Search Columns',
        'parent_item_colon'  => 'Parent Columns:',
        'not_found'          => 'No columns found.',
        'not_found_in_trash' => 'No columns found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'columns' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'author' ),
    );

    register_post_type( 'columns', $args );
}

add_action( 'init', 'create_columns_cpt' );

add_theme_support( 'post-thumbnails' );
add_image_size( 'author-photo', 100, 100, true ); // Adjust the size as needed

function create_columns_taxonomy() {
    $labels = array(
        'name'                       => 'Authors',
        'singular_name'              => 'Author',
        'search_items'               => 'Search Authors',
        'popular_items'              => 'Popular Authors',
        'all_items'                  => 'All Authors',
        'edit_item'                  => 'Edit Author',
        'update_item'                => 'Update Author',
        'add_new_item'               => 'Add New Author',
        'new_item_name'              => 'New Author Name',
        'separate_items_with_commas' => 'Separate authors with commas',
        'add_or_remove_items'        => 'Add or remove authors',
        'choose_from_most_used'      => 'Choose from the most used authors',
        'not_found'                  => 'No authors found',
        'menu_name'                  => 'Authors',
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'authors' ),
    );

    register_taxonomy( 'authors', 'columns', $args ); // Change 'columns' to an array('columns') if using multiple post types.
}

add_action( 'init', 'create_columns_taxonomy' );


// Register Teams Tahonomy
function custom_teams_taxonomy() {

    $labels = array(
        'name'                       => _x( 'Teams', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Team', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Teams', 'text_domain' ),
        'all_items'                  => __( 'All Teams', 'text_domain' ),
        'parent_item'                => __( 'Parent Team', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Team:', 'text_domain' ),
        'new_item_name'              => __( 'New Team Name', 'text_domain' ),
        'add_new_item'               => __( 'Add New Team', 'text_domain' ),
        'edit_item'                  => __( 'Edit Team', 'text_domain' ),
        'update_item'                => __( 'Update Team', 'text_domain' ),
        'view_item'                  => __( 'View Team', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate teams with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove teams', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Teams', 'text_domain' ),
        'search_items'               => __( 'Search Teams', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No teams', 'text_domain' ),
        'items_list'                 => __( 'Teams list', 'text_domain' ),
        'items_list_navigation'      => __( 'Teams list navigation', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
    );
    register_taxonomy( 'teams', array( 'post' ), $args );

}
add_action( 'init', 'custom_teams_taxonomy', 0 );

// CPT: Blog
function create_blog_post_type() {
    register_post_type('blog',
        array(
            'labels' => array(
                'name' => __('Blog'),
                'singular_name' => __('Blog'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt', 'custom-fields', 'post-formats'),
            'menu_icon' => 'dashicons-welcome-write-blog', // Change the icon as needed
            'taxonomies' => array('category', 'post_tag'), // Add support for categories and tags
        )
    );
}
add_action('init', 'create_blog_post_type');

// Change post to news

function change_post_type_labels( $args, $post_type ) {
    if ( 'post' === $post_type ) {
        $args['labels']['name'] = 'News';
        $args['labels']['singular_name'] = 'News';
        $args['labels']['menu_name'] = 'News';
    }
    return $args;
}
add_filter( 'register_post_type_args', 'change_post_type_labels', 10, 2 );

// CPT Products

function create_product_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Products',
            'singular_name' => 'Product',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => 'products'),
        'supports' => array('title', 'editor', 'thumbnail'),
    );
    register_post_type('product', $args);
}
add_action('init', 'create_product_post_type');



function map_acf_fields_to_product_post_type() {
    acf_add_local_field_group(array(
        'key' => 'group_product_fields',
        'title' => 'Product Fields',
        'fields' => array(
            array(
                'key' => 'field_product_title',
                'label' => 'Product Title',
                'name' => 'product_title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_product_price',
                'label' => 'Product Price',
                'name' => 'product_price',
                'type' => 'number',
            ),
            array(
                'key' => 'product_price_id',
                'label' => 'Stripe Price ID',
                'name' => 'product_price_id',
                'type' => 'text',
            ),
            array(
                'key' => 'product_mode',
                'label' => 'Product Mode',
                'name' => 'product_mode',
                'type' => 'radio',
                'choices' => array(
                    'subscription' => 'Subscription',
                    'payment' => 'One-time Payment',
                ),
                'layout' => 'horizontal',
            ),
            
            array(
                'key' => 'checkout_button',
                'label' => 'Checkout button text',
                'name' => 'checkout_button_text',
                'type' => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'map_acf_fields_to_product_post_type');


