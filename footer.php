<?php
/**
 * The template for displaying the footer
 */
?>

<footer style="background-image: url('<?php the_field('footer_bg_image', 'option'); ?>');">
    <div class="footer-sm-row">
        <div class="social-media-column">
            <?php
            $social_media_links = get_field('social_media_links', 'option');
            
            if ($social_media_links) {
                echo '<div class="social-media-links">';
                foreach ($social_media_links as $link) {
                    $icon = isset($link['icon']) ? $link['icon'] : '';
                    $title = isset($link['title']) ? $link['title'] : '';
                    $url = isset($link['url']) ? $link['url'] : '';

                    echo '<a href="' . esc_url($url) . '" target="_blank">';
                    if ($icon) {
                        echo '<img src="' . esc_url($icon) . '" alt="' . esc_attr($title) . '" />';
                    }
                    echo esc_html($title);
                    echo '</a>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <hr class="footer-separator">

    <div class="footer-row">
        <?php
        $footer_columns = get_field('footer_columns', 'option');

        if ($footer_columns) {
            foreach ($footer_columns as $column) {
                echo '<div class="footer-column">';
                
                $heading = isset($column['heading']) ? $column['heading'] : '';
                $content = isset($column['content']) ? $column['content'] : '';

                if ($heading) {
                    echo '<h4>' . esc_html($heading) . '</h4>';
                }

                echo '<p>' . wp_kses_post($content) . '</p>';
                echo '</div>';
            }
        }
        ?>
    </div>

    <hr class="footer-separator">

    <div class="copyright-footer-row">
        <div class="footer-column copyright-column">
            <?php
            $copyright_text = get_field('copyright_text', 'option');
            echo '<p>' . esc_html($copyright_text) . '</p>';
            ?>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>

</html>
