<?php 

function basic_script_enqueue() {
  wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '5.3.3', 'all' );
  wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/style.css', array(), '1.0.0', 'all' );

  wp_enqueue_script('customjs', get_template_directory_uri() . '/js/script.js', array(), '1.0.0', true );

  //put jQuery in the footer
  wp_deregister_script('jquery');
  wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.js', false, '3.7.1', true);
  wp_enqueue_script('jquery');

  wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.bundle.js', array('jquery'), '5.3.3', true);
}

add_action('wp_enqueue_scripts', 'basic_script_enqueue');

/*  Activate Menu */
function basic_theme_setup() {

  add_theme_support('menus');

  // register_nav_menu('primary', 'Primary Header Navigation');
  // register_nav_menu('secondary', 'Footer Navigation');
}

/*  Theme Support Function */
add_action('init', 'basic_theme_setup');

add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');
add_theme_support('html5', array('search-form'));

add_theme_support('post-formats', array('aside', 'image', 'video'));

/*  Sidebar Function */
function basic_widget_setup() {
  
  register_sidebar(
    array(
      'name'          => 'sidebar',
      'id'            => 'sidebar-1',
      'class'         => 'custom',
      'description'   => 'Standard Sidebar',
      'before_widget' => '<aside id="%1$s" class="widget %2$s"',
      'after_widget'  => '</aside>',
      'before_title'  => '<h1 class="widget-title">',
      'after_title'   => '</h1>',
    )
  );
}
add_action('widgets_init', 'basic_widget_setup');


/*  Custom Post Types */
function basic_custom_post_type() {
  $labels = array(
    'show_in_rest'  => true,
    'name'          => 'Portfolio',
    'singular_name' => 'Portfolio',
    'add_new_item'  => 'Add Portfolio Item',
    'all_items'     => 'All Items',
    // 'add_new_item'  => 'Add Item',
    'edit_item'     => 'Edit Item',
    'new_item'      => 'New Item',
    'view_item'     => 'View Item',
    'search_item'   => 'Search Portfolio',
    'not_found'     => 'Not Items Found',
    'not_found_in_trash'  =>  'No items found in trash',
    'parent_item_colon'   =>  'Parent Item'
  );
  $args = array(
    'labels'        =>  $labels,
    'public'        =>  true,
    'has_archive'   =>  true,
    'publicly_queryable'  =>  true,
    'query_var'     =>  true,
    'rewrite'       =>  true,
    'capability_type' =>  'post',
    'hierarchical'    =>  false,
    'supports'       =>  array(
        'title',
        'editor',
        'excerpt',
        'thumbnail',
        'revisions',
    ),
    'taxonomies'    => array('category', 'post_tag'),
    'menu_position' => 5,
    'exclude_from_search' => false
  );
  register_post_type('portfolio', $args);
}
add_action('init', 'basic_custom_post_type');
 
/*  Taxonomies */
Function basic_custom_taxonomies() {
/*  Add new taxonomy hierarchical */
$labels = array(
  'name' => 'Fields',
  'singular_name' => 'Field',
  'search_items' => 'Search Fields',
  'all_items' => 'All Fields',
  'parent_item' => 'Parent Field',
  'parent_item_colon' => 'Parent Field: ',
  'edit_item' => 'Edit Field',
  'update_item' => 'Update Field',
  'add_new_item' => 'Add New Work Field',
  'new_item_name' => 'New Field Name',
  'menu_name' => 'Fields'
);

$args = array(
  'hierarchical'  => true,
  'labels'  => $labels,
  'show_ui' => true,
  'show_admin_column' => true,
  'query_var' => true,
  'rewrite' => array('slug' => 'field')
);

register_taxonomy('field', array('portfolio'), $args);

/*  Add new taxonomy NOT hierarchical */
  register_taxonomy('software', 'portfolio', array(
    'label' => 'Software',
    'rewrite' => array('slug' => 'software'),
    'hierarchical' => false
  ));
}

add_action('init', 'basic_custom_taxonomies');




/*  Walker Class */
// require get_template_directory() . '/inc/walker.php';


/*  Bootstrap Menu */
// require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
 
// register a new menu
register_nav_menu('main-menu', 'Main menu');

// bootstrap 5 wp_nav_menu walker
class bootstrap_5_wp_nav_menu_walker extends Walker_Nav_menu
{
  private $current_item;
  private $dropdown_menu_alignment_values = [
    'dropdown-menu-start',
    'dropdown-menu-end',
    'dropdown-menu-sm-start',
    'dropdown-menu-sm-end',
    'dropdown-menu-md-start',
    'dropdown-menu-md-end',
    'dropdown-menu-lg-start',
    'dropdown-menu-lg-end',
    'dropdown-menu-xl-start',
    'dropdown-menu-xl-end',
    'dropdown-menu-xxl-start',
    'dropdown-menu-xxl-end'
  ];

  function start_lvl(&$output, $depth = 0, $args = null)
  {
    $dropdown_menu_class[] = '';
    foreach($this->current_item->classes as $class) {
      if(in_array($class, $this->dropdown_menu_alignment_values)) {
        $dropdown_menu_class[] = $class;
      }
    }
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu " . esc_attr(implode(" ",$dropdown_menu_class)) . " depth_$depth\">\n";
  }

  function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
  {
    $this->current_item = $item;

    $indent = ($depth) ? str_repeat("\t", $depth) : '';

    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array) $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = 'nav-item';
    $classes[] = 'nav-item-' . $item->ID;
    if ($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-menu dropdown-menu-end';
    }

    $class_names =  join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
    $class_names = ' class="' . esc_attr($class_names) . '"';

    $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
    $id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

    $output .= $indent . '<li ' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

    $active_class = ($item->current || $item->current_item_ancestor || in_array("current_page_parent", $item->classes, true) || in_array("current-post-ancestor", $item->classes, true)) ? 'active' : '';
    $nav_link_class = ( $depth > 0 ) ? 'dropdown-item ' : 'nav-link ';
    $attributes .= ( $args->walker->has_children ) ? ' class="'. $nav_link_class . $active_class . ' dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : ' class="'. $nav_link_class . $active_class . '"';

    $item_output = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}


/*
================================================
   PHP OOP - HTMLFiveDev 
================================================
*/
 
// require get_theme_file_path('/_classes/Test_Oop_Wp.php');
// require get_theme_file_path('/_classes/Utils.php');  
// print_r($url); die;

// require get_theme_file_path('/_autoloader/class-autoloader.php');

/*  Composer Class Loads */
require __DIR__ . '/vendor/autoload.php';

 