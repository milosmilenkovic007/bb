<?php
/**
 * Template Name: Blog Page
 *
 * This is a custom template for the home page.
 *
 * @link https://bollsvenskan.dk
 *
 * @package Bollsvenskan
 */

get_header();

// Get the header ad code from the Advertisement ACF module
$header_ad_code = get_field('header_ad_code', 'option');
$header_poll_code = get_field('header_poll_code', 'option');
?>

<div class="home-page">
    <div class="header-section">
        <div class="header-column">
        <div class="header-ad">
    <?php
    // Retrieve the header ads from the options page
    $header_ads = get_field('header_ad', 'option');
    if ($header_ads && is_array($header_ads)) {
        // Loop through each header ad
        foreach ($header_ads as $ad) :
            // Check if the banner image exists
            if ($ad['banner_image']) :
    ?>
                <a href="<?php echo esc_url($ad['custom_ad_url']); ?>" target="_blank">
                    <img class="ad-banner" src="<?php echo esc_url($ad['banner_image']['url']); ?>" alt="<?php echo esc_attr($ad['banner_image']['alt']); ?>">
                </a>
            <?php else : ?>
                <!-- Display the header ad code if the banner image doesn't exist -->
                <div class="ad-txt">
                    <?php echo $ad['header_ad_code']; ?>
                </div>
            <?php endif; ?>
    <?php
        endforeach;
    }
    ?>
</div>
</div>
        <div class="poll-column">
            <div class="header-poll">
            <?php 
        echo do_shortcode('[poll id="2" type="result"]');
        ?>
            </div>
        </div>
    </div>

    <div class="author-container"> 
    </div>

    <div class="blog-articles-module"> 
    </div>
