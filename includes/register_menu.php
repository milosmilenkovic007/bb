<?php

/**
 * Register Menus.
 */
add_action( 'after_setup_theme', function(){
    register_nav_menus( [
        'primary_menu'  => 'Primary Menu',
    ] );
} );

// Footer menu

function acf_load_menu_field_choices($field) {
    $menus = get_terms('nav_menu', array('hide_empty' => false));

    if ($menus) {
        foreach ($menus as $menu) {
            $field['choices'][$menu->term_id] = $menu->name;
        }
    }

    return $field;
}

add_filter('acf/load_field/name=footer_menu', 'acf_load_menu_field_choices');