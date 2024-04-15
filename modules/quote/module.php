<?php
/**
 * Quote module.
 *
 * @package Webnorth
 * @subpackage LE34
 */

/**
 * Generates HTML for Quote module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_quote_module( $config ) {

	$config_defaults = array(
		'data'   => array(),
		'module' => array(),
	);

	$config = wp_parse_args( $config, $config_defaults );

	$data_defaults = array(
		'title' => '',
		'text'  => '',
		'link'  => false,
	);

	$data = wp_parse_args( $config['data'], $data_defaults );

	ob_start();

	?>
	<div class="row">
		<div class="col-md-9 col-md-offset-2">
			<h2 class="heading-03"><?php echo esc_html( $data['title'] ); ?></h2>
			<div class="text"><?php echo $data['text']; ?></div>
			<?php if ( $data['link'] ) : ?>
			<a class="link-cta" href="<?php echo esc_url( $data['link']['url'] ); ?>" <?php the_link_target( $data['link'] ); ?>><?php echo esc_html( $data['link']['title'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<?php

	// module's html here.

	$html = ob_get_clean();

	$args = array(
		'name'  => 'quote',
		'html'  => $html,
		'fluid' => true,
	);

	$args = array_merge( $args, $config['module'] );

	ob_start();

	get_template_part( slug: 'template-parts/module', args: $args );

	return ob_get_clean();
}
