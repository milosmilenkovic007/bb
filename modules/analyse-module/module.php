<?php

// Function to check if the current user has access to the full content
function has_full_access_to_content() {
    if (is_user_logged_in()) {
        // Check if the current user is a subscriber or administrator
        if (current_user_can('instant') || current_user_can('administrator')) {
            return true; // User has full access
        }
    }
    return false; // User does not have full access
}

// Function to display post meta information for Analysis CPT
function display_analysis_post_meta($analysis_id) {
    $author_id = get_post_field('post_author', $analysis_id);
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_avatar = get_avatar($author_id);
    $author_email = get_the_author_meta('user_email', $author_id);

    $post_date = get_the_date('Y-m-d', $analysis_id);
    $reading_time = get_post_meta($analysis_id, 'reading_time', true);

    // Output post meta information
    echo '<div class="post-meta">';
    echo '<div class="author-info">';
    echo '<div class="author-avatar">' . $author_avatar .  '</div>';
    echo '<div class="author-details">';
    echo '<div class="author-name">' . $author_name . ' | ' . $post_date . ' | ' . $reading_time . '</div>';
    echo '<div class="author-email">' . $author_email . '</div>';
    echo '</div>'; 
    echo '</div>'; 
    echo '</div>'; 
}

// Function to display related analysis
function display_related_analysis() {
    $current_post_id = get_the_ID();
    $related_analysis = get_field('related_analyse');

    if ($related_analysis) {
        $related_analysis_id = $related_analysis->ID;
        // Display post meta information
        display_analysis_post_meta($related_analysis_id);
        $analyse_excerpt = get_field('analyse_excerpt', $related_analysis_id);
        $analyse_content = get_field('analyse_content', $related_analysis_id);
        $behind_paywall = get_field('behind_paywall', $related_analysis_id);
        $visible_percentage = get_field('visible_percentage', $related_analysis_id);

        // Check if the user has full access to content
        if ($behind_paywall) {
            if (has_full_access_to_content()) {
                // User is logged in with subscriber or administrator role
                // Display full content without the lock
                echo '<div class="related-analysis">';
                echo '<p>' . $analyse_excerpt . '</p>';
                echo '<div>' . $analyse_content . '</div>';
                echo '</div>';
            } else {
                // User is not logged in or doesn't have subscriber/administrator role
                // Display excerpt and visible content percentage
                echo '<div class="related-analysis">';
                echo '<p>' . $analyse_excerpt . '</p>';
                $content_length = strlen($analyse_content);
                $visible_content = substr($analyse_content, 0, ceil($content_length * ($visible_percentage / 100)));
                echo '<div>' . $visible_content . '</div>';
                echo '</div>';
                // Display content with lock
                echo '<div class="article-lock">';
                echo '<div class="paywall-lock-buttons">';
                // Retrieve and display buttons

                $button_one = get_field('button_one', 'option');
                $button_two = get_field('button_two', 'option');
                if ($button_one) {
                    foreach ($button_one as $button) {
                        // Get the post ID from the $button object
                        $post_id = $button->ID;
                        echo '<div id ="analyse-button-one">';
                        // Generate shortcode for custom_product with the post ID
                        echo do_shortcode('[custom_product id="' . $post_id . '"]');
                        echo '</div>';
                    }
                }
                
                if ($button_two) {
                    foreach ($button_two as $button) {
                        // Get the post ID from the $button object
                        $post_id = $button->ID;
                        echo '<div id ="analyse-button-two">';
                        // Generate shortcode for custom_product with the post ID
                        echo do_shortcode('[custom_product id="' . $post_id . '"]');
                        echo '</div>';
                    }
                }
                
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Display full content without lock and buttons
            echo '<div class="related-analysis">';
            echo '<p>' . $analyse_excerpt . '</p>';
            echo '<div>' . $analyse_content . '</div>';
            echo '</div>';
        }
    }
}

?>
