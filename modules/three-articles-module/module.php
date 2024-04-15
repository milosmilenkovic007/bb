<?php
// three-articles-module.php

function generate_three_articles_module($config) {
    $config_defaults = array(
        'articles' => array(),
    );

    $config = wp_parse_args($config, $config_defaults);

    if (!empty($config['articles'])) :
        ?>
        <div class="three-articles-grid">
            <?php
            foreach ($config['articles'] as $article) :
                // Get the team ID for the current article using ACF field 'team'
                $team_id = get_field('team', $article->ID);

                // Get the custom excerpt
                $excerpt = get_field('article_excerpt', $article->ID);
                ?>
                <div class="three-article" data-team-id="<?php echo esc_attr($team_id); ?>">
                    <a href="<?php echo esc_url(get_permalink($article->ID)); ?>" class="three-article-link">
                        <div class="three-article-image">
                            <?php echo get_the_post_thumbnail($article->ID, 'medium'); ?>
                        </div>
                        <div class="three-article-content">
                            <h3 class="three-article-title"><?php echo esc_html(get_the_title($article->ID)); ?></h3>
                            <div class="three-article-excerpt">
                                <?php echo wp_trim_words($excerpt, 20); ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    else :
        echo 'No articles selected.';
    endif;
}
?>
