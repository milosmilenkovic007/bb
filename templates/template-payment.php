<?php
/**
 * Template Name: Custom Checkout Template
 * Template Post Type: page
 *
 * This is the template for the custom checkout page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <!-- Stripe Buy Button -->
                <script async src="https://js.stripe.com/v3/buy-button.js"></script>

                <stripe-buy-button
                  buy-button-id="buy_btn_1P08pHK5jB6KWDXlr196MbO0"
                  publishable-key="pk_test_51HaAwtK5jB6KWDXlgteNAsz7yn0xXiA1jluSEF96XKdiDJ7daT32leXRQjyRDhTKqx6R2tANyvbNmcF3u8rK63Y200SXAwp5e0"
                >
                </stripe-buy-button>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>
<style>

#post-473 {
    width:600px;
}
/* Custom CSS for Stripe Card Element */
#card-element {
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 4px;
  padding: 10px;
  margin-bottom: 15px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

/* Error message style */
#card-errors {
  color: #dc3545;
  margin-top: 10px;
  font-size: 14px;
}


</style>
