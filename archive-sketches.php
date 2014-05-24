<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'roots'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

    <button class="filter" data-filter="all">All</button>
    <button class="filter" data-filter=".category-life">Life</button>
    <button class="filter" data-filter=".category-death">Death</button>

<div id="grid" class="grid top-l-pad">
    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('templates/content', 'sketch-teaser'); ?>
    <?php endwhile; ?>
    <div class="gridbreak"></div>
</div>

<?php if ($wp_query->max_num_pages > 1) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
      <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
    </ul>
  </nav>
<?php endif; ?>
