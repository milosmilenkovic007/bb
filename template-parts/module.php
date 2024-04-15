<?php
/**
 * template-parts/module.php
 * Module template.
 *
 * @package Bollsvenskan
 */

$defaults = array(
	'name'                       => '',
	'html'                       => '',
	'fluid'                      => false,
	'id'                         => '',
	'class'                      => '',
	'container_class'            => '',
	'spacing_top'                => 'none',
	'spacing_top_desktop'        => 0,
	'spacing_top_mobile'         => 0,
	'spacing_bottom'             => 'none',
	'spacing_top_bottom_desktop' => 0,
	'spacing_top_bottom_mobile'  => 0,
);

$settings = wp_parse_args( $args, $defaults );

$module_classes = array(
	'module',
	'module-' . $settings['name'],
);

if ( $settings['class'] ) :
	$module_classes[] = $settings['class'];
endif;

if ( $settings['spacing_top'] ) :
	$module_classes[] = 'spacing-top-' . $settings['spacing_top'];
endif;

if ( $settings['spacing_bottom'] ) :
	$module_classes[] = 'spacing-bottom-' . $settings['spacing_bottom'];
endif;

if ( $settings['id'] ) :
	$module_classes[] = 'scroll-active';
endif;

$module_classes[] = 'scroll-active';
$module_classes[] = 'anchor';

$container_classes = array(
	'container-fluid',
);

if ( $settings['container_class'] ) :
	$container_classes[] = $settings['container_class'];
endif;
?>
<div <?php the_css_class( $module_classes ); ?>>
	<?php if ( $settings['fluid'] ) : ?>    
	<div <?php the_css_class( $container_classes ); ?>>
	<?php endif; ?>
	<?php if ( 'custom' === $settings['spacing_top'] ) : ?>
	<div class="hidden-xs hidden-sm" style="padding-top: <?php echo $settings['spacing_top_desktop']; ?>px"></div>
	<div class="hidden visible-sm visible-xs" style="padding-top: <?php echo $settings['spacing_top_mobile']; ?>px"></div>
	<?php endif; ?>
	<?php echo $settings['html']; ?>
	<?php if ( 'custom' === $settings['spacing_top'] ) : ?>
	<div class="hidden-xs hidden-sm" style="padding-top: <?php echo $settings['spacing_bottom_desktop']; ?>px"></div>
	<div class="hidden visible-sm visible-xs" style="padding-top: <?php echo $settings['spacing_bottom_mobile']; ?>px"></div>
	<?php endif; ?>
	<?php if ( $args['fluid'] ) : ?>    
	</div>
	<?php endif; ?>
</div>
