<?php
/**
 * Admin Usage Page
 *
 * @package: Pelagios Widgets for WordPress
 *
 * @updated: 2014-10-20
 */
function wp_pelagios_settings_usage_page()
{
	global $wp_pelagios;
	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_style( 'jquery-ui-custom', $wp_pelagios->plugin_dir_url . 'inc/assets/css/admin/jquery-ui.custom' . $min . '.css', array(), '1.8.16' );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-accordion' );
?>
<div id="accordion" style="margin-top:15px;">
	<h3 class="acc" aria-expanded="true"><a href="#"><?php _e( 'Pelagios Widgets', 'wp_pelagios' ); ?></a></h3>
	<div>
		<img src="<?php echo $wp_pelagios->plugin_dir_url; ?>inc/assets/images/logo.png" alt="image" title="Pelagios" class="alignright" style="width:200px;margin:15px;"/>
		<p><?php _e( 'The Pelagios widgets are widgets that you can embed on a web page to display relationships between places and items in ancient history collections. The information displayed originates from museums, research institutes, universities and projects that are part of Pelagios, and includes details about these items and maps showing associated locations.', 'wp_pelagios' ); ?></p>
	</div>
	<h3 class="acc"><a href="#"><?php _e( 'Pelagios Search', 'wp_pelagios' ); ?></a></h3>
	<div>
		<p><?php _e( 'The Pelagios Search widget allows you and your site visitors to search for a particular place. It displays all the matches in the Pleiades gazetteer on a map and as a list. You can then view the Pelagios information associated with each of the places in these search results.', 'wp_pelagios' ); ?></p>
		<p><?php echo sprintf(	__( 'Visit the next tab for a real life <a href="%s">example</a>.', 'wp_pelagios' ), esc_url( admin_url() . 'options-general.php?page=wp-pelagios-settings&tab=examples' ) ); ?></p>
		<h4><?php _e( 'Widget Implementation', 'wp_pelagios' ); ?></h4>
		<p><?php _e( 'There are several ways to include the search widget in your website:', 'wp_pelagios' ); ?></p>
		<ol style="margin-left: 20px;">
			<li><?php _e( 'Prepend the widget to the post content automatically.', 'wp_pelagios' ); ?></li>
			<li><?php _e( 'Append the widget to the post content automatically.', 'wp_pelagios' ); ?></li>
			<li><?php _e( 'Display the widget with a shortcode (in posts and pages):', 'wp_pelagios' ); ?> <code>[pelagios_search]</code></li>
			<li><?php _e( 'Display the widget with a shortcode (in your template files):', 'wp_pelagios' ); ?> <code>&lt;?php echo do_shortcode( '[pelagios_search]' ); ?&gt;</code></li>
			<li><?php _e( 'Display the widget with a WordPress widget.', 'wp_pelagios' ); ?></li>
			<li><?php _e( 'Display the widget with a template tag:', 'wp_pelagios' ); ?><br /><p><code>&lt;?php if( function_exists( 'wp_pelagios_search_widget' ) ) echo wp_pelagios_search_widget(); ?&gt;</code></p></li>
		</ol>
		<p><?php echo sprintf(	__( 'Visit the <a href="%s">settings tab</a> to choose an implementation method.', 'wp_pelagios' ), esc_url( admin_url() . 'options-general.php?page=wp-pelagios-settings&tab=settings' ) ); ?></p>
	</div>
	<h3 class="acc"><a href="#"><?php _e( 'Pelagios Places', 'wp_pelagios' ); ?></a></h3>
	<div>
		<p><?php _e( 'A Pelagios Place Widget takes the form of an icon, which when clicked, pops up information about a place. This includes a map and images associated with the place, as well as data drawn from Pelagios partners. It can be used on web pages where a particular place is mentioned to allow users of the page to view the Pelagios information associated with the place.', 'wp_pelagios' ); ?></p>
		<div id="accordion_inside">
		<h3 class="acc" aria-expanded="false"><a href="#"><?php _e( 'Shortcode', 'wp_pelagios' ); ?></a></h4>
		<div>
		<p><?php _e( 'Pelagios Place widgets can be inserted in your post content with shortcodes. A Pelagios shortcode will automatically generate the required HTML markup for the Pelagios script, e.g.:', 'wp_pelagios' ); ?></p>
		<p style="margin-left: 20px;"><code>[pelagios id="PLEIADES_ID"]</code></p>
		will be rendered as:
		<p style="margin-left: 20px;"><code>&lt;span id="WIDGET_ID" data-pleiades_id="PLEIADES_ID" class="pelagios pelagios-place" data-display_map="" data-icon="" data-mouseover=""&gt;&lt;/span&gt;</code></p>
		<p><?php echo sprintf(	__( 'Visit the next tab for a real life <a href="%s">example</a>. See the section "Shortcode Parameters" below on how to retrieve the Pleiades ID for a place.', 'wp_pelagios' ), esc_url( admin_url() . 'options-general.php?page=wp-pelagios-settings&tab=examples' ) ); ?></p>
		</div>
		<h3 class="acc"><a href="#"><?php _e( 'Shortcode Parameters', 'wp_pelagios' ); ?></a></h4>
		<div style="border-color:transparent">
		<p><?php echo sprintf(	__( 'Seven shortcode parameters can be configured. In most cases a valid Pleiades <code>$id</code> will suffice. Setting optional parameters in a shortcode means you will override the default settings configured on the <a href="%s">settings page</a>.', 'wp_pelagios' ), esc_url( admin_url() . 'options-general.php?page=wp-pelagios-settings&tab=settings' ) ); ?></p>
		<table class="widefat">
		  <thead>
		    <tr>
		      <th><?php _e( 'Parameter', 'wp_pelagios' ); ?></th>
		      <th><?php _e( 'Required', 'wp_pelagios' ); ?></th>
		      <th><?php _e( 'Description', 'wp_pelagios' ); ?></th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <td><code>$widget_id</code></td>
		      <td><em><?php _e( 'optional', 'wp_pelagios' ); ?></em></td>
		      <td>
		      	<p><?php _e( 'Every widget needs an ID, a unique alphanumeric string not clashing with the id of any other html element on your page. If you want to embed more than one widget on a page each widget must have a different ID.', 'wp_pelagios' ); ?></p>
		      	<p><?php _e( 'If you do not specify a value for this parameter (recommended), a random widget ID will be generated.', 'wp_pelagios' ); ?></p>
		      </td>
		    </tr>
		    <tr>
		      <td><code>$id</code></td>
		      <td><em><?php _e( 'required', 'wp_pelagios' ); ?></em></td>
		      <td>
		      	<p><?php _e( 'Find the place on the Pleiades website and look at the URL of the page for the place to get the Pleiades ID.', 'wp_pelagios' ); ?></p>
		      	<p><?php _e( 'Example: if the URL is <code>http://pleiades.stoa.org/places/579885/</code> or <code>http://pleiades.stoa.org/places/579885/?searchterm=Athens*</code> then the Pleiades ID is <code>579885</code>.', 'wp_pelagios' ); ?></p>
		      </td>
		    </tr>
		    <tr>
		      <td><code>$map</code></td>
		      <td><em><?php _e( 'optional', 'wp_pelagios' ); ?></em></td>
		      <td>
		      	<?php _e( 'To not display any maps in the widget, add <code>map="false"</code> to the shortcode. Defaults to <code>true</code>.', 'wp_pelagios' ); ?>
		      </td>
		    </tr>
		    <tr>
		      <td><code>$icon</code></td>
		      <td><em><?php _e( 'optional', 'wp_pelagios' ); ?></em></td>
		      <td>
		      	<?php _e( 'To display the expanded widget inline rather than as an icon and pop-up, add <code>icon="false"</code> to the shortcode. Defaults to <code>true</code>.', 'wp_pelagios' ); ?>
		      </td>
		    </tr>
		    <tr>
		      <td><code>$mouseover</code></td>
    		  <td><em><?php _e( 'optional', 'wp_pelagios' ); ?></em></td>
		      <td>
    		  	<?php _e( 'To display the widget on mouseover of the icon, rather than on click, add <code>mouseover="true"</code> to the shortcode. Defaults to <code>false</code>.', 'wp_pelagios' ); ?>
		      </td>
    		</tr>
		    <tr>
		      <td><code>$class</code></td>
		      <td><em><?php _e( 'optional', 'wp_pelagios' ); ?></em></td>
		      <td>
		      	<?php _e( 'The HTML classes applied. Defaults to <code>pelagios pelagios-place</code>. Extra classes can be added by adding e.g. <code>class="my-class another-class"</code> to the shortcode.', 'wp_pelagios' ); ?>
		      </td>
		    </tr>
		    <tr>
		      <td><code>$wrap</code></td>
		      <td><em><?php _e( 'optional', 'wp_pelagios' ); ?></em></td>
		      <td>
		      	<?php _e( 'The HTML tag used to wrap the widget, <code>span</code> for inline widgets (default), or <code>div</code> for expanded widgets.', 'wp_pelagios' ); ?>
		      </td>
		    </tr>
		  </tbody>
		</table>
		</div>
		<h3 class="acc"><a href="#"><?php _e( 'Shortcode Buttons', 'wp_pelagios' ); ?></a></h4>
		<div>
		<p><img src="<?php echo $wp_pelagios->plugin_dir_url; ?>inc/assets/images/wp_pelagios_icon.png" alt="button" title="button" class="alignright" style="width:24px;margin-right:11px;"/><?php _e( 'You can easily insert new Pelagios widgets in your post or page content via the tinyMCE shortcode button added to the visual editor.', 'wp_pelagios' ); ?></p>
		<p><?php _e( 'Alternatively, you can insert shortcodes with the quicktag button added to the HTML editor.', 'wp_pelagios' ); ?></p>
		<p><?php echo sprintf(	__( 'Visit the <a href="%s">settings tab</a> to enable or disable editor buttons functionality.', 'wp_pelagios' ), esc_url( admin_url() . 'options-general.php?page=wp-pelagios-settings&tab=settings' ) ); ?></p>
		</div>
		<h3 class="acc"><a href="#"><?php _e( 'Advanced', 'wp_pelagios' ); ?></a></h4>
		<div>
		<p><?php _e( 'Pelagios Place widgets can be inserted directly in your template files using following code:', 'wp_pelagios' ); ?></p>
		<p><code>&lt;?php echo do_shortcode( '[pelagios widget_id="MY_UNIQUE_WIDGET_ID" id="PLEIADES_ID"]' ); ?&gt;</code></p>
		</div>
		</div>
	</div>
	<?php /* <h3 class="acc"><a href="#"><?php _e( 'Custom Styles', 'wp_pelagios' ); ?></a></h3>
	<div>
		<p><?php _e( 'To override the default styles that ship with Pelagios Widgets:', 'wp_pelagios' ); ?></p>
		<ul style="margin-left: 20px;">
			<li>- <?php echo sprintf(	__( 'Make a copy of the <code>pelagios-sample.css</code> file located <a href="%s">here</a>.', 'wp_pelagios' ), $wp_pelagios->plugin_dir_url . 'inc/assets/css/pelagios-sample.css' ); ?></li>
			<li>- <?php _e( 'Rename the copy to <code>pelagios.css</code>.', 'wp_pelagios' ); ?></li>
			<li>- <?php _e( 'Move the <code>pelagios.css</code> file to the stylesheet directory of your WordPress theme, e.g. <code>http://mysite.com/wp-content/themes/twentyeleven/pelagios.css</code>.', 'wp_pelagios' ); ?></li>
		</ul>
	</div> */ ?>
	<h3 class="acc"><a href="#"><?php _e( 'Troubleshooting', 'wp_pelagios' ); ?></a></h3>
	<div>
		<h4><?php _e( 'Common problems', 'wp_pelagios' ); ?></h4>
		<h5><?php _e( 'GOOGLE MAPS ERRORS', 'wp_pelagios' ); ?></h5>
		<?php _e( 'These can happen if you are using Google Maps v2 on your page. This conflicts with Google Maps v3 which is used by the widget. To get round this, only run the Pelagios script after Google Maps v2 has finished loading. The Pelagios script should then detect that Google Maps v2 is already been used on the page and not load Google Maps v3 and not display the map. If you use Google Loader, you can set a callback for when Google Maps has finished loading.', 'wp_pelagios' ); ?>
		<h5><?php _e( 'AWLD.JS', 'wp_pelagios' ); ?></h5>
		<?php echo sprintf( __( 'There is an unresolved issue at the moment with using Pelagios Widgets in combination with awld.js, related to the fact that both use require.js but different versions of it (see <a href="%s" target="_blank">this ticket</a> on Github).', 'wp_pelagios' ), esc_url( 'https://github.com/pelagios/pelagios-widgets/issues/104' ) ); ?></p>
		<h4><?php _e( 'Find support', 'wp_pelagios' ); ?></h4>
		<p><?php echo sprintf( __( 'If you have any issues with the Pelagios widgets, please contact %s (%s) or raise an issue on <a href="%s" target="_blank">Github</a>.', 'wp_pelagios' ), 'Juliette Culver', 'j.culver@open.ac.uk', esc_url( 'https://github.com/pelagios/pelagios-widgets/issues' ) ); ?></p>
		<p><?php echo sprintf( __( 'If you have any issues with the WordPress plugin, please raise an issue on the WordPress <a href="%s" target="_blank">support forums</a>.', 'wp_pelagios' ), esc_url( 'http://wordpress.org/support/plugin/pelagios-widgets-for-wordpress' ) ); ?></p>
	</div>
</div>
<script>
jQuery(function($){$( "#accordion,#accordion_inside" ).accordion({heightStyle:"content"});});
</script>
<?php
}

/* end of file admin-usage.php */
