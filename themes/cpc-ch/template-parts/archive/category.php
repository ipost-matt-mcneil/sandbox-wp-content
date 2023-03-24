<?php

/**
 * Category Page
 */

$category_count 			= 0;
$last_count 					= 1;
$paged 								= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$has_cross_sell 			= get_term_meta( get_queried_object()->term_id, 'cpc_ch_category_cross_sell_inline_title', true );
$top_posts 						= ( build_category_query( $has_cross_sell ) ) ? new WP_Query( build_category_query( $has_cross_sell ) ) : false;
$post_count 					= $wp_query->found_posts;
$post_num 						= ( $has_cross_sell )  ? 10 : 11;

?>

<?php if( $top_posts && $top_posts->have_posts() ) : ?>
	<div class="tiles__container <?php echo ( $has_cross_sell !== '' ) ? 'tiles__container--is-category-cross-sell' : '' ?> row">
    <?php while ( $top_posts->have_posts() ) : $top_posts->the_post(); ?>
    	<?php if ( ( $category_count === 1 || $category_count === 2 || $category_count === 4 ) && $has_cross_sell && $paged === 1 ) $last_count = 2; ?>
			<?php for ( $tiles = 0 ;  $tiles < $last_count; $tiles++ ): ?>
				<div class="tiles__item <?php echo ( $has_cross_sell !== '' ) ? 'tiles__item--is-category-cross-sell' : 'tiles__item--is-category' ?>  <?php echo ( $category_count === 0 && $paged === 1 ) ? 'tiles__item--is-category-feature' : '' ?> large-4 medium-6 small-12 columns">
					<?php if ( $last_count === 2 && $tiles === 0 && $paged === 1 ) : ?>
						<?php get_template_part( 'template-parts/cross-sells/inline' ); ?>
					<?php else : ?>	
						<?php if( ( ( $category_count === 1 || $category_count === 2 ) && $paged === 1 ) ) : ?>
							<h2 class="tiles__subheading"><?php _e('Most recent posts', 'cpc-ch' ); ?></h2>
						<?php endif; ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>"  class="card" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
								<div class="card__img-wrapper">
									<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
										<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, (( $category_count === 0 ) ? 'medium' : 'thumbnail' ) ); ?>);">
									<?php else : ?>
										<div class="card__img card__img--no-img">
									<?php endif; ?>
									<?php echo build_category_icon( $post->ID ); ?>
											<div class="card__ratio"></div>
										</div>
								</div>
							</a>
							<div class="card__text">
								<?php if( ( $category_count === 0 && $paged === 1 ) ) : ?>
									<div class="card__img-overlay" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>);"></div>
									<div class="card__white-overlay"></div>
								<?php endif; ?>
								<?php echo build_breadcrumbs( $post->ID ); ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
									<?php if( $category_count === 0 ) : ?>
										<h2 class="card__title"><?php the_title(); ?></h2>
									<?php elseif ( $has_cross_sell === '' && $category_count === 1) : ?>
										<h2 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h2>
									<?php else : ?>
										<h3 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h3>
									<?php endif; ?>
									<?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
										<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
									<?php endif; ?>
								</a>
							</div>	
					<?php endif; ?>
				</div>
			<?php endfor; ?>
			<?php $category_count++; ?>
			<?php $last_count = 1; ?>
    <?php endwhile ?> 
  <?php wp_reset_postdata(); ?>
  </div>
  <?php if( $post_num + $post_count > $post_num )  : ?>
		<div class="tiles__container row js-view-more-content">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="tiles__item large-4 medium-6 small-12 columns js-view-more-post">
					<a href="<?php echo esc_url( get_permalink() ); ?>"  class="card" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
						<div class="card__img-wrapper">
							<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
								<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'thumbnail' ); ?>);">
							<?php else : ?>
								<div class="card__img card__img--no-img">
							<?php endif; ?>
								<?php echo build_category_icon( $post->ID ); ?>
								<div class="card__ratio"></div>
								</div>
						</div>
					</a>
					<div class="card__text">
						<?php echo build_breadcrumbs( $post->ID ); ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
							<h3 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h3>
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
		<div class="pagination large-12 columns">
			<a href="#" data-pagination="page/2" class="pagination__viewing button button--is-view-more js-view-more-button" id="<?php echo $wp_query->max_num_pages; ?>"><?php _e( 'View more posts', 'cpc-ch' ); ?></a>
			<a href="javascript:void(0)" class="pagination__loading button button--is-view-more" id="<?php echo $wp_query->max_num_pages; ?>"><?php _e( 'Loading...', 'cpc-ch' ); ?></a>
		</div>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/cross-sells/full-width' ); ?>
<?php else : ?>
	<div class="row">
		<div class="large-12 columns">
			<p><?php _e( 'No posts found', 'cpc-ch' ); ?></p>
		</div>
	</div>
<?php endif; ?>
