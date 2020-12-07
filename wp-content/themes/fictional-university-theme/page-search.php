<?php

get_header();

while ( have_posts() ) {
	the_post();
	get_template_part( 'template-parts/page-banner' );

	echo '<div class="container container--narrow page-section">';
	echo '<div class="generic-content">';
	get_search_form();
	echo '</div>';
	echo '</div>';
}

get_footer();

