<?php
/**
 * Custom functions
 */
 
/*==============================================================

Menu adjustment for CPTs - stops "Blog" page being highlighed by means of active class

===============================================================*/

add_filter( 'nav_menu_css_class', 'carawebs_menu_classes', 10, 2 );

function carawebs_menu_classes( $classes , $item ){
	
	if ( is_singular( 'sfwd-courses') || is_singular('sfwd-lessons') || is_archive( 'sfwd-courses' )	) 
	
	{
		
		// remove unwanted active class if it's found
		$classes = str_replace( 'active', '', $classes );
		
		// find the url you want and add the class you want
		if ( is_archive( 'sfwd-courses' ) || get_post_type() == 'sfwd-courses' ) {
			$classes = str_replace( 'menu-courses', 'menu-courses active', $classes );
			//remove_filter( 'nav_menu_css_class', 'namespace_menu_classes', 10, 2 );
		}
	}
	return $classes;
}