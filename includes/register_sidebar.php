<?php

/**
* Register Sidebar.
 */

 function register_custom_sidebar() {
     register_sidebar( array(
         'name'          => __( 'Single Article', 'bollsvenskan' ),
         'id'            => 'custom-sidebar',
         'description'   => __( 'This is a custom sidebar for single posts.', 'bollsvenskan' ),
         'before_widget' => '<div id="%1$s" class="widget %2$s">',
         'after_widget'  => '</div>',
         'after_title'   => '</h4>',
     ) );
 }
 add_action( 'widgets_init', 'register_custom_sidebar' );


?>


