<?php 
/*
================================================
   Class Auto Loader 
================================================
*/

spl_autoload_register('class_auto_loader');

function class_auto_loader($class_name)
{
  // var_dump($class_name);
  add_filter('theme_file_path', 'wp_normalize_path');
  /*  Checking for My_ PREFIX */
  if(0 !== strpos($class_name, 'My_')){
    return;
  }

  $base_path = get_theme_file_path() . '/_classes/';
  $extension = '.php';

  // var_dump($class_name);
  // $path = get_theme_file_path() . '/_classes/';
  // $extension = '.php';
  // $full_path = $path . $class_name . $extension;
  $paths = ['test/', 'utils/'];

  foreach($paths as $path){
    $current_path = $base_path . $path . $class_name . $extension;
    
    // var_dump($current_path);
    if(file_exists($current_path)){
      var_dump($current_path);
      require_once($current_path);
      break;
    }
  }
  // require_once $full_path;
}
