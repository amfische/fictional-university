<?php
get_header();
get_template_part( 'template-parts/page-banner', null, [
	'title'    => 'All Events',
	'subtitle' => 'See what\'s going on in our world.'
] );
?>

<div class="container container--narrow page-section">
	<?php
	if ( have_posts() ) {
		while( have_posts() ) {
			the_post();
			$date = new DateTime( get_field( 'event_date' ) );
			get_template_part( 'template-parts/content', 'event', [ 'date' => $date ] );
		}
		paginate_links();
	}
	?>
  <hr class="section-break">
  <p>Looking for a recap of past events? <a href="<?php echo site_url( '/past-events' ); ?>">Check out our past events archive</a>.</p>
	<?php
	if ( ! have_posts() ) {
		echo "<p>Sorry, no results found.</p>";
	}
	?>
</div>

<?php get_footer(); ?>
