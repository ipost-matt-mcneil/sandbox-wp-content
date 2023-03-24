<div class="banner banner--is-post banner--is-top">
	<div class="banner__container banner__container--is-post" role="banner" aria-label="<?php _e( 'Banner', 'cpc-ch' ); ?>">
		<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
			<div class="banner__img banner__img--is-post" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>);"></div>
		<?php  else : ?>
			<div class="banner__img banner__img--is-post banner__img--no-img"></div>
		<?php endif; ?>
	</div>
</div>