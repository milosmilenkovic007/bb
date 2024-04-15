<?php
/**
 * Template Name: Home Page
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

    <div class="flex-container">
    <div class="article-grid-module">
        <?php
        generate_article_grid_module([
            'articles' => get_field('articles'),
        ]);
        ?>
    </div></div></div>

    <div class="most-read-block">
        <?php
        generate_most_read_module([
        ]);
        ?>
    
</div>
</div>
</div>
</div>

<div class="flex-containe-ads">
<div class="inline-ad">
    <?php
    // Retrieve the inline page ads from the options page
    $inline_page_ads = get_field('inline_page_ad', 'option');

    // Check if the inline page ads exist and is not empty
    if ($inline_page_ads) :
        // Loop through each inline page ad
        foreach ($inline_page_ads as $ad) :
            // Retrieve the banner image and custom ad URL
            $banner_image = $ad['inline_page_banner_image'];
            $custom_ad_url = $ad['inline_page_custom_ad_url'];

            // Check if the banner image exists
            if ($banner_image) :
    ?>
                <a href="<?php echo esc_url($custom_ad_url); ?>" target="_blank">
                    <img class="inline-page-banner" src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>" />
                </a>
    <?php
            endif;
        endforeach;
    endif;
    ?>
</div>
</div>

<div class="flex-container-one">
    <div class="three-articles-module">
        <?php
        generate_three_articles_module([
            'articles' => get_field('three_articles'),
        ]);
        ?>
    </div>

    <div class="upcoming-block">
        <?php
        generate_upcoming_posts_module([
        ]);
        ?>
    </div>
</div>

<div class="separator">
    <?php
    generate_separator_module([
        'separator' => get_field('separator_type'),
    ]);
    ?>
</div>

<div class="five-articles-module">
    <?php
    generate_five_articles_module([
        'articles' => get_field('five_articles'),
    ]);
    ?>
</div>

<div class="separator">
    <?php
    generate_separator_module([
        'separator' => get_field('separator_type'),
    ]);
    ?>
</div>

<div class="inline-ad">
    <?php
    // Retrieve the inline page ads from the options page
    $inline_page_ads = get_field('inline_page_ad', 'option');

    // Check if the inline page ads exist and is not empty
    if ($inline_page_ads) :
        // Loop through each inline page ad
        foreach ($inline_page_ads as $ad) :
            // Retrieve the banner image and custom ad URL
            $banner_image = $ad['inline_page_banner_image'];
            $custom_ad_url = $ad['inline_page_custom_ad_url'];

            // Check if the banner image exists
            if ($banner_image) :
    ?>
                <a href="<?php echo esc_url($custom_ad_url); ?>" target="_blank">
                    <img class="inline-page-banner" src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>" />
                </a>
    <?php
            endif;
        endforeach;
    endif;
    ?>
</div>

<div class="four-articles-module">
    <?php
    generate_four_articles_module([
        'articles' => get_field('four_articles'),
    ]);
    ?>
</div>

<div class="separator">
    <?php
    generate_separator_module([
        'separator' => get_field('separator_type'),
    ]);
    ?>
</div>

<div class="five-articles-module">
    <?php
    generate_five_articles_module([
        'articles' => get_field('five_articles'),
    ]);
    ?>
</div>

<div class="separator">
    <?php
    generate_separator_module([
        'separator' => get_field('separator_type'),
    ]);
    ?>
</div>

<div class="four-articles-module">
    <?php
    generate_four_articles_module([
        'articles' => get_field('four_articles'),
    ]);
    ?>
</div>

<?php get_footer(); ?>
