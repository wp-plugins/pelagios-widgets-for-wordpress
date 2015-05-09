<?php
/**
 * Front End Functions
 * 
 * General functions file for the front end.
 *
 * @author      Peter J. Herrel
 * @category    Functions
 * @package     Pelagios Widgets for WordPress
 */

/**
 * Pelagios Shortcode Filter
 *
 * Prevents shortcodes from being executed on archive pages / in manual exerpts
 *
 * @param   string  $return
 * @return  string
 */
add_filter( 'wp_pelagios_shortcode', 'wp_pelagios_shortcode_output_filter' );
function wp_pelagios_shortcode_output_filter( $return )
{
    if( ! is_singular() && in_the_loop() )
        $return = '';

    return $return;
}

/**
 * Pelagios Search Widget HTML
 *
 * @param   int     $width  container width
 * @return  string
 */
function wp_pelagios_search_widget_html( $width = '' )
{
    global $wp_pelagios;

    $maps   = ( 'yes' != get_option( 'wp_pelagios_search_widget_maps' ) ) ? 'false' : 'true';
    $width  = ( is_int( $width ) ) ? ' data-container_width="' . $width . '"' : '';

    $html = '<div id="wp_pelagios_search_widget" class="pelagios pelagios-search" data-display_map="' . $maps . '"' . $width . '></div>';

    $wp_pelagios->enqueue( 'search' );

    return apply_filters( 'wp_pelagios_search_widget_html', $html );
}

/**
 * Pelagios Search Widget template tag
 *
 * @return  string
 */
function wp_pelagios_search_widget( $width = '' )
{
    if( 'tag' != get_option( 'wp_pelagios_search_widget_implement' ) )
        return '';

    return wp_pelagios_search_widget_html( $width );
}

/**
 * Pelagios Search Widget Content Filter
 *
 * @param   string  $content
 * @return  string
 */
add_filter( 'the_content', 'wp_pelagios_index_filter', 11, 1 );
function wp_pelagios_index_filter( $content )
{
    if( is_singular() && 'append' == get_option( 'wp_pelagios_search_widget_implement' ) )
        return $content . wp_pelagios_search_widget_html();

    if( is_singular() && 'prepend' == get_option( 'wp_pelagios_search_widget_implement' ) )
        return wp_pelagios_search_widget_html() . $content;

    return $content;
}

/* end of file functions.php */
