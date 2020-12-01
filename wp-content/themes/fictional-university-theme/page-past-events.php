<?php
get_header();
get_template_part( 'template-parts/page-banner', null, [
	'title'    => 'Past Events',
	'subtitle' => 'A recap of our past events.'
] );
?>

<div class="container container--narrow page-section">
	<?php
	$pastEvents = new WP_Query( [
		'post_type'  => 'event',
		'paged'      => get_query_var( 'paged', 1 ),
		'meta_key'   => 'event_date',
		'orderby'    => 'meta_value_num',
		'meta_query' => [
			[
				'key'     => 'event_date',
				'compare' => '<',
				'value'   => date( 'Ymd' ),
				'type'    => 'numeric'
			]
		]
	] );
	if ( $pastEvents->have_posts() ) {
		while( $pastEvents->have_posts() ) {
			$pastEvents->the_post();
			$date = new DateTime( get_field( 'event_date' ) );
			get_template_part( 'template-parts/content', 'event', [ 'date' => $date ] );
		}
	  echo paginate_links( [ 'total' => $pastEvents->max_num_pages ] );
	} else {
		echo "<p>Sorry, no results found.</p>";
	}
	?>
</div>

<?php get_footer(); ?>

