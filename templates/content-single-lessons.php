<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <h3>This lesson is from: <?php carawebs_show_taxonomy_terms ('courses'); ?></h3>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content">
      <?php carawebs_home_featured_image('large'); ?>
      <?php the_content(); ?>
      
    <h3>See Other Lessons on this Course</h3>
    <?php carawebs_related_lessons(); ?>    
    </div>
    
    <?php comments_template('/templates/comments.php'); ?>
    <hr>
    <div class="navigation"><?php previous_post('&laquo; %', 'Previous Lesson', 'no'); ?>&nbsp;|&nbsp;<?php next_post('% &raquo;', 'Next Lesson', 'no'); ?></div>
    <hr>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
  </article>
<?php endwhile; ?>
