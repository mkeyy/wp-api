<?php

/**
 * ...
 *
 * @package Rest WP
 */
?>
<?php

/**
 * [ivn_utils_setup description]
 *
 * @return void
 */
function ivn_utils_setup() {

	// Recent Comments Style
	add_filter( 'show_recent_comments_widget_style', '__return_false' );

	// WP Version
	remove_action( 'wp_head', 'wp_generator' );

	// Category Feeds
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	// Post And Comment Feeds
	remove_action( 'wp_head', 'feed_links', 2 );

	// EditURI Link
	remove_action( 'wp_head', 'rsd_link' );

	// Windows Live Writer
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Index Link
	remove_action( 'wp_head', 'index_rel_link' );

	// Previous Link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

	// Start Link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

	// Links For Adjacent Posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// Nice Search Redirect
	add_action( 'template_redirect', 'ivn_nice_search_redirect' );

	// Template Include
	add_action( 'template_include', 'ivn_template_include' );

}

add_action( 'after_setup_theme', 'ivn_utils_setup' );

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/is_search
 * @link   http://codex.wordpress.org/Function_Reference/is_admin
 * @link   http://codex.wordpress.org/Function_Reference/wp_redirect
 * @link   http://codex.wordpress.org/Function_Reference/user_trailingslashit
 * @link   http://codex.wordpress.org/Function_Reference/trailingslashit
 * @link   http://codex.wordpress.org/Function_Reference/home_url
 * @link   http://codex.wordpress.org/Function_Reference/get_query_var
 *
 * @global WP_Rewrite $wp_rewrite
 *
 * @return void
 */
function ivn_nice_search_redirect() {
	global $wp_rewrite;

	if ( !isset( $wp_rewrite ) || !is_object( $wp_rewrite ) || !$wp_rewrite->using_permalinks() ) {
		return;
	}

	$sSearchBase = $wp_rewrite->search_base;

	if ( is_search() && !is_admin() && strpos( $_SERVER['REQUEST_URI'], "/{$sSearchBase}/" ) === false ) {
		wp_redirect( user_trailingslashit( trailingslashit( home_url( "/{$sSearchBase}/" . urlencode( get_query_var( 's' ) ) ) ) ) );
		exit();
	}
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Class_Reference/WP_Query
 *
 * @param  string $sPageTemplateName
 *
 * @return false|WP_Post
 */
function ivn_get_page_by_template( $sPageTemplateName ) {
	if ( empty( $sPageTemplateName ) ) {
		return false;
	}

	$aPageTemplateArguments = array(
		'posts_per_page' => 1,
		'nopaging'       => true,
		'post_type'      => 'page',
		'post_status'    => 'publish',
		'meta_key'       => '_wp_page_template',
		'meta_value'     => $sPageTemplateName,
		'orderby'        => 'ID',
		'order'          => 'DESC',
	);

	$oPageTemplateQuery = new WP_Query( $aPageTemplateArguments );

	if ( $oPageTemplateQuery->have_posts() ) {
		return $oPageTemplateQuery->next_post();
	}

	return false;
}

/**
 * @since  1.0
 *
 * @param  integer $iTermID
 * @param  string  $sMetaKey
 * @param  mixed   $mMetaValue
 * @param  boolean $bAutoload
 *
 * @return boolean
 */
function ivn_set_term_meta( $iTermID, $sMetaKey, $mMetaValue, $bAutoload = true ) {
	if ( !$iTermID = absint( $iTermID ) ) {
		return false;
	}

	$sMetaKey = trim( $sMetaKey );

	if ( empty( $sMetaKey ) ) {
		return false;
	}

	$sMetaKey = 'term_meta_' . $iTermID . '_k_' . $sMetaKey;

	if ( $bAutoload || get_option( $sMetaKey ) !== false ) {
		return update_option( $sMetaKey, $mMetaValue );
	} else {
		return add_option( $sMetaKey, $mMetaValue, '', $bAutoload === true ? 'yes' : 'no' );
	}
}

/**
 * @since  1.0
 *
 * @param  integer $iTermID
 * @param  string  $sMetaKey
 * @param  boolean $mMetaDefault
 *
 * @return false|mixed
 */
function ivn_get_term_meta( $iTermID, $sMetaKey, $mMetaDefault = false ) {
	if ( !$iTermID = absint( $iTermID ) ) {
		return false;
	}

	$sMetaKey = trim( $sMetaKey );

	if ( empty( $sMetaKey ) ) {
		return false;
	}

	$sMetaKey = 'term_meta_' . $iTermID . '_k_' . $sMetaKey;

	return get_option( $sMetaKey, $mMetaDefault );
}

/**
 * @since  1.0
 *
 * @param  integer $iTermID
 * @param  string  $sMetaKey
 *
 * @return boolean
 */
function ivn_unset_term_meta( $iTermID, $sMetaKey ) {
	if ( !$iTermID = absint( $iTermID ) ) {
		return false;
	}

	$sMetaKey = trim( $sMetaKey );

	if ( empty( $sMetaKey ) ) {
		return false;
	}

	$sMetaKey = 'term_meta_' . $iTermID . '_k_' . $sMetaKey;

	return delete_option( $sMetaKey );
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/locate_template
 *
 * @param  string $sTemplateFile
 *
 * @return string
 */
function ivn_template_include( $sTemplateFile ) {
	$oQueriedObject = get_queried_object();
	$sTempTemplateFile = '';

	if ( is_single() && !is_singular( 'post' ) ) {
		$sTempTemplateFile = locate_template( array(
			'includes/views/single/single-' . $oQueriedObject->post_type . '.php',
		) );
	} elseif ( is_post_type_archive() ) {
		$sTempTemplateFile = locate_template( array(
			'includes/views/archive/archive-' . $oQueriedObject->name . '.php',
		) );
	} elseif ( is_category() ) {
		$sTempTemplateFile = locate_template( array(
			'includes/views/category/category-' . $oQueriedObject->slug . '.php',
			'includes/views/category/category-' . $oQueriedObject->term_id . '.php',
		) );
	} elseif ( is_tax() ) {
		$sTempTemplateFile = locate_template( array(
			'includes/views/taxonomy/taxonomy-' . $oQueriedObject->taxonomy . '-' . $oQueriedObject->slug . '.php',
			'includes/views/taxonomy/taxonomy-' . $oQueriedObject->taxonomy . '.php',
		) );
	} elseif ( is_tag() ) {
		$sTempTemplateFile = locate_template( array(
			'includes/views/tag/tag-' . $oQueriedObject->slug . '.php',
			'includes/views/tag/tag-' . $oQueriedObject->term_id . '.php',
		) );
	}

	if ( !empty( $sTempTemplateFile ) ) {
		return $sTempTemplateFile;
	}

	return $sTemplateFile;
}