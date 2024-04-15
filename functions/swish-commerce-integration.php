<?php
// Swish Commerce Integration

// Create Payment Request
function create_payment_request() {
    $ch = curl_init('https://mss.cpc.getswish.net/swish-cpcapi/api/v1/paymentrequests');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '1');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '1');
    curl_setopt($ch, CURLOPT_CAINFO, get_template_directory() . '/Swish TLS Root CA.pem');
    curl_setopt($ch, CURLOPT_SSLCERT, get_template_directory() . '/Swish Merchant Test Certificate 1231181189.pem');
    curl_setopt($ch, CURLOPT_SSLKEY, get_template_directory() . '/Swish Merchant Test Certificate 1231181189.key');

    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers) {
            // this function is called by curl for each header received
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) {
                // ignore invalid headers
                return $len;
            }

            $name = strtolower(trim($header[0]));
            echo "[". $name . "] => " . $header[1];

            return $len;
        }
    );

    $data = array(
        "payeePaymentReference" => "0123456789",
        "callbackUrl" => "https://example.com/api/swishcb/paymentrequests",
        "payerAlias" => "4671234768",
        "payeeAlias" => "1231181189",
        "amount" => "100",
        "currency" => "SEK",
        "message" => "Kingston USB Flash Drive 8 GB"
    );
    $data_string = json_encode($data);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );

    if(!$response = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
}

// Get Payment Request
function get_payment_request() {
    $ch = curl_init('https://mss.cpc.getswish.net/swish-cpcapi/api/v1/paymentrequests/5EAA11CBE0844071B0DBF81E9F4B0DB7');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '1');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '1');
    curl_setopt($ch, CURLOPT_CAINFO, get_template_directory() . '/Swish TLS Root CA.pem');
    curl_setopt($ch, CURLOPT_SSLCERT, get_template_directory() . '/Swish Merchant Test Certificate 1231181189.pem');
    curl_setopt($ch, CURLOPT_SSLKEY, get_template_directory() . '/Swish Merchant Test Certificate 1231181189.key');

    curl_setopt($ch, CURLOPT_HEADERFUNCTION,
        function($curl, $header) use (&$headers) {
            // this function is called by curl for each header received
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) {
                // ignore invalid headers
                return $len;
            }

            $name = strtolower(trim($header[0]));
            echo "[". $name . "] => " . $header[1];

            return $len;
        }
    );

    if(!$response = curl_exec($ch)) {
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
}

// Execute functions
create_payment_request();
get_payment_request();
