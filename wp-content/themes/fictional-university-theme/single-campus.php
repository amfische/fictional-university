<?php /** @noinspection PhpUnhandledExceptionInspection */
get_header();
while( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-banner' );
	?>

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'campus' ) ?>">
          <i class="fa fa-home" aria-hidden="true"></i> All Campuses
        </a>
        <span class="metabox__main"><?php the_title() ?></span>
      </p>
    </div>
    <div class="generic-content"><?php the_content(); ?></div>

    <div class="acf-map">
		<?php $mapLocation = get_field( 'map_location' ); ?>
      <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>" data-lng="<?php echo $mapLocation['lng'] ?>">
        <h3><?php the_title(); ?></h3>
        <span><?php echo $mapLocation['address']; ?></span>
      </div>
    </div>

	  <?php
	  $relatedPrograms = get_field( 'related_programs' );
	  if ( isset( $relatedPrograms ) ) {
		  usort( $relatedPrograms, function( $a, $b ) {
			  return strcmp( $a->post_title, $b->post_title );
		  } );
		  echo "<hr class='section-break'>";
		  echo "<h2 class='headline headline--medium'>Programs available at this Campus</h2>";
		  echo "<ul class='link-list min-list'>";

		  foreach ( $relatedPrograms as $program ) {
			  echo "<li><a href='" . get_the_permalink( $program->ID ) . "'>" . get_the_title( $program->ID ) . "</a></li>";
		  }
		  echo "</ul>";
	  }
	  ?>
  </div>

<?php
endwhile;
get_footer();
?>
