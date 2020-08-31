<?php
/**
 * IVN Base Theme functions and definitions
 *
 * @package Rest WP
 */
?>
<?php

/**
 * Basic Constants
 */

define('IVN_THEME_DIR', trailingslashit(get_template_directory()));
define('IVN_THEME_URI', trailingslashit(get_template_directory_uri()));

define('IVN_CORE_DIR', trailingslashit(IVN_THEME_DIR . 'ivn-core'));
define('IVN_CORE_URI', trailingslashit(IVN_THEME_URI . 'ivn-core'));

define('IVN_INC_DIR', trailingslashit(IVN_THEME_DIR . 'includes'));
define('IVN_INC_URI', trailingslashit(IVN_THEME_URI . 'includes'));

/**
 * WPML Constants - disable default 'css' and 'js' files
 */

define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
define('ICL_DONT_LOAD_LANGUAGES_JS', true);

/**
 * Files to include
 */

$IVN_Includes = array(
    IVN_INC_DIR . 'constants.php',
    IVN_INC_DIR . 'endpoints.php',
    IVN_INC_DIR . 'php-functions.php',
    IVN_CORE_DIR . 'admin.php',
    IVN_CORE_DIR . 'enqueue.php',
    IVN_CORE_DIR . 'login.php',
    IVN_CORE_DIR . 'media.php',
    IVN_CORE_DIR . 'navigation.php',
    IVN_CORE_DIR . 'utils.php',
    IVN_INC_DIR . 'custom.php',
);

foreach ($IVN_Includes as $IVN_Include) {
    require($IVN_Include);
}

/**
 * IF YOU WANT TO ADD ANY CUSTOM CODE PLEASE DO IT IN 'includes/custom.php' FILE.
 */