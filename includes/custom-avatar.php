<?php

/**
 * Register Menus.
 */

function custom_avatar_filter($avatar, $id_or_email, $size, $default, $alt) {
    // Check if it's a user ID
    if (is_numeric($id_or_email)) {
        $user_id = $id_or_email;
    } elseif (is_object($id_or_email) && isset($id_or_email->user_id)) {
        // Check if it's a WP_User object
        $user_id = $id_or_email->user_id;
    } else {
        // Check if it's an email
        $user = get_user_by('email', $id_or_email);
        if ($user) {
            $user_id = $user->ID;
        }
    }

    // Get custom avatar URL
    $custom_avatar_url = get_the_author_meta('custom_avatar', $user_id);

    // Use custom avatar if available, otherwise use the default
    if ($custom_avatar_url) {
        $avatar = "<img alt='{$alt}' src='{$custom_avatar_url}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
    }

    return $avatar;
}

add_filter('get_avatar', 'custom_avatar_filter', 10, 5);
