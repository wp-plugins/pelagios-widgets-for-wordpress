<?php

/**************************************************************************

Plugin Name: Pelagios Widgets for WordPress
Plugin URI: http://peterherrel.com/wordpress/plugins/wp-pelagios
Description: The Pelagios widgets are widgets that you can embed on a web page to display relationships between places and items in ancient history collections. The information displayed originates from museums, research institutes, universities and projects that are part of Pelagios, and includes details about these items and maps showing associated locations.
Version: 0.1.1
Author: Peter J. Herrel
Author URI: http://peterherrel.com/
License: GPL3
Text Domain: wp_pelagios
Domain Path: /inc/lang

**************************************************************************

Copyright (c) 2012 Peter J. Herrel <peterherrel - gmail>

Pelagios Widgets for WordPress is free software; you can redistribute it and/or modify 
it under the terms of the GNU Lesser General Public License as published by the Free
Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along
with this program. If not, see <http://www.gnu.org/licenses/>.

**************************************************************************

PELAGIOS WIDGETS

The source code of Pelagios Widgets is available on Github released under Gnu Public Licence v3.
The widgets were developed at the Institute of Educational Technology at The Open University. 

**************************************************************************/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Wp_Pelagios' ) ) {

/**
 * Main Wp_Pelagios Class
 *
 * Contains the main functions for Wp_Pelagios
 *
 * @since Pelagios Widgets for WordPress 0.1.1
 */
class Wp_Pelagios
{	
	var $version = '0.1.1';	
	var $plugin_dir_url = '';

	/**
	 * Constructor
	 */
	function __construct()
	{
		// constant
		define( 'WP_PELAGIOS_VERSION', $this->version );
		
		// plugin directory url
		$this->plugin_dir_url = trailingslashit( plugins_url( dirname( plugin_basename( __FILE__ ) ) ) );
		
		// includes
		$this->includes();

		// installation
		if ( is_admin() && ! defined('DOING_AJAX') ) :
		
			$this->install();
			$this->uninstall();
			
		endif;
		
		// actions
		add_action( 'init', array( &$this, 'init' ), 0 );
		
		// action hook
		do_action( 'wp_pelagios_loaded' );
	}
	/**
	 * Includes
	 **/
	function includes()
	{
		// admin includes
		if ( is_admin() )									$this->admin_includes();
		
		// front end includes
		if ( ! is_admin() || defined( 'DOING_AJAX' ) )		$this->frontend_includes();

		// core functions
		// include( 'inc/core/functions.php' );
		
		// widget(s)
		if( get_option( 'wp_pelagios_search_widget_implement' ) == 'widget' )
			include( 'inc/widgets/widget-init.php' );
		
		// action hook
		do_action( 'wp_pelagios_includes' );
	}	
	/**
	 * Admin
	 **/
	function admin_includes()
	{
		// admin includes
		include( 'inc/admin/admin-init.php' );
		
		// settings link
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( &$this, 'settings_link' ) );
		
		// action hook
		do_action( 'wp_pelagios_admin_includes' );
	}
	/**
	 * Front End
	 **/
	function frontend_includes()
	{		
		// functions
		include( 'inc/wp/functions.php' );

		// shortcodes
		add_shortcode( 'pelagios', array( &$this, 'shortcode' ), 10, 2 );
		add_shortcode( 'pelagios_search', array( &$this, 'shortcode_search' ), 11 );
		
		// filters
		add_filter( 'the_excerpt', 'do_shortcode');
		
		// action hook
		do_action( 'wp_pelagios_frontend_includes' );
	}	
	/**
	 * Activation
	 **/
	function install()
	{
		// activation hook
		register_activation_hook( __FILE__, 'activate_wp_pelagios' );
		
		// install check
		if ( get_option( 'wp_pelagios_db_version' ) != $this->version ) 
			add_action( 'init', 'install_wp_pelagios', 1 );
	}
	/**
	 * Deactivation
	 **/
	function uninstall()
	{
		// deactivation hook
		register_deactivation_hook( __FILE__, 'deactivate_wp_pelagios' );
	}
	/**
	 * Init
	 **/
	function init()
	{
		// localisation
		$this->load_plugin_textdomain();

		// front end
		if ( ! is_admin() || defined( 'DOING_AJAX' ) )
		{
			add_filter( 'body_class', array( &$this, 'body_class' ), 10, 1 );
			add_filter( 'post_class', array( &$this, 'post_class' ), 10, 1 );
		}
		
		// actions
		add_action( 'init', array( &$this, 'register_scripts' ) );
		
		// action hook
		do_action( 'wp_pelagios_init' );
	}
	/**
	 * Localisation
	 **/
	function load_plugin_textdomain()
	{
		load_plugin_textdomain( 'wp_pelagios', false, $this->plugin_dir_url . 'inc/lang/' );
	}
	public function register_scripts()
	{
		// options
		$require 	= ( get_option( 'wp_pelagios_js_source' ) == 'local' ) ? $this->plugin_dir_url . 'inc/assets/js/build/lib/require.js' : 'http://pelagios.github.com/pelagios-widgets/lib/require.js';
		$search 	= ( get_option( 'wp_pelagios_js_source' ) == 'local' ) ? $this->plugin_dir_url . 'inc/assets/js/build/search.js' : 'http://pelagios.github.com/pelagios-widgets/search.js';
		$place 		= ( get_option( 'wp_pelagios_js_source' ) == 'local' ) ? $this->plugin_dir_url . 'inc/assets/js/build/place.js' : 'http://pelagios.github.com/pelagios-widgets/place.js';
		
		// register scripts
		wp_register_script( 'wp-pelagios-require', $require, array( 'jquery' ), NULL, true );
		wp_register_script( 'wp-pelagios-search', $search, array( 'wp-pelagios-require' ), NULL, true );
		wp_register_script( 'wp-pelagios-place', $place, array( 'wp-pelagios-require' ), NULL, true );
		
		// action hook
		do_action( 'wp_pelagios_register_scripts' );
	}
	function enqueue( $val )
	{
		if( ! in_array( $val, array( 'search', 'place', 'all' ) ) )
			return;
			
		// $file = get_stylesheet_directory() . '/pelagios.css';
		// $url = ( file_exists( $file ) ) ? get_stylesheet_directory_uri() . '/pelagios.css' : $this->plugin_dir_url . 'inc/assets/js/build/css/pelagios.css';
		
		wp_enqueue_script( 'wp-pelagios-require' );
		
		if( $val === 'search' || $val === 'all' )
			wp_enqueue_script( 'wp-pelagios-search' );
			
		if( $val === 'place' || $val === 'all' )
			wp_enqueue_script( 'wp-pelagios-place' );
		
		/*$wp_pelagios_params = array(
			'WpPelagiosStyleSheetUrl' => $url
		);			
		wp_localize_script( 'wp-pelagios-ui', 'wp_pelagios', $wp_pelagios_params );*/
		
		// action hook
		do_action( 'wp_pelagios_enqueue' );
	}
 	public function shortcode( $atts, $content = null )
 	{
		// options
		$map_default = ( get_option( 'wp_pelagios_place_display_map' ) == 'yes' ) ? 'true' : 'false';
		$icon_default = ( get_option( 'wp_pelagios_place_display_inline' ) == 'yes' ) ? 'true' : 'false';
		$mouse_default = ( get_option( 'wp_pelagios_place_on_mouseover' ) == 'yes' ) ? 'true' : 'false';
		
		extract( shortcode_atts( array(
			'widget_id' => 'pelagios_' . substr( md5( rand() ), 0, 7 ),
			'id' => '',
			'map' => $map_default,
			'icon' => $icon_default,
			'mouseover' => $mouse_default,
			'class' => '',
			'wrap' => 'span'
		), $atts ) );

		if( empty( $id ) )
			return '';

		// enqueue scripts
		$this->enqueue( 'place' );

		// output
		$return = '<' . esc_attr( $wrap ) 
			. ' id="' . esc_attr( $widget_id )
			. '" class="pelagios pelagios-place ' . esc_attr( $class )
			. '" data-display_map="' . esc_attr( $map ) 
			. '" data-icon="' . esc_attr( $icon ) 
			. '" data-mouseover="' . esc_attr( $mouseover )
			. '" data-pleiades_id="' . esc_attr( $id ) 
			. '"></' . esc_attr( $wrap ) . '>';
			
		// filter output
		return apply_filters( 'wp_pelagios_shortcode', $return );
	}
	function shortcode_search( $atts )
	{
		if( get_option( 'wp_pelagios_search_widget_implement' ) != 'shortcode' )
			return;			
		$div = $this->shortcode_search_cb();		
		return $div;
	}
	function shortcode_search_cb()
	{
		$div = wp_pelagios_search_widget_html();		
		return apply_filters( 'wp_pelagios_shortcode_search_cb', $div );
	}
	function body_class( $classes )
	{
		$classes[] = 'wp-pelagios';
        return apply_filters( 'wp_pelagios_body_class', $classes );
	}
	function post_class( $classes )
	{
        $classes[] = 'wp-pelagios-post';
        return apply_filters( 'wp_pelagios_post_class', $classes );
	}
	function settings_link( $links )
	{ 
		$settings_link = '<a href="admin.php?page=wp-pelagios-settings">' . __( 'Settings', 'wp_pelagios' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links; 
	}
}

/**
 * Init main class
 */
$GLOBALS['wp_pelagios'] = new Wp_Pelagios();

} // class_exists check

/**
 * Sanitize variables
 *
 * Helper function to sanitize user input
 *
 * @since Pelagios Widgets for WordPress 0.1.1
 */
function wp_pelagios_clean( $var )
{
	return trim( strip_tags( stripslashes( $var ) ) );
}