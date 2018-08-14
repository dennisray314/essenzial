<?php

// =============================================================================
// TEMPLATE NAME: Layout - Sidebar Left, Content Right - Prodotti in evidenza
// -----------------------------------------------------------------------------
// Handles output of sidebar left, content right pages.
//
// Content is output based on which Stack has been selected in the Customizer.
// To view and/or edit the markup of your Stack's index, first go to "views"
// inside the "framework" subdirectory. Once inside, find your Stack's folder
// and look for a file called "template-layout-sidebar-content.php," where
// you'll be able to find the appropriate output.
// =============================================================================

get_header(); ?>

  <div class="x-main full" role="main">
    <div class="x-container max width offset-top offset-bottom">

      <?php if ( x_is_shop() ) : ?>
        <header class="entry-header shop">
          <h1 class="entry-title"><?php echo x_get_option( 'x_icon_shop_title' ); ?></h1>
        </header>
      <?php endif; ?>

      <?php woocommerce_content(); ?>

    </div>
  </div>

  <?php get_sidebar(); ?>
<?php get_footer(); ?>