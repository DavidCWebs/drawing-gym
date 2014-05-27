<?php while (have_posts()) : the_post(); ?>
  <?php the_content(); ?>
  <?php
  // WP_Query arguments
    $args = array (
        'post_type'              => 'lessons',
        'tax_query' => array(
		array(
			'taxonomy' => 'courses',
			'field' => 'slug',
			'terms' => 'gensler-custom-course'
		)),
        /*'category_name'          => 'Gensler',*/
        'posts_per_page'         => '10',
        'posts_per_archive_page' => '10',
        'order'                  => 'ASC',
    );

    // The Query
    $lessonquery = new WP_Query( $args );

    // The Loop
    if ( $lessonquery->have_posts() ) {
        while ( $lessonquery->have_posts() ) {
            $lessonquery->the_post();
            
           ?>  <header>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php get_template_part('templates/entry-meta'); ?>
            </header>
            <?php
            
        }
    } else {
        // no posts found
    }

    // Restore original Post Data
    wp_reset_postdata();
    ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
