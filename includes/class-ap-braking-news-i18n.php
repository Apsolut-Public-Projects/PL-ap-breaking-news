<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       aleksandarperisic.com
 * @since      1.0.0
 *
 * @package    Ap_Breaking_News
 * @subpackage Ap_Breaking_News/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ap_Breaking_News
 * @subpackage Ap_Breaking_News/includes
 * @author     Aleksandar <alex7apsolut@hotmail.com>
 */
class Ap_Breaking_News_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ap-breaking-news',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
