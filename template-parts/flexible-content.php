<?php
// flexible-content.php

// Check if flexible content rows exist on the current page
if (have_rows('modules')) {
    // Loop through each flexible content row
    while (have_rows('modules')) {
        the_row();

        // Check if the current row contains the "post_list_module" module
        if (get_row_layout() === 'post_list_module') {
            // Include the post-list-module.php template part
            get_template_part('template-parts/modules/post-list-module');

            break; // Exit the loop after the first occurrence of the "post_list_module"
        }
    }
}


