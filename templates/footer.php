<footer class="content-info" role="contentinfo">
  <div class="container">
    <?php dynamic_sidebar('sidebar-footer'); ?>
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
    <!-- Next line for debugging purposes -->
    <div><strong>Current template:</strong> <?php get_current_template( true ); ?></div>
  </div>
</footer>

<?php wp_footer(); ?>
