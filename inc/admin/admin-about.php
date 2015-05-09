<?php

/**
 * Admin About Page
 *
 * @package: Pelagios Widgets for WordPress
 *
 * @updated: 20 oct 2014
 */
if ( ! function_exists( 'wp_pelagios_settings_about_page' ) )
{
function wp_pelagios_settings_about_page()
{
    global $wp_pelagios;
    $v = $wp_pelagios->version;
?>
<style>
.wp-awld-js-welcome-panel{line-height:20px}.wp-badge{float:left;clear:left;margin:0 10px}.welcome-panel-column p{padding: 0 20px 0 0}.bottomline{text-align:center;color:#888}
</style>
	<div id="welcome-panel" class="welcome-panel wp-pelagios-welcome-panel" style="border-top:0;">
	<div class="wp-badge"><?php printf( __( 'Plugin v. %s', 'wp_pelagios' ), $v ); ?></div>

	<div class="welcome-panel-content">
	<h3><?php _e( 'Pelagios Widgets for WordPress', 'wp_pelagios' ); ?></h3>
	<p class="about-description"><?php _e( 'The Pelagios widgets are small embeddable Javascript applications that you can put on your website to allow users of your site to access ancient history data from Pelagios partners.', 'wp_pelagios' ); ?></p>
	<div class="welcome-panel-column-container">
	<div class="welcome-panel-column">
		<h4><?php _e( 'About Pelagios Widgets', 'wp_pelagios' ); ?></h4>
		<p><?php _e( 'The Pelagios widgets are widgets that you can embed on a web page to display relationships between places and items in ancient history collections.', 'wp_pelagios' ); ?></p>
		<p><?php _e( 'There are two widgets, one to display information about places you mention on your site, the other allows people to search for information related to places.', 'wp_pelagios' ); ?></p>
		<p><?php _e( 'The information displayed originates from museums, research institutes, universities and projects that are part of Pelagios, and includes details about these items and maps showing associated locations.', 'wp_pelagios' ); ?></p>
		<h4><?php _e( 'Links and resources', 'wp_pelagios' ); ?></h4>
		<ul>
		<li><?php echo sprintf(	__( 'Pelagios <a href="%s" target="_blank">news</a>', 'wp_pelagios' ), esc_url( 'http://pelagios-project.blogspot.co.uk/' ) ); ?></li>
		<li><?php echo sprintf(	__( 'Pelagios Widgets <a href="%s" target="_blank">demo</a>', 'wp_pelagios' ), esc_url( 'http://pelagios.github.io/pelagios-widgets/demo/index.html' ) ); ?></li>
		<li><?php echo sprintf(	__( 'Pelagios Widgets <a href="%s" target="_blank">docs</a>', 'wp_pelagios' ), esc_url( 'http://pelagios.github.io/pelagios-widgets/docs/index.html' ) ); ?></li>
		<li><?php echo sprintf(	__( 'Pelagios Widgets code repository on <a href="%s" target="_blank">Github</a>', 'wp_pelagios' ), esc_url( 'https://github.com/pelagios/pelagios-widgets' ) ); ?></li>		
		</ul>
	</div>
	<div class="welcome-panel-column">
		<h4><?php _e( 'Credits', 'wp_pelagios' ); ?></h4>
		<p><?php _e( 'The Pelagios Widgets were developed by the Institute of Educational Technology at The Open University as part of the Pelagios 2 project funded by JISC.', 'wp_pelagios' ); ?></p>
		<h4><?php _e( 'Copyright', 'wp_pelagios' ); ?></h4>
		<p><?php _e( 'Pelagios Widgets &copy; 2012, the Institute of Educational Technology. All rights reserved.', 'wp_pelagios' ); ?></p>
		<p><?php printf( __( 'WordPress plugin &copy; 2012-%s, Peter J. Herrel.', 'wp_pelagios' ), date( 'Y' ) ); ?></p>
		<h4><?php _e( 'License', 'wp_pelagios' ); ?></h4>
		<p><?php echo sprintf(	__( 'Pelagios Widgets is released under GNU Public Licence v3; see <a href="%s" target="_blank">LICENSE.txt</a> for more infomation.', 'wp_pelagios' ), esc_url( 'https://github.com/pelagios/pelagios-widgets/blob/master/LICENCE.txt' ) ); ?></p>
		<p><?php _e( 'WordPress plugin license: GPLv3.', 'wp_pelagios' ); ?></p>
		<h4><?php _e( 'Disclaimer', 'wp_pelagios' ); ?></h4>
		<p><?php _e( 'Both widgets are currently in beta.', 'wp_pelagios' ); ?></p>
	</div>
	<div class="welcome-panel-column welcome-panel-last">
		<h4><?php _e( 'About this plugin', 'wp_pelagios' ); ?></h4>
		<p><?php _e( 'The <em>Pelagios Widgets for WordPress</em> plugin was developed by <strong>Peter J. Herrel</strong>', 'wp_pelagios' ); ?></p>
		<p><?php _e( 'The author has no affiliations with the Institute of Educational Technology.', 'wp_pelagios' ); ?></p>
		<p><?php echo sprintf( __( 'If you appreciate his work, feel free to <a href="%1s">rate</a> the plugin on WordPress.org, or buy him a <a href="%2s" target="_blank">cup of coffee</a>.', 'wp_pelagios' ), esc_url( 'https://wordpress.org/support/view/plugin-reviews/pelagios-widgets-for-wordpress' ), esc_url( 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WAY79HJWYKPQE' ) ); ?></p>
		<h4><?php _e( 'Links and resources', 'wp_pelagios' ); ?></h4>
		<ul>
		<li><?php echo sprintf(	__( 'Plugin on <a href="%s" target="_blank">WordPress.org</a>', 'wp_pelagios' ), esc_url( 'https://wordpress.org/plugins/pelagios-widgets-for-wordpress/' ) ); ?></li>
		<li><?php echo sprintf(	__( 'Plugin <a href="%s" target="_blank">support forums</a>', 'wp_pelagios' ), esc_url( 'https://wordpress.org/support/plugin/pelagios-widgets-for-wordpress' ) ); ?></li>
		<li><?php echo sprintf(	__( 'Plugin code repository on <a href="%s" target="_blank">Github</a>', 'wp_pelagios' ), esc_url( 'https://github.com/diggy/wp-pelagios' ) ); ?></li>
		</ul>
		<h4><?php _e( 'Other plugins', 'wp_pelagios' ); ?></h4>
		<ul>
		<li><a href="https://wordpress.org/plugins/ancient-world-linked-data-for-wordpress/" target="_blank">Ancient World Linked Data for WordPress</a></li>
		</ul>
	</div>
	</div>
	</div>
	</div>
	<p style="text-align:center;color:#888;"><?php _e( 'Pelagios Partners include: ', 'wp_pelagios' ); ?><a href="http://googleancientplaces.wordpress.com/">Google Ancient Places</a> (Open University, Southampton), <a href="http://lucero-project.info/lb/">LUCERO</a> (The Open University),
<a href="http://pleiades.stoa.org/">Pleiades</a> (Institute for the Study of the Ancient World, NYU), <a href="http://perseus%20digital%20library/">Perseus Digital Library</a> (Tufts), <a href="http://www.arachne.uni-koeln.de/drupal/">Arachne</a> (Cologne), <a href="http://spqr.cerch.kcl.ac.uk/">SPQR</a> (King's College, London), <a href="http://www.ait.ac.at/research-services/research-services-safety-security/digital-memory-engineering/?L=1">Digital Memory Engineering</a> (Austrian Institute of Technology), <a href="http://opencontext.org/">Open Context</a> (UC Berkeley), <a href="http://explore.clarosnet.org/XDB/ASP/clarosHome/">CLAROS</a> (Oxford), <a href="http://ptolemymachine/">PtolemyMachine</a> (Holy Cross), <a href="http://www.reading.ac.uk/Ure/index.php">Ure Museum</a> (Reading), <a href="http://www.fastionline.org/">FastiOnline</a> (AIAC), <a href="http://nomisma.org/">Nomisma</a> (ANS), <a href="http://www.francia.ahlfeldt.se/index.php">Regnum Francorum Online</a>, <a href="http://www.britishmuseum.org/">The British Museum</a>, <a href="http://www.stg.brown.edu/projects/Inscriptions/">Inscriptions of Israel/Palestine</a> (Brown), <a href="http://papyri.info/">Papyri.info</a> (ISAW/NYU), <a href="http://www.ancientportsantiques.com/">Ports Antiques</a>, <a href="http://oracc.museum.upenn.edu/">Oracc</a> (U. Penn.), <a href="http://meketre.org/">Meketre</a> (Vienna), <a href="http://numismatics.org/ocre/">OCRE</a> (ANS/ISAW).</p>
	<?php
}
}

/* end of file admin-about.php */
