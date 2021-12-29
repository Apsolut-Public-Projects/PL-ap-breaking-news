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
 */

/**
 * AP Breaking News options fields
 * Register all fields for options
 *
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {

	Container::make( 'theme_options', __( 'AP Breaking News', 'crb' ) )
	         ->add_fields( array(
		         Field::make( 'checkbox', 'apbno_show_apbn', __( 'Enable AP Breaking News' ) )
		              ->set_option_value( 'yes' ),
		         Field::make( 'checkbox', 'apbno_show_icon', __( 'Show icon' ) )
		              ->set_option_value( 'yes' ),
		         Field::make( 'text', 'apbno_custom_prefix_title', 'Custom Title' ),
		         Field::make( 'color', 'apbno_background', 'Background' )
		              ->set_palette( array( '#DC0000','#ff1854','#027cd2','#0b112c','#2b8d02', '#f2d501' )),
		         Field::make( 'color', 'apbno_color', 'Color' )
		              ->set_palette( array( '#FFFFFF','#000000','#ff1854','#2b8d02', '#f2d501'  )),
		         Field::make( 'separator', 'crb_separator2', __( '' ) ),
		         Field::make( 'text', 'apbno_current_breaking_id', 'Current Breaking News ID' )
			         ->set_attribute( 'readOnly', true)
			         ->set_width( 33 ),
		         Field::make( 'text', 'apbno_current_breaking_name', 'Current Breaking News Title' )
		              ->set_attribute( 'readOnly', true)
			         ->set_width( 87 ),
				 Field::make( 'html', 'apbno_information_text' )
				     ->set_html( '<a class="breakingpostedit" href="'.get_site_url().'">Edit Breaking News</a>' ),
		         Field::make( 'separator', 'crb_separator1', '' ),
				     //->set_html( '<a href="'.get_site_url().'/wp-admin/post.php?post='.carbon_get_theme_option( 'apbno_current_breaking_id' ).'&action=edit">Edit Breaking News</a>' )
	         ) );
}

/**
 * AP Breaking News post fields
 * Register all fields for post
 *
 */
add_action( 'carbon_fields_register_fields', 'crb_attach_post_fields' );
function crb_attach_post_fields() {
	Container::make( 'post_meta', 'APBN Data' )
	         ->where( 'post_type', '=', 'post' )
			->set_context( 'side' )
			->set_priority( 'high' )
	         ->add_fields( array(
		         Field::make( 'separator', 'crb_separator3', __( '' ) ),
		         Field::make( 'checkbox', 'apbn_make_breaking_enable', __( 'Make this post breaking news' ) )
		              ->set_option_value( 'yes' ),
		         Field::make( 'text', 'apbno_custom_prefix_title', 'Custom Title' )
			         ->set_conditional_logic( array(
				         array(
					         'field' => 'apbn_make_breaking_enable',
					         'value' => true,
				         )
			         ) ),
		         Field::make( 'checkbox', 'apbn_expiring_enable', __( 'Set expiration date and time' ) )
		             ->set_option_value( 'yes' )
			         ->set_conditional_logic( array(
				         array(
					         'field' => 'apbn_make_breaking_enable',
					         'value' => true,
				         )
			         ) ),
		         Field::make( 'date_time', 'apbn_expiring_date', __( 'Estimated time of arrival' ) )
			         ->set_storage_format('Y-m-d H:i:s')
			         ->set_input_format('Y m d H:i','Y m d H:i')
			         ->set_conditional_logic( array(
				         array(
					         'field' => 'apbn_expiring_enable',
					         'value' => true,
				         )
			         ) ),
		         Field::make( 'separator', 'crb_separator4', '' ),
	         ));
}

add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
	require_once( AP_MODULES_DIR . '/vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}