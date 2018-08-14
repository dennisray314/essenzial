<?php 

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

?>

<?php get_header(); ?>
  


    <?php while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="width: 25%; float: left;">
		  
		    <?php x_icon_comment_number(); ?>
		    
		      <?php x_get_view( 'icon', '_content', 'post-header' ); ?>
		      <?php if ( has_post_thumbnail() ) : ?>
		      <div class="entry-featured">
		        <?php x_featured_image(); ?>
		      </div>
		      <?php endif; ?>
		      <?php x_get_view( 'global', '_content' ); ?>
		    <?php
      $stack           = x_get_stack();
$container_begin = ( $stack == 'icon' ) ? '<div class="x-container max width">' : '';
$container_end   = ( $stack == 'icon' ) ? '</div>' : '';

?>

<?php if ( comments_open() ) : ?>
  <?php echo $container_begin; ?>
    <?php comments_template( '', true ); ?>
  <?php echo $container_end; ?>
<?php endif; ?>
		  
		</article>
		
    <?php endwhile; ?>



  <aside class="x-sidebar nano" role="complementary">
    <div class="max width nano-content">
      <?php if ( get_option( 'ups_sidebars' ) != array() ) : ?>
        <?php dynamic_sidebar( apply_filters( 'ups_sidebar', 'left-sidebar' ) ); ?>
      <?php else : ?>
        <?php dynamic_sidebar( 'sidebar-main' ); ?>
      <?php endif; ?>
    </div>
  </aside>
<?php get_footer(); ?>