<?php
/**
 * Super Image component template
 *
 * @package Webnorth
 * @subpackage LE34
 */

$defaults = array(
	'video'      => null,
	'image'      => null,
	'image_size' => '2k',
	'alt'        => '',
	'class'      => '',
);

$config = wp_parse_args( $args, $defaults );

$classes = array(
	'super-img',
);

if ( $config['class'] ) :
	$classes[] = $config['class'];
endif;

?>
<div <?php the_css_class( $classes ); ?> >
	<?php
	if ( $config['image'] ) :
		$image_attr = array();
		if ( $config['alt'] ) :
			$image_attr['alt'] = $config['alt'];
		else :
			$image_attr['alt'] = $config['image']['alt'];
		endif;
		echo wp_get_attachment_image( attachment_id: $args['image']['ID'], size: $config['image_size'], attr: $image_attr );
	endif;
	?>

	<?php if ( $config['video'] ) : ?>
	<video loop autoplay webkit-playsinline playsinline muted src="<?php echo esc_url( $config['video']['url'] ); ?>" ></video>
	<?php endif; ?>
</div>
