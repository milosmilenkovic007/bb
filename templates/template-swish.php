<?php
/**
 * Template Name: Swish Page
 *
 * This is a custom template for the swish page.
 *
 * @link https://bollsvenskan.dk
 *
 * @package Bollsvenskan
 */

?>

<div class="qr-page-container">
<?php echo do_shortcode('[swish_qr product_id="470"]'); ?>
</div>

<style>
.qr-page-container {
    margin-top:10%;
    width: 25%;
    margin-left: auto;
    margin-right: auto;
}

.btn-primary {
    background-color: #00427f;
    color: #ffffff;
    padding: 10px 50px;
    border: none;
    box-shadow: none;
    cursor: pointer;
}

#customer_number {
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 17px;
    padding: 10px 70px 10px 15px;
    
}

.qr-image {
    margin:0;
    border-radius: 50px;
    box-shadow: 0 4px 4px 0 rgba(0,0,0,.251);
}

.qr-card {
    padding: 20px;
    border-radius: 60px;
    background: linear-gradient(180deg, #4fc426, #689958);
    box-shadow: 0 4px 4px 0 rgba(0,0,0,.251);
}

.customer-number {
    color: #ffffff;
    text-align: center;
    font-size: 28px;
    font-weight: 700;
    text-shadow: 1px 1px rgba(0,0,0,.251);
    margin: 0;
}


.qr-price-amount {
    color: #ffffff;
    text-align: center;
    margin: 0;
    text-shadow: 1px 1px rgba(0,0,0,.251);
}
.webhook-text {
    text-align: center;
}

</style>