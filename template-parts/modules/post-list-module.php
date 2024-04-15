<?php

// Configuration for the post list module
$config = array(
    'show_latest_posts' => true, // Show latest posts
    'post_selection' => array(), // No specific post selection
    'post_category_filter' => array(), // No category filter
    'tag_filter' => array(), // No tag filter
    'number_of_posts' => 10, // Number of posts to display
    'layout_option' => 'List', // Display posts in list layout
);

// Call the generate_post_list_module function with the provided configuration
generate_post_list_module($config);
?>
