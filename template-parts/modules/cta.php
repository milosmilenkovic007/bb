<?php
/**
 * CTA module template part.
 *
 * @package Webnorth
 * @subpackage LE34
 */

$config = array(
	'data'   => array(
		'image_position' => $args['cta_image_position'],
		'image'          => $args['cta_image'],
		'image_alt'      => $args['cta_image_alt'],
		'image_size'     => $args['cta_image_size'],
		'title'          => $args['cta_title'],
		'subtitle'       => $args['cta_subtitle'],
		'text'           => $args['cta_text'],
		'link'           => $args['cta_link'],
	),
	'module' => get_module_settings( $args ),
);

echo generate_cta_module( $config );
