<?php
get_header();
get_template_part('template-parts/page-banner', null, [
  'title'    => 'All Programs',
  'subtitle' => 'See what Fictional University has to offer.'
]);
?>

<div class="container container--narrow page-section">
  <ul class="link-list min-list">
    <?php if(have_posts()) :
    while(have_posts()) : the_post(); ?>
      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
    <?php endwhile;
    echo paginate_links(); ?>
  </ul>
  <?php else : ?>
    <p>Sorry, no results found.</p>
  <?php endif; ?>
</div>

<?php get_footer(); ?>
