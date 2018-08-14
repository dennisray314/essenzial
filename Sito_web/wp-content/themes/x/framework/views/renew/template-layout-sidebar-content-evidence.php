<?php

// =============================================================================
// VIEWS/RENEW/TEMPLATE-LAYOUT-SIDEBAR-CONTENT.PHP
// -----------------------------------------------------------------------------
// Sidebar left, content right page output for Renew.
// =============================================================================

?>

<?php get_header(); ?>

  <div class="x-container max width offset">
    <div class="<?php x_main_content_class(); ?>" role="main">

      <?php 

      $args = array(
      	'post_type' => 'product', 
      	'product_cat' => 'in-evidenza'
      	);
      $evidence = new WP_Query($args);
      while ( have_posts() ) : the_post(); ?>
        <?php x_get_view( 'renew', 'content', 'page' ); ?>
        <?php x_get_view( 'global', '_comments-template' ); ?>
      <?php endwhile; ?>

    </div>

    <?php get_sidebar(); ?>

  </div>

<?php get_footer(); ?>