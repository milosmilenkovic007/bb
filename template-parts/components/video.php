<?php
/**
 * Video component template
 *
 * @package Webnorth
 * @subpackage LE34
 */

$defaults = array(
	'video_type'           => null,
	'video_url'            => null,
	'video_loop'           => true,
	'video_autoplay'       => true,
	'video_play_on_mobile' => true,
	'image'                => null,
	'image_alt'            => '',
	'image_size'           => 'landscape',
);

$config = wp_parse_args( $args, $defaults );

$video_attributes = array(
	'autoplay',
	'muted',
	'playsinline',
);

if ( $config['video_loop'] ) :
	$video_attributes[] = 'loop';
endif;

?>

<div class="video">
	<?php
	if ( 'youtube' === $config['video_type'] ) :

		$video_classes = array(
			'wrap',
			'embed-video',
		);

		if ( ! $config['video_play_on_mobile'] ) :
			$video_classes[] = 'hidden-xs';
			$video_classes[] = 'hidden-sm';
		endif;
		?>
	<div <?php the_css_class( $video_classes ); ?>>
		<div class="iframe-wrap">
			<iframe data-src="<?php echo esc_url( $config['video_url'] ); ?>" data-autoplay="<?php echo $config['video_autoplay'] ? 'yes' : 'no'; ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			<div class="video-poster">
				<?php
				if ( $config['image'] ) :
					echo wp_get_attachment_image( $config['image']['ID'], '2k' );
				endif;
				?>
			</div>
		</div>
	</div>
	<?php else : ?>
		<?php if ( ! $config['video_play_on_mobile'] && $config['image'] ) : ?>
		<div class="wrap mobile-image hidden visible-sm visible-xs">
			<?php super_img( image: $config['image'], alt: $config['image_alt'], css_class: $config['image_size'] ); ?>
		</div>
		<?php endif; ?>
		<?php
		if ( $config['video_url'] ) :

			$video_classes = array(
				'wrap',
				'auto-video',
			);

			if ( ! $config['video_play_on_mobile'] ) :
				$video_classes[] = 'hidden-xs';
				$video_classes[] = 'hidden-sm';
			endif;
			?>
		<div <?php the_css_class( $video_classes ); ?>>
			<video data-src="<?php echo esc_url( $config['video_url'] ); ?>" data-autoplay="<?php echo $config['video_autoplay'] ? 'yes' : 'no'; ?>" <?php echo join( ' ', $video_attributes ); ?>></video>
			<div class="video-poster">
				<?php
				if ( $config['image'] ) :
					echo wp_get_attachment_image( $config['image']['ID'], '2k' );
				endif;
				?>
			</div>
		</div>
		<?php endif; ?>
	<?php endif; ?>

</div>
