<?php
// Swish QR 
function swish_qr_shortcode($atts) {
    // Get product ID from shortcode attributes
    $atts = shortcode_atts(array(
        'product_id' => '', 
    ), $atts);

    $product_id = $atts['product_id'];
    // Get the product price
    $product_price = get_field('product_price', $product_id);

    ob_start();
    if (isset($_POST['customer_number'])) {
        $url = "https://mpc.getswish.net/qrg-swish/api/v1/prefilled";
        $customer_number = isset($_POST['customer_number']) ? $_POST['customer_number'] : "";
        $payload = '{
            "format": "png",
            "size": 300,
            "message": {
                "value": "Swish payment"
            },
            "amount": {
                "value": ' . $product_price . ',
                "editable": false
            },
            "payee": {
                "value": "' . $customer_number . '",
                "editable": true
            },
            "payer": {
                "editable": false
            }
        }';
        
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    ?>

        <?php if (!isset($result)) : ?>
                    <form method="post">
                        <div class="form-group">
                            <input name="customer_number" type="text" class="form-control" id="customer_number"
                                placeholder="Customer Number..."
                                value="<?php echo isset($_POST['customer_number']) ? $_POST['customer_number'] : ""; ?>"
                                required>
                        </div>
                        <!-- Hidden input field for product price -->
                        <input type="hidden" name="price" value="<?php echo $product_price; ?>">
                        <button type="submit" class="btn btn-primary">Generate Swish QR Code</button>
                    </form>
        <?php else : ?>
                    <div class="qr-card">
                    <?php echo "<img class='qr-image' src='data:image/png;base64," . base64_encode($result) . "'>"; ?>
                            <h3 class="customer-number"> <?php echo $_POST['customer_number']; ?></h3>
                            <h3 class="qr-price-amount"><?php echo "Amount: " . $product_price . " SEK"; ?></h3>
                            <a href="/" class="back-button">
        <svg fill="#ffffff" height="24px" width="24px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26.676 26.676" xml:space="preserve" stroke="#ffffff">
                    <path d="M26.105,21.891c-0.229,0-0.439-0.131-0.529-0.346l0,0c-0.066-0.156-1.716-3.857-7.885-4.59 c-1.285-0.156-2.824-0.236-4.693-0.25v4.613c0,0.213-0.115,0.406-0.304,0.508c-0.188,0.098-0.413,0.084-0.588-0.033L0.254,13.815 C0.094,13.708,0,13.528,0,13.339c0-0.191,0.094-0.365,0.254-0.477l11.857-7.979c0.175-0.121,0.398-0.129,0.588-0.029 c0.19,0.102,0.303,0.295,0.303,0.502v4.293c2.578,0.336,13.674,2.33,13.674,11.674c0,0.271-0.191,0.508-0.459,0.562 C26.18,21.891,26.141,21.891,26.105,21.891z"></path>
        </svg>
    </a>
            </div>
            <h3 class="webhook-text"> Waiting for webhook response... </h3>
        <?php endif; ?>

    <?php
    return ob_get_clean();
}
add_shortcode('swish_qr', 'swish_qr_shortcode');