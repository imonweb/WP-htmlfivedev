<?php 
/*
================================================
   Test OOP PHP ON WP 
================================================
*/
namespace HtmlFiveDev\Test;

class TestOopWp 
{
  public $message;
  public $post_id;

  public function __construct($message, $post_id = null)
  {
    $this->message = $message;
    $this->post_id = $post_id;
  }

  public function get_message() 
  {
    echo '<p>Test_Oop_Wp <br>' . $this->message . '</p>';
  }

  public function get_my_post()
  {
    $my_post = get_post($this->post_id);
    return $my_post;
  }

  public function get_my_cats()
  {
    $my_cat = get_terms('category');
    return $my_cat;
  }
}