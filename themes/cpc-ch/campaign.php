<?php 

/* Template Name: Campaign Template */ 

$campaign_count 				= 0;
$campaign								= new WP_Query( build_campaign_query() );
$post_count 						= $campaign->found_posts;

$meta 									= get_post_meta( get_the_ID());
$button_title 					= ( isset( $meta[ 'cpc_ch_campaign_button_title' ][0] ) ) ? $meta[ 'cpc_ch_campaign_button_title' ][0] : null;
$button_url 						= ( isset( $meta[ 'cpc_ch_campaign_button_url' ][0] ) ) ? $meta[ 'cpc_ch_campaign_button_url' ][0] : null;
$button_analytics 			= ( isset( $meta[ 'cpc_ch_campaign_button_analytics' ][0] ) ) ? $meta[ 'cpc_ch_campaign_button_analytics' ][0] : null;
$button_target 					= ( isset( $meta[ 'cpc_ch_campaign_button_target' ][0] ) ) ? $meta[ 'cpc_ch_campaign_button_target' ][0] : null;
$title									= ( isset( $meta[ 'cpc_ch_page_cross_sell_title' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_title' ][0] : null;
$image									= ( isset( $meta[ 'cpc_ch_page_cross_sell_image' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_image' ][0] : null;
$image_alignment				= ( isset( $meta[ 'cpc_ch_page_cross_sell_image_alignment' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_image_alignment' ][0] : null;
$button_link_1					= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_link_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_link_1' ][0] : null;
$button_title_1					= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_title_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_title_1' ][0] : null;
$button_target_1				= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_target_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_target_1' ][0] : null;
$button_analytics_id_1	= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_analytics_id_1' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_analytics_id_1' ][0] : null;
$button_link_2					= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_link_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_link_2' ][0] : null;
$button_title_2					= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_title_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_title_2' ][0] : null;
$button_target_2				= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_target_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_target_2' ][0] : null;
$button_analytics_id_2	= ( isset( $meta[ 'cpc_ch_page_cross_sell_button_analytics_id_2' ][0] ) ) ? $meta[ 'cpc_ch_page_cross_sell_button_analytics_id_2' ][0] : null;
$banner_background			= ( isset( $meta[ 'cpc_ch_campaign_banner_background' ][0] ) ) ? $meta[ 'cpc_ch_campaign_banner_background' ][0] : null;

get_header();

?>

<?php if ( has_post_thumbnail() ) : ?>
	<div class="banner" style="background: <?php echo ( $banner_background ) ? $banner_background : ''; ?>;">
	  <div class="banner__container" role="banner" aria-label="<?php _e( 'Banner', 'cpc-ch' ); ?>">
	    	<div class="banner__img" style="background-image: url( <?php echo get_the_post_thumbnail_url( $post->ID, 'campaign' ); ?> );"></div>
	  </div>
	</div>
<?php endif; ?>
<section class="main" role="main" id="main" aria-label="<?php _e( 'Main', 'cpc-ch' ); ?>" tabindex="-1"> 
	<div class="main__container"> 
		<div class="main__content">  
			<div class="row">
				<div class="large-12 columns">
					<div class="tiles"> 
						<h1><?php the_title(); ?></h1>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; ?>
						<?php if ( $post_count > 0 ) : ?>
							<div class="tiles__container tiles__container--is-campaign row">
								<?php while ( $campaign->have_posts() ) : $campaign->the_post() ?>
									<div class="tiles__item tiles__item--is-campaign <?php echo ( $campaign_count === 0 ) ? 'tiles__item--is-campaign-feature' : '' ?> large-4 medium-6 small-12 columns">
										<?php if( $campaign_count === 1 ) : ?>
											<h2 class="tiles__subheading"><?php _e( 'Related posts', 'cpc-ch' ) ?></h2>
										<?php endif; ?>
										<a href="<?php echo esc_url( get_permalink() ) ?>" class="card" aria-label="<?php the_title() ?>" aria-hidden="true" tabindex="-1">
											<div class="card__img-wrapper">
												<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
													<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, (( $campaign_count === 0 ) ? 'large' : 'thumbnail' ) ); ?>);">
												<?php else : ?>
													<div class="card__img card__img--no-img">
												<?php endif; ?>
													<?php echo build_category_icon( $post->ID ); ?>
														<div class="card__ratio"></div>
													</div>
											</div>
										</a>
										<div class="card__text">
											<?php if( $campaign_count === 0  ) : ?>
												<div class="card__img-overlay" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, (( $campaign_count === 0 ) ? 'large' : 'thumbnail' ) );  ?>);"></div>
												<div class="card__white-overlay"></div>
											<?php endif; ?>
											<?php echo build_breadcrumbs( $post->ID ); ?>
											<a href="<?php echo esc_url( get_permalink() ) ?>" class="card">
												<h2 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h2>
												<?php if( $campaign_count > 0  ) : ?>
													<div class="card__author"><?php _e( 'By', 'cpc-ch' ); ?> <?php _e( get_the_author_meta( 'display_name' ), 'cpc-ch' ); ?></div>
												<?php endif; ?>
											</a>
											<?php if( $campaign_count === 0  && $button_title && $button_url ) : ?>
												<a href="<?php echo $button_url; ?>" class="card__button button secondary" id="<?php echo $button_analytics; ?>" <?php echo ( $button_target ) ? 'target="_blank"' : ''; ?>  ><?php echo $button_title; ?></a>
											<?php endif; ?>
										</div>
									</div>
								<?php $campaign_count++; ?>
								<?php endwhile; ?>
								</div>
							</div>
						</div> 
					<?php endif; ?> 
					<?php if ( $title ) : ?>
						<div class="cross-sell cross-sell--is-full-width">
							<div class="cross-sell__container cross-sell__container--is-full-width">
								<div class="cross-sell__text <?php echo ( $image ) ? '' : 'cross-sell__text--is-full-width' ?>">
									<span class="cross-sell__heading cross-sell__heading--is-centered"><?php echo ( $title ) ? $title : '' ?></span>
									<?php if ( $button_title_1 ) : ?>
										<div>
											<a href="<?php echo ( $button_link_1 ) ? $button_link_1 : ''; ?>" class="cross-sell__link cross-sell__link--is-centered" id="<?php echo ( $button_analytics_id_1 ) ? $button_analytics_id_1 : ''; ?>" <?php echo ( $button_target_1 ) ? 'target="_blank"' : ''; ?>>
												<?php echo ( $button_title_1 ) ? $button_title_1  : ''; ?>
											</a>
										</div>
									<?php endif; ?>
									<?php if ( $button_title_2 ) : ?>
										<div>
											<a href="<?php echo ( $button_link_2 ) ? $button_link_2 : ''; ?>" class="cross-sell__link cross-sell__link--is-secondary cross-sell__link--is-centered" id="<?php echo ( $button_analytics_id_2 ) ? $button_analytics_id_2 : ''; ?>" <?php echo ( $button_target_2 ) ? 'target="_blank"' : ''; ?>>
												<?php echo ( $button_title_2 ) ? $button_title_2 : ''; ?>
											</a>
										</div>
									<?php endif; ?>
								</div>
								<?php if ( $image ) : ?>
									<div class="cross-sell__img <?php echo ( $image_alignment === 'horizontal' ) ? 'cross-sell__img--is-horizonally-aligned' : ''; ?>" style="background-image: url(<?php echo ( $image ) ? $image : ''; ?>)" aria-label="<?php echo ( $title ) ? $title  : ''; ?>"></div>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?> 
				</div>  
			</div> 
		</div>  
	</div> 
</section>

<?php get_footer(); ?>
