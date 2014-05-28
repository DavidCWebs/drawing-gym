<?php
/**
 * Custom functions
 */
 
/*
add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'lessons', 'normal');});
add_action('add_meta_boxes', function() { add_meta_box('lesson-parent', 'Course', 'course_attributes_meta_box', 'lessons', 'side', 'high');});
  
    function course_attributes_meta_box($post) {
    
        $post_type_object = get_post_type_object($post->post_type);
        
        if ( $post_type_object->hierarchical ) {
        
        $pages = wp_dropdown_pages(array('post_type' => 'page', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 'sort_column'=> 'menu_order, post_title', 'echo' => 0));
          
          if ( ! empty($pages) ) {
            
            echo $pages;
          } // end empty pages check
        } // end hierarchical check.
      }
*/
/*=====================================*//*
//Add the meta box callback function
/*
add_action('admin_menu', function() { remove_meta_box('pageparentdiv', 'lessons', 'normal');});
add_action('add_meta_boxes', 'lesson_meta');

function lesson_meta(){
    
	add_meta_box('lesson_parent_id', 'Lesson Study Parent ID', 'set_lesson_parent_id', 'lessons', 'side', 'high');

}

//Meta box for setting the parent ID
function set_lesson_parent_id() {
	
	global $post;
	$custom = get_post_custom($post->ID);
	$parent_id = $custom['parent_id'][0];
	
	?>
	<p>Please specify the ID of the page or post to be a parent to this Case Study.</p>
	<p>Leave blank for no heirarchy.  Case studies will appear from the server root with no associated parent page or post.</p>
	<input type="text" id="parent_id" name="parent_id" value="<?php echo $post->post_parent; ?>" />
	<?php
	
	// create a custom nonce for submit verification later
	echo '<input type="hidden" name="parent_id_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}

// Save the meta data
function save_lesson_parent_id($post_id) {
	global $post;

	// make sure data came from our meta box
	if (!wp_verify_nonce($_POST['parent_id_noncename'],__FILE__)) return $post_id;
	if(isset($_POST['parent_id']) && ($_POST['post_type'] == "lessons")) {
	$data = $_POST['parent_id'];
	update_post_meta($post_id, ‘parent_id’, $data);
	}
}

 */
 

/*========================================

/* Carawebs Custom Image for ACF image embed

=========================================*/

function carawebs_custom_image( $field, $class, $size = 'thumbnail' ) {
global $post;
$image = get_field($field);
    
    $thumb = $image['sizes'][ $size ];

    if( !empty($image) ){ ?>

        <img class="img-responsive <?php echo $class; ?>" src="<?php echo $thumb;/*$image['url'];*/ ?>" alt="<?php echo $image['alt']; ?>" title="<?php echo $image['title']; ?>" />

    <?php }

}



/*========================================

/* Display Category

========================================*/
function carawebs_show_taxonomy_terms ($taxonomy = 'category') {
        
        global $post;
        
        // get the term IDs assigned to post.
        $post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
        // separator between links
        $separator = ', ';

        if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

            $term_ids = implode( ',' , $post_terms );
            $terms = wp_list_categories( 'title_li=&style=none&echo=0&taxonomy=' . $taxonomy . '&include=' . $term_ids );
            $terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

            // display post categories
            echo  $terms;
        }
}

function carawebs_course_id ( ) {
    
    foreach((get_the_terms($post->ID, 'courses')) as $term) 
        {
        echo $term->term_id. '';
        }
       
}

/*============================================================

 Related Lessons
 
============================================================*/

function carawebs_related_lessons() {
// get the custom post type's taxonomy terms
    global $post;
    $custom_taxterms = wp_get_object_terms( $post->ID, 'courses', array('fields' => 'ids') );
    // arguments
            $args = array(
                'post_type' => 'lessons',
                'post_status' => 'publish',
                'posts_per_page' => 10,
                'orderby' => 'date',
                'order' => 'ASC',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'courses',
                        'field' => 'id',
                        'terms' => $custom_taxterms
                    )
                ),
                'post__not_in' => array ($post->ID), // Don't retrieve the current post!
            );
    
    $related_items = new WP_Query( $args );
    
    // loop over query
    if ($related_items->have_posts())
    {        
        echo '<ul>';

            while ( $related_items->have_posts() ) : $related_items->the_post();
            ?>
            <li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
            <?php
            endwhile;

        echo '</ul>';
        
    }
    
    // Reset Post Data
    wp_reset_postdata();
    
}

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
	
	if ( is_singular( 'sfwd-courses') || is_singular('lessons') || is_singular('sketches') || is_post_type_archive('lessons') || is_post_type_archive('sketches')	) 
	
	{
		
		// remove unwanted active class if it's found
		$classes = str_replace( 'active', '', $classes );
		
		// find the url you want and add the class you want
		if ( is_post_type_archive('lessons') /*|| get_post_type() == 'lessons'*/ )
        {
			$classes = str_replace( 'menu-lessons', 'menu-lessons active', $classes );
			
		}
		elseif ( is_post_type_archive('sketches') || get_post_type() == 'sketches' )
        {
            $classes = str_replace( 'menu-sketches', 'menu-sketches active', $classes );
        }
	}
	return $classes;
}


/*================================================================

Post Order Archive Pages

================================================================*/
function change_order($orderby, $query) {
    
    global $wpdb;
    if(is_archive())
    $orderby = "{$wpdb->prefix}posts.post_date ASC";
    return $orderby;
}
add_filter('posts_orderby','change_order');


/*================================================================

Responsive videos, thanks to Matthew Horne: http://diywpblog.com/embed-responsive-videos-with-wordpress/

===============================================================*/

add_filter('embed_oembed_html', 'carawebs_wrap_embed_with_div', 10, 3);

function carawebs_wrap_embed_with_div($html, $url, $attr) {
        return "<div class=\"responsive-container\">".$html."</div>";
}
