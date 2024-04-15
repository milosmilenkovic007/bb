<?php
/**
 * Template Name: Single Article
 *
 * This is a custom template for the Single Articles.
 *
 * @link https://bollsvenskan.dk
 *
 * @package Bollsvenskan
 */

get_header();

// Get the header ad code from the Advertisement ACF module
$header_ads = get_field('article_header_ad', 'option');

?>

<div class="single-article-page">
    <div class="single-header-section">
        <div class="single-header-column">
            <div class="single-article-ad">
                <?php
                if ($header_ads && is_array($header_ads)) {
                    foreach ($header_ads as $ad) :
                        if ($ad['article_banner_image']) :
                ?>
                            <a href="<?php echo esc_url($ad['article_custom_ad_url']); ?>" target="_blank">
                                <img class="article-ad-banner" src="<?php echo esc_url($ad['article_banner_image']['url']); ?>" alt="<?php echo esc_attr($ad['article_banner_image']['alt']); ?>">
                            </a>
                        <?php else : ?>
                            <div class="ad-txt">
                                <?php echo $ad['article_header_ad_code']; ?>
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

    <div id="primary" class="content-area">
        <main id="content" class="site-content">
            <div class="single-article-content">
                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="entry-content">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                                <p class="single-excerpt"><?php the_field('article_excerpt'); ?></p>
                                <div class="post-meta-module">
    <?php display_post_meta(); ?>
</div>
                                <p class="single-content"> <?php display_related_article(); ?></p>
                            </div>

                            <div class="article-analyse">
                                <?php display_related_analysis(); ?>
                            </div>
                        </header>
                    </article>

                <?php endwhile; ?>
        
        
<?php generate_related_articles_module(); ?>
        </main>


        <aside id="secondary" class="sidebar">
            <?php if (is_active_sidebar('custom-sidebar')) : ?>
                <?php dynamic_sidebar('custom-sidebar'); ?>
            <?php endif; ?>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
