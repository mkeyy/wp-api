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
 * @link   http://codex.wordpress.org/Function_Reference/add_image_size
 * @link   http://codex.wordpress.org/Post_Thumbnails
 *
 * @return [type] [description]
 */
function ivn_default_image_sizes() {
	/**
	 * Thumbnail Size
	 */
	if ( get_option( 'thumbnail_size_w' ) != '150' ) {
		update_option( 'thumbnail_size_w', '150' );
	}

	if ( get_option( 'thumbnail_size_h' ) != '150' ) {
		update_option( 'thumbnail_size_h', '150' );
	}

	if ( get_option( 'thumbnail_crop' ) != '1' ) {
		update_option( 'thumbnail_crop', '1' );
	}

	/**
	 * Medium Size
	 */
	if ( get_option( 'medium_size_w' ) != '300' ) {
		update_option( 'medium_size_w', '300' );
	}

	if ( get_option( 'medium_size_h' ) != '300' ) {
		update_option( 'medium_size_h', '300' );
	}

	if ( get_option( 'medium_crop' ) != '0' ) {
		update_option( 'medium_crop', '0' );
	}

	/**
	 * Large Size
	 */
	if ( get_option( 'large_size_w' ) != '1024' ) {
		update_option( 'large_size_w', '1024' );
	}

	if ( get_option( 'large_size_h' ) != '1024' ) {
		update_option( 'large_size_h', '1024' );
	}

	if ( get_option( 'large_crop' ) != '0' ) {
		update_option( 'large_crop', '0' );
	}
}

/**
 * @since  1.0
 * @link   http://codex.wordpress.org/Function_Reference/add_image_size
 *
 * @return void
 */
function ivn_image_sizes() {
	//add_image_size( 'image-name', int IMAGE_WIDTH, int IMAGE_HEIGHT, bool CROP_IMAGE );
}