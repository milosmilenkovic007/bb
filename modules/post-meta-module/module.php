<?php
// Function to display post meta information
function display_post_meta() {
    // Get the post author information
    $author_id = get_the_author_meta('ID');
    $author_name = get_the_author();
    $author_avatar = get_avatar($author_id);
    $author_email = get_the_author_meta('user_email');

    // Get the post date and estimated reading time
    $post_date = get_the_date('Y-m-d');
    $reading_time = get_post_meta(get_the_ID(), 'reading_time', true);

    // Output post meta information
    echo '<div class="post-meta">';
    echo '<div class="author-info">';
    echo '<div class="author-avatar">' . $author_avatar .  '</div>';
    echo '<div class="author-details">';
    echo '<div class="author-name">' . $author_name . ' | ' . $post_date . ' | ' . $reading_time . '</div>';
    echo '<div class="author-email">' . $author_email . '</div>';
    echo '</div>'; // Close author-details
    echo '</div>'; // Close author-info
    echo '</div>'; // Close post-meta
}
?>
