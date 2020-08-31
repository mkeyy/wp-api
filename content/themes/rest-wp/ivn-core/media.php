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
 * @link   http://codex.wordpress.org/Function_Reference/add_theme_support
 * @link   http://codex.wordpress.org/Function_Reference/add_action
 * @link   http://codex.wordpress.org/Function_Reference/add_filter
 *
 * @return void
 */
function ivn_media_setup() {
	add_theme_support( 'post-thumbnails' );

	add_filter( 'image_size_names_choose', 'ivn_image_size_names_choose' );
	add_filter( 'get_image_tag', 'ivn_remove_image_dimensions' );
	add_filter( 'post_thumbnail_html', 'ivn_remove_image_dimensions' );
	add_filter( 'image_send_to_editor', 'ivn_remove_image_dimensions' );
	add_filter( 'image_resize_dimensions', 'ivn_image_resize_dimensions_upscale', 10, 6 );
	add_filter( 'sanitize_file_name', 'ivn_sanitize_file_name' );
}

add_action( 'after_setup_theme', 'ivn_media_setup' );

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
 *
 * @param  array $aImageSizes
 *
 * @return array
 */
function ivn_image_size_names_choose( $aImageSizes ) {
	$aIntermediateImageSizes = get_intermediate_image_sizes();
	$aNewImageSizes = array();

	foreach ( $aIntermediateImageSizes as $aImageSize ) {
		$aNewImageSizes[$aImageSize] = $aImageSize;
	}

	$aImageSizes = array_merge( $aNewImageSizes, $aImageSizes );

	return $aImageSizes;
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/is_admin
 *
 * @param  string $sHTML
 *
 * @return string
 */
function ivn_remove_image_dimensions( $sHTML ) {
	if ( !is_admin() ) {
		return preg_replace( '/(height|width)="\d*"\s/', '', $sHTML );
	}

	return $sHTML;
}

/**
 * @since  1.0
 *
 * @param  int     $Default
 * @param  int     $iOriginalWidth
 * @param  int     $iOriginalHeight
 * @param  int     $iNewWidth
 * @param  int     $iNewHeight
 * @param  boolean $bCrop
 *
 * @return array
 */
function ivn_image_resize_dimensions_upscale( $Default, $iOriginalWidth, $iOriginalHeight, $iNewWidth, $iNewHeight, $bCrop ) {
	if ( !$bCrop ) {
		return null;
	}

	$iSizeRatio = max( $iNewWidth / $iOriginalWidth, $iNewHeight / $iOriginalHeight );

	$iCropWidth = round( $iNewWidth / $iSizeRatio );
	$iCropHeight = round( $iNewHeight / $iSizeRatio );

	return array( 0, 0, (int) floor( ( $iOriginalWidth - $iCropWidth ) / 2 ), (int) floor( ( $iOriginalHeight - $iCropHeight ) / 2 ), (int) $iNewWidth, (int) $iNewHeight, (int) $iCropWidth, (int) $iCropHeight );
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/remove_accents
 * @link   http://codex.wordpress.org/Function_Reference/seems_utf8
 * @link   http://codex.wordpress.org/Function_Reference/utf8_uri_encode
 *
 * @param  string $sFileName
 *
 * @return string
 */
function ivn_sanitize_file_name( $sFileName ) {
	$sFileName = remove_accents( $sFileName );
	$sFileName = strip_tags( $sFileName );

	if ( seems_utf8( $sFileName ) ) {
		if ( function_exists( 'mb_strtolower' ) ) {
			$sFileName = mb_strtolower( $sFileName, 'UTF-8' );
		}

		$sFileName = utf8_uri_encode( $sFileName, 200 );
	}

	$sFileName = strtolower( $sFileName );
	$sFileName = preg_replace( '/\s+/', '-', $sFileName );
	$sFileName = preg_replace( '|-+|', '-', $sFileName );
	$sFileName = trim( $sFileName, '-' );

	return $sFileName;
}