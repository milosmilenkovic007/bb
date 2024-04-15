<?php
// five-articles-grid.php

function generate_five_articles_module($config) {
    $config_defaults = array(
        'articles' => array(),
    );

    $config = wp_parse_args($config, $config_defaults);

    if (!empty($config['articles'])) :
        ?>
        <div class="five-articles-grid">
            <div class="five-articles-grid-small">
                <?php
                $count = 0;
                $total_articles = count($config['articles']);
                foreach ($config['articles'] as $article) :
                    $count++;

                    // Skip the last article for the left side
                    if ($count === $total_articles) {
                        continue;
                    }

                    // Get the team ID for the current article
                    $team_id = get_field('team', $article->ID);
                    
                    // Get the custom excerpt
                    $excerpt = get_field('article_excerpt', $article->ID);
                ?>
                    <div class="five-articles article-left" data-team-id="<?php echo esc_attr($team_id); ?>">
                        <?php if (has_post_thumbnail($article->ID)) : ?>
                            <a href="<?php echo get_permalink($article->ID); ?>" class="article-link">
                                <div class="five-article-image">
                                    <?php echo get_the_post_thumbnail($article->ID, 'medium'); ?>
                                </div>
                                <div class="five-article-content">
                                    <h3 class="five-article-small-title"><?php echo get_the_title($article->ID); ?></h3>
                                    <div class="five-article-excerpt">
                                        <?php echo wp_trim_words($excerpt, 20); ?>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($count == 2) : ?>
                        </div>
                        <div class="five-articles-grid-small-right">
                    <?php endif; ?>

                <?php endforeach; ?>
            </div>

            <?php
            // Display the big article on the right (5th article)
            $big_article = end($config['articles']);
            $big_team_id = get_field('team', $big_article->ID);
            
            // Get the custom excerpt for the big article
            $big_excerpt = get_field('article_excerpt', $big_article->ID);
            ?>
            <div class="five-articles article-big" data-team-id="<?php echo esc_attr($big_team_id); ?>">
                <?php if (has_post_thumbnail($big_article->ID)) : ?>
                    <a href="<?php echo get_permalink($big_article->ID); ?>" class="article-link">
                        <div class="five-article-image-big">
                            <?php echo get_the_post_thumbnail($big_article->ID, 'large'); ?>
                        </div>
                        <div class="five-article-content">
                            <h3 class="five-article-big-title"><?php echo get_the_title($big_article->ID); ?></h3>
                            <div class="five-article-excerpt">
                                <?php echo wp_trim_words($big_excerpt, 100); ?>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php else :
        echo 'No articles selected.';
    endif;
}
?>
