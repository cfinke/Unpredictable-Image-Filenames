<?php

/**
 * Plugin Name: Unpredictable Image Filenames
 * Description: Images uploaded from cameras can have predictable (and guessable) filenames. Prevent predictable filenames. Use Unpredictable Image Filenames.
 * Version: 1.1a4
 * Author: Christopher Finke
 * Author URI: http://www.chrisfinke.com/
 * Author Email: cfinke@gmail.com
 * License: GPL2
 */

class Unpredictable_Image_Filenames {
	public static function plugins_loaded() {
		add_filter( 'wp_handle_upload_prefilter', array( __CLASS__, 'wp_handle_upload_prefilter' ) );
	}

	public static function wp_handle_upload_prefilter( $file ) {
		$filetype = wp_check_filetype( $file['name'] );

		// Only rename images.
		if ( empty( $filetype['type'] ) || 0 !== strpos( $filetype['type'], 'image/' ) ) {
			return $file;
		}

		$file['name'] = strtoupper( wp_generate_uuid4() );

		if ( ! empty( $filetype['ext'] ) ) {
			$file['name'] .= "." . $filetype['ext'];
		}

		return $file;
	}
}

add_action( 'plugins_loaded', array( 'Unpredictable_Image_Filenames', 'plugins_loaded' ) );
