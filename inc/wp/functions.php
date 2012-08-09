<?php

/**
 * Front End Functions
 * 
 * General functions file for the front end.
 *
 * @author 		Peter J. Herrel
 * @category 	Functions
 * @package: 	Pelagios Widgets for WordPress
 */

/**
 * Pelagios Shortcode Filter
 *
 * Prevents shortcodes from being executed on archive pages / in manual exerpts
 */
function wp_pelagios_shortcode_output_filter( $return )
{
	if( ! is_singular() && in_the_loop() )
		$return = '';
	return $return;
}
add_filter( 'wp_pelagios_shortcode', 'wp_pelagios_shortcode_output_filter' );

/**
 * Pelagios Search Widget HTML
 */
function wp_pelagios_search_widget_html()
{
	global $wp_pelagios;
	$maps = ( get_option( 'wp_pelagios_search_widget_maps' ) !== 'yes' ) ? 'false' : 'true';
	$html = '<div id="wp_pelagios_search_widget" class="pelagios pelagios-search" data-display_map="' . $maps . '">' . $wp_pelagios->enqueue( 'search' ) . '</div>';
	return apply_filters( 'wp_pelagios_search_widget_html', $html );
}
/**
 * Pelagios Search Widget template tag
 */
function wp_pelagios_search_widget()
{
	if( get_option( 'wp_pelagios_search_widget_implement' ) != 'tag' )
		return '';
	return wp_pelagios_search_widget_html();
}

/**
 * Pelagios Search Widget Content Filter
 */
function wp_pelagios_index_filter( $content )
{
	if( is_singular() && get_option( 'wp_pelagios_search_widget_implement' ) == 'append' )
		return $content . wp_pelagios_search_widget_html();
	if( is_singular() && get_option( 'wp_pelagios_search_widget_implement' ) == 'prepend' )
		return wp_pelagios_search_widget_html() . $content;
	return $content;
}
add_filter( 'the_content', 'wp_pelagios_index_filter', 11, 1 );

/**
 * Conditional tag
 *
 * Checks if a post contains a [pelagios id="..."] shortcode
 *
 * @param: $shortcode (string) 
 */
if ( ! function_exists( 'has_pelagios_shortcode' ) )
{
function has_pelagios_shortcode( $shortcode = '' )
{
	global $post;
	$obj = get_post( $post->ID );
	$found = false;
	if ( ! $shortcode ) return $found;
	if ( stripos( $obj->post_content, '[' . $shortcode ) !== false ) $found = true;
	return $found;
}
}