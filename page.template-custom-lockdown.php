<?php
/*
Template Name: Custom Lockdown
*/
?>
<?php get_template_part('templates/page', 'header'); ?>
<?php if (is_user_logged_in()) :?>
<?php get_template_part('templates/content', 'page'); ?>
<?php endif; ?>
