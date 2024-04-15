<?php

// Register the upcoming posts module as a sidebar widget
function register_upcoming_posts_widget() {
    register_widget('Upcoming_Posts_Widget');
}
add_action('widgets_init', 'register_upcoming_posts_widget');

// Register the shortcode for the upcoming posts module
add_shortcode('upcoming_posts', 'generate_upcoming_posts_shortcode');

// Widget class
class Upcoming_Posts_Widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'upcoming_posts_widget', // Base ID
            __('Upcoming Posts', 'text_domain'), // Name
            array('description' => __('Displays upcoming posts', 'text_domain')) // Args
        );
    }

    // Widget frontend
    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }
        generate_upcoming_posts_module($instance);
        echo $args['after_widget'];
    }

    // Widget form
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Upcoming Posts', 'text_domain');
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

// Function to generate upcoming posts module
function generate_upcoming_posts_module($args = array()) {
    $defaults = array(
        'title' => __('Upcoming Posts', 'text_domain'),
        'posts_per_page' => 5
    );
    $args = wp_parse_args($args, $defaults);

    $upcoming_posts = get_posts(array(
        'post_status' => 'future',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => $args['posts_per_page']
    ));

    if ($upcoming_posts) {
        echo '<div class="upcoming-posts-module">';
        echo '<h3 class="upcoming-title">' . esc_html($args['title']) . '</h3>';
        echo '<ul class="upcoming-ul">';
        foreach ($upcoming_posts as $upcoming_post) {
            echo '<li class="upcoming-single">';
            echo esc_html($upcoming_post->post_title);
            echo '</li>';
        }
        echo '</ul>';
        echo '</div>';
    } else {
        echo 'No upcoming posts.';
    }
}

// Shortcode function
function generate_upcoming_posts_shortcode($atts) {
    $atts = shortcode_atts(array(
        'title' => __('Upcoming Posts', 'text_domain'),
        'posts_per_page' => 5
    ), $atts);

    ob_start();
    generate_upcoming_posts_module($atts);
    return ob_get_clean();
}
?>
