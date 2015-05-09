<?php
/**
 * Pelagios Search Widget (WordPress)
 * 
 * @package     Pelagios Widgets for WordPress
 * @category    Widgets
 * @author      Peter J. Herrel
 */

class Wp_Pelagios_Search_Widget extends WP_Widget
{
	/** Variables to setup the widget. */
	var $pelagios_widget_cssclass;
	var $pelagios_widget_description;
	var $pelagios_widget_idbase;
	var $pelagios_widget_name;
	
	/** constructor */
	function Wp_Pelagios_Search_Widget()
	{
		/* Widget variable settings. */
		$this->pelagios_widget_cssclass = 'widget_pelagios';
		$this->pelagios_widget_description = __( 'This allows you to search for a particular place. It displays all the matches in the Pleiades gazetteer on a map and as a list. You can then view the Pelagios information associated with each of the places in these search results. Visit the settings tab for configuration options.', 'wp_pelagios' );
		$this->pelagios_widget_idbase = 'wp_pelagios_search_widget_wrap';
		$this->pelagios_widget_name = __('Pelagios Search', 'wp_pelagios' );
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => $this->pelagios_widget_cssclass, 'description' => $this->pelagios_widget_description );
		
		/* Create the widget. */
		$this->WP_Widget('wp_pelagios_search', $this->pelagios_widget_name, $widget_ops);
	}
	/** @see WP_Widget */
	function widget( $args, $instance )
	{	
		//global $post;
		//if( is_singular() && has_shortcode( $post->post_content, 'pelagios' ) )
		//{
			extract($args);

			$title = $instance['title'];
			$title = apply_filters('widget_title', $title, $instance, $this->id_base);
		
			global $wp_pelagios;
			$wp_pelagios->enqueue( 'search' );
		
			echo $before_widget;
		
			if ($title) echo $before_title . $title . $after_title;
		
			echo '<div id="wp_pelagios_search_widget" class="pelagios pelagios-search"></div>';
		
			echo $after_widget;
		//}
	}
	/** @see WP_Widget->update */
	function update( $new_instance, $old_instance )
	{
		$instance['title'] = strip_tags(stripslashes($new_instance['title']));
		return $instance;
	}
	/** @see WP_Widget->form */
	function form( $instance )
	{
		global $wpdb;
		?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wp_pelagios' ) ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php if (isset ( $instance['title'])) {echo esc_attr( $instance['title'] );} ?>" /></p>
		<?php
	}
} // Wp_Pelagios_Search_Widget

/* end of file widget-pelagios-search.php */
