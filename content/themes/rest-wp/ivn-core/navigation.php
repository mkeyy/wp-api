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
function ivn_navigation_setup() {
	//Nothing here yet.
}

add_action( 'after_setup_theme', 'ivn_navigation_setup' );

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/add_query_arg
 * @link   http://codex.wordpress.org/Function_Reference/get_query_var
 * @link   http://codex.wordpress.org/Function_Reference/is_search
 * @link   http://codex.wordpress.org/Function_Reference/user_trailingslashit
 * @link   http://codex.wordpress.org/Function_Reference/trailingslashit
 * @link   http://codex.wordpress.org/Function_Reference/get_search_link
 * @link   http://codex.wordpress.org/Function_Reference/wp_parse_args
 * @link   http://codex.wordpress.org/Function_Reference/paginate_links
 *
 * @global WP_Rewrite    $wp_rewrite
 * @global WP_Query      $wp_query
 *
 * @param  array         $aArguments
 * @param  void|WP_Query $oQuery
 *
 * @return void|string|array
 */
function ivn_loop_pagination( $aArguments = array(), $oQuery = false ) {
	global $wp_rewrite, $wp_query;

	$oQuery = !empty( $oQuery ) ? $oQuery : $wp_query;

	if ( 1 >= $oQuery->max_num_pages ) {
		return;
	}

	$aDefaults = array(
		'base'         => add_query_arg( 'paged', '%#%' ),
		'format'       => '',
		'total'        => intval( $oQuery->max_num_pages ),
		'current'      => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
		'prev_next'    => true,
		'prev_text'    => __( '&laquo; Previous' ),
		'next_text'    => __( 'Next &raquo;' ),
		'show_all'     => false,
		'end_size'     => 2,
		'mid_size'     => 2,
		'add_fragment' => '',
		'type'         => 'list',
		'before'       => '',
		'after'        => '',
		'echo'         => true,
	);

	if ( $wp_rewrite->using_permalinks() && !is_search() ) {
		$aDefaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . $wp_rewrite->pagination_base . '/%#%' );
	}

	if ( is_search() ) {
		$sSearchPermastruct = $wp_rewrite->get_search_permastruct();

		if ( !empty( $sSearchPermastruct ) ) {
			$aDefaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . $wp_rewrite->pagination_base . '/%#%' );
		}
	}

	$aArguments = wp_parse_args( $aArguments, $aDefaults );
	$oPageLinks = paginate_links( $aArguments );

	if ( 'array' == $aArguments['type'] ) {
		return $oPageLinks;
	}

	$sPageLinks = $aArguments['before'] . $oPageLinks . $aArguments['after'];

	if ( $aArguments['echo'] ) {
		echo $sPageLinks;
	} else {
		return $sPageLinks;
	}
}