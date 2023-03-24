<div class="byline <?php echo ( get_the_author_meta( 'cpc_user_profile_pic', get_post_field( 'post_author' ) ) && get_the_author_meta( 'cpc_user_profile_pic_display', get_post_field( 'post_author' ) ) ) ? '' : 'byline--no-profile-picture' ;  ?>">
	<?php if ( build_author( get_the_author_meta('user_nicename') ) ) : ?>
		<div class="byline__img-wrapper">
			<?php if ( get_the_author_meta( 'cpc_user_profile_pic', get_post_field( 'post_author' ) ) && get_the_author_meta( 'cpc_user_profile_pic_display', get_post_field( 'post_author' ) ) ) : ?>
				<?php if ( ! is_amp() ) : ?> <img src="<?php echo get_the_author_meta( 'cpc_user_profile_pic', get_post_field( 'post_author' ) ); ?>" alt="<?php echo get_the_author_meta( 'display_name' ); ?>" class="byline__img"><?php endif; ?>
				<?php if ( is_amp() ) : ?> <amp-img src="<?php echo get_the_author_meta( 'cpc_user_profile_pic', get_post_field( 'post_author' ) ); ?>" alt="<?php echo get_the_author_meta( 'display_name' ); ?>" class="byline__img" height="60px" width="60px"></amp-img><?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="byline__name-wrapper">
			<?php echo ( ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' )  ) ? '<span class="byline__by">Par</span>' : '<span class="byline__by">By</span>' ; ?>
			<?php echo ( get_the_author_meta('user_nicename') === 'canadapost' || get_the_author_meta('user_nicename') === 'canada-post'  ) ? '<span class="byline__name">' : '<a href="' . get_author_posts_url( get_the_author_meta('ID'), get_the_author_meta('user_nicename') ) . '" tabindex="0" class="byline__name">' ?>
			<?php echo __( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?>
			<?php echo ( get_the_author_meta('user_nicename') === 'canadapost' || get_the_author_meta('user_nicename') === 'canada-post' ) ? '<span>' : '</a>' ?>
			<?php echo ( get_the_author_meta( 'cpc_user_position_fr', get_post_field( 'post_author' ) ) && ( get_bloginfo( 'language' ) === 'fr' || get_bloginfo( 'language' ) === 'fr-CA' )  ) ? '<span class="byline__role">' . get_the_author_meta( 'cpc_user_position_fr', get_post_field( 'post_author' ) )  . '</span>' : '' ; ?>
			<?php echo ( get_the_author_meta( 'cpc_user_position', get_post_field( 'post_author' ) ) && ( get_bloginfo( 'language' ) === 'en' || get_bloginfo( 'language' ) === 'en-CA' ) ) ? '<span class="byline__role">' . get_the_author_meta( 'cpc_user_position', get_post_field( 'post_author' ) )  . '</span>' : '' ; ?>	
		</div>
	<?php endif; ?>
	<div class="byline__share <?php echo ( ( is_plugin_active( 'cmb2/init.php' )) && ( build_author( get_the_author_meta( 'user_nicename' ) ) ) )  ? '' : 'byline__share--no-author' ;  ?>"><?php echo  build_share( $content = false ) ; ?></div>
</div>	
