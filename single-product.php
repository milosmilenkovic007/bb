<?php
/**
 * Template Name: Custom Product Template
 * Template Post Type: product
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                    <p><strong>Price:</strong> <?php echo get_field('product_price'); ?></p>
                    <?php
                    $product_title = get_field('product_title');
                    if (!empty($product_title)) {
                        echo '<p><strong>Product Title:</strong> ' . $product_title . '</p>';
                    }
                    ?>
                    <!-- Payment method selector -->
                    <form id="payment-method-form">
                        <label for="payment-method">Select Payment Method:</label>
                        <select name="payment-method" id="payment-method">
                            <option value="swish">Swish</option>
                            <option value="stripe">Stripe</option>
                        </select>
                    </form>
                    <!-- Stripe Checkout button -->
                    <button id="stripe-checkout-button" class="button button-secondary">Proceed to Checkout</button>
                </div>
            </article>
        <?php
        endwhile;
        ?>
    </main>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/custom-product.min.js"></script> 

<?php
get_footer();
?>
