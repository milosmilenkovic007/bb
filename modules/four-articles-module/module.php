<?php
// four-articles-module.php

function generate_four_articles_module($config) {
    $config_defaults = array(
        'articles' => array(),
    );

    $config = wp_parse_args($config, $config_defaults);

    if (!empty($config['articles'])) :
        ?>
        <div class="four-articles-grid">
            <?php
            foreach ($config['articles'] as $article) :
                // Get the team ID for the current article using custom taxonomy 'teams'
                $team_terms = wp_get_post_terms($article->ID, 'teams');

                // Check if team ID is available, use the first one if multiple are assigned
                $team_id = !empty($team_terms) ? $team_terms[0]->term_id : 'default';

                // Get the custom excerpt
                $excerpt = get_field('article_excerpt', $article->ID);
                ?>
                <div class="four-article team-<?php echo esc_attr($team_id); ?>" data-team-id="<?php echo esc_attr($team_id); ?>">
                    <a href="<?php echo esc_url(get_permalink($article->ID)); ?>" class="four-article-link">
                        <div class="four-article-image">
                            <?php echo get_the_post_thumbnail($article->ID, 'medium'); ?>
                        </div>
                        <div class="four-article-content">
                            <h3 class="four-article-title"><?php echo esc_html(get_the_title($article->ID)); ?></h3>
                            <div class="four-article-excerpt">
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
