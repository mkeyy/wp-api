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
 * @link   http://codex.wordpress.org/Function_Reference/wp_get_current_user
 *
 * @since  1.0
 */
function ivn_admin_setup()
{
    $oCurrentUser = wp_get_current_user();

    add_theme_support('html5', array('script', 'style'));

    add_action('admin_init', 'ivn_disable_content_editor');
    add_action('admin_print_styles', 'ivn_admin_css');
    add_filter('admin_body_class', 'ivn_admin_body_classes');

    add_action('admin_print_scripts', 'ivn_admin_js');

    add_action('admin_init', 'ivn_disable_comments_post_types_support');
    add_filter('comments_open', 'ivn_disable_comments_status', 20, 2);
    add_filter('pings_open', 'ivn_disable_comments_status', 20, 2);
    add_filter('comments_array', 'ivn_disable_comments_hide_existing_comments', 10, 2);
    add_action('admin_menu', 'ivn_disable_comments_admin_menu');

    if ($oCurrentUser->user_login !== 'admin_dev') {
        add_filter('pre_site_transient_update_core', '__return_null');
        add_filter('pre_site_transient_update_plugins', '__return_null');
        add_filter('pre_site_transient_update_themes', '__return_null');
    }
}

add_action('after_setup_theme', 'ivn_admin_setup');

/**
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @since  1.0
 */
function ivn_admin_css()
{
    /**
     * Enqueue custom styles.
     */
    do_action('ivn_back_end_styles');
}

/**
 * @param string $sClasses
 *
 * @return string
 * @link   http://codex.wordpress.org/Function_Reference/get_page_template_slug
 * @link   http://codex.wordpress.org/Function_Reference/sanitize_title_with_dashes
 * @link   http://codex.wordpress.org/Function_Reference/sanitize_html_class
 *
 * @global WP_POST $post
 *
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/get_current_screen
 */
function ivn_admin_body_classes($sClasses)
{
    if ($oScreenObj = get_current_screen()) {
        $aNewClasses = array();
        $aScreenKeys = array('action', 'base', 'id', 'post_type', 'taxonomy');

        foreach ($aScreenKeys as $sScreenKey) {
            if (!empty($oScreenObj->$sScreenKey)) {
                $aNewClasses[] = 'screen-' . $sScreenKey . '-' . $oScreenObj->$sScreenKey;
            }
        }

        if ($oScreenObj->post_type === 'page') {
            global $post;

            if ($sTemplateName = get_page_template_slug($post)) {
                $aNewClasses[] = sanitize_title_with_dashes(substr($sTemplateName, 0, -4));
            }
        }

        if (!empty($aNewClasses)) {
            $sClasses .= ' ' . implode(' ', array_map('sanitize_html_class', $aNewClasses));
        }
    }

    return $sClasses;
}

/**
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 * @link   http://codex.wordpress.org/Function_Reference/wp_localize_script
 * @link   http://codex.wordpress.org/Function_Reference/wp_is_mobile
 * @link   http://codex.wordpress.org/Function_Reference/admin_url
 *
 * @since  1.0
 */
function ivn_admin_js()
{

    /**
     * Enqueue custom scripts.
     */
    do_action('ivn_back_end_scripts');
}

/**
 * Disable Gutenberg.
 */
add_filter('use_block_editor_for_post', '__return_false');

/**
 * Disable support for comments and trackbacks in post types
 */
function ivn_disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}

/**
 * @return bool
 *
 * Close any open comments on the front-end just in case
 */
function ivn_disable_comments_status()
{
    return false;
}

/**
 * @param $comments
 * @return array
 *
 * Hide any existing comments that are on the site
 */
function ivn_disable_comments_hide_existing_comments($comments)
{
    $comments = array();
    return $comments;
}

/**
 * Disable comments in admin menu
 */
function ivn_disable_comments_admin_menu()
{
    remove_menu_page('edit-comments.php');
}
