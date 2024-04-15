<?php
/**
 * Buffer output so that we can replace special characters
 *
 * @return void
 */
function start_buffering() {
	ob_start();
}

add_action( 'wp_head', 'start_buffering', PHP_INT_MIN );

/**
 * Output buffer
 *
 * @return void
 */
function output_buffer() {
	echo replace_special_chars( ob_get_clean() );
}

add_action( 'wp_footer', 'output_buffer', PHP_INT_MAX );
