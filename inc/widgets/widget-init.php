<?php

/**
 * Widgets init
 * 
 * Initialize widget(s).
 *
 * @package		Pelagios Widgets for WordPress
 * @category	Widgets
 * @author		Peter J. Herrel
 */

include_once( 'widget-pelagios-search.php' );

function wp_pelagios_register_widgets()
{
	register_widget( 'Wp_Pelagios_Search_Widget' );
}
add_action( 'widgets_init', 'wp_pelagios_register_widgets' );