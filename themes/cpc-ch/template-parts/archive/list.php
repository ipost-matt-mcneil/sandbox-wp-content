<?php

/**
 * Tag/Author/Resources List Page
 */

$top_posts 	= ( is_tag() ) ? new WP_Query(  build_tag_list_query() ) : false;
$top_posts 	= ( is_author() ) ? new WP_Query(  build_author_list_query() ) : $top_posts;
$top_posts 	= ( is_category() ) ? new WP_Query(  build_resources_list_query() ) : $top_posts;
$post_count = $wp_query->found_posts;
$post_num 	= 11;

?>


<?php if( $top_posts && $top_posts->have_posts() ) : ?>
	<div class="tiles__container row">
		<?php while ( $top_posts->have_posts() ) : $top_posts->the_post(); ?>
			<div class="tiles__item tiles__item--is-list columns">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="card card--is-list" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
					<div class="card__img-wrapper card__img-wrapper--is-list">
						<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
				  		<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'thumbnail' ); ?>);" tabindex="-1" aria-hidden="true">
				  	<?php  else : ?>
							<div class="card__img card__img--no-img">
						<?php endif; ?>
								<?php echo build_category_icon( $post->ID ); ?>
							<div class="card__ratio card__ratio--is-list"></div>
						</div>
					</div>
				</a>
				<div class="card__text card__text--is-list">
					<?php echo build_breadcrumbs( $post->ID ); ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
						<h2 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h2>
						<?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
							<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
						<?php endif; ?>
					</a>		
				</div>
			</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
	<?php if( $post_num + $post_count > $post_num )  : ?>
		<div class="tiles__container row js-view-more-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="tiles__item tiles__item--is-list columns js-view-more-post">
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="card card--is-list" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
						<div class="card__img-wrapper card__img-wrapper--is-list">
							<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
					  		<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'thumbnail' ); ?>);" tabindex="-1" aria-hidden="true">
					  	<?php  else : ?>
								<div class="card__img card__img--no-img">
							<?php endif; ?>
									<?php echo build_category_icon( $post->ID ); ?>
								<div class="card__ratio card__ratio--is-list"></div>
							</div>
						</div>
					</a>
					<div class="card__text card__text--is-list">
						<?php echo build_breadcrumbs( $post->ID ); ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
							<h2 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h2>
							<?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
								<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
							<?php endif; ?>
						</a>		
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	<?php endif; ?>
	<?php if( is_plugin_active( 'infinite-scroll/infinite-scroll.php' ) && ( $post_num + $post_count ) > ( $post_num + 6 ) ) : ?>
		<div class="pagination large-10 columns">
			<a href="#" data-pagination="page/2" class="button button--is-view-more js-view-more-button pagination__viewing " id="<?php echo $wp_query->max_num_pages; ?>"><?php _e( 'View more posts', 'cpc-ch' ); ?></a>
			<a href="javascript:void(0)" class="button button--is-view-more pagination__loading pagination__loading--is-list" id="<?php echo $wp_query->max_num_pages; ?>"><?php _e( 'Loading...', 'cpc-ch' ); ?></a>
		</div>
	<?php endif; ?>
	<?php if ( isset( get_queried_object()->term_id ) ) : ?>
		<?php get_template_part( 'template-parts/cross-sells/full-width' ); ?>
	<?php endif; ?>
<?php else : ?>
	<div class="row">
		<div class="large-12 columns">
			<p><?php _e( 'No posts found', 'cpc-ch' ); ?></p>
		</div>
	</div>
<?php endif; ?>
