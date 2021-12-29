<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       aleksandarperisic.com
 * @since      1.0.0
 *
 * @package    Ap_Breaking_News
 * @subpackage Ap_Breaking_News/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ap_Breaking_News
 * @subpackage Ap_Breaking_News/admin
 * @author     Aleksandar <alex7apsolut@hotmail.com>
 *
 */

class Ap_Breaking_News_Admin {


	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ap_Breaking_News_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ap_Breaking_News_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ap-breaking-news-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ap_Breaking_News_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ap_Breaking_News_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ap-breaking-news-admin.js', array( 'jquery' ), $this->version, false );

	}

	/*
	 * APBN: Register shortcodes
	 */
	public function apbn_register_shortcodes() {
		add_shortcode( 'ap-breaking-news', array( $this, 'apbn_shortcode_function') );
	}
	function apbn_shortcode_function( $atts ) {

		$apbn_enable_global = carbon_get_theme_option( 'apbno_show_apbn' );
		if ($apbn_enable_global) {
			if ( !is_admin() ) {

				/**
				 * CC get fields
				 * Options: carbon_get_theme_option( 'apbn_value' );
				 * Post meta: carbon_get_the_post_meta( 'apbn_value' );
				 * Post meta with ID: carbon_get_post_meta( get_the_ID(), 'apbn_value' );
				 */

				$apbn_date = date('Y-m-d H:i:s'); //d m Y H:i:s
				$apbn_args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 1,
					'ignore_sticky_posts' => true,
					'meta_query'    => array(
						array(
							'key'       => '_apbn_expiring_date',
							'compare'   => '>=',
							'value'     => $apbn_date,
						),
					),
					'meta_key'          => '_apbn_expiring_date',
					'orderby'           => 'meta_value',
					'order'             => 'DESC',
					'suppress_filters'  => false,
				);
				$apbn_query = new  WP_Query( $apbn_args );
				/**
				 * Set time zone
				 * Change if neede for client needs (timezones or some custom date/time parts)
				 */
				$timezone = new DateTimeZone( 'Europe/Berlin' );
				if (get_option('timezone_string')) {
					$timezone = new DateTimeZone( get_option('timezone_string') );
				}

				/**
				 * Define fields
				 * Define options fields
				 */

				$current_date = 1;
				$post_expire  = '';
				$output  = '';
				$ap_breaking_news_title = carbon_get_theme_option( 'apbno_custom_prefix_title' ) ?: __('BREAKING NEWS: ', 'ap-breaking-news');
				$ap_breaking_news_bg = carbon_get_theme_option( 'apbno_background' ) ?: '#dc0000';
				$ap_breaking_news_text = carbon_get_theme_option( 'apbno_color' ) ?: '#ffffff';
				$ap_breaking_news_icon = carbon_get_theme_option( 'apbno_show_icon' ) ?: '';
				$apbn_icon = '';
				if ($ap_breaking_news_icon) {
					$apbn_icon = '<svg width="14" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-triangle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg>';
				}

				if($apbn_query->have_posts()):
					while ( $apbn_query->have_posts() ) : $apbn_query->the_post();

						/**
						 * Setup all fields to show
						 * Post page: Title
						 * Options page: Icon, Prefix (eg. BREAKING NEWS:), Background, Text Color
						 * @link https://github.com/dmhendricks/carbon-fields-loader/blob/master/vendor/htmlburger/carbon-fields/core/Field/Date_Time_Field.php
						 */
						$ap_breaking_news_post_title = carbon_get_post_meta( get_the_ID(), 'apbno_custom_prefix_title' ) ?: get_the_title();
						$ap_breaking_news_post_url =  get_the_permalink( get_the_ID() );
						update_option( '_apbno_current_breaking_id', get_the_ID() );
						update_option( '_apbno_current_breaking_name',  get_the_title( get_the_ID() ) );

						/**
						 * Today date from WP with Time zone from backend or custom
						 * Example also
						 * define: $date_today2 = wp_date("Y-m-d g:i:s", null, $timezone );
						 * output: strtotime($date_today2);
						 *
						 * strtotime would be shorter, but this leaves some space for other extra things
						 * if we change formats, manipulations etc.
						 *
						 */
						$date_today = wp_date("Y-m-d H:i:s", null, $timezone );

						/**
						 * Current date to compare
						 */
						$today_date = DateTime::createFromFormat(
							'Y-m-d H:i:s', // what format are you inputing
							$date_today, // '26 12 2021 8:07',
							new DateTimeZone(get_option('timezone_string')?: 'Europe/Berlin')
						);
						$current_date = $today_date->getTimestamp() ?: '';

						/**
						 * Date expiry field to compare
						 */
						$expire_date_field = carbon_get_the_post_meta( 'apbn_expiring_date' );
						$expire_date = DateTime::createFromFormat(
							'Y-m-d H:i:s', // what format are you inputing
							$expire_date_field, // '26 12 2021 8:07',
							new DateTimeZone(get_option('timezone_string')?: 'Europe/Berlin')
						);

						$post_expire = $expire_date->getTimestamp() ?: '';

						/**
						 * Output thigns and check if there isnt date to compare
						 */
						$output = '<div id="abpn-container" class="apbn-container" data-id="'.get_the_ID().'"><div class="apbn-slider">';

						$output .=
							'<div class="single-breaking-news" style="background-color:'. $ap_breaking_news_bg .';color:'. $ap_breaking_news_text .';">'.
							'<div class="apbn-hint"><div class="name">' . $apbn_icon . $ap_breaking_news_title . '</div></div>'.
							'<div class="apbn-title"><a href="'. $ap_breaking_news_post_url .'" style="color:'.$ap_breaking_news_text.';" alt="'.esc_attr(get_the_title(get_the_ID())).'">' . $ap_breaking_news_post_title . '</a></div>'.
							'</div>';
						$output .= '</div></div>';

					endwhile;
				else :

				endif;
				wp_reset_query();


				if ( $current_date <= $post_expire ) {
					return $output;
				}
				else {
					$apbn_no_dates = '';
					$apbn_extra_args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 1,
						'ignore_sticky_posts' => true,
						'meta_query'    => array(
							array(
								'key'       => '_apbn_make_breaking_enable',
								'compare'   => '>=',
								'value'     => $apbn_date,
							),
						),
						'order'             => 'DESC',
						'suppress_filters'  => false,

					);
					$apbn_extra_query = new  WP_Query( $apbn_extra_args );
					while ( $apbn_extra_query->have_posts() ) : $apbn_extra_query->the_post();

					if (carbon_get_post_meta( get_the_ID(), 'apbn_make_breaking_enable' )) {

						/**
						 * Setup all fields to show
						 * Post page: Title
						 * Options page: Icon, Prefix (eg. BREAKING NEWS:), Background, Text Color
						 */

						$ap_breaking_news_post_title = carbon_get_the_post_meta( 'apbno_custom_prefix_title' ) ?: get_the_title();
						$ap_breaking_news_post_url =  get_the_permalink( get_the_ID() );

						update_option( '_apbno_current_breaking_id', get_the_ID() );
						update_option( '_apbno_current_breaking_name',  get_the_title( get_the_ID() ) );

						/**
						 * Output thigns and check if there isnt date to compare
						 */
						$apbn_no_dates = '<div id="abpn-container" class="apbn-container"  data-id="'.get_the_ID().'"><div class="apbn-slider">';

						$apbn_no_dates .=
							'<div class="single-breaking-news" style="background-color:'.$ap_breaking_news_bg.';color:'.$ap_breaking_news_text.';">'.
							'<div class="apbn-hint"><div class="name">' .  $apbn_icon .  $ap_breaking_news_title . '</div></div>'.
							'<div class="apbn-title"><a href="'. $ap_breaking_news_post_url .'" style="color:'.$ap_breaking_news_text.';" alt="'.esc_attr(get_the_title(get_the_ID())).'">' . $ap_breaking_news_post_title . '</a></div>'.
							'</div>';
						$apbn_no_dates .= '</div></div>';
					}

					endwhile;
					wp_reset_query();
					return $apbn_no_dates;
				}
			}
		}

    }

	/*
	 * APBN: Unchecker for Breaking News
	 */
	function apbn_unchecker_for_apbn() {

		/**
		 * When post expire remove it from Breaking news (uncheck)
		 * Today Date to Compare
		 */
		$timezone = new DateTimeZone( 'Europe/Berlin' );
		if (get_option('timezone_string')) {
			$timezone = new DateTimeZone( get_option('timezone_string') );
		}
		$date_today = wp_date("Y-m-d H:i:s", null, $timezone );
		$date_today_timestamp = strtotime($date_today);

		/**
		 * Arguments for auto update
         * Should not be used on large posts, we should make some scheduler
         * also I think we dont need `unchecker` if DATE is EXPIRED
         * no need to add complexity when post expire
		 */

		$apbn_unchecker_args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'numberposts' => -1,
		);
		$apbn_checker_field_key = 'apbn_make_breaking_enable';
		$apbn_checker_field_value = false;
		$apbn_datepicker_enable_field_key = 'apbn_expiring_enable';
		$apbn_datepicker_enable_field_value = false;
		$apbn_datepicker_field_key = 'apbn_expiring_date';
		$apbn_datepicker_field_value = '';
		$apbn_uncheck_all_posts = get_posts($apbn_unchecker_args);

		if (!empty($apbn_uncheck_all_posts)) {
			foreach ($apbn_uncheck_all_posts as $post){

				setup_postdata($post);

				/**
				 * if Make this post breaking news is checked
				 * only when check for expired post and uncheck them
				 */

				$apbn_breaking_post_checked = carbon_get_post_meta( $post->ID, 'apbn_expiring_enable' );

				if ($apbn_breaking_post_checked) {

					/**
					 * Get expire date and see is it expired
					 */
					$expire_date_field = carbon_get_post_meta( $post->ID, 'apbn_expiring_date' );
					$expire_date_field_timestamp =  strtotime($expire_date_field);


					if ($expire_date_field_timestamp <= $date_today_timestamp) {

						/**
						 * update_post_meta( $post_id, '_crb_event_timestamp', $timestamp );
						 * @link https://docs.carbonfields.net/learn/containers/post-meta.html
						 * or WP way: update_post_meta( $post->ID, $apbn_checker_field_key, $apbn_checker_field_value );
						 */
						carbon_set_post_meta( $post->ID, $apbn_checker_field_key, $apbn_checker_field_value );
						carbon_set_post_meta( $post->ID, $apbn_datepicker_enable_field_key, $apbn_datepicker_enable_field_value );
						carbon_set_post_meta( $post->ID, $apbn_datepicker_field_key, $apbn_datepicker_field_value );

					}
				}

			}
		}
	}

}