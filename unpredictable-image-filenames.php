<?php

/**
 * Plugin Name: Unpredictable Image Filenames
 * Description: Images uploaded from cameras can have predictable (and guessable) filenames. Prevent predictable filenames. Use Unpreditable Image Filenames.
 * Version: 1.0
 * Author: Christopher Finke
 * Author URI: http://www.chrisfinke.com/
 * Author Email: cfinke@gmail.com
 * License: GPL2
 */

class Unpredictable_Image_Filenames {
	public static function plugins_loaded() {
		add_action( 'wp_handle_upload_prefilter', array( __CLASS__, 'wp_handle_upload_prefilter' ) );
	}
	
	public static function wp_handle_upload_prefilter( $file ) {
		$pathinfo = pathinfo( $file['name'] );
		
		$file['name'] = sprintf(
			'%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
			mt_rand( 0, 65535 ),
			mt_rand( 0, 65535 ),
			mt_rand( 0, 65535 ),
			mt_rand( 16384, 20479 ),
			mt_rand( 32768, 49151 ),
			mt_rand( 0, 65535 ),
			mt_rand( 0, 65535 ),
			mt_rand( 0, 65535 )
		) . "." . $pathinfo['extension'];
		
		return $file;
	}
}

add_action( 'plugins_loaded', array( 'Unpredictable_Image_Filenames', 'plugins_loaded' ) );