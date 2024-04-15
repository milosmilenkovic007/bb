<?php
// Registration module.php
function custom_register_user() {
    if ( isset( $_POST['user_phone'] ) && isset( $_POST['user_password'] ) ) {
        $phone_number = sanitize_text_field( $_POST['user_phone'] );
        $password = $_POST['user_password'];


        $user = get_user_by( 'login', $phone_number );

        if ( $user ) {
            
            return;
        }

        
        $user_id = wp_create_user( $phone_number, $password );

        if ( is_wp_error( $user_id ) ) {
            
            return;
        }

        update_user_meta( $user_id, 'phone_number', $phone_number );


        $user = get_user_by( 'id', $user_id );
        wp_set_current_user( $user_id, $user->user_login );
        wp_set_auth_cookie( $user_id );

        // Redirect after registration
        $redirect_to = ! empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : home_url();
        wp_redirect( $redirect_to );
        exit;
    }
}
add_action( 'register_post', 'custom_register_user' );




?>