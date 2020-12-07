<?php

get_header();
get_template_part(
	'template-parts/page-banner',
	null,
	array(
		'title'    => 'Search Results',
		'subtitle' => 'You searched for &ldquo;' . esc_html( get_search_query() ) . '&rdquo;',
	)
);

echo '<div class="container container--narrow page-section">';

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		if ( get_post_type() === 'event' ) {
			$date = new DateTime( get_field( 'event_date' ) );
			echo "<div class='post-item'>";
			get_template_part( 'template-parts/content', get_post_type(), array( 'date' => $date ) );
			echo '</div>';
		} else {
			get_template_part( 'template-parts/content', get_post_type() );
		}
	}
	echo paginate_links();
} else {
	echo '<h2 class="headline headline--small - plus">No results match that search</h2>';
}

echo "<hr class='section-break'>";

get_search_form();

echo '</div>';

get_footer();
