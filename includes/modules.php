<?php
/**
 * Includes all modules
 *
 * @link https://bollsvenskan.dk
 * @package Bollsvenskan
 */

foreach ( glob( THEME_MODULES_DIR . '/*/module.php' ) as $module_file ) {
    require_once $module_file;
}
