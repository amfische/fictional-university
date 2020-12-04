<?php
get_header();
while( have_posts() ) :
	the_post();
	get_template_part( 'template-parts/page-banner' );
	?>

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p>
        <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link( 'program' ) ?>">
          <i class="fa fa-home" aria-hidden="true"></i> All Programs
        </a>
        <span class="metabox__main"><?php the_title() ?></span>
      </p>
    </div>
    <div class="generic-content"><?php the_field('main_body_content'); ?></div>

	  <?php
	  $professors = new WP_Query( [
		  'posts_per_page' => - 1,
		  'post_type'      => 'professor',
		  'orderby'        => 'title',
		  'order'          => 'ASC',
		  'meta_query'     => [
			  [
				  'key'     => 'related_programs',
				  'compare' => 'LIKE',
				  'value'   => get_the_ID()
			  ]
		  ]
	  ] );

	  if ( $professors->have_posts() ) : ?>

        <hr class="section-break">
        <h2 class="headline headline--medium"><?php the_title(); ?> Professors</h2>
        <ul class="professor-cards">
			<?php while( $professors->have_posts() ) : $professors->the_post(); ?>
              <li class="professor-card__list-item">
                <a class="professor-card" href="<?php the_permalink(); ?>">
                  <img class="professor-card__image" src="<?php the_post_thumbnail_url( 'professorLandscape' ); ?>">
                  <span class="professor-card__name"><?php the_title(); ?></span>
                </a>
              </li>
			<?php endwhile; ?>
        </ul>
	  <?php
	  endif;

	  wp_reset_postdata();

	  $events = new WP_Query( [
		  'posts_per_page' => 2,
		  'post_type'      => 'event',
		  'meta_key'       => 'event_date',
		  'orderby'        => 'meta_value_num',
		  'order'          => 'ASC',
		  'meta_query'     => [
			  [
				  'key'     => 'event_date',
				  'compare' => '>=',
				  'value'   => date( 'Ymd' ),
				  'type'    => 'numeric'
			  ],
			  [
				  'key'     => 'related_programs',
				  'compare' => 'LIKE',
				  'value'   => get_the_ID()
			  ]
		  ]
	  ] );
	  ?>
	  <?php if ( $events->have_posts() ) : ?>
        <hr class="section-break">
        <h2 class="headline headline--medium">Upcoming <?php the_title(); ?> Events</h2>
		  <?php
		  while( $events->have_posts() ) {
			  $events->the_post();
			  $date = new DateTime( get_field( 'event_date' ) );
			  get_template_part( 'template-parts/content', 'event', [ 'date' => $date ] );
		  }
	  endif;

	  wp_reset_postdata();
	  ?>

    <hr class="section-break">
    <h2 class="headline headline--medium"><?php the_title(); ?> is available at these campuses</h2>

	  <?php
	  $campuses = new WP_Query( [
		  'posts_per_page' => - 1,
		  'post_type'      => 'campus',
		  'orderby'        => 'title',
		  'order'          => 'ASC',
		  'meta_query'     => [
			  [
				  'key'     => 'related_programs',
				  'compare' => 'LIKE',
				  'value'   => get_the_ID()
			  ]
		  ]
	  ] );

	  if ( $campuses->have_posts() ) {
		  echo "<ul class='min-list link-list'>";
		  while( $campuses->have_posts() ) {
			  $campuses->the_post();
			  ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li> <?php
		  }
		  echo "</ul>";
	  } else {
		  echo "<p>Sorry, program is currently not available at any of our campuses.</p>";
	  }
	  ?>


  </div>

<?php
endwhile;
get_footer();
?>
