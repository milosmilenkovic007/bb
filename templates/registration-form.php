<?php
/**
 * Template Name: Registration page
 *
 * This is a custom template for the home page.
 *
 * @link https://bollsvenskan.dk
 *
 * @package Bollsvenskan
 */

get_header();

?>

<?php if ( ! is_user_logged_in() ) : ?>
    <form id="registration-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post">
        <label for="user_login"><?php _e( 'Username' ); ?></label>
        <input type="text" name="user_login" id="user_login" />

        <label for="user_password"><?php _e( 'Password' ); ?></label>
        <input type="password" name="user_password" id="user_password" />

        <label for="user_phone"><?php _e( 'Phone Number' ); ?></label>
        <?php
        $phone_number = get_field( 'phone_number' );
        ?>
        <input type="tel" name="user_phone" id="user_phone" value="<?php echo esc_attr( $phone_number ); ?>" />

        <?php do_action( 'register_form' ); ?>
        <input type="submit" value="<?php _e( 'Register' ); ?>" />
        <input type="hidden" name="redirect_to" value="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>" />
        <?php wp_nonce_field( 'register', 'register-nonce' ); ?>
    </form>
<?php endif; ?>



<?php get_footer(); ?>