<?php  
if ( is_singular('sfwd-courses') ) :    
  dynamic_sidebar('sidebar-courses'); 
else:
  ?><div class="bottom-pad"><?php get_search_form(); ?></div><?php
  dynamic_sidebar('sidebar-primary');
endif;  
?>
<?php dynamic_sidebar('sidebar-secondary'); ?>
