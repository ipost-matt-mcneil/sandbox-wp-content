<?php

/* Single Page */ 

get_header(); 

?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php get_template_part( 'template-parts/single/banner' ); ?>
		<section class="main main--is-single" role="main" id="main" aria-label="<?php _e( 'Main', 'cpc-ch' ); ?>" tabindex="-1">
			<div class="main__container main__container--is-single"> 
				<div class="main__content main__content--is-single"> 
					<?php if ( ! is_amp() )get_template_part( 'template-parts/single/overlay' ); ?>
					<div class="row">
						<div class="large-12 columns">
							<?php if ( ! is_amp() ) echo build_breadcrumbs( $post->ID ); ?>
							<?php echo sprintf( '<h1>%s</h1>', build_title( get_post_field( 'post_title' ) ) ); ?>
							<?php echo build_published_date(); ?>
							<?php echo build_reading_time(); ?>
							<?php get_template_part( 'template-parts/single/byline' ); ?>
							<div class="entry-content">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div> 
	</section> 
<?php endwhile; ?>

<?php get_footer(); ?>
