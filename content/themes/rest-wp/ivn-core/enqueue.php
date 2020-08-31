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
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/add_action
 * @link   http://codex.wordpress.org/Function_Reference/add_filter
 *
 * @since  1.0
 */
function ivn_enqueue_setup()
{
    add_filter('clean_url', 'ivn_add_async_for_script', 11, 1);
    add_action('wp_enqueue_scripts', 'ivn_modern_jquery');

    add_action('wp_enqueue_scripts', 'ivn_css');
    add_filter('body_class', 'ivn_body_classes');
    add_filter('style_loader_src', 'ivn_remove_style_script_version', 100);

    add_action('wp_enqueue_scripts', 'ivn_js');
    add_filter('script_loader_src', 'ivn_remove_style_script_version', 100);

    add_action('wp_default_scripts', 'ivn_remove_jquery_migrate');
    add_action('wp_footer', 'ivn_deregister_wp_embed');
}

add_action('after_setup_theme', 'ivn_enqueue_setup');

/**
 * @param $url
 * @return string|string[]
 */
function ivn_add_async_for_script($url)
{
    if (strpos($url, '#async') === false) {
        return $url;
    } else if (is_admin()) {
        return str_replace('#async', '', $url);
    } else {
        return str_replace('#async', '', $url) . "' async='async";
    }
}

/**
 * @return void
 */
function ivn_modern_jquery()
{
    global $wp_scripts;
    if (is_admin()) return;
    $wp_scripts->registered['jquery-core']->src = 'https://code.jquery.com/jquery-3.5.1.min.js';
    $wp_scripts->registered['jquery']->deps = ['jquery-core'];
}

/**
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @since  1.0
 */
function ivn_css()
{
    /**
     * Get assets mapping info
     */
    $assetsMapping = json_decode(file_get_contents(IVN_ASSETS_DIR . 'mapping.json'), true);

    /**
     * Dequeue default Wordpress styles - comment if you need Gutenberg styling
     */
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');

    /**
     * Enqueue custom styles.
     */
    do_action('ivn_front_end_styles');

    /**
     * Enqueue main style.
     */
    wp_enqueue_style('ivn-style', IVN_CSS_URI . $assetsMapping['style'], array(), false);
}

/**
 * @param array $classes
 *
 * @return array
 * @since  1.0
 *
 */
function ivn_body_classes($classes)
{
    if (preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches) && $matches[1] < 9) {
        $classes[] = 'ie';
    }

    return $classes;
}

/**
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/wp_deregister_script
 * @link   http://codex.wordpress.org/Function_Reference/wp_register_script
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link   http://codex.wordpress.org/Function_Reference/wp_localize_script
 * @link   http://codex.wordpress.org/Function_Reference/wp_is_mobile
 * @link   http://codex.wordpress.org/Function_Reference/admin_url
 *
 * @since  1.0
 */
function ivn_js()
{
    /**
     * Get assets mapping info
     */
    $assetsMapping = json_decode(file_get_contents(IVN_ASSETS_DIR . 'mapping.json'), true);

    /**
     * Enqueue custom scripts.
     */
    do_action('ivn_front_end_scripts');

    /**
     * Enqueue vendor scripts.
     */
    //wp_enqueue_script('ivn-vendor', IVN_JS_URI . $assetsMapping['vendor'], array('jquery'), false, true);

    /**
     * Enqueue and localize main script.
     */
    wp_enqueue_script('ivn-main', IVN_JS_URI . $assetsMapping['main'] . '#async', array('jquery'), false, true);
    wp_localize_script('ivn-main', '_IVN', array_merge(apply_filters('ivn_localize_front_end_script', array()), array(
        'Mobile' => intval(wp_is_mobile()),
        'Ajax' => array(
            'URL' => admin_url('admin-ajax.php'),
            'Nonces' => apply_filters('ivn_nonces_front_end', array()),
        ),
        'Assets' => array(
            'URL' => trailingslashit(IVN_THEME_URI . 'assets'),
        ),
    )));
}

/**
 * @param string $resource
 *
 * @return string
 * @link   http://codex.wordpress.org/Function_Reference/remove_query_arg
 * @link   http://codex.wordpress.org/Function_Reference/add_query_arg
 *
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/is_admin
 */
function ivn_remove_style_script_version($resource)
{
    if (!is_admin() && strpos($resource, 'ver=') !== false) {
        $resource = remove_query_arg('ver', $resource);
    }

    return $resource;
}

/**
 * @param $scripts
 *
 * Removes jQuery migrate from Wordpress
 */
function ivn_remove_jquery_migrate($scripts)
{
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];

        if ($script->deps) { // Check whether the script has any dependencies
            $script->deps = array_diff($script->deps, array(
                'jquery-migrate',
                'wp-embed'
            ));
        }
    }
}

/**
 * Deregister wp-embed.js from Wordpress
 */
function ivn_deregister_wp_embed()
{
    wp_deregister_script('wp-embed');
}