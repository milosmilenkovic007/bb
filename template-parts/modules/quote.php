<?php
/**
 * Quote module template part.
 *
 * @package Webnorth
 * @subpackage LE34
 */

$config = array(
	'data'   => array(
		'title' => $args['quote_title'],
		'text'  => $args['quote_text'],
		'link'  => ! empty( $args['quote_link'] ) ? $args['quote_link'] : null,
	),
	'module' => get_module_settings( $args ),
);

echo generate_quote_module( $config );
