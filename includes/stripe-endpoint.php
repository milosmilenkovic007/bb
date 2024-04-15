<?php
// Include WordPress environment
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

// Adjust the path to include the Stripe PHP library
require_once get_template_directory() . '/functions/vendor/stripe/stripe-php/init.php';

// Stripe webhook key for martin.milos.live
// $stripe_webhook_secret = 'whsec_y1G9Gwj9MKGJbdIEvBwEOS3N8ACZYQBi'; 

// Stripe webhook key for localhost/livelink
$stripe_webhook_secret = 'whsec_y1G9Gwj9MKGJbdIEvBwEOS3N8ACZYQBi'; 

// Register REST API endpoint
add_action('rest_api_init', 'register_stripe_endpoint');

function register_stripe_endpoint() {
    register_rest_route('stripe-handler/v1', '/process-payment', array(
        'methods' => 'POST',
        'callback' => 'process_stripe_payment',
    ));
}

function process_stripe_payment($request) {
    global $stripe_webhook_secret;

    // Verify the webhook signature
    $payload = $request->get_body();
    $sig_header = $request->get_header('stripe-signature');

    // Debugging: Output values for inspection
    error_log('Payload: ' . $payload);
    error_log('Signature Header: ' . $sig_header);

    try {
        // Verify the webhook signature using the Stripe PHP library
        $event = \Stripe\Webhook::constructEvent(
            $payload, $sig_header, $stripe_webhook_secret
        );
    } catch(\UnexpectedValueException $e) {
        // Debugging: Output error message
        error_log('UnexpectedValueException: ' . $e->getMessage());
        // Invalid payload
        return new WP_REST_Response('Invalid payload', 400);
    } catch(\Stripe\Exception\SignatureVerificationException $e) {
        // Debugging: Output error message
        error_log('SignatureVerificationException: ' . $e->getMessage());
        // Invalid signature
        return new WP_REST_Response('Invalid signature', 401);
    }

    // Handle the Stripe event
    if ($event->type == 'payment_intent.succeeded') {
        // Extract data from the event
        $paymentIntent = $event->data->object;

        // Process the payment logic here
        // Example: Update order status, send confirmation email, etc.

        // Return a success response
        return new WP_REST_Response('Payment processed successfully', 200);
    } elseif ($event->type == 'checkout.session.completed') {
        // Extract data from the event
        $session = $event->data->object;

        // Extract user email from the session
        $customer_email = $session->customer_email;

        // Generate username from email (you can adjust this as needed)
        $username = explode('@', $customer_email)[0];

        // Generate a random password
        $password = wp_generate_password();

        // Register the user in WordPress
        $user_id = wp_create_user($username, $password, $customer_email);

        if (!is_wp_error($user_id)) {
            // User registration successful
            // Optionally, log the user in or send a confirmation email
            return new WP_REST_Response('User registration successful', 200);
        } else {
            // User registration failed
            // Log or handle the error
            return new WP_REST_Response('User registration failed', 500);
        }
    }

    // Return a response for unsupported events
    return new WP_REST_Response('Event not supported', 200);
}
