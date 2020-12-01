<?php
get_header();
while (have_posts()) :
  the_post();
  get_template_part('template-parts/page-banner');
  ?>

  <div class="container container--narrow page-section">
    <div class="generic-content">
      <div class="row group">
        <div class="one-third">
          <?php the_post_thumbnail('professorPortrait'); ?>
        </div>
        <div class="two-thirds">
          <span class="like-box" data-id="<?php the_ID(); ?>" data-exists="<?php echo in_array(get_current_user_id(), get_field('user_likes')) ? 'yes' : 'no' ?>">
            <i class="fa fa-heart-o" aria-hidden="true"></i>
            <i class="fa fa-heart" aria-hidden="true"></i>
            <span class="like-count"><?php echo count(get_field('user_likes') ?? []); ?></span>
          </span>
          <?php the_content(); ?>
        </div>
      </div>
    </div>

    <?php
    $relatedPrograms = get_field('related_programs');
    if (!empty($relatedPrograms)):
      ?>
      <hr class="section-break">
      <h2 class="headline headline--medium">Subject(s) Taught</h2>
      <ul class="link-list min-list">
        <?php foreach ($relatedPrograms as $program): ?>
          <li><a href="<?php echo get_the_permalink($program) ?>"><?php echo get_the_title($program); ?></a></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>

<?php
endwhile;
get_footer();
?>
