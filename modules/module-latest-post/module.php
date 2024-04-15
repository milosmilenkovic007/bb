<?php

// Register the latest posts module as a sidebar widget
function register_latest_posts_widget() {
    register_widget('Latest_Posts_Widget');
}
add_action('widgets_init', 'register_latest_posts_widget');

// Register the shortcode for the latest posts module
add_shortcode('latest_posts', 'generate_latest_posts_shortcode');

// Widget class
class Latest_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'latest_posts_widget', 
            __('Latest Posts', 'bollsvenskan'), 
            array('description' => __('Displays latest posts with featured images', 'bollsvenskan')) // Args
        );
    }

    // Widget frontend
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        generate_latest_posts_module($instance);
        echo $args['after_widget'];
    }

    // Widget form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Senaste', 'bollsvenskan');
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

// Function to generate latest posts module
function generate_latest_posts_module($args = array()) {
    $defaults = array(
        'title' => __('Senaste', 'bollsvenskan'),
        'posts_per_page' => 10,
    );
    $args = wp_parse_args($args, $defaults);

    $latest_posts = new WP_Query(array(
        'posts_per_page' => $args['posts_per_page'],
        'orderby' => 'date',
        'order' => 'DESC',
    ));

    if ($latest_posts->have_posts()) {
        echo '<div class="latest-posts-block">';
        echo '<h3 class="latest-posts-title">' . esc_html($args['title']) . '</h3>';
        echo '<ul class="latest-posts-ul">';

        while ($latest_posts->have_posts()) : $latest_posts->the_post();
            echo '<li class="latest-posts-single">';
            
            // Display the featured image
            if (has_post_thumbnail()) {
                echo '<div class="latest-posts-image">';
                the_post_thumbnail('thumbnail'); 
                echo '</div>';
            }
            echo '<a href="' . esc_url(get_permalink()) . '">' . get_the_title() . '</a>';
            echo '</li>';
        endwhile;

        echo '</ul>';
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo 'No latest posts.';
    }
}

// Shortcode function
function generate_latest_posts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Latest Posts', 'text_domain'),
        'posts_per_page' => 5,
    ), $atts);

    ob_start();
    generate_latest_posts_module($atts);
    return ob_get_clean();
}
?>
