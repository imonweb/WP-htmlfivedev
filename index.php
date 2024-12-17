 <?php 

 // silence is golden...

get_header(); ?>
<?php // require get_theme_file_path('/_classes/Test_Oop_Wp.php'); ?>
<?php // require get_theme_file_path('/_classes/Utils.php'); ?>

<?php 
  use HtmlFiveDev\Test\TestOopWp;
  use HtmlFiveDev\Utils\Utils;
  $test_obj = new TestOopWp('All is well!', 85);
?>

<main id="primary" class="site-main container">
  <header id="header-test" class="site-header container py-5 text-center">

    <h1>TEST OOP PHP ON WP</h1>
    <hr class="bg-dark">

  </header>
  <div class="row">
 
    
      <section class="col-sm-12">
         
          <strong>Col1</strong><br />
          
          <?php $test_obj->get_message(); ?>
      
      </section><!-- /.col-lg-4 -->
      <section class="col-sm-12">
          
          <strong>Col2</strong><br />
          <?php $post_obj = $test_obj->get_my_post(); ?>

          <?php Utils::show_nice($post_obj->post_date); ?>
          <?php Utils::show_nice($post_obj->post_title); ?>
          <?php Utils::show_nice($post_obj->post_content); ?>
          <?php Utils::show_nice($post_obj->post_status); ?>

          <?php Utils::show_nice($post_obj); ?>
         
          <?php // print_r($test_obj->get_my_post()); ?>
      
      </section><!-- /.col-lg-4 -->
      <section class="col-sm-12">
          <!-- <hr class="bg-danger"> -->
          <strong>Col3</strong><br />
          
          <?php // print_r($test_obj->get_my_cats()) ?>
          <?php $cat_obj = $test_obj->get_my_cats() ?>
          <?php Utils::show_loop($cat_obj); ?>
          <?php Utils::show_nice($cat_obj); ?>
       
      </section><!-- /.col-lg-4 -->
 
</div>
  
</main>




<?php get_footer(); ?>


