<?php 
  /*  
    This is the template for the header
    @package basictheme
  */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php if(is_singular() && pings_open(get_queried_object())) : ?>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
  <?php endif; ?>

  <?php wp_head(); ?>
</head>

<?php 
  if(is_home()) :
    $basic_classes = array('basic-class', 'my-class');
  else :
    $basic_classes = array('no-basic-classes');
  endif;
?>

<body <?php body_class( $basic_classes); ?>>
<?php wp_body_open(); ?>

<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="main-menu">
           <!-- <div class="navbar-nav"> -->
            <?php
           
            wp_nav_menu(array(
                'theme_location' => 'main-menu',
                'container_class' => 'collapse navbar-collapse',
                'container_id'    => 'navbarNavDropdown',
                'menu_class'      => 'navbar-nav ms-auto',
                'fallback_cb'     => '',
                'menu_id'         => 'main-menu',
                'depth'           => 2,
                'walker' => new bootstrap_5_wp_nav_menu_walker()
            ));
          

                // wp_nav_menu(array(
								// 	'theme_location' => 'primary',
								// 	'container' => false,
								// 	'menu_class' => 'nav navbar-nav navbar-right',
								// 	'walker' => new Walker_Nav_Primary()
								// 	)
								// );
            ?>
              <!-- </div> -->
            <?php get_search_form(); ?>
            <!-- <form class="d-flex" role="search">
              <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success" type="submit">Search</button>
            </form> -->
        </div>
    </div>
          </nav>

<?php // wp_nav_menu(array('theme_location' => 'primary')); ?>

<?php // var_dump(get_custom_header(  )); ?>

<img src="<?php header_image(); ?>" alt="" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
