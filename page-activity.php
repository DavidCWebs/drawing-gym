<?php
/*
Template Name: Custom Lockdown
*/
?>
<?php get_template_part('templates/page', 'header'); ?>
<h1>LOCKDOWN TEMPLATE</h1>
<?php if (is_user_logged_in()) :?>
<?php get_template_part('templates/content', 'lockdown-page'); ?>
<?php endif; ?>
