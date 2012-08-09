<?php
/**
 * Functions for the admin options page.
 * 
 * The options page contains settings for the Pelagios Widgets for WordPress plugin
 * This file contains functions to display and save the list of options.
 *
 * @author 		Peter J. Herrel
 * @category 	Admin
 * @package 	Pelagios Widgets for WordPress
 */

/**
 * Define options
 */
global $wp_pelagios_settings;

$wp_pelagios_settings['settings'] = apply_filters( 'wp_pelagios_general_settings', array(
	/**
	 * SEARCH WIDGET
	 */
	array( 'name' 	=> __( 'Pelagios Search', 'wp_pelagios' ), 'type' => 'title', 'desc' => '', 'id' => 'settings-search-widget' ),
	array(  
		'name' 		=> __( 'Implementation', 'wp_pelagios' ),
		'desc' 		=> __( 'Please choose how would you like to implement the search widget.', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_search_widget_implement',
		'css' 		=> 'min-width:160px;',
		'std' 		=> 'none',
		'type' 		=> 'select',
		'options' 	=> array( 
			'none'  		=> __( 'No Widget', 'wp_pelagios' ),
			'prepend'		=> __( 'Prepend to post content', 'wp_pelagios' ),
			'append'		=> __( 'Append to post content', 'wp_pelagios' ),
			'widget'		=> __( 'WordPress widget', 'wp_pelagios' ),
			'shortcode'		=> __( 'Shortcode', 'wp_pelagios' ),
			'tag'			=> __( 'Template tag', 'wp_pelagios' )
		)
	),
	array(  
		'name' 		=> __( 'Maps', 'wp_pelagios' ),
		'desc' 		=> __( 'Display maps in the widget', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_search_widget_maps',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox'
	),	
	array( 'type' => 'sectionend', 'id' => 'settings-search-widget'),
	/**
	 * PLACE WIDGETS
	 */
	array( 'name' => __( 'Pelagios Places', 'wp_pelagios' ), 'type' => 'title', 'desc' => '', 'id' => 'settings-pelagios-links' ),
	array(  
		'name' 		=> __( 'Default Settings', 'wp_pelagios' ),
		'desc' 		=> __( 'Display maps in the widget', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_place_display_map',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox',
		'checkboxgroup' => 'start'
	),	
	array(  
		'name' 		=> __( 'Display inline', 'wp_pelagios' ),
		'desc' 		=> __( 'Display inline (disable to display the expanded widget inline rather than as an icon and pop-up)', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_place_display_inline',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox',
		'checkboxgroup' => ''
	),	
	array(  
		'name' 		=> __( 'Display on mouseover', 'wp_pelagios' ),
		'desc' 		=> __( 'Display the widget on mouseover of the icon, rather than on click.', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_place_on_mouseover',
		'std' 		=> 'no',
		'type' 		=> 'checkbox',
		'checkboxgroup' => 'end'
	),	
	array( 'type' => 'sectionend', 'id' => 'settings-pelagios-links'),
	/**
	 * WP EDITOR
	 */
	array( 'name' => __( 'WordPress Editor', 'wp_pelagios' ), 'type' => 'title', 'desc' => '', 'id' => 'settings-editor' ),
	array(  
		'name' => __( 'Shortcode Buttons', 'wp_pelagios' ),
		'desc' 		=> __( 'Enable tinyMCE button in the visual editor.', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_button',
		'std' 		=> 'yes',
		'type' 		=> 'checkbox',
		'checkboxgroup'	=> 'start'
	),	
	array(  
		'name' => __( 'Buttons', 'wp_pelagios' ),
		'desc' 		=> __( 'Enable quicktag button in the HTML editor.', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_quicktags',
		'std' 		=> 'no',
		'type' 		=> 'checkbox',
		'checkboxgroup'	=> 'end'
	),	
	array( 'type' => 'sectionend', 'id' => 'settings-editor'),
	/**
	 * ADVANCED
	 */
	array( 'name' => __( 'Advanced', 'wp_pelagios' ), 'type' => 'title', 'desc' => '', 'id' => 'settings-advanced' ),
	array(  
		'name' => __( 'Javascript Source', 'wp_pelagios' ),
		'desc' 		=> __( 'When hosted locally, all Pelagios scripts will be loaded from the plugin folder located on your webserver. If you choose "remote", they will be loaded from the Pelagios Github repository.', 'wp_pelagios' ),
		'id' 		=> 'wp_pelagios_js_source',
		'css' 		=> 'min-width:160px;',
		'std' 		=> 'local',
		'type' 		=> 'select',
		'options' => array( 
			'local'		=> __( 'Local', 'wp_pelagios' ),
			'remote'	=> __( 'Remote', 'wp_pelagios' ),
		)
	),
	array( 'type' => 'sectionend', 'id' => 'settings-advanced'),
)); // End of settings array

/**
 * Options page
 * 
 * Handles the display of the options page.
 */
if ( ! function_exists( 'wp_pelagios_settings' ) )
{
function wp_pelagios_settings()
{
    global $wp_pelagios, $wp_pelagios_settings;

    $current_tab = ( empty( $_GET['tab'] ) ) ? 'about' : urldecode( $_GET['tab'] );

    if ( ! empty( $_POST ) )
    {    
    	if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wp-pelagios-settings' ) ) 
    		die( __( 'Something went wrong. Please refresh the page and retry.', 'wp_pelagios' ) );    	
 	
 		switch ( $current_tab ) {
			case "about" :
			case "usage" :
			case "examples" :
			
			break;
			case "settings" :
				wp_pelagios_update_options( $wp_pelagios_settings[$current_tab] );
			break;
		}

		do_action( 'wp_pelagios_update_options' );
		do_action( 'wp_pelagios_update_options_' . $current_tab );				

		$redirect = add_query_arg( 'saved', 'true' );		
		//wp_safe_redirect( $redirect );
		echo "<meta http-equiv='refresh' content='0;url=$redirect' />";
		exit;
	}	
	if ( ! empty( $_GET['saved'] ) ) {		
		echo '<div id="message" class="updated fade"><p><strong>' . __( 'Your settings have been saved.', 'wp_pelagios' ) . '</strong></p></div>';
        do_action('wp_pelagios_settings_saved');
    }
	if ( isset( $_GET['activated'] ) && $_GET['activated'] === '1' ) {		
		global $current_user;
		echo '<div id="message" class="updated fade"><p><strong>' . sprintf( __( 'Hello, %s. <em>Pelagios Widgets for WordPress</em> has been successfully installed!', 'wp_pelagios' ), $current_user->display_name ) . '</strong></p></div>';
    }
    ?>
	<div class="wrap wp_pelagios">
		<form method="post" id="mainform" action="">
			<div class="icon32 icon-plugins icon32-wp-pelagios-settings" id="icon-wp-pelagios"><br /></div><h2 class="nav-tab-wrapper wp-pelagios-nav-tab-wrapper">
				<?php
					$tabs = array(
						'about' 	=> __( 'About', 'wp_pelagios' ),
						'usage' 	=> __( 'User Guide', 'wp_pelagios' ),
						'examples' 	=> __( 'Demo', 'wp_pelagios' ),
						'settings' 	=> __( 'Settings', 'wp_pelagios' )
					);					
					$tabs = apply_filters('wp_pelagios_settings_tabs_array', $tabs);					
					foreach ( $tabs as $name => $label ) {
						echo '<a href="' . admin_url( 'admin.php?page=wp-pelagios-settings&tab=' . $name ) . '" class="nav-tab ';
						if( $current_tab == $name ) echo 'nav-tab-active';
						echo '">' . $label . '</a>';
					}					
					do_action( 'wp_pelagios_settings_tabs' ); 
				?>
			</h2>
			<?php wp_nonce_field( 'wp-pelagios-settings', '_wpnonce', true, true ); ?>
			<?php
				switch ( $current_tab ) :
					case "about" :
						include( 'admin-about.php' );
						wp_pelagios_settings_about_page();
					break;
					case "usage" :
						include( 'admin-usage.php' );
						wp_pelagios_settings_usage_page();
					break;
					case "examples" :
						include( 'admin-examples.php' );
						wp_pelagios_settings_examples_page();
					break;
					case "settings" :
						wp_enqueue_script( 'farbtastic' );
						wp_pelagios_admin_fields( $wp_pelagios_settings[$current_tab] );
					break;
					default :
						do_action( 'wp_pelagios_settings_tabs_' . $current_tab );
					break;
				endswitch;
				if( isset( $current_tab ) && $current_tab == 'settings' )
				{ ?><p class="submit">
	        		<input name="save" class="button-primary" type="submit" value="<?php _e( 'Save changes', 'wp_pelagios' ); ?>" />       		
	        	</p><?php 
	        } ?>
		</form>
	</div>
	<script type="text/javascript">
	<?php if( isset( $current_tab ) && $current_tab == 'settings' ) : ?>
	jQuery(window).load(function(){
		// Edit prompt
		jQuery(function(){
			var changed = false;
			jQuery('input, select, checkbox').change(function(){
				changed = true;
			});					
			jQuery('.wp-pelagios-nav-tab-wrapper a').click(function(){
				if (changed) {
					window.onbeforeunload = function() {
					    return '<?php echo __( 'The changes you made will be lost if you navigate away from this page.', 'wp_pelagios' ); ?>';
					}
				} else {
					window.onbeforeunload = '';
				}
			});					
			jQuery('.submit input').click(function(){
				window.onbeforeunload = '';
			});
		});
	});
	<?php endif; ?>
	jQuery(document).ready(function() {
		jQuery('.fade').fadeTo(2500,1).fadeOut(1500);
	});
	</script><?php
}
}