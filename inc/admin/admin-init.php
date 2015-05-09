<?php
/**
 * WP Pelagios Admin
 * 
 * Main admin file.
 *
 * @author      Peter J. Herrel
 * @category    Admin
 * @package     Pelagios Widgets for WordPress
 */

/**
 * Admin menu
 *
 * @return  void
 */
add_action( 'admin_menu', 'wp_pelagios_admin_menu' );
function wp_pelagios_admin_menu()
{
    add_options_page(
         __( 'Pelagios Widgets', 'wp_pelagios' )
        ,__( 'Pelagios Widgets', 'wp_pelagios' )
        ,'manage_options'
        ,'wp-pelagios-settings'
        ,'wp_pelagios_settings_page'
    );
}

/**
 * Admin settings page
 *
 * @return  void
 */
function wp_pelagios_settings_page()
{
    include_once( 'admin-forms.php' );
    include_once( 'admin-settings.php' );

    wp_pelagios_settings();
}

/**
 * TinyMCE Admin init
 *
 * @return  void
 */
add_action( 'init', 'wp_pelagios_add_mce_button' );
function wp_pelagios_add_mce_button()
{
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
        return;

    if ( ! ( get_user_option( 'rich_editing' ) == 'true' && get_option( 'wp_pelagios_button' ) == 'yes' ) )
        return;

    add_action( 'admin_head',           'wp_pelagios_admin_head' );

    add_filter( 'mce_external_plugins', 'wp_pelagios_mce_external_plugins' );
    add_filter( 'mce_buttons',          'wp_pelagios_mce_buttons' );
}

/**
 * Admin CSS
 *
 * @return  void
 */
function wp_pelagios_admin_head()
{
    echo '<style type="text/css">i.mce-i-wp-pelagios-mce-button{background-image: url("' . $GLOBALS['wp_pelagios']->plugin_dir_url . 'inc/assets/images/wp_pelagios_icon.png");}</style>' . "\n";
}

/**
 * TinyMCE External Plugins
 *
 * @param   array   $plugin_array   array of external plugins
 * @return  array                   modified array of external plugins
 */
function wp_pelagios_mce_external_plugins( $plugin_array )
{
    $min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    $plugin_array['wp_pelagios_mce_button'] = $GLOBALS['wp_pelagios']->plugin_dir_url . 'inc/assets/js/wp_pelagios_editor_plugin' . $min . '.js';

    return $plugin_array;
}

/**
 * TinyMCE Buttons
 *
 * @param   array   $buttons    array of buttons
 * @return  array               modified array of buttons
 */
function wp_pelagios_mce_buttons( $buttons )
{
    array_push( $buttons, "wp_pelagios_mce_button" );

    return $buttons;
}

/**
 * Add Quicktag to HTML editor
 *
 * Addq custom Quicktag buttons to the editor Wordpress ver. 3.3 and above only
 *
 * Params for this are:
 *
 * - Button HTML ID (required)
 * - Button display, value="" attribute (required)
 * - Opening Tag (required)
 * - Closing Tag (required)
 * - Access key, accesskey="" attribute for the button (optional)
 * - Title, title="" attribute (optional)
 * - Priority/position on bar, 1-9 = first, 11-19 = second, 21-29 = third, etc. (optional)
 *
 * @return  void
 */
add_action( 'admin_print_footer_scripts',  '_wp_pelagios_add_quicktags' );
function _wp_pelagios_add_quicktags()
{ 
    if ( get_option( 'wp_pelagios_quicktags' ) != 'yes' || ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
        return;

    global $pagenow;

    if( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) )
        return;
?>
<script type="text/javascript">
QTags.addButton( 'pelagios', 'Pelagios', '[pelagios id=""]', '', '', 'default', '991' );
</script>
<?php
}

/**
 * Update options
 *
 * @return  void
 */
function wp_pelagios_default_options()
{
    global $wp_pelagios_settings;

    include_once( 'admin-settings.php' );

    foreach( $wp_pelagios_settings as $section )
    {
        foreach( $section as $value )
        {
            if ( isset( $value['std'] ) && isset( $value['id'] ) )
                add_option($value['id'], $value['std']);
        }
    }
}

/**
 * Delete options
 *
 * @return  void
 */
function wp_pelagios_delete_options()
{
    global $wp_pelagios_settings;

    include_once( 'admin-settings.php' );

    foreach( $wp_pelagios_settings as $section )
    {
        foreach( $section as $value )
        {
            if( isset( $value['id'] ) )
                delete_option( $value['id'] );
        }
    }
}

/* end of file admin-init.php */
