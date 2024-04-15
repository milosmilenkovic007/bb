<?php
//modules/post-list-module/module.php

/**
 * Function to generate Post List Module content.
 *
 * @param array $config Configuration array for the module.
 * @return void
 */
function generate_post_list_module($config) {
    // Fetching values from the provided config array
    $show_latest_posts = $config['show_latest_posts'] ?? false;
    $post_selection = $config['post_selection'] ?? array();
    $post_category_filter = $config['post_category_filter'] ?? '';
    $tag_filter = $config['tag_filter'] ?? array();
    $number_of_posts = $config['number_of_posts'] ?? 4;
    $layout_option = $config['layout_option'] ?? 'List';

    // Fetch posts based on configuration
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $number_of_posts,
        'orderby' => $show_latest_posts ? 'date' : 'rand', 
        'post__in' => $post_selection, 
        'category__in' => $post_category_filter, 
        'tag__in' => $tag_filter, 
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) :
?>
        <div class="post-list-module">
            <?php if ($layout_option === 'List') : ?>
                <ul class="post-list">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <li class="post-item">
                            <a href="<?php the_permalink(); ?>" class="post-link">
                                <h2 class="post-title"><?php the_title(); ?></h2>
                                <div class="post-excerpt"><?php the_excerpt(); ?></div>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php elseif ($layout_option === 'Grid') : ?>
                <div class="post-grid">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="post-item">
                            <a href="<?php the_permalink(); ?>" class="post-link">
                                <div class="post-thumbnail"><?php the_post_thumbnail(); ?></div>
                                <h2 class="post-title"><?php the_title(); ?></h2>
                                <div class="post-excerpt"><?php the_excerpt(); ?></div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
<?php
        wp_reset_postdata();
    else :
        echo 'No posts found.';
    endif;
}
