<?php

function enqueue_styles_scripts() {
    $theme_version = wp_get_theme()->get('Version');

    // Enqueue main styles
    wp_enqueue_style('styles', get_template_directory_uri() . '/assets/css/styles.css', array(), $theme_version, 'all');

    // Enqueue home page styles
    wp_enqueue_style('home-page-styles', get_template_directory_uri() . '/assets/css/home-page.css', array(), $theme_version, 'all');

    // Enqueue main script
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), $theme_version, true);

    // Localize script for AJAX
    wp_localize_script('main', 'MyAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

    // Enqueue Stripe.js
    wp_enqueue_script('stripe-js', 'https://js.stripe.com/v3/', array(), null, true);

    // Check if the paywall-lock-buttons class is present on the page
    if (is_page() && has_shortcode(get_post()->post_content, 'paywall-lock-buttons')) {
        // Enqueue custom JavaScript for Stripe payment functionality
        wp_enqueue_script('custom-product-script', get_template_directory_uri() . '/assets/js/custom-product.min.js', array('jquery', 'stripe-js'), null, true);

        // Localize the script with admin-ajax.php URL
        wp_localize_script('custom-product-script', 'customProductData', array(
            'adminAjaxUrl' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_styles_scripts');


// Lightbox

function enqueue_lightbox_scripts() {
    // Enqueue Magnific Popup script
    wp_enqueue_script('magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);
    // Enqueue your custom lightbox script
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/src/js/lightbox.js', array('jquery'), null, true);

    // Localize the custom script with the desired PHP data
    wp_localize_script('custom-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'ajax_nonce' => wp_create_nonce('ajax_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_scripts');

// Hide WP Adminbar
function hide_admin_bar() {
    if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
        show_admin_bar( false );
    }
}
add_action( 'after_setup_theme', 'hide_admin_bar' );


// Woo support
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


// Swish QR code

function generate_swish_qr_code_callback() {
    try {
        // Check if the request is coming from a valid source
        check_ajax_referer('generate_swish_qr_code_nonce', 'security');

        // Get the product ID from the Ajax request
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : '';

        if (empty($product_id)) {
            throw new Exception('Product ID is missing.');
        }

        // Dump important variables for debugging
        var_dump($product_id); // Check the product ID

        // Your Swish token and other necessary parameters
        $token = "umP7Eg2HT_OUId8Mc0FHPCxhX3Hkh4qI"; // Replace with your Swish token
        $format = "png"; // You can change the format if needed

        // Include Swish QR code module file
        require_once get_template_directory() . '/modules/swish-qr-code-module/module.php';

        // Call the Swish QR code generation function
        $swishQrCode = SwishQRCodeModule::generateMCommerceQRCode($token, $format);

        if (!$swishQrCode) {
            throw new Exception('Failed to generate Swish QR code.');
        }

        // Return the generated QR code
        echo $swishQrCode;

    } catch (Exception $e) {
        // Handle the exception - log error, display error message, etc.
        error_log('Error generating Swish QR code: ' . $e->getMessage());
        echo 'Error generating Swish QR code: ' . $e->getMessage();
    }

    // Always use die() or wp_die() at the end of Ajax callbacks
    wp_die();
}

// Render Swish QR shortcode
add_action('wp_ajax_render_swish_qr_shortcode', 'render_swish_qr_shortcode');
add_action('wp_ajax_nopriv_render_swish_qr_shortcode', 'render_swish_qr_shortcode');

function render_swish_qr_shortcode() {
    // Verify nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'ajax_nonce')) {
        wp_die('Permission denied.');
    }

    // Get the product ID from the AJAX request
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

    // Construct the shortcode with double quotes
    $shortcode = "[swish_qr]";

    // Render the shortcode
    $shortcode_content = do_shortcode($shortcode);

    // Return the rendered content
    echo $shortcode_content;

    // Always exit to avoid extra output
    wp_die();
}

