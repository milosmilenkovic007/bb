<?php

// Register the most read posts module as a sidebar widget
function register_most_read_widget() {
    register_widget('Most_Read_Widget');
}
add_action('widgets_init', 'register_most_read_widget');

// Register the shortcode for the most read posts module
add_shortcode('most_read_posts', 'generate_most_read_shortcode');

// Widget class
class Most_Read_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'most_read_widget', // Base ID
            __('Most Read Posts', 'text_domain'), // Name
            array('description' => __('Displays most read posts', 'text_domain')) // Args
        );
    }

    // Widget frontend
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        generate_most_read_module($instance);
        echo $args['after_widget'];
    }

    // Widget form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Most Read Posts', 'text_domain');
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    // Widget update
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
}

// Function to generate most read posts module
function generate_most_read_module($args = array()) {
    // Customize the query parameters as needed
    $defaults = array(
        'title' => __('Most Read Posts', 'text_domain'),
        'posts_per_page' => 5,
    );
    $args = wp_parse_args($args, $defaults);

    $most_read_posts = new WP_Query(array(
        'posts_per_page' => $args['posts_per_page'],
        'meta_key' => 'wpb_post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    ));

    if ($most_read_posts->have_posts()) {
        echo '<div class="most-read-block">';
        echo '<h3 class="most-read-title">' . esc_html($args['title']) . '</h3>';
        echo '<ul class="most-read-ul">';

        while ($most_read_posts->have_posts()) : $most_read_posts->the_post();
            echo '<li class="most-read-single">';
            
            // Display the featured image
            if (has_post_thumbnail()) {
                echo '<div class="most-read-image">';
                the_post_thumbnail('thumbnail'); // You can use different image sizes as needed
                echo '</div>';
            }

            echo '<div class="most-read-content">';
            echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
            echo '</div>';

            echo '</li>';
        endwhile;

        echo '</ul>';
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo 'No most read posts.';
    }
}

// Shortcode function
function generate_most_read_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Most Read Posts', 'text_domain'),
        'posts_per_page' => 5,
    ), $atts);

    ob_start();
    generate_most_read_module($atts);
    return ob_get_clean();
}
?>
