<?php
get_header();
get_template_part( 'template-parts/page-banner', null, [
	'title'    => 'Our Campuses',
	'subtitle' => 'We have several conveniently located campuses.'
] );
?>

<div class="container container--narrow page-section">
  <div class="acf-map">
	  <?php
	  if ( have_posts() ) :
	  while( have_posts() ) :
		  the_post();
		  $mapLocation = get_field( 'map_location' );
		  ?>
        <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <span><?php echo $mapLocation['address']; ?></span>
        </div>
	  <?php endwhile; ?>
  </div>
	<?php else : ?>
      <p>Sorry, no results found.</p>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
