<?php

/**
 * Resources Page
 */

$resources_count 		= 0;
$row_count 					= 0;
$column_count 			= 0;
$rows 							= array( '' );
$rows 							= array_merge( $rows, get_term_children( get_queried_object()->term_id, 'category' ) );
$resources_results	= new WP_Query( build_resources_query() );

?>

<?php if ( $resources_results->have_posts() ) : ?>
	<div class="tiles__container row">
		<?php foreach ( $rows	as $row ) : ?>
			<div class="tiles__row">
				<?php while ( $resources_results->have_posts() ) : $resources_results->the_post(); ?>
					<?php if ( has_category( $row ) ) : ?>
						<?php $total_column_count = ( $row_count === 0 ) ? 2 : 3 ; ?>
						<?php if ( $column_count < $total_column_count ) : ?>
							<div class="tiles__item <?php echo ( $row_count === 0 ) ? 'tiles__item--is-subcategory-feature' : ''; ?> <?php echo ( $row_count  > 0 ) ? 'tiles__item--is-resources' : '' ; ?> large-4 medium-6 small-12 columns">
								<?php if ( $column_count === 0 && $row_count > 0  ) : ?>
									<div class="tiles__subheading">
										<h2 class="subheading__title"><?php echo get_cat_name( $row ); ?></h2>
										<div class="subheading__link-container">
											<a href="<?php echo get_category_link( $row ); ?>" class="subheading__link"><?php _e( 'See all', 'cpc-ch' ); ?></a><span class="icon icon--arrow"></span>
										</div>
									</div>
								<?php endif; ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="card" aria-label="<?php the_title() ?>" aria-hidden="true" tabindex="-1">
									<div class="card__img-wrapper">
										<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
								  		<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, ( ( $resources_count === 0 ) ? 'large' : 'thumbnail' ) );?>);">
								  	<?php  else : ?>
											<div class="card__img card__img--no-img">
										<?php endif; ?>
											<?php echo build_category_icon( $post->ID ); ?>
											<div class="card__ratio"></div>
										</div>
									</div>
								</a>
								<div class="card__text">
									<?php if( $row_count === 0  ) : ?>
										<div class="card__overlay" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, ( ( $resources_count === 0 ) ? 'large' : 'thumbnail' ) ); ?>);"></div>
										<div class="card__white-overlay"></div>
									<?php endif; ?>
									<?php echo build_breadcrumbs( $post->ID ); ?>
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
										<?php if( $row_count === 0  ) : ?>
											<h2 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h2>
										<?php  else : ?>
											<h3 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h3>
										<?php endif; ?>
										<?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
											<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
										<?php endif; ?>
									</a>		
								</div>
							</div>
							<?php $column_count++; ?>
						<?php endif; ?>
					<?php endif; ?>
				<?php endwhile; ?>
				<?php $column_count = 0; ?>
				<?php $row_count++; ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php get_template_part( 'template-parts/cross-sells/full-width' ); ?>
<?php else : ?>
	<div class="row">
		<div class="large-12 columns">
			<p><?php _e( 'No posts found', 'cpc-ch' ); ?></p>
		</div>
	</div>
<?php endif; ?>
