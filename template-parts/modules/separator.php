<?php
/**
 * Separator module template part.
 *
 * @package Bollsvenskan
 * @link https://bollsvenskan.dk
 */

// Ensure $module is properly set before using it
if (isset($module)) {
    // Output the $module data for debugging
    var_dump($module);

    // Define the configuration array using data from $module
    $config = array(
        'separator_type' => !empty($module['separator'][0]['acf_fc_layout']) ? $module['separator'][0]['acf_fc_layout'] : 'line',
        'line_color' => !empty($module['separator'][0]['color']) ? $module['separator'][0]['color'] : '#00427F',
        'line_thickness' => !empty($module['separator'][0]['thickness']) ? $module['separator'][0]['thickness'] . 'px' : '6px',
        'line_style' => !empty($module['separator'][0]['style']) ? $module['separator'][0]['style'] : 'solid',
        'custom_image' => !empty($module['separator'][0]['image']) ? $module['separator'][0]['image']['url'] : '',
    );

    // Output the configuration array for debugging
    var_dump($config);

    // Generate separator module with dynamic configuration
    echo generate_separator_module($config);
} else {
    // Log or handle the case where $module is not properly set
    error_log('Error: $module is not properly set.');
}

// Remove the function declaration from here
?>
