<?php

/***************************************************************************************************

Plugin Name: Pelagios Widgets for WordPress
Plugin URI: http://peterherrel.com/wordpress/plugins/wp-pelagios
Description: The Pelagios widgets are widgets that you can embed on a web page to display relationships between places and items in ancient history collections. The information displayed originates from museums, research institutes, universities and projects that are part of Pelagios, and includes details about these items and maps showing associated locations.
Version: 0.2.0
Author: Peter J. Herrel
Author URI: http://peterherrel.com/
License: GPL3
Text Domain: wp_pelagios
Domain Path: /inc/lang

****************************************************************************************************

Copyright (c) 2012-2015 Peter J. Herrel <peterherrel - gmail>

Pelagios Widgets for WordPress is free software; you can redistribute it and/or modify 
it under the terms of the GNU Lesser General Public License as published by the Free
Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along
with this program. If not, see <http://www.gnu.org/licenses/>.

****************************************************************************************************

PELAGIOS WIDGETS

The source code of Pelagios Widgets is available on Github released under Gnu Public Licence v3.
The widgets were developed at the Institute of Educational Technology at The Open University. 

***************************************************************************************************/

/*
 * Security, exit if accessed directly
 */
if( ! defined( 'ABSPATH' ) )
    exit;

if( ! class_exists( 'Wp_Pelagios' ) )
{
/**
 * Main Wp_Pelagios Class
 *
 * Contains the main functions for Wp_Pelagios
 *
 * @since Pelagios Widgets for WordPress 0.1.1
 */
class Wp_Pelagios
{
    // vars
    public $version         = '0.2.0';
    public $version_wp      = '3.9';
    public $version_req_js  = '2.0.4';
    public $plugin_dir_url  = '';

    /**
     * Constructor
     *
     * @return  void
     */
    public function __construct()
    {
        // constants
        define( 'WP_PELAGIOS_VERSION',      $this->version );
        define( 'WP_PELAGIOS_VERSION_WP',   $this->version_wp );

        // plugin directory url
        $this->plugin_dir_url = trailingslashit( plugins_url( dirname( plugin_basename( __FILE__ ) ) ) );

        // i18n
        add_action( 'init', array( $this, 'load_plugin_textdomain' ), 0 );

        // installation and upgrading
        if( is_admin() && ! defined( 'DOING_AJAX' ) ) :

            // activation
            register_activation_hook( __FILE__, array( $this , 'register_activation_hook' ) );

            // deactivation
            register_deactivation_hook( __FILE__, array( $this, 'register_deactivation_hook' ) );

            // check compatibility
            add_action( 'admin_init', array( $this, 'check_compat' ), 9 );

            if( '1' == get_option( 'wp_pelagios_install' ) && false !== self::is_compatible() )
                add_action( 'admin_init', array( $this, 'redirect_after_activation' ), 10 );

        endif;

        // includes
        $this->includes();

        // actions
        add_action( 'init', array( $this, 'init' ), 0 );

        // action hook
        do_action( 'wp_pelagios_loaded' );
    }
    /**
     * Includes
     *
     * @return  void
     */
    public function includes()
    {
        // admin includes
        if( is_admin() )                                $this->admin_includes();

        // front end includes
        if( ! is_admin() || defined( 'DOING_AJAX' ) )   $this->frontend_includes();

        // widget(s)
        if( 'widget' == get_option( 'wp_pelagios_search_widget_implement' ) )
            include_once( 'inc/widgets/widget-init.php' );

        // action hook
        do_action( 'wp_pelagios_includes' );
    }
    /**
     * Admin includes
     *
     * @return  void
     */
    public function admin_includes()
    {
        // plugin meta
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),   array( $this, 'plugin_action_links' ), 10, 1 );
        add_filter( 'plugin_row_meta',                                      array( $this, 'plugin_row_meta' ), 10, 2 );

        // admin includes
        include_once( 'inc/admin/admin-init.php' );

        // action hook
        do_action( 'wp_pelagios_admin_includes' );
    }
    /**
     * Front end includes
     *
     * @return  void
     */
    public function frontend_includes()
    {
        // functions
        include_once( 'inc/wp/functions.php' );

        // shortcodes
        add_shortcode( 'pelagios',          array( $this, 'shortcode' ), 10, 2 );
        add_shortcode( 'pelagios_search',   array( $this, 'shortcode_search' ), 11 );

        // filters
        if( ! has_filter( 'the_content', 'do_shortcode' ) )
            add_filter( 'the_excerpt', 'do_shortcode' );

        // action hook
        do_action( 'wp_pelagios_frontend_includes' );
    }
    /**
     * Init
     *
     * @return  void
     */
    public function init()
    {
        // front end
        if( ! is_admin() || defined( 'DOING_AJAX' ) )
        {
            add_filter( 'body_class', array( $this, 'body_class' ), 10, 1 );
            add_filter( 'post_class', array( $this, 'post_class' ), 10, 1 );
        }

        // actions
        add_action( 'init', array( $this, 'register_scripts' ) );

        // action hook
        do_action( 'wp_pelagios_init' );
    }
    /**
     * Localisation
     *
     * @return  void
     */
    public function load_plugin_textdomain()
    {
        load_plugin_textdomain( 'wp_pelagios', false, $this->plugin_dir_url . 'inc/lang/' );
    }
    /**
     * Register scripts
     *
     * @return  void
     */
    public function register_scripts()
    {
        // options
        $require    = ( 'local' == get_option( 'wp_pelagios_js_source' ) ) ? $this->plugin_dir_url . 'inc/assets/js/build/lib/require.js'   : 'https://pelagios.github.io/pelagios-widgets/lib/require.js';
        $search     = ( 'local' == get_option( 'wp_pelagios_js_source' ) ) ? $this->plugin_dir_url . 'inc/assets/js/build/search.js'        : 'https://pelagios.github.io/pelagios-widgets/search.js';
        $place      = ( 'local' == get_option( 'wp_pelagios_js_source' ) ) ? $this->plugin_dir_url . 'inc/assets/js/build/place.js'         : 'https://pelagios.github.io/pelagios-widgets/place.js';

        $version    = ( 'local' == get_option( 'wp_pelagios_js_source' ) ) ? $this->version : null;
        $version = null;

        // register scripts
        wp_register_script( 'wp-pelagios-require',  $require,   array( 'jquery' ),                          $this->version_req_js, true );
        wp_register_script( 'wp-pelagios-search',   $search,    array( 'jquery', 'wp-pelagios-require' ),   $version, true );
        wp_register_script( 'wp-pelagios-place',    $place,     array( 'jquery', 'wp-pelagios-require' ),   $version, true );

        // action hook
        do_action( 'wp_pelagios_register_scripts' );
    }
    /**
     * Enqueue scripts
     *
     * @param   string  $val
     * @return  void
     */
    public function enqueue( $val )
    {
        if( ! in_array( $val, array( 'search', 'place', 'all' ) ) )
            return;

        // wp_script_is
        if( $val === 'search' || $val === 'all' )
            wp_enqueue_script( 'wp-pelagios-search' );

        if( $val === 'place' || $val === 'all' )
            wp_enqueue_script( 'wp-pelagios-place' );

        // action hook
        do_action( 'wp_pelagios_enqueue' );
    }
    /**
     * Shortcode callback
     *
     * @param   array   $atts
     * @param   string  $content
     * @return  string
     */
    public function shortcode( $atts, $content = null )
    {
        // options
        $map_default    = ( 'yes' == get_option( 'wp_pelagios_place_display_map' ) )    ? 'true' : 'false';
        $icon_default   = ( 'yes' == get_option( 'wp_pelagios_place_display_inline' ) ) ? 'true' : 'false';
        $mouse_default  = ( 'yes' == get_option( 'wp_pelagios_place_on_mouseover' ) )   ? 'true' : 'false';

        extract( shortcode_atts( array(
             'widget_id'    => 'pelagios_' . substr( md5( rand() ), 0, 7 )
            ,'id'           => ''
            ,'map'          => $map_default
            ,'icon'         => $icon_default
            ,'mouseover'    => $mouse_default
            ,'class'        => ''
            ,'wrap'         => 'span'
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
    /**
     * Search shortcode callback
     *
     * @param   array   $atts
     * @return  string
     */
    public function shortcode_search( $atts )
    {
        if( 'shortcode' != get_option( 'wp_pelagios_search_widget_implement' ) )
            return;

        extract( shortcode_atts( array(
            'width' => ''
        ), $atts ) );

        return apply_filters( 'wp_pelagios_shortcode_search_cb', wp_pelagios_search_widget_html( $width ) );
    }
    /**
     * Body Class
     *
     * @param   array   $classes
     * @return  array
     */
    public function body_class( $classes )
    {
        $classes[] = 'wp-pelagios';

        return apply_filters( 'wp_pelagios_body_class', $classes );
    }
    /**
     * Post Class
     *
     * @param   array   $classes
     * @return  array
     */
    public function post_class( $classes )
    {
        $classes[] = 'wp-pelagios-post';

        return apply_filters( 'wp_pelagios_post_class', $classes );
    }
    /**
     * Activation hook
     *
     * @uses    wp_pelagios_default_options()
     * @return  void
     */
    public function register_activation_hook()
    {
        if( false === self::is_compatible() )
        {
            require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin.php' );

            deactivate_plugins( plugin_basename( __FILE__ ) );

            wp_die( 
                 sprintf( __( 'The Pelagios Widgets for WordPress plugin requires WordPress %s or higher.', 'wp_pelagios' ), $this->version_wp )
                ,__( 'Pelagios Widgets for WordPress plugin activation error.', 'wp_pelagios' )
                ,array( 'back_link' => true )
            );
        }
        else
        {
            $this->includes();

            update_option( 'wp_pelagios_install', 1 );

            wp_pelagios_default_options();

            update_option( 'wp_pelagios_db_version', $this->version );
        }
    }
    /**
     * Admin redirect
     *
     * @return  void
     */
    public function redirect_after_activation()
    {
        delete_option( 'wp_pelagios_install' );

        wp_safe_redirect( admin_url( 'options-general.php?page=wp-pelagios-settings&tab=about&activated=1' ) );

        exit;
    }
    /**
     * Deactivation
     *
     * @uses    wp_pelagios_delete_options()
     * @return  void
     */
    public function register_deactivation_hook()
    {
        $this->includes();

        update_option( 'wp_pelagios_uninstall', 1 );

        wp_pelagios_delete_options();

        delete_option( 'wp_pelagios_db_version', $this->version );
        delete_option( 'wp_pelagios_uninstall' );
    }
    /**
     * Compatibility check
     *
     * @uses    wp_pelagios_default_options()
     * @return  void
     */
    public function check_compat()
    {
        // if incompatible
        if( false === self::is_compatible() )
        {
            require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/plugin.php' );

            if( ! is_plugin_active( plugin_basename( __FILE__ ) ) )
                return;

            deactivate_plugins( plugin_basename( __FILE__ ) );

            add_action( 'admin_notices', array( $this, 'admin_notices' ) );

            if( isset( $_GET['activate'] ) )
                unset( $_GET['activate'] );
        }
        // if upgrade
        elseif( $this->version != get_option( 'wp_pelagios_db_version' ) )
        {
            $this->includes();

            wp_pelagios_default_options();

            update_option( 'wp_pelagios_db_version', $this->version );
        }
    }
    /**
     * Version compare
     *
     * @return  bool
     */
    public static function is_compatible()
    {
        if( version_compare( $GLOBALS['wp_version'], constant( 'WP_PELAGIOS_VERSION_WP' ), '<' ) )
            return false;

        return true;
    }
    /**
     * Admin notice
     *
     * @return  void
     */
    public function admin_notices()
    {
        printf( '<div class="error" id="message"><p><strong>%s</strong></p></div>', sprintf( __( 'The Pelagios Widgets for WordPress plugin requires WordPress %s or higher. The plugin had been deactivated.', 'wp_pelagios' ), $this->version_wp ) );
    }
    /**
     * Admin plugin settings link
     *
     * @param   array   $links
     * @return  array
     */
    public function plugin_action_links( $links )
    { 
        array_unshift( $links, sprintf( '<a href="admin.php?page=wp-pelagios-settings">%s</a>', __( 'Settings', 'wp_pelagios' ) ) );

        return $links; 
    }
    /**
     * Admin plugin row meta
     *
     * @param   array   $links
     * @param   string  $file
     * @return  array
     */
    public function plugin_row_meta( $links, $file )
    {
        if( $file == plugin_basename( __FILE__ ) )
            return array_merge( $links, array(
                 sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'https://wordpress.org/support/plugin/pelagios-widgets-for-wordpress' ), __( 'Support', 'wp_pelagios' ) )
                ,sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'https://github.com/diggy/wp-pelagios' ), __( 'Repository', 'wp_pelagios' ) )
            ) );

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
 * @param   string  $var    variable
 * @return  string          sanitized variable
 */
function wp_pelagios_clean( $var )
{
    return sanitize_text_field( $var );
}

/* end of file wp-pelagios.php */
