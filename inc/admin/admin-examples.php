<?php
/**
 * Examples Page
 *
 * @package: Pelagios Widgets for WordPress
 *
 * @updated: 03 jun 2012
 */
if ( ! function_exists( 'wp_pelagios_settings_examples_page' ) )
{
function wp_pelagios_settings_examples_page()
{
	global $wp_pelagios;
	
	// enqueue Pelagios scripts
	$wp_pelagios->enqueue( 'all' );

	// examples array	
	$examples = array(
		array(
			'id' => 'athens_default',
			'title' => array( 'Athens', '', '' ),
			'example' => 'Athens <span id="453668455456" data-pleiades_id="579885" class="pelagios pelagios-place"></span>',
			'code' => array( 'Athens [pelagios id=&#34;579885&#34;]' ),
			'notes' => 'Default (onclick)',
		),
		array(
			'id' => 'athens_mouseover',
			'title' => array( 'Athens', '', '' ),
			'example' => 'Athens <span id="4569547578" data-pleiades_id="579885" class="pelagios pelagios-place" data-mouseover="true"></span>',
			'code' => array( 'Athens [pelagios mouseover=&#34;true&#34; id=&#34;579885&#34;]' ),
			'notes' => 'On mouseover',
		),
		/*array(
			'id' => '',
			'title' => array( '', '', '' ),
			'example' => '',
			'code' => array( '' ),
			'notes' => '',
		),*/
	); // end examples array
	?><br />
<style>.wp-list-table{margin-bottom:15px}p.description{color:#666;}.pelagios .section-header .section-strapline{color:white}.pelagios .section-header h2{text-shadow:none}</style>
<table class="wp-list-table widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" id="feat" class="manage-column column-title" style="max-width:150px;"><span><?php _e( 'Search Widget', 'wp_pelagios' ); ?></span><span class=""></span></th>
			<th scope="col" id="sample" class="manage-column column-title"></th>
			<th scope="col" id="code" class="manage-column column-title"></th>
			<th scope="col" id="notes" class="manage-column column-title"></th>
		</tr>
	</thead>
	<tbody id="wp-pelagios-list">
		<tr valign="top" style="height:300px;">
			<td>
				<p><strong><?php _e( 'Shortcode: ', 'wp_pelagios' ); ?></strong></p>
				<p><input type="text" onclick="jQuery(this).select();" value="[pelagios_search]" /></p>
				<p class="description"><?php _e( 'The width of the search widget is 580px.', 'wp_pelagios' ); ?></p>
			</td>
			<td style="overflow:visible;width:600px;"><div id="WIDGET_ID_6845" class="pelagios pelagios-search"></div></td>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
<table class="wp-list-table widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" id="feat" class="manage-column column-title" style="max-width:150px;"><span><?php _e( 'Place Widgets', 'wp_pelagios' ); ?></span><span class=""></span></th>
			<th scope="col" id="sample" class="manage-column column-title"><span><?php _e( 'Example', 'wp_pelagios' ); ?></span><span class=""></span></th>
			<th scope="col" id="code" class="manage-column column-title"><span><?php _e( 'Code', 'wp_pelagios' ); ?></span><span class=""></span></th>
			<th scope="col" id="notes" class="manage-column column-title"><span><?php _e( 'Notes', 'wp_pelagios' ); ?></span><span class=""></span></th>
		</tr>
	</thead>
	<tbody id="wp-pelagios-list_2">
		<?php
			foreach( $examples as $example ) : 
				$return = '<tr id="' . $example['id'] . '" valign="top">
					<td><p style="font-weight:bold">' . $example['title'][0] . '</p></td>
					<td><p id="' . $example['id'] . '">' . $example['example'] . '</p></td>
					<td>';
				$fields = $example['code'];
				foreach( $fields as $field ) : 
					$return .= '<input type="text" onclick="jQuery(this).select();" value="' . $field . '" />';
				endforeach;
				$return .= '</td>
					<td><p class="description">' . $example['notes'] . '</p></td>
				</tr>';
				echo $return;
			endforeach;
		?>
	</tbody>
</table>
<p class="description" style="text-align:right;"><?php _e( 'Last updated:', 'wp_pelagios' ); ?> 05 Aug 2012</p>
<?php
}
}