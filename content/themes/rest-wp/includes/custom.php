<?php
/**
 * ...
 *
 * @package Rest WP
 * @since   1.0
 */
?>
<?php

/**
 * Files to include
 */

$IVN_CustomIncludes = array(
    /**
     * Meta Boxes
     */
    'meta-boxes/cmb-options.php',
    'meta-boxes/cmb-homepage.php',
    'meta-boxes/cmb-about.php',

    /**
     * Custom Post Types
     */

    /**
     * Other Files
     */

    'admin.php',
    'media.php'
);

foreach ($IVN_CustomIncludes as $IVN_CustomInclude) {
    require(IVN_INC_DIR . $IVN_CustomInclude);
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @return void
 * @since  1.0
 *
 */
function ivn_theme_setup()
{
    /**
     * Main Query Hooks
     */
    add_action('pre_get_posts', 'ivn_main_query_back_end_filter');

    /**
     * Media
     */
    add_action('init', 'ivn_default_image_sizes');
    add_action('init', 'ivn_image_sizes');

    /**
     * Enqueue CSS
     */
    add_action('ivn_back_end_styles', 'ivn_back_end_css');

    /**
     * Enqueue JavaScript
     */
    add_action('ivn_back_end_scripts', 'ivn_back_end_js');
    add_action('ivn_localize_back_end_script', 'ivn_back_end_script_settings');

    /**
     * Custom Menus
     */
    add_action('init', 'ivn_register_menus');

    /**
     * Admin Menu
     */
    add_action('admin_menu', 'ivn_admin_menu');

    /**
     * Disable Emoji's
     */
    add_filter('tiny_mce_plugins', function ($plugins) {
        if (is_array($plugins)) {
            return array_diff($plugins, array('wpemoji'));
        } else {
            return array();
        }
    });

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}

add_action('after_setup_theme', 'ivn_theme_setup');

/**
 * @param WP_Query $oQuery
 *
 * @return void
 * @link   http://codex.wordpress.org/Class_Reference/WP_Query
 * @link   http://codex.wordpress.org/Plugin_API/Action_Reference/pre_get_posts
 *
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/is_admin
 */
function ivn_main_query_back_end_filter($oQuery)
{
    if (!is_admin() || !$oQuery->is_main_query()) {
        return;
    }
}

/**
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/register_nav_menus
 *
 * @since  1.0
 */
function ivn_register_menus()
{
    register_nav_menus(array(
        'main-menu' => __('Main Menu', 'ivn-theme'),
        'footer-menu' => __('Footer Menu', 'ivn-theme'),
    ));
}