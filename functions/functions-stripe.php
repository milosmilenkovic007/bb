<?php
// functions-stripe.php

define('STRIPE_PAYMENT_MODE_PAYMENT', 'payment');
define('STRIPE_PAYMENT_MODE_SUBSCRIPTION', 'subscription');
define('STRIPE_SUCCESS_URL_SHOP', get_field('successful_payment_shop', 'option'));
define('STRIPE_CANCEL_URL_SHOP', get_field('payment_fail_page_shop', 'option'));
define('STRIPE_SUCCESS_URL_DONATE', get_field('successful_payment_donate', 'option'));
define('STRIPE_CANCEL_URL_DONATE', get_field('payment_fail_page_donate', 'option'));
define('STRIPE_SUCCESS_URL_SUBSCRIPTION', get_field('successful_payment_subscription', 'option'));
define('STRIPE_CANCEL_URL_SUBSCRIPTION', get_field('payment_fail_page_subscription', 'option'));
define('STRIPE_SHIPPING_ENABLED_PRICE_IDS', [
    'price_1P08pHK5jB6KWDXl4QPelJUE'
]);

add_action('wp_ajax_bm_stripe_payment', 'bollsvenskan_ajax_stripe_payment');
add_action('wp_ajax_nopriv_bm_stripe_payment', 'bollsvenskan_ajax_stripe_payment');
add_action('stripe_payment', 'stripe_payment_check');

function bollsvenskan_ajax_stripe_payment()
{
    $price_id = $_POST['price_id'] ?? false;
    $mode = $_POST['mode'] ?? false;
    $module = $_POST['module'] ?? false;

    if (!$price_id || !$mode || !$module) {
        wp_send_json_error(['message' => 'Invalid input data.']);
    }

    require_once __DIR__ . '/vendor/autoload.php';
    $secret_key = get_field('stripe_secret_key', 'options');

    list($success_url, $cancel_url) = define_success_cancel_urls($module, $mode);

    $stripe = new \Stripe\StripeClient($secret_key);

    try {
        $session = create_stripe_session($stripe, $price_id, $mode, $success_url, $cancel_url);

        if ($session) {
            wp_send_json_success(['message' => 'Ok', 'url' => $session->url]);
        } else {
            wp_send_json_error(['message' => 'Bad request']);
        }
    } catch (\Stripe\Exception\ApiErrorException $e) {
        wp_send_json_error(['message' => $e->getMessage()]);
    }
}

function define_success_cancel_urls($module, $mode)
{
    $success_url = '';
    $cancel_url = '';

    if ($module == 'shop') {
        $success_url = STRIPE_SUCCESS_URL_SHOP;
        $cancel_url = STRIPE_CANCEL_URL_SHOP;
    } else {
        if ($mode == STRIPE_PAYMENT_MODE_PAYMENT) {
            $success_url = STRIPE_SUCCESS_URL_DONATE;
            $cancel_url = STRIPE_CANCEL_URL_DONATE;
        } elseif ($mode == STRIPE_PAYMENT_MODE_SUBSCRIPTION) {
            $success_url = STRIPE_SUCCESS_URL_SUBSCRIPTION;
            $cancel_url = STRIPE_CANCEL_URL_SUBSCRIPTION;
        }
    }

    return [$success_url, $cancel_url];
}

function create_stripe_session($stripe, $price_id, $mode, $success_url, $cancel_url)
{
    // Add console.log statement
    echo '<script>console.log("Creating Stripe Session");</script>';

    if (in_array($price_id, STRIPE_SHIPPING_ENABLED_PRICE_IDS)) {
        return create_session_with_shipping($stripe, $price_id, $mode, $success_url, $cancel_url);
    } else {
        return create_session_without_shipping($stripe, $price_id, $mode, $success_url, $cancel_url);
    }
}

function create_session_with_shipping($stripe, $price_id, $mode, $success_url, $cancel_url)
{
    // Add console.log statement
    echo '<script>console.log("Creating Session with Shipping");</script>';

    $shipping_rates = $stripe->shippingRates->all(['limit' => 3, 'active' => true]);
    $shipping_rate_ids = array_column($shipping_rates->data, 'id');
    $shipping_options = array_map(function ($rate_id) {
        return ['shipping_rate' => $rate_id];
    }, $shipping_rate_ids);

    $address_collection = [
        'allowed_countries' => [
            'AF', 'AX', 'AL', 'DZ', 'AD', 'AO', 'AI', 'AG', 'AR', 'AM', 'AW', 'AU', 'AT', 'AZ',
            'BS', 'BH', 'BD', 'BB', 'BY', 'BE', 'BZ', 'BJ', 'BM', 'BT', 'BO', 'BA', 'BW', 'BV',
            'BR', 'IO', 'VG', 'BN', 'BG', 'BF', 'BI', 'KH', 'CM', 'CA', 'CV', 'BQ', 'KY', 'CF',
            'TD', 'CL', 'CN', 'CO', 'KM', 'CG', 'CD', 'CK', 'CR', 'CI', 'HR', 'CW', 'CY', 'CZ',
            'DK', 'DJ', 'DM', 'DO', 'EC', 'EG', 'SV', 'GQ', 'ER', 'EE', 'SZ', 'ET', 'FK', 'FO',
            'FJ', 'FI', 'FR', 'GF', 'PF', 'TF', 'GA', 'GM', 'GE', 'DE', 'GH', 'GI', 'GR', 'GL',
            'GD', 'GP', 'GU', 'GT', 'GG', 'GN', 'GW', 'GY', 'HT', 'HN', 'HK', 'HU', 'IS', 'IN',
            'ID', 'IQ', 'IE', 'IM', 'IL', 'IT', 'JM', 'JP', 'JE', 'JO', 'KZ', 'KE', 'KI', 'XK',
            'KW', 'KG', 'LA', 'LV', 'LB', 'LS', 'LR', 'LY', 'LI', 'LT', 'LU', 'MO', 'MG', 'MW',
            'MY', 'MV', 'ML', 'MT', 'MQ', 'MR', 'MU', 'YT', 'MX', 'MD', 'MC', 'MN', 'ME', 'MS',
            'MA', 'MZ', 'MM', 'NA', 'NR', 'NP', 'NL', 'NC', 'NZ', 'NI', 'NE', 'NG', 'NU', 'MK',
            'NO', 'OM', 'PK', 'PA', 'PG', 'PY', 'PE', 'PH', 'PN', 'PL', 'PT', 'PR', 'QA', 'RE',
            'RO', 'RU', 'RW', 'WS', 'SM', 'ST', 'SA', 'SN', 'RS', 'SC', 'SL', 'SG', 'SX', 'SK',
            'SI', 'SB', 'SO', 'ZA', 'GS', 'KR', 'SS', 'ES', 'LK', 'BL', 'SH', 'KN', 'LC', 'MF',
            'PM', 'VC', 'SR', 'SJ', 'SE', 'CH', 'TW', 'TJ', 'TZ', 'TH', 'TL', 'TG', 'TK', 'TO',
            'TT', 'TA', 'TN', 'TR', 'TM', 'TC', 'TV', 'UG', 'UA', 'AE', 'GB', 'US', 'UY', 'UZ',
            'VU', 'VA', 'VE', 'VN', 'WF', 'YE', 'ZM', 'ZW'
        ],

    ];

    return $stripe->checkout->sessions->create([
        'line_items' => [['price' => $price_id, 'quantity' => 1]],
        'shipping_options' => $shipping_options,
        'mode' => $mode,
        'success_url' => $success_url . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $cancel_url,
        'payment_method_types' => ['card'],
        'shipping_address_collection' => $address_collection,
    ]);
}

function create_session_without_shipping($stripe, $price_id, $mode, $success_url, $cancel_url)
{
    return $stripe->checkout->sessions->create([
        'line_items' => [['price' => $price_id, 'quantity' => 1]],
        'mode' => $mode,
        'success_url' => $success_url . '?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $cancel_url,
        'payment_method_types' => ['card'],
    ]);
}

function stripe_payment_check()
{
    global $post;
    $session_id = $_GET['session_id'] ?? false;

    if (!$session_id) {
        return false;
    }

    require_once __DIR__ . '/vendor/autoload.php';
    $secret_key = get_field('stripe_secret_key', 'options');
    $stripe = new \Stripe\StripeClient($secret_key);

    try {
        $session = $stripe->checkout->sessions->retrieve($session_id);
        $customer = $session->customer_details;
        $amount = (!empty($session->amount_total)) ? round($session->amount_total / 100, 2) : false;
        $currency = $session->currency ?? null;
        $mode = $session->mode ?? null;
        $donation_amount = (!empty($amount)) ? $amount . $currency : null;

        http_response_code(200);
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }

    if (!empty($customer)) {
        $email = $customer->email;
        $name = explode('@', $email)[0];
        $existing_user = get_user_by('email', $email);

        if ($existing_user) {
            // User already exists, log them in
            wp_set_current_user($existing_user->ID);
            wp_set_auth_cookie($existing_user->ID);
        } else {
            // User doesn't exist, create a new user
            $user_id = wp_create_user($name, wp_generate_password(), $email);

            if (!is_wp_error($user_id)) {
                // User registration successful, log them in
                wp_set_current_user($user_id);
                wp_set_auth_cookie($user_id);
            }
        }
    }
}
