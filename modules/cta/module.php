<?php
/**
 * CTA module.
 *
 * @package Webnorth
 * @subpackage LE34
 */

/**
 * Generates HTML for CTA module.
 *
 * @param  array $config Configuration of the module.
 * @return string HTML of the module
 */
function generate_cta_module($config) {
    $config_defaults = [
        'data'   => [],
        'module' => [],
    ];

    $config = wp_parse_args($config, $config_defaults);

    $data_defaults = [
        'image_position' => 'left',
        'image'          => null,
        'image_alt'      => '',
        'image_size'     => 'landscape',
        'title'          => '',
        'subtitle'       => '',
        'text'           => '',
        'link'           => null,
    ];

    $data = wp_parse_args($config['data'], $data_defaults);

    $first_column_classes = ['col-sm-6'];
    $second_column_classes = ['col-sm-6'];

    if (isset($data['image_position']) && 'right' === $data['image_position']) {
        $first_column_classes[] = 'col-sm-push-6';
        $second_column_classes[] = 'col-sm-pull-6';
    }

    ob_start();
    ?>
    <div class="title-wrap-rotate">
        <h2><?php echo esc_html($data['title']); ?></h2>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-2">
            <div class="row">
                <div <?php the_css_class($first_column_classes); ?>>
                    <?php if (isset($data['image'])) {
                        super_img(['image' => $data['image'], 'css_class' => $data['image_size'], 'alt' => $data['image_alt']]);
                    } ?>
                </div>
                <div <?php the_css_class($second_column_classes); ?>>
                    <?php if (!empty($data['subtitle'])) : ?>
                        <h3><?php echo esc_html($data['subtitle']); ?></h3>
                    <?php endif; ?>
                    <div><?php echo $data['text']; ?></div>
                    <?php if (!empty($data['link'])) : ?>
                        <a class="btn-cta" <?php the_link_href($data['link']); ?> <?php the_link_target($data['link']); ?>><?php the_link_label($data['link']); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    $html = ob_get_clean();

    $args = [
        'name'  => 'cta',
        'html'  => $html,
        'fluid' => true,
    ];

    $args = array_merge($args, $config['module']);

    ob_start();

    // Assume get_template_part accepts 'slug' and 'args' correctly as named parameters
    get_template_part('template-parts/module', ['args' => $args]);

    return ob_get_clean();
}
