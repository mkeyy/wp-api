<?php

/**
 * @param integer $userId
 *
 * @return void
 */
function wp_install_defaults( $userId ) {
	/**
	 * @global \wpdb $wpdb
	 * @global \WP_Rewrite $wp_rewrite
	 */
	global $wpdb, $wp_rewrite, $table_prefix;

	$categoryName = __( 'Uncategorized' );
	/* translators: Default category slug */
	$categorySlug = sanitize_title( _x( 'Uncategorized', 'Default category slug' ) );

	if ( global_terms_enabled() ) {
		$categoryId = $wpdb->get_var( $wpdb->prepare( "SELECT cat_ID FROM {$wpdb->sitecategories} WHERE category_nicename = %s", $categorySlug ) );
		if ( $categoryId == null ) {
			$wpdb->insert( $wpdb->sitecategories, array( 'cat_ID' => 0, 'cat_name' => $categoryName, 'category_nicename' => $categorySlug, 'last_updated' => current_time( 'mysql', true ) ) );
			$categoryId = $wpdb->insert_id;
		}

		update_option( 'default_category', $categoryId );
	} else {
		$categoryId = 1;
	}

	$wpdb->insert( $wpdb->terms, array( 'term_id' => $categoryId, 'name' => $categoryName, 'slug' => $categorySlug, 'term_group' => 0 ) );
	$wpdb->insert( $wpdb->term_taxonomy, array( 'term_id' => $categoryId, 'taxonomy' => 'category', 'description' => '', 'parent' => 0, 'count' => 1 ) );

	$homeUrl = untrailingslashit( wp_guess_url() );
	$homeUrl = substr( $homeUrl, 0, strrpos( $homeUrl, '/' ) );

	update_option( 'home', $homeUrl );
	update_option( 'siteurl', $homeUrl . '/wordpress' );
	update_option( 'date_format', 'd/m/Y' );
	update_option( 'time_format', 'H:i' );
	update_option( 'use_smilies', 0 );
	update_option( 'blog_public', 0 );
	update_option( 'default_pingback_flag', 0 );
	update_option( 'default_ping_status', 'closed' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'comment_registration', 1 );
	update_option( 'comments_notify', 0 );
	update_option( 'moderation_notify', 0 );
	update_option( 'comment_moderation', 1 );
	update_option( 'comment_whitelist', 1 );
	update_option( 'permalink_structure', '/%postname%/' );

	update_user_meta( $userId, 'show_welcome_panel', 0 );
	update_user_meta( $userId, 'show_admin_bar_front', 0 );

	if ( is_multisite() ) {
		$user = new WP_User( $userId );
		$wpdb->update( $wpdb->options, array( 'option_value' => $user->user_email ), array( 'option_name' => 'admin_email' ) );

		// Remove all perms except for the login user.
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE user_id != %d AND meta_key = %s", $userId, $table_prefix . 'user_level' ) );
		$wpdb->query( $wpdb->prepare( "DELETE FROM $wpdb->usermeta WHERE user_id != %d AND meta_key = %s", $userId, $table_prefix . 'capabilities' ) );

		if ( !is_super_admin( $userId ) && $userId != 1 ) {
			$wpdb->delete( $wpdb->usermeta, array( 'user_id' => $userId, 'meta_key' => $wpdb->base_prefix . '1_capabilities' ) );
		}
	}

	$wp_rewrite->init();
	$wp_rewrite->add_external_rule( 'wp-login.php(.*)', 'wordpress/wp-login.php$1' );
	$wp_rewrite->add_external_rule( 'wp-admin/(.*)', 'wordpress/wp-admin/$1' );
	$wp_rewrite->flush_rules();
}