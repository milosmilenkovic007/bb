<?php
/**
 * template-parts/blueprints/module_template_part.php
 * _module_title_ module template part.
 *
 * @package Bollsvenskan
 */

$config = array(
	'data'   => array(),
	'module' => get_module_settings( $args ),
);

echo generate__module_id__module( $config );
