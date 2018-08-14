<?php


add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_script('snow-js', get_stylesheet_directory_uri() . '/xmas/snowfall.jquery.min.js', array('jquery'),true);
	wp_enqueue_style( 'xmas-theme', get_stylesheet_directory_uri(). '/xmas/natale.css', array('x-child')  );
});

add_action( 'wp_footer', function(){
	?>

	<script>
		jQuery(function($){
			$('body').snowfall({image :"<?php echo get_stylesheet_directory_uri() . '/xmas/';?>flake.png", minSize: 5, maxSize:13});
		});
	</script>
	<?php 
});
