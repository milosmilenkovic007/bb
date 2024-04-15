<?php
// related-articles-module.php

function generate_related_articles_module($args = array()) {
    // Get ACF settings
    $related_articles_settings = get_field('related_articles_settings');

    // Set defaults
    $defaults = array(
        'title' => __('Related Articles', 'text_domain'),
        'posts_per_page' => 3, 
        'post_type' => 'post',
    );

    $args = wp_parse_args($args, $defaults);

    // Modify args based on selected settings
    if ($related_articles_settings) {
        switch ($related_articles_settings) {
            case 'tag':
                $args['tag'] = get_the_tags()[0]->term_id; 
                break;
            case 'category':
                $args['category__in'] = wp_get_post_categories(get_the_ID());
                break;
            case 'custom_taxonomy':
                
                break;
            default:
                break;
        }
    }

    // Query related articles
    $related_articles_query = new WP_Query($args);

    // Check if there are related articles
    if ($related_articles_query->have_posts()) {
        echo '<div class="related-articles-module">';

        while ($related_articles_query->have_posts()) : $related_articles_query->the_post();
            echo '<div class="related-articles-single">';
            
            // Display the featured image
            if (has_post_thumbnail()) {
                echo '<div class="related-articles-image">';
                the_post_thumbnail('thumbnail'); // Adjust the image size as needed
                echo '</div>';
            }

            echo '<div class="related-articles-content">';
            // Display the article title
            echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';

            // Display the excerpt from ACF field, trimmed to 20 words
            $excerpt = wp_trim_words(get_field('article_excerpt'), 20, '...');
            echo '<p class="related-article-excerpt">' . $excerpt . '</p>';
            echo '</div>'; 

            echo '</div>'; 
        endwhile;

        echo '</div>'; 
        wp_reset_postdata();
    } else {
        // If no related articles found, query random posts
        $random_posts_query = new WP_Query(array(
            'posts_per_page' => $args['posts_per_page'],
            'orderby' => 'rand',
            'post_type' => $args['post_type'],
        ));

        if ($random_posts_query->have_posts()) {
            echo '<div class="related-articles-module">';

            while ($random_posts_query->have_posts()) : $random_posts_query->the_post();
                echo '<div class="related-articles-single">';
                
                // Display the featured image
                if (has_post_thumbnail()) {
                    echo '<div class="related-articles-image">';
                    the_post_thumbnail('thumbnail'); // Adjust the image size as needed
                    echo '</div>';
                }

                echo '<div class="related-articles-content">';
                // Display the article title
                echo '<h3 class="related-article-title">'; 
                echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
                echo '</h3>';

                // Display the excerpt from ACF field, trimmed to 20 words
                $excerpt = wp_trim_words(get_field('article_excerpt'), 20, '...');
                echo '<p class="related-article-excerpt">' . $excerpt . '</p>';
                echo '</div>'; 

                echo '</div>'; 
            endwhile;

            echo '</div>'; 
            wp_reset_postdata();
        } else {
            echo 'No related articles found.';
        }
    }
}

?>
