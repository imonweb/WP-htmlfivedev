<?php 

namespace HtmlFiveDev\Utils;

class Utils 
{
  public static function show_nice($obj)
  {
    echo '<hr class="bg-info">';
    echo '<pre';
    print_r($obj);
    echo '</pre>';
  }

  public static function show_loop($arr)
  {
    foreach($arr as $cat){
      echo 'Cat Name: ' . $cat->name . '<br/>';
      echo 'Cat ID: ' . $cat->term_id . '<br/>';
      echo 'Taxonomy: ' . $cat->taxonomy . '<br/>';
      echo '<hr class="bg-warning">';
      
    }
  }
}
?>
 