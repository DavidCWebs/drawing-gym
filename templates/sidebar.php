<?php  
if ( is_singular('sfwd-courses') ) {    
  dynamic_sidebar('sidebar-courses');
}

elseif (is_singular('lessons')) {
  dynamic_sidebar('sidebar-lessons');
}

else {
  dynamic_sidebar('sidebar-primary');
}  

/*============================================
$cpt_id = get_post_type( );
switch ($cpt_id){
    case 'single':
        dynamic_sidebar('sidebar-primary');
    break;
    case 'sfwd-courses':
        dynamic_sidebar('sidebar-courses');
    break;
    case 'sfwd-lessons':
        dynamic_sidebar('sidebar-lessons');
    break;
    default:
        dynamic_sidebar('sidebar-primary');
    break;

}*/


?>