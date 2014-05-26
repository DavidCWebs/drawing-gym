<?php
/**
 * Custom functions
 */
/*========================================

/* Image Cropping

========================================*/
function carawebs_hard_image_crop () {

    // Hard crop medium images - don't forget to regenerate thumbnails
    if (false === get_option ('medium_crop')) {
  
    // Medium images don't have hard crop enabled, enable it.
    add_option ('medium_crop', '1' );

    } else {
  
    // Medium images have hard crop enabled, change it.
    update_option ('medium_crop', '1' );
    
    }
    
    // Hard crop large images
    if (false === get_option ('large_crop')) {
  
    // Medium images don't have hard crop enabled, enable it.
    add_option ('large_crop', '1' );

    } else {
  
    // Medium images have hard crop enabled, change it.
    update_option ('large_crop', '1' );
    
    }

}

add_action ('init', 'carawebs_hard_image_crop' );

/*========================================

/* Featured Image on Archive Page

=========================================*/
/**
* Featured Image function for posts and pages
* 
* @param  string $class The CSS class name to apply to the image default is .img-responsive
* @param  string $size  The image size to use. Default is full size
* @return string        img -> width | height | src | class | alt | title
* 
*/
function carawebs_home_featured_image( $size = 'full', $firstclass ) {
 
     $class = $firstclass . ' img-responsive'; // Ensure that all images are responsive
 
    global $post;
 
    if ( has_post_thumbnail( $post->ID ) ) {
 
    // get the title attribute of the post or page 
    // and apply it to the alt tag of the image if the alt tag is empty
    //
    $attachment_id = get_post_thumbnail_id( $post->ID );
 
    if ( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) === '' ) {
        // if no alt attribute is filled out then echo "Featured Image of article: Article Name"
        $alt = the_title_attribute( 
            array( 
                'before' => __( 'Featured image of article: ', 'YOUR-THEME-TEXTDOMAIN' ), 
                'echo' => false
            ) 
        );
    } else {
        // the post thumbnail img alt tag
        $alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
        // the post thumbnail img title tag
    }
    
    // Get the title attribute for the featured image
    $title = get_the_title($attachment_id);
    
    // Get the Image Caption
    $caption = get_post($attachment_id)->post_excerpt;
 
    $default_attr = array(
        'class' => $class,
        'alt' => $alt,
        'title' => $title
    );
 
    // echo the featured image
    //the_post_thumbnail( $size, $default_attr );
    
    the_post_thumbnail( $size, $default_attr );
    //echo $caption;
 
    }
}

/*==============================================================

Menu adjustment for CPTs - stops "Blog" page being highlighed by means of active class

===============================================================*/

add_filter( 'nav_menu_css_class', 'carawebs_menu_classes', 10, 2 );

function carawebs_menu_classes( $classes , $item ){
	
	if ( is_singular( 'sfwd-courses') || is_singular('sfwd-lessons') || is_singular('sketches') || is_post_type_archive('sfwd-courses') || is_post_type_archive('sketches')	) 
	
	{
		
		// remove unwanted active class if it's found
		$classes = str_replace( 'active', '', $classes );
		
		// find the url you want and add the class you want
		if ( is_post_type_archive('sfwd-courses') || get_post_type() == 'sfwd-courses' )
        {
			$classes = str_replace( 'menu-courses', 'menu-courses active', $classes );
			
		}
		elseif ( is_post_type_archive('sketches') || get_post_type() == 'sketches' )
        {
            $classes = str_replace( 'menu-sketches', 'menu-sketches active', $classes );
        }
	}
	return $classes;
}

/*================================================================

Responsive videos, thanks to Matthew Horne: http://diywpblog.com/embed-responsive-videos-with-wordpress/

===============================================================*/

add_filter('embed_oembed_html', 'carawebs_wrap_embed_with_div', 10, 3);

function carawebs_wrap_embed_with_div($html, $url, $attr) {
        return "<div class=\"responsive-container\">".$html."</div>";
}
