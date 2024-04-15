<?php
/**
 * template-parts/modules.php
 * Modules template.
 *
 * @package Bollsvenskan
 */

?>
<div class="wrapper-content-modules">
<?php
// Define $module before using it in the loop
$modules = get_modules();

if ($modules) {
    foreach ($modules as $module) :
        // Check if $module is set and not empty
        if (isset($module['acf_fc_layout'])) {
            // Include the template part only if $module['acf_fc_layout'] is set
            get_template_part('template-parts/modules/' . $module['acf_fc_layout'], $module);
        }
    endforeach;
} else {
    // Handle case where $modules is empty or not set
    echo 'No modules found.';
}
?>
</div>
