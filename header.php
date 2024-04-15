<?php
/**
 * The header.
 *
 * @link https://bollsvenskan.com
 *
 * @package Bollsvenskan
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php wp_body_open(); ?>

    <!-- Top Header -->
    <div class="top-header" style="background: #00427F;">
        <div class="top-header-container">
            <div class="left-content">
                <?php
                // Display left content from ACF options
                $left_content = get_field('left_content', 'option');
                echo $left_content;
                ?>
            </div>
            <div class="right-content">
                <?php
                // Display login or right content from ACF options
                $right_content = get_field('right_content', 'option');
                echo $right_content;
                ?>
            </div>
            <a href="/login" class="login-button">
                <img class="login-icon" src="/wp-content/themes/bollsvenskan/assets/images/openpadlock.svg" alt="Login">
            </a>
        </div>
    </div>

    <!-- Row with 3 Columns -->
    <div class="next-row">
        <div class="logo-column">
            <?php
            $home_url = esc_url(home_url('/'));
            echo '<a href="' . $home_url . '">';
            $logo = get_field('logo', 'option');
            echo '<img src="' . esc_url($logo) . '" alt="Logo" />';
            echo '</a>';
            ?>
        </div>

        <div class="aktuella-matcher">
            <?php
            echo '<h4 class="small-title">Aktuella Matcher</h4>';
            // Aktuella Matcher
            $matches = get_field('matches', 'option');

            if ($matches) {
                $column1 = array_slice($matches, 0, 3);
                $column2 = array_slice($matches, 3);

                // Function to get the first three letters of a team name
                function getAbbreviation($teamName)
                {
                    return substr($teamName, 0, 3);
                }

                // matches in the left column
                echo '<div class="match-column-one">';
                foreach ($column1 as $match) {
                    $team1 = getAbbreviation(get_term($match['select_team_1'])->name);
                    $team2 = getAbbreviation(get_term($match['select_team_2'])->name);
                    $result = esc_html($match['match_results']);

                    echo '<p class="match-title">' . $team1 . ' - ' . $team2 . ': ' . $result . '</p>';
                }
                echo '</div>';

                // matches in the right column
                echo '<div class="match-column-two">';
                foreach ($column2 as $match) {
                    $team1 = getAbbreviation(get_term($match['select_team_1'])->name);
                    $team2 = getAbbreviation(get_term($match['select_team_2'])->name);
                    $result = esc_html($match['match_results']);

                    echo '<p class="match-title">' . $team1 . ' - ' . $team2 . ': ' . $result . '</p>';
                }
                echo '</div>';
            }
            ?>
        </div>

	<div class="featured-column">
    <?php
    // Fetch the latest post from the "Columns" custom post type
    $latest_column = new WP_Query(array(
        'post_type' => 'columns',
        'posts_per_page' => 1,
        'orderby' => 'date',
        'order' => 'DESC',
    ));

    // Check if there is a column post
    if ($latest_column->have_posts()) {
        // Display author image, column title, and author name
        while ($latest_column->have_posts()) {
            $latest_column->the_post();
            $author_id = get_the_author_meta('ID');
            $author_photo = get_avatar(get_the_author_meta('user_email'), 'author-photo', null, null, array('class' => 'author-photo'));
            $column_title = get_the_title();
            $author_name = get_the_author();

            if ($author_photo) {
                echo $author_photo;
            }

            echo '<h4 class="column-title"><a href="' . esc_url(get_permalink()) . '" target="_blank">' . esc_html($column_title) . '</a></h4>';
            echo '<h4 class="author-title">' . esc_html($author_name) . '</h4>';
        }

        wp_reset_postdata();
    }
    ?>
</div>

</div>

    <!--Menu Items -->
    <div class="menu-row">
        <div class="menu-column">
            <?php
            wp_nav_menu(array('theme_location' => 'primary_menu'));
            ?>
        </div>
        <div class="social-icons-column">
            <div class="social-icon facebook"></div>
            <div class="social-icon twitter"></div>
            <div class="social-icon whatsapp"></div>
            <div class="social-icon plus"></div>
        </div>
        <div class="language-selector-column">
            <a href="/en">IN ENGLISH</a>
        </div>
    </div>

    <!--Teams Filter -->
<div class="teams-filter-row">
    <div class="teams-filter-column">
        <p>VÄLJ LAG:</p>
        <?php
        // Display your ACF custom tags field here for Ajax tag filtering
        // Modify the code based on your ACF field structure
        $teams = get_terms(array('taxonomy' => 'teams', 'hide_empty' => false));
        if (!empty($teams)) {
            echo '<div class="team-logos">';
            foreach ($teams as $team) {
                $logo_url = get_field('team_logo', 'teams_' . $team->term_id);
                // Add the data-team-id attribute to each team logo
                echo '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($team->name) . '" class="team-logo" data-team-id="' . esc_attr($team->term_id) . '" />';
            }
            echo '</div>';
        }
        ?>
    </div>

        
        <div class="date-column">
            <?php
            // Display standard WP date
            echo date('F j, Y');
            ?>
        </div>
    </div></div>

</body>

</html>
