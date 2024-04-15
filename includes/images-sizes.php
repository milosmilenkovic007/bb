<?php


//for upload images more than 2560px
add_filter( 'big_image_size_threshold', '__return_false' );

//set thumbnail sizes
add_action( 'after_setup_theme', 'set_image_size');
function set_image_size() {
    add_image_size( '2k', 2560, 9999 );
    add_image_size( '4k', 3840, 9999 );
}
