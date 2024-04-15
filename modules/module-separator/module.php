<?php
// modules/module-separator/module.php

function generate_separator_module($config) {
    switch ($config['separator_type']) {
        case 'line':
            ?>
            <hr style="border-color: <?php echo esc_attr($config['line_color']); ?>;
                        border-width: <?php echo esc_attr($config['line_thickness']); ?>;
                        border-style: <?php echo esc_attr($config['line_style']); ?>;">
            <?php
            break;

        case 'custom_image':
            if (!empty($config['custom_image'])) :
                ?>
                <img src="<?php echo esc_url($config['custom_image']); ?>" alt="Custom Image Separator">
                <?php
            endif;
            break;

        default:
            ?>
            <hr>
            <?php
            break;
    }
}
?>
