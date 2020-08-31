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
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 *
 * @global WP_Styles $wp_styles
 *
 * @return void
 */
function ivn_back_end_css()
{
    global $wp_styles;
}

/**
 * @link   http://codex.wordpress.org/Function_Reference/wp_enqueue_script
 *
 * @return void
 */
function ivn_back_end_js()
{
}

/**
 * @link   http://codex.wordpress.org/Class_Reference/WP_Post
 * @link   http://codex.wordpress.org/Conditional_Tags
 *
 * @global WP_Post $post
 *
 * @param array $scriptSettings
 *
 * @return array
 */
function ivn_back_end_script_settings($scriptSettings)
{
    if ($screenObj = get_current_screen()) {
        global $post;
    }

    return $scriptSettings;
}

/**
 * @return void
 * @link   http://codex.wordpress.org/Function_Reference/wp_get_current_user
 * @link   http://codex.wordpress.org/Function_Reference/remove_menu_page
 * @link   http://codex.wordpress.org/Function_Reference/remove_submenu_page
 *
 * @since  1.0
 */
function ivn_admin_menu()
{
    $currentUserObj = wp_get_current_user();

    /**
     * Posts
     */
    remove_menu_page('edit.php');
    /* Add New */
    remove_submenu_page('edit.php', 'post-new.php');

    /* Categories */
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');

    /* Tags */
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');

    if ($currentUserObj->user_login !== 'admin_dev') {
        /**
         * Dashboard
         */
        /* Updates  */
        //remove_submenu_page( 'index.php', 'update-core.php' );

        /**
         * Media
         */
        //remove_menu_page( 'upload.php' );
        /* Add New */
        //remove_submenu_page( 'upload.php', 'media-new.php' );

        /**
         * Pages
         */
        //remove_menu_page( 'edit.php?post_type=page' );
        /* Add New */
        //remove_submenu_page( 'edit.php?post_type=page', 'post-new.php?post_type=page' );

        /**
         * Appearance
         */
        //remove_menu_page( 'themes.php' );
        /* Widgets */
        //remove_submenu_page( 'themes.php', 'widgets.php' );

        /* Menus */
        //remove_submenu_page( 'themes.php', 'nav-menus.php' );

        /**
         * Plugins
         */
        //remove_menu_page( 'plugins.php' );
        /* Add New */
        //remove_submenu_page( 'plugins.php', 'plugin-install.php' );

        /**
         * Tools
         */
        //remove_menu_page( 'tools.php' );
        /* Import */
        //remove_submenu_page( 'tools.php', 'import.php' );

        /* Export */
        //remove_submenu_page( 'tools.php', 'export.php' );

        /**
         * Settings
         */
        //remove_menu_page( 'options-general.php' );
        /* Writing */
        //remove_submenu_page( 'options-general.php', 'options-writing.php' );

        /* Reading */
        //remove_submenu_page( 'options-general.php', 'options-reading.php' );

        /* Discussion */
        //remove_submenu_page( 'options-general.php', 'options-discussion.php' );

        /* Media */
        //remove_submenu_page( 'options-general.php', 'options-media.php' );

        /* Permalinks */
        //remove_submenu_page( 'options-general.php', 'options-permalink.php' );

        //remove_submenu_page( $menu_slug, $submenu_slug )
    }
}

/**
 *  Disable content editor for listed templates
 */
function ivn_disable_content_editor()
{
    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } elseif (isset($_POST['post_ID'])) {
        $post_id = $_POST['post_ID'];
    }
    if (!isset($post_id)) return;

    remove_post_type_support('page', 'editor');
}
