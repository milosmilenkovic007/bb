<?php

// Initialize ACF
add_action('acf/init', 'my_acf_init');
function my_acf_init() {
}

// Function to display related article
function display_related_article() {
    // Check if ACF function exists before using it
    if (function_exists('get_field')) {
        $article_excerpt = get_field('article_excerpt');
        $article_content = get_field('article_content');
        $behind_paywall = get_field('behind_paywall');
        $visible_percentage = get_field('visible_percentage');
        $button_one = get_field('button_one', 'option');
        $button_two = get_field('button_two', 'option');
    } else {
        // ACF is not available, handle accordingly
        return;
    }

    // Check if article excerpt and content are not empty
    if (!empty($article_excerpt) && !empty($article_content)) {
        // Check if behind paywall is false, then display full content without lock or buttons
        if (!$behind_paywall) {
            echo '<div class="single-article">';
            echo '<p>' . $article_excerpt . '</p>';
            echo '<div>' . $article_content . '</div>';
            echo '</div>';
        } else {
            // Check if the user has full access to content
            if (has_full_access_to_content()) {
                // User is logged in with subscriber or administrator role
                // Display full content without the lock
                echo '<div class="single-article">';
                echo '<p>' . $article_excerpt . '</p>';
                echo '<div>' . $article_content . '</div>';
                echo '</div>';
            } else {
                // User is not logged in or doesn't have subscriber/administrator role
                // Display excerpt and visible content percentage
                echo '<div class="single-article">';
                echo '<p>' . $article_excerpt . '</p>';
                $content_length = strlen($article_content);
                $visible_content = substr($article_content, 0, ceil($content_length * ($visible_percentage / 100)));
                echo '<div>' . $visible_content . '</div>';
                echo '</div>';
                // Display content with lock
                echo '<div class="article-lock">';
                echo '<div class="paywall-lock-buttons">';
                // Retrieve and display buttons
                if (is_array($button_one)) {
                    foreach ($button_one as $button) {
                        // Get the post ID of the selected post
                        $post_id = $button->ID;
                        echo '<div id ="article-button-one">';
                        // Generate shortcode for custom_product with the post ID
                        echo do_shortcode('[custom_product id="' . $post_id . '"]');
                        echo '</div>';
                    }
                }

                if (is_array($button_two)) {
                    foreach ($button_two as $button) {
                        // Get the post ID of the selected post
                        $post_id = $button->ID;
                        echo '<div id ="article-button-two">';
                        // Generate shortcode for custom_product with the post ID
                        echo do_shortcode('[custom_product id="' . $post_id . '"]');
                        echo '</div>';
                    }
                }
                echo '</div>';
                echo '</div>';
            }
        }
    }
}

// Display related article module
display_related_article();
?>
