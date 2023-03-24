<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
	<div class="overlay__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ) ?>);"></div>
<?php endif; ?> 
<div class="overlay__white"></div> 

