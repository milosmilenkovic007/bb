<?php

// Add Instant user role
function add_instant_role() {
    add_role(
        'instant',
        __( 'Instant', 'bollsvenskan' ),
        array(
            // Define capabilities for the role
            'read'         => true,  
            'edit_posts'   => true,  
            'delete_posts' => true,  
        
        )
    );
}
add_action( 'init', 'add_instant_role' );

?>