<?php
// Custom product
function custom_product_shortcode($atts) {
    
    $atts = shortcode_atts(array(
        'id' => '', 
    ), $atts);

    
    $product_id = $atts['id'];
    $post = get_post($product_id);

    
    if (!$post) {
        return 'Custom product not found.';
    }

    
    setup_postdata($post);

    ob_start(); 
    ?>
    <div class="paywall-button-container" data-product-id="<?php echo $product_id; ?>">
    <?php
    // Get the current article ID
    $current_article_id = get_the_ID();
 //Test
    echo '<p class="hidden">Current Article ID: ' . $current_article_id . '</p>';

    $product_title = get_field('product_title', $product_id);
    if (!empty($product_title)) {
        echo '<p class="custom-product-title"></strong> ' . $product_title . '</p>';
    }

    
    $product_mode = get_field('product_mode', $product_id); 
    
    ?>
    <p class="custom-product-price"><?php echo get_field('product_price', $product_id) . ' SEK'; ?></p>
    <p class="custom-product-description"> <?php the_content(); ?></p>
    <form class="payment-method-form">
        <select name="payment-method" class="payment-method" required>
            <option value="" disabled selected>Select Payment Method</option>
            <option value="swish">&#128176; Swish</option>
            <option value="stripe">&#x1F4B3; Credit Card</option>
        </select>
    </form>
    
    <div class="checkout-buttons">
        <?php if ($product_mode === 'subscription') : ?>
            <button class="stripe-checkout-button" data-price-id="<?php echo get_field('product_price_id', $product_id); ?>" data-mode="subscription" class="button button-secondary">Subscribe</button>
        <?php else : ?>
            <button class="stripe-checkout-button" data-price-id="<?php echo get_field('product_price_id', $product_id); ?>" class="button button-secondary">Instant Access</button>
        <?php endif; ?>
        <button class="swish-qr-button" data-product-id="<?php echo $product_id; ?>" class="button button-secondary">Proceed with payment</button>
    </div>

</div>

<script>
    jQuery(document).ready(function($) {
        // Hide all checkout buttons initially
        $('.checkout-buttons button').hide();

        // Event listener for payment method change in article-button-one container
        $('#article-button-one .payment-method').change(function() {
            var selectedPaymentMethod = $(this).val();

            // Hide all buttons first
            $('#article-button-one .checkout-buttons button').hide();

            // Show checkout button based on selected payment method
            if (selectedPaymentMethod === 'swish') {
                $('#article-button-one .swish-qr-button').show();
            } else if (selectedPaymentMethod === 'stripe') {
                $('#article-button-one .stripe-checkout-button').show();
            }
        });

        // Event listener for payment method change in article-button-two container
        $('#article-button-two .payment-method').change(function() {
            var selectedPaymentMethod = $(this).val();

            // Hide all buttons first
            $('#article-button-two .checkout-buttons button').hide();

            // Show checkout button based on selected payment method
            if (selectedPaymentMethod === 'swish') {
                $('#article-button-two .swish-qr-button').show();
            } else if (selectedPaymentMethod === 'stripe') {
                $('#article-button-two .stripe-checkout-button').show();
            }
        });

        // Event listener for payment method change in analyse-button-one container
        $('#analyse-button-one .payment-method').change(function() {
            var selectedPaymentMethod = $(this).val();

            // Hide all buttons first
            $('#analyse-button-one .checkout-buttons button').hide();

            // Show checkout button based on selected payment method
            if (selectedPaymentMethod === 'swish') {
                $('#analyse-button-one .swish-qr-button').show();
            } else if (selectedPaymentMethod === 'stripe') {
                $('#analyse-button-one .stripe-checkout-button').show();
            }
        });

        // Event listener for payment method change in analyse-button-two container
        $('#analyse-button-two .payment-method').change(function() {
            var selectedPaymentMethod = $(this).val();

            // Hide all buttons first
            $('#analyse-button-two .checkout-buttons button').hide();

            // Show checkout button based on selected payment method
            if (selectedPaymentMethod === 'swish') {
                $('#analyse-button-two .swish-qr-button').show();
            } else if (selectedPaymentMethod === 'stripe') {
                $('#analyse-button-two .stripe-checkout-button').show();
            }
        });
    });
</script>


<style>
    .checkout-buttons button {
        display: none;
    }
</style>


    
    <?php
    $content = ob_get_clean(); 
    wp_reset_postdata(); 
    return $content;
}

add_shortcode('custom_product', 'custom_product_shortcode');

