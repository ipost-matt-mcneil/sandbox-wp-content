<?php

/* Template Name: Homepage Template */ 

$homepage_feature_count         = 0;
$homepage_feature               = new WP_Query(  build_homepage_feature_query() );
$homepage_featured_list_count   = 0;
$homepage_featured_list         = new WP_Query( build_homepage_featured_list_query() );
$homepage_categories_count      = 1;
$homepage_categories            = get_categories( build_homepage_categories_query() );

$meta                           = get_post_meta( get_the_ID());
$title                          = ( isset( $meta[ 'cpc_ch_page_cross_sell_title' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_title' ][0] : null;
$image                          = ( isset( $meta[ 'cpc_ch_page_cross_sell_image' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_image' ][0] : null;
$image_alignment                = ( isset( $meta[ 'cpc_ch_page_cross_sell_image_alignment' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_image_alignment' ][0] : null;
$button_link_1                  = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_link_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_link_1' ][0] : null;
$button_title_1                 = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_title_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_title_1' ][0] : null;
$button_target_1                = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_target_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_target_1' ][0] : null;
$button_analytics_id_1          = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_analytics_id_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_target_1' ][0] : null;
$button_link_2                  = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_link_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_link_2' ][0] : null;
$button_title_2                 = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_title_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_title_2' ][0] : null;
$button_target_2                = ( isset( $meta[ 'cpc_ch_page_cross_sell_button_target_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_target_2' ][0] : null;

get_header();

?>

<section class="main" role="main" id="main" aria-label="<?php _e( 'Main', 'cpc-ch' ); ?>" tabindex="-1">
    <div class="main__container"> 
        <div class="main__content main__content--is-full-width" role="banner" aria-label="<?php _e( 'Banner', 'cpc-ch' ); ?>">
            <div class="tiles tiles--is-section">
                <div class="tiles__container row"> 	
                    <?php while ( $homepage_feature->have_posts() ) : $homepage_feature->the_post(); ?>
                        <?php if ( $homepage_feature_count === 0 ) : ?>
                            <div class="tiles__item tiles__item--is-home-feature columns">
                                <div class="card__img-wrapper card__img-wrapper--is-mask">
                                    <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                        <div class="card__img card__img--is-mask" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>);">
                                    <?php else : ?>
                                        <div class="card__img card__img--is-home-feature card__img--no-img">
                                    <?php endif; ?>
                                        <div class="card__ratio"></div>
                                    </div>
                                </div>
                                <div class="card__img-wrapper">
                                    <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                        <div class="card__img card__img--is-home-feature" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>);">
                                    <?php else : ?>
                                        <div class="card__img card__img--is-home-feature card__img--no-img">
                                    <?php endif; ?>
                                    <?php echo build_category_icon( $post->ID ); ?>
                                    <div class="card__ratio"></div>
                                </div>
                            </div>
                            <div class="card__text">
                                <div class="card__img-overlay card__img-overlay--is-home-feature" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'large' ); ?>);"></div>
                                <div class="card__white-overlay card__white-overlay--is-home-feature"></div>
                                    <?php echo build_breadcrumbs( $post->ID ); ?>
                                    <a href="<?php echo esc_url( get_permalink($homepage_feature->ID) ); ?>" class="card" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
                                        <h1 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h1>
                                        <?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
                                            <div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
                                        <?php endif; ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php $homepage_feature_count++; ?>
                    <?php endwhile; ?>
                </div>	
            </div>
        </div>
		<div class="main__content"> 
			<div class="tiles <?php echo ( $title ) ?  '' : 'tiles--is-section' ; ?> "> 
				<div class="row">
					<?php while ( $homepage_featured_list->have_posts() ) : $homepage_featured_list->the_post(); ?>
						<?php if ( $homepage_featured_list_count < 4 ) : ?>
							<div class="tiles__item <?php echo ( $homepage_featured_list_count === 0 ) ? 'tiles__item--is-text tiles__item--is-category-feature' : 'tiles__item--is-text' ?> large-4 medium-6 small-12 columns">
								<?php if ( $homepage_featured_list_count === 0 ) : ?>
									<div class="tiles__subheading">
										<h2><?php _e( 'Featured', 'cpc-ch' ); ?></h2>
									</div>
									<a href="<?php echo esc_url( get_permalink() ); ?>"  class="card" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
										<div class="card__img-wrapper">
											<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
												<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, (( $homepage_featured_list_count === 0 ) ? 'medium' : 'thumbnail' ) ); ?>);">
											<?php else : ?>
												<div class="card__img card__img--no-img">
											<?php endif; ?>
												<?php echo build_category_icon( $post->ID ); ?>
												<div class="card__ratio"></div>
											</div>
										</div>
									</a>
								<?php endif; ?>
								<div class="card__text">
									<?php if( ( $homepage_featured_list_count === 0 ) ) : ?>
										<div class="card__img-overlay" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>);"></div>
										<div class="card__white-overlay"></div>
									<?php endif; ?>
									<?php echo build_breadcrumbs( $post->ID ); ?>
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
										<h3 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h3>
										<?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
											<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
										<?php endif; ?>
									</a>
								</div>	
							</div>
						<?php endif; ?>
					<?php $homepage_featured_list_count++; ?>
					<?php endwhile; ?>
				</div>
				<?php if ( $title ) : ?>	
					<div class="tiles tiles--is-section"> 
						<div class="tiles__container row">
							<div class="tiles__item columns">
								<div class="cross-sell cross-sell--is-full-width cross-sell--is-home">
									<div class="cross-sell__container cross-sell__container--is-full-width">
										<div class="cross-sell__text <?php echo ( $image ) ? '' : 'cross-sell__text--is-full-width' ?>">
											<span class="cross-sell__heading cross-sell__heading--is-centered"><?php echo ( $title ) ? $title : '' ?></span>
											<?php if ( $button_title_1 ) : ?>
												<div>
													<a href="<?php echo ( $button_link_1 ) ? $button_link_1 : '' ?>" class="cross-sell__link cross-sell__link--is-centered" id="<?php echo ( $button_analytics_id_1 ) ? $button_analytics_id_1 : '' ?>" <?php echo ( $button_target_1 ) ? 'target="_blank"' : '' ?>>
														<?php echo ( $button_title_1 ) ? $button_title_1  : '' ?>
													</a>
												</div>
											<?php endif; ?>
											<?php if ( $button_title_2 ) : ?>
												<div>
													<a href="<?php echo ( $button_link_2 ) ? $button_link_2 : '' ?>" class="cross-sell__link cross-sell__link--is-secondary cross-sell__link--is-centered" id="<?php echo ( $button_analytics_id_2 ) ? $button_analytics_id_2 : '' ?>" <?php echo ( $button_target_2 ) ? 'target="_blank"' : '' ?>>
														<?php echo ( $button_title_2 ) ? $button_title_2 : '' ?>
													</a>
												</div>
											<?php endif; ?>
										</div>
										<?php if ( $image ) : ?>
											<div class="cross-sell__img <?php echo ( $image_alignment === 'horizontal' ) ? 'cross-sell__img--is-horizonally-aligned' : '' ?>" style="background-image: url(<?php echo ( $image ) ? $image : '' ?>)" aria-label="<?php echo ( $title ) ? $title  : '' ?>"></div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php foreach ( $homepage_categories as $category ) : $row_count = 0; ?>
		<?php if ( $category->name != 'Uncategorized' && $category->name != 'Non classifié(e)'  ) : ?>
			<div class="main__container <?php echo ( $homepage_categories_count > 1 && $homepage_categories_count < ( sizeof( $homepage_categories ) - 1) ) ? 'main__container--is-after-ribbon' : ''; ?>"> 
				<div class="main__content <?php echo ( ($homepage_categories_count + 1) === sizeof( $homepage_categories ) ) ? 'main__content--is-last' : '' ?>"> 
					<div class="tiles">
						<div class="tiles__container row">
							<?php foreach( get_posts( build_homepage_categories_list_query ( $category->term_id ) ) as $post ) : ?>
								<div class="tiles__item <?php echo ( $row_count === 0 ) ? 'tiles__item--is-category-feature' : '' ?> tiles__item--is-home  large-4 medium-6 small-12 columns">
								<?php if ( $row_count === 0 ) : ?>
									<div class="tiles__subheading">
										<h2 class="subheading__title"><?php echo $category->name; ?></h2>
										<div class="subheading__link-container">
											<a href="<?php echo get_category_link( $category->term_id ); ?>" class="subheading__link"><?php _e( 'See all', 'cpc-ch' ); ?></a><span class="icon icon--arrow"></span>
										</div>
									</div>
								<?php endif; ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="card" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
									<div class="card__img-wrapper">
										<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
											<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, (( $row_count === 0 ) ? 'medium' : 'thumbnail' ) ); ?>);">
										<?php else : ?>
											<div class="card__img card__img--no-img">
										<?php endif; ?>
											<?php echo build_category_icon( $post->ID ); ?>
											<div class="card__ratio"></div>
										</div>
									</div>
								</a>
								<div class="card__text">
									<?php if ( $row_count === 0 ) : ?>
										<div class="card__img-overlay" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>);"></div>
										<div class="card__white-overlay"></div>
									<?php endif; ?>
									<?php echo build_breadcrumbs( $post->ID, $category->term_id ); ?>
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="card">
										<h3 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h3>
										<?php if ( build_author( get_the_author_meta( 'user_nicename' ) ) ) : ?>
										<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name', get_post_field( 'post_author', $post->ID ) ), 'cpc-ch' ); ?></div>
										<?php endif; ?>
									</a>
								</div>
							</div>
						<?php $row_count++; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
		<?php $homepage_categories_count++; ?>
		<?php if ( $homepage_categories_count === 2 && sizeof( $homepage_categories ) > 1 ) echo build_homepage_navigation(); ?>
		<?php endif; ?>
	<?php endforeach; ?>
</section>

<?php get_footer(); ?>