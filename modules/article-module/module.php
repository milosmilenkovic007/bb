<?php
// acf-article-grid.php

function generate_article_grid_module($config) {
    $config_defaults = array(
        'articles' => array(),
    );

    $config = wp_parse_args($config, $config_defaults);

    if (!empty($config['articles'])) :
        ?>
        <div class="article-grid">
            <?php
            $first_article = array_shift($config['articles']);
            $first_team_terms = wp_get_post_terms($first_article->ID, 'teams');

            // Add debugging information
            if (!empty($first_team_terms)) {
                $first_team_id = $first_team_terms[0]->term_id;
                echo '<!-- Team ID: ' . esc_html($first_team_id) . ' -->';

                // Ensure that $first_team_id is not empty before using it
                $first_team_class = ($first_team_id) ? 'team-' . esc_attr($first_team_id) : '';
            } else {
                // Default class if no team is assigned
                $first_team_class = 'default-team';
            }
            ?>
            <div class="article article-big <?php echo $first_team_class; ?>">
                <?php if (has_post_thumbnail($first_article->ID)) : ?>
                    <a href="<?php echo get_permalink($first_article->ID); ?>" class="article-link">
                        <div class="article-image-big">
                            <?php echo get_the_post_thumbnail($first_article->ID, 'large'); ?>
                        </div>
                        <div class="article-content">
                            <h3 class="article-big-title"><?php echo get_the_title($first_article->ID); ?></h3>
                            <div class="article-excerpt">
                                <?php echo wp_trim_words(strip_tags(get_field('article_excerpt', $first_article->ID)), 100); ?>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

            <div class="article-grid-small">
                <?php
                $count = 0;
                $total_articles = count($config['articles']);
                foreach ($config['articles'] as $article) :
                    $count++;

                    // Get the team ID for the current article
                    $team_terms = wp_get_post_terms($article->ID, 'teams');
                    $team_id = !empty($team_terms) ? $team_terms[0]->term_id : '';

                    // Apply the correct team class
                    $team_class = ($team_id) ? 'team-' . esc_attr($team_id) : 'default-team';
                    
                    // Determine the trim word count based on whether it's the top or bottom article
                    $trim_words_count = ($count === 1) ? 30 : 20;
                ?>
                    <div class="article <?php echo ($count === 1) ? 'article-top' : 'article-bottom'; ?> <?php echo $team_class; ?>">
                        <?php if (has_post_thumbnail($article->ID)) : ?>
                            <a href="<?php echo get_permalink($article->ID); ?>" class="article-link">
                                <div class="article-image">
                                    <?php echo get_the_post_thumbnail($article->ID, 'medium'); ?>
                                </div>
                                <div class="article-content">
                                    <h3 class="article-small-title"><?php echo get_the_title($article->ID); ?></h3>
                                    <div class="article-excerpt">
                                        <?php echo wp_trim_words(strip_tags(get_field('article_excerpt', $article->ID)), $trim_words_count); ?>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php if ($count === 1 && $total_articles > 2) : ?>
                        <div class="article-grid-bottom">
                    <?php endif; ?>

                <?php endforeach; ?>

                <?php if ($total_articles > 2) : ?>
                    </div>
                <?php endif; ?>

        <?php
    else :
        echo 'No articles selected.';
    endif;
}
?>
