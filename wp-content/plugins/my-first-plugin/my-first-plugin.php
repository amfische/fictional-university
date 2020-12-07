<?php
/**
 * Plugin Name: My First Plugin
 * Description: This is a pretty cool way to do things!
 * Author: Aaron Fischer
 * Version: 1.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: Text Domain
 * Domain Path: Domain Path
 * Network: false
 */

add_filter( 'the_content', 'content_edits', 10, 1 );

function content_edits( $content ) {
	$content .= '<p>All content belongs to Fictional University.</p>';
	$content  = str_replace( 'Lorem', '*****', $content );
	return $content;
}

add_shortcode( 'programCount', 'get_program_count' );

function get_program_count() {
	$obj = wp_count_posts( 'program', '' );
	return $obj->publish;
}
