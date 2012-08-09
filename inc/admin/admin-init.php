<?php
/**
 * Admin
 * 
 * Main admin file.
 *
 * @author 		Peter J. Herrel
 * @category 	Admin
 * @package: Pelagios Widgets for WordPress
 */

/**
 * Admin Menu
 */
function wp_pelagios_admin_menu()
{
	global $menu, $wp_pelagios;	
    $main_page = add_options_page( __( 'Pelagios Widgets', 'wp_pelagios' ), __( 'Pelagios Widgets', 'wp_pelagios' ), 'manage_options', 'wp-pelagios-settings' , 'wp_pelagios_settings_page' );  
}
add_action( 'admin_menu', 'wp_pelagios_admin_menu' );

/**
 * Includes
 */
function wp_pelagios_settings_page()
{
	include_once( 'admin-forms.php' );
	include_once( 'admin-settings.php' );
	wp_pelagios_settings();
}

/**
 * tinyMCE button
 */
function wp_pelagios_add_buttons_wysiwyg_editor( $mce_buttons )
{
    $pos = array_search( 'wp_more', $mce_buttons, true );
    if ( $pos !== false ) {
        $tmp_buttons = array_slice( $mce_buttons, 0, $pos+1 );
        $tmp_buttons[] = 'wp_page';
        $mce_buttons = array_merge( $tmp_buttons, array_slice( $mce_buttons, $pos+1 ) );
    }
    return $mce_buttons;
}
add_filter( 'mce_buttons', 'wp_pelagios_add_buttons_wysiwyg_editor' );

function wp_pelagios_add_shortcode_button()
{
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) return;
	if ( get_user_option( 'rich_editing' ) == 'true' && get_option( 'wp_pelagios_button' ) == 'yes' ) :
		add_filter( 'mce_external_plugins', 'wp_pelagios_add_shortcode_tinymce_plugin' );
		add_filter( 'mce_buttons', 'wp_pelagios_register_shortcode_button' );
	endif;
}
add_action( 'init', 'wp_pelagios_add_shortcode_button' );

function wp_pelagios_register_shortcode_button( $buttons )
{
	array_push($buttons, "|", "wp_pelagios_shortcodes_button" );
	return $buttons;
}

function wp_pelagios_add_shortcode_tinymce_plugin( $plugin_array )
{
	global $wp_pelagios;
	$plugin_array['WpPelagiosShortcodes'] = $wp_pelagios->plugin_dir_url . 'inc/assets/js/wp_pelagios_editor_plugin.js';
	return $plugin_array;
}

function wp_pelagios_refresh_mce( $ver )
{
	$ver += 3;
	return $ver;
}
add_filter( 'tiny_mce_version', 'wp_pelagios_refresh_mce' );

/**
 * Add Quicktag to HTML editor
 **/
if( ! function_exists( '_wp_pelagios_add_quicktags' ) )
{
    function _wp_pelagios_add_quicktags()
    { 
    	if ( get_option( 'wp_pelagios_quicktags' ) != 'yes' || ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) return;
    	global $pagenow;
    	if( 'post.php' == $pagenow || 'post-new.php' == $pagenow ) :
    	?>
        <script type="text/javascript">
        /* Add custom Quicktag buttons to the editor Wordpress ver. 3.3 and above only
         *
         * Params for this are:
         * - Button HTML ID (required)
         * - Button display, value="" attribute (required)
         * - Opening Tag (required)
         * - Closing Tag (required)
         * - Access key, accesskey="" attribute for the button (optional)
         * - Title, title="" attribute (optional)
         * - Priority/position on bar, 1-9 = first, 11-19 = second, 21-29 = third, etc. (optional)
         */
        QTags.addButton( 'pelagios', 'Pelagios', '[pelagios id=""]', '', '', 'default', '991' );
        </script>
    <?php endif;
    }
    add_action( 'admin_print_footer_scripts',  '_wp_pelagios_add_quicktags' );
}

/**
 * Activation
 */
function activate_wp_pelagios()
{
	update_option( 'wp_pelagios_install', 1 );
	install_wp_pelagios();
}

/**
 * Install
 */
function install_wp_pelagios()
{
	global $wp_pelagios;
	wp_pelagios_default_options();
	update_option( "wp_pelagios_db_version", $wp_pelagios->version );
}

/**
 * Update options
 */
function wp_pelagios_default_options()
{
	global $wp_pelagios_settings;
	include_once( 'admin-settings.php' );	
	foreach ( $wp_pelagios_settings as $section ) {	
		foreach ( $section as $value ) {	
	        if ( isset( $value['std'] ) && isset( $value['id'] ) ) {	        		
	       		add_option($value['id'], $value['std']);   
	        }        
        }        
   }
}

/**
 * Redirect after activation
 */
function wp_pelagios_activ_redirect()
{
    if ( get_option( 'wp_pelagios_install' ) == 1 ) :
    	$url = admin_url() . 'options-general.php?page=wp-pelagios-settings&tab=about&activated=1';
    	delete_option( 'wp_pelagios_install' );
    	wp_safe_redirect( $url );
    	exit;
    endif;
}
add_action( 'admin_init', 'wp_pelagios_activ_redirect' );

/**
 * Deactivation
 */
function deactivate_wp_pelagios()
{
	update_option( 'wp_pelagios_uninstall', 1 );
	uninstall_wp_pelagios();
}

/**
 * Uninstall
 */
function uninstall_wp_pelagios()
{
	global $wp_pelagios;
	wp_pelagios_delete_options();
	delete_option( "wp_pelagios_db_version", $wp_pelagios->version );
	delete_option( 'wp_pelagios_uninstall' );
}

/**
 * Delete options
 */
function wp_pelagios_delete_options()
{
	global $wp_pelagios_settings;
	include_once( 'admin-settings.php' );	
	foreach ( $wp_pelagios_settings as $section ) {	
		foreach ( $section as $value ) {	
	        if ( isset( $value['id'] ) ) {	        		
	       		delete_option( $value['id'] );   
	        }        
        }        
    }
}