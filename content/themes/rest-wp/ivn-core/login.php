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
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/add_action
 * @link   http://codex.wordpress.org/Function_Reference/add_filter
 *
 * @return void
 */
function ivn_login_style_setup()
{
    add_action('login_enqueue_scripts', 'ivn_login_css');
    add_filter('login_headerurl', 'ivn_login_headerurl');
    add_filter('login_headertext', 'ivn_login_headertitle');
}

add_action('after_setup_theme', 'ivn_login_style_setup');

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @return void
 */
function ivn_login_css()
{
    wp_enqueue_style('ivn-login', IVN_CORE_URI . 'css/style-login.css', array(), false);
    wp_print_styles('ivn-login');
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/home_url
 *
 * @return string
 */
function ivn_login_headerurl()
{
    return home_url();
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/get_option
 *
 * @return string
 */
function ivn_login_headertitle()
{
    return get_option('blogname');
}