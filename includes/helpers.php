<?php
/**
 * Helper functions
 *
 * @package Bollsvenskan
 */

/**
 * Get current WPML language code.
 *
 * @return string Language code
 */
function get_current_language_code() {
	return apply_filters( 'wpml_current_language', null );
}

/**
 * Get  WPML post translations.
 *
 * @return array {
 *     Array of WPML post translations.
 *
 *     @type array ...$0 {
 *         Array of resource attributes, or a URL string.
 *
 *         @type string $label   Language code of the translation.
 *         @type string $url     Permalink of the translation.
 *         @type boolean $active Whether the translation is in current language.
 *
 * }
 */
function get_current_post_languages() {

	global $sitepress;

	$current_language_code = get_current_language_code();

	$items = array();

	foreach ( $sitepress->get_ls_languages( array( 'skip_missing' => false ) ) as $translation ) :

		$items[] = array(
			'label'  => $translation['code'],
			'url'    => $translation['url'],
			'active' => $current_language_code === $translation['code'],
		);

	endforeach;

	return $items;
}



/**
 * Get array of Flexible Content modules.
 *
 * @param  int|null $post_id Defaults to the current post ID.
 * @return array Array of Flexible Content Modules.
 */


/**
 * Get array of Flexible Content modules.
 *
 * @param  int|null $post_id Defaults to the current post ID.
 * @return array Array of Flexible Content Modules.
 */
function get_modules( $post_id = null ) {
    if ( is_null( $post_id ) ) {
        $post_id = get_the_ID();
    }

    $post_type = get_post_type( $post_id );

    switch ( $post_type ) {
        // Add your custom logic to retrieve modules based on post type
        case 'news':
            $modules = array(
                // Define your new ACF module configurations here
                array(
                    'acf_fc_layout' => 'post_list',
                   
                ),
            );
            break;
       
        default:
            // Default behavior to retrieve modules from ACF
            $modules = get_field( 'modules', $post_id, true );
            $modules = $modules ? $modules : array();
            break;
    }

    return $modules;
}



/**
 * Output class attribute
 *
 * @param  array $classes Array of CSS classes.
 * @return void
 */
function the_css_class( $classes ) {
	if ( ! empty( $classes ) ) :
		printf(
			'class="%1$s"',
			esc_attr( join( ' ', $classes ) )
		);
	endif;
}

/**
 * Checks if current page request is POST.
 *
 * @return boolean
 */
function is_post_request() {
	return 'POST' === $_SERVER['REQUEST_METHOD'];
}


/**
 * Generate module settings our of args
 *
 * @param  mixed[] $args ACF fields data.
 * @return mixed[]
 */
function get_module_settings( $args ) {

	$defaults = array(
		'id'                     => '',
		'class'                  => '',
		'spacing_top'            => 'none',
		'spacing_bottom'         => 'none',
		'spacing_top_desktop'    => 0,
		'spacing_top_mobile'     => 0,
		'spacing_bottom_desktop' => 0,
		'spacing_bottom_mobile'  => 0,
	);

	$settings = array(
		'id'                     => isset( $args['module_id'] ) ? $args['module_id'] : null,
		'class'                  => isset( $args['module_class'] ) ? $args['module_class'] : null,
		'spacing_top'            => isset( $args['module_spacing_top'] ) ? $args['module_spacing_top'] : null,
		'spacing_bottom'         => isset( $args['module_spacing_bottom'] ) ? $args['module_spacing_bottom'] : null,
		'spacing_top_desktop'    => isset( $args['module_spacing_top_desktop'] ) ? intval( $args['module_spacing_top_desktop'] ) : null,
		'spacing_top_mobile'     => isset( $args['module_spacing_top_mobile'] ) ? intval( $args['module_spacing_top_mobile'] ) : null,
		'spacing_bottom_desktop' => isset( $args['module_spacing_bottom_desktop'] ) ? intval( $args['module_spacing_bottom_desktop'] ) : null,
		'spacing_bottom_mobile'  => isset( $args['module_spacing_bottom_mobile'] ) ? intval( $args['module_spacing_bottom_mobile'] ) : null,
	);

	return wp_parse_args( $settings, $defaults );
}


/**
 * Replace TM and R special characters so that we can format them better
 *
 * @param  string $text Text to be modifed.
 * @return string
 */
function replace_special_chars( $text ) {

	if ( is_string( $text ) ) :

		$replacements = array(
			'&#x2122;'     => "<span class='tm-sign'>&#x2122;</span>",
			'™'            => "<span class='tm-sign'>™</span>",
			'&amp;#8482;'  => "<span class='tm-sign'>™</span>",
			'&#8482;'      => "<span class='tm-sign'>™</span>",
			'&amp;#169;'   => '&#169;',
			'®'            => "<span class='r-sign'>®</span>",
			'&#x00AE;'     => "<span class='r-sign'>®</span>",
			'&amp;#x00AE;' => "<span class='r-sign'>®</span>",
		);

		$text = strtr( $text, $replacements );

	endif;

	return $text;
}

/**
 * Generate template-part
 *
 *
 */

function custom_get_template_part( $slug, $args = array() ) {
    ob_start();
    $template_path = locate_template( $slug . '.php' );
    if ( ! empty( $template_path ) ) {
        include( $template_path );
    }
    return ob_get_clean();
}

/**
 * Generate Youtube embed video URL
 *
 * @param  string $id Youtube video's ID.
 * @param  string $loop Should video loop.
 * @return string
 */
function get_youtube_embed_url( $id, $loop = true ) {
	return sprintf(
		'https://www.youtube.com/embed/%1$s?autoplay=1&showinfo=0&loop=%2$s&mute=1&controls=0&rel=0&hd=1',
		$id,
		$loop ? 1 : 0
	);
}

/**
 * Outputs super-img component
 *
 * @param  mixed[]|int $image ACF Attachment array or Attachment ID.
 * @param  mixed[]     $video ACF Attachment array.
 * @param  string      $alt Image alt text ( overrides the one set in WP ).
 * @param  string      $css_class Extra CSS class of the component container.
 * @param  string      $size Max image size to display.
 * @return void
 */
function super_img( $image = null, $video = null, $alt = '', $css_class = '', $size = '' ) {

	if ( is_int( $image ) ) :
		$image = acf_get_attachment( $image );
	endif;

	$super_img_args = array(
		'image'      => $image,
		'video'      => $video,
		'alt'        => $alt,
		'class'      => $css_class,
		'image_size' => $size,
	);

	get_template_part( slug: 'template-parts/components/super-img', args: $super_img_args );
}

/**
 * Outputs video component
 *
 * @param  string       $url URL to video.
 * @param  string       $type Youtube / Local.
 * @param  boolean      $loop Should video loop.
 * @param  boolean      $autoplay Should video autoplay.
 * @param  boolean      $mobile Should video display on mobile.
 * @param  mixed[]|null $image ACF attachment array.
 * @param  string       $alt Image alt text.
 * @param  string       $size Image aspect ratio class.
 * @return void
 */
function video( $url, $type, $loop = true, $autoplay = true, $mobile = true, $image = null, $alt = '', $size = 'landscape' ) {

	$video_args = array(
		'video_type'           => $type,
		'video_url'            => $url,
		'video_loop'           => $loop,
		'video_autoplay'       => $autoplay,
		'video_play_on_mobile' => $mobile,
		'image'                => $image,
		'image_alt'            => $alt,
		'image_size'           => $size,
	);

	get_template_part( slug: 'template-parts/components/video', args: $video_args );
}

/**
 * Outputs the image. It is shorted than calling wp_get_attachment_image.
 *
 * @param  int    $id Attachment ID.
 * @param  string $size Image size.
 * @param  string $alt Image alt text.
 * @return void
 */
function the_image( $id, $size = 'medium-large', $alt = '' ) {

	$args = array();

	if ( $alt ) :
		$args['alt'] = $alt;
	endif;

	echo wp_get_attachment_image( $id, $size, $args );
}



