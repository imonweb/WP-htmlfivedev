<?php 
/*  Collection of Walker Class */

class Walker_Nav_Primary extends Walker_Nav_menu {
  function start_lvl( &$output, $depth ) {
    $indent = str_repeat("\t", $depth);
    $submenu = ($depth > 0) ? ' sub-menu' : '';
    $output .= "\n$indent<ul class=\"dropdown-menu$submenu depth_$depth\">\n";
  }

  function start_el( &$output, $item, $depth=0, $args = array(), $id = 0) {
    $indent = str_repeat("\t", $depth);
    
    $li_attributes = '';
    $class_names = $value = '';

    $classes = empty($item->classes) ? array() : (array)  $item->classes;

    $classes[] = ($args->walker->has_children) ? 'dropdown' : '';
    $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
    $classes[] = 'menu-item-' . $item->ID;
    if($depth && $args->walker->has_children) {
      $classes[] = 'dropdown-submenu';
    }

    $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter( $classes ), $item, $args ) );
    $class_names = ' class="' . esc_attr($class_names) . ' "';

    $id = apply_filters('nav_menu_id', 'menu-item-' .$item->ID, $item, $args);
    $id = strlen($id) ? ' id="'. esc_attr($id) .'"' : '';

    $output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

    $attributes = ! empty($item->attr_title) ? ' title="' . esc_att($item->attr_title) . '"' : '';
    $attributes = ! empty($item->target) ? ' target="' . esc_att($item->target) . '"' : '';
    $attributes = ! empty($item->xfn) ? ' rel="' . esc_att($item->xfn) . '"' : '';
    $attributes = ! empty($item->url) ? ' href="' . esc_att($item->url) . '"' : '';

    $attributes = ! empty($args->walker->has_children) ? ' class="dropdown-toggle" data-toggle="dropdonw"' : '';

    $item_output = $args->before;
    $item_output .='<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
    $item_output .= ( $depth == 0 && $args->walker->has_children) ? ' <b class="caret"></b></a>' : '</a>';
    $item_output .= $args->after;

    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);


  }

  // function end_el() {

  // }

  // function end_lvl() {

  // }
}