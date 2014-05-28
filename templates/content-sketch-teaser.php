<article <?php post_class('mix'); ?>>
    <div class="sq-overlay-container">
        <a href="<?php the_permalink(); ?>"><?php carawebs_home_featured_image('medium'); ?></a>
        <div class="sq-overlay-wrapper"><!--allows a darkened background for legibility -->
            <header>
                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                <div style="font-size: 14px;"><?php get_template_part('templates/entry-meta'); ?></div>
            </header>
                <div class="sq-overlay-excerpt"><!-- allows overlay to be styled & positioned -->
                <p><?php //carawebs_custom_excerpt(); ?></p>
            </div>
        </div>
    </div>             
</article>
