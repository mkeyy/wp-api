<?php

/**
 * Plugin Name: Ivision - Change Admin Url
 * Description: ...
 * Author: Ivision
 * Author URI: ivision.pl
 * Version: 0.1
 */

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
if ( !defined( 'SITECOOKIEPATH' ) ) {
	define( 'SITECOOKIEPATH', str_replace( '/wordpress/', '/', preg_replace( '|https?://[^/]+|i', '', get_option( 'siteurl' ) . '/' ) ) );
}

/**
 * @return void
 */
function ivn_change_admin_url_init() {
	/**
	 *
	 */
	add_rewrite_rule( 'wp-login.php(.*)', 'wordpress/wp-login.php$1' );
	add_rewrite_rule( 'wp-admin/(.*)', 'wordpress/wp-admin/$1' );

	/**
	 *
	 */
	add_filter( 'admin_url', 'ivn_fix_admin_url' );
	add_filter( 'site_url', 'ivn_fix_site_url' );

	/**
	 *
	 */
	$shouldFixPermalinks = defined( 'MULTISITE' ) && MULTISITE;

	if ( $shouldFixPermalinks ) {
		$shouldFixPermalinks = defined( 'SUBDOMAIN_INSTALL' ) && !SUBDOMAIN_INSTALL;
	}

	if ( $shouldFixPermalinks ) {
		/**
		 * @global $wp_scripts \WP_Scripts
		 * @global $wp_styles  \WP_Styles
		 */
		global $wp_scripts, $wp_styles;

		if ( !is_a( $wp_scripts, 'WP_Scripts' ) ) {
			$wp_scripts = new WP_Scripts();
		}

		$wp_scripts->base_url = untrailingslashit( preg_replace( "/([a-z]+\/)(wordpress\/?)/", "$1", $wp_scripts->base_url ) );

		if ( !is_a( $wp_styles, 'WP_Styles' ) ) {
			$wp_styles = new WP_Styles();
		}

		$wp_styles->base_url = untrailingslashit( preg_replace( "/([a-z]+\/)(wordpress\/?)/", "$1", $wp_styles->base_url ) );

		add_filter( 'script_loader_src', 'ivn_fix_style_script_loader_src' );
		add_filter( 'style_loader_src', 'ivn_fix_style_script_loader_src' );
		add_action( 'wp_default_scripts', 'ivn_fix_wp_default_styles_scripts' );
		add_action( 'wp_default_styles', 'ivn_fix_wp_default_styles_scripts' );
	}
}

add_action( 'init', 'ivn_change_admin_url_init' );

/**
 * @param string $url
 *
 * @return string
 */
function ivn_fix_admin_url( $url ) {
	return str_replace( '/wordpress/wp-admin/', '/wp-admin/', $url );
}

/**
 * @param string $url
 *
 * @return string
 */
function ivn_fix_site_url( $url ) {
	return str_replace( '/wordpress/wp-login.php', '/wp-login.php', $url );
}

/**
 * @param string $url
 *
 * @return string
 */
function ivn_fix_style_script_loader_src( $url ) {
	static $siteUrl;

	if ( !isset( $siteUrl ) ) {
		$siteUrl = preg_replace( '(^https?://)', '', site_url( '/' ) );
	}

	if ( false !== strpos( $url, $siteUrl ) ) {
		return preg_replace( "/([a-z]+\/)(wordpress\/)/", "$1", $url );
	}

	return $url;
}

/**
 * @param \WP_Scripts|\WP_Styles $obj
 */
function ivn_fix_wp_default_styles_scripts( &$obj ) {
	$obj->base_url = untrailingslashit( preg_replace( "/([a-z]+\/)(wordpress\/?)/", "$1", $obj->base_url ) );
}