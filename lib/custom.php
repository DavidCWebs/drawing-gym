<?php
/**
 * Custom functions
 */
 
/*=============================================================

Debugging - output current template
See: http://wordpress.stackexchange.com/questions/10537/get-name-of-the-current-template-file/10565#10565
and: http://wordpress.stackexchange.com/questions/37292/how-do-you-find-out-which-template-page-is-serving-the-current-page

==============================================================*/
add_filter( 'template_include', 'var_template_include', 1000 );
function var_template_include( $t ){
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}

function get_current_template( $echo = true ) {
    if( !isset( $GLOBALS['current_theme_template'] ) )
        return false;
    if( $echo )
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
}

//add_shortcode('template', 'wpse10537_get_template_name()');


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

/*==============================================================
==

Responsive videos, thanks to Matthew Horne: http://diywpblog.com/embed-responsive-videos-with-wordpress/

===============================================================*/

add_filter('embed_oembed_html', 'carawebs_wrap_embed_with_div', 10, 3);

function carawebs_wrap_embed_with_div($html, $url, $attr) {
        return "<div class=\"responsive-container\">".$html."</div>";
}
