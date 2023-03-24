<?php

$subcategory_count 		= 0;
$last_count 					= 1;
$paged 								= ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$top_posts						= ( build_subcategory_query( ) ) ? new WP_Query( build_subcategory_query( ) ) : false;
$post_count 					= $wp_query->found_posts;
$post_num 						= 9;

?>

<?php if (post_type_exists('events')) : ?>
<?php
    $args = array( 
    		'post_status' 		=> 'publish',
    		'post_type' 			=> 'events',
    		'no_found_rows' 	=> true,
				'category__and' 	=> array( get_queried_object()->term_id ),
				'meta_key'      	=> 'cpc_ch_events_event-date',
				'meta_value' 			=> date( 'Y-m-d' ),
        'meta_compare' 		=> '>=',
        'orderby' 				=> array( 'meta_value' => 'ASC' ),
				'posts_per_page' 	=> 100
     );

     $loop = new WP_Query( $args );

		 if( $loop->have_posts() ) { ?>
			 <div class="row tiles events">
			 <?php
        while( $loop->have_posts() ) : $loop->the_post();

        		$meta 										= get_post_meta( get_the_ID());
        		$location 								= ( isset( $meta[ 'cpc_ch_events_event-location' ][0] ) ) ? $meta[ 'cpc_ch_events_event-location' ][0] : null;
						$event_date 							= ( isset( $meta[ 'cpc_ch_events_event-date' ][0] ) ) ? $meta[ 'cpc_ch_events_event-date' ][0] : null;
						$description 							= ( isset( $meta[ 'cpc_ch_events_event-description' ][0] ) ) ? $meta[ 'cpc_ch_events_event-description' ][0] : null;
						$language 								= ( isset( $meta[ 'cpc_ch_events_event-language' ][0] ) ) ? $meta[ 'cpc_ch_events_event-language' ][0] : null;
						$price 										= ( isset( $meta[ 'cpc_ch_events_event-price' ][0] ) ) ? $meta[ 'cpc_ch_events_event-price' ][0] : null;
						$register_link 						= ( isset( $meta[ 'cpc_ch_events_event-register-link' ][0] ) ) ? $meta[ 'cpc_ch_events_event-register-link' ][0] : null;
						$register_link_analytics  = ( isset( $meta[ 'cpc_ch_events_event-register-link-analytics' ][0] ) ) ? $meta[ 'cpc_ch_events_event-register-link-analytics' ][0] : null;
						$detail_link  						= ( isset( $meta[ 'cpc_ch_events_event-detail-link' ][0] ) ) ? $meta[ 'cpc_ch_events_event-detail-link' ][0] : null;
						$detail_link_analytics  	= ( isset( $meta[ 'cpc_ch_events_event-detail-link-analytics' ][0] ) ) ? $meta[ 'cpc_ch_events_event-detail-link-analytics' ][0] : null;
						$date  										= date_create( $event_date );
          
          ?>
          <div class="tiles__item tiles__item_event large-4 medium-6 small-12 columns">
              <div class="card__img-wrapper">
                <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                  <div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, 'thumbnail' ); ?>);" aria-label="<?php the_title(); ?>" tabindex="-1">
                <?php  else : ?>
                  <div class="card__img card__img--no-img">
                <?php endif; ?>
                  <div class="card__ratio card__ratio--is-list"></div>
                  <div class="event_date"><span class="month"><?php echo date_format( $date,"M" ); ?></span><span class="day"><?php echo date_format( $date,"d" ); ?></span></div>
                </div>
              </div>
            <div class="card__text">
              <h2 class="card__title"><?php echo build_title ( get_post_field( 'post_title' ) ); ?></h2>
              <div class="location"><?php echo $location ?></div>
              <p><?php echo $description ?></p>
              <?php if ( $language ) : ?><p class="language"><span class="icon icon--language"></span><?php _e( 'Event held in', 'cpc-ch' ); ?> <?php echo $language ?></p><?php endif; ?>
              <?php if ( $price ) : ?><p class="price"><span class="icon icon--ticket"></span><?php echo $price; ?></p><?php endif; ?>
              <div class="button-container">
                <?php if ( $register_link ) : ?>
                  <a id="<?php echo $register_link_analytics; ?>" href="<?php echo $register_link; ?>" class="button secondary"><?php _e( 'Register', 'cpc-ch' ); ?></a>
                <?php endif; ?>
                <?php if ( $detail_link ) : ?>
                  <a id="<?php echo $detail_link_analytics; ?>" href="<?php echo $detail_link; ?>" class="button link"><?php _e( 'Details', 'cpc-ch' ); ?></a>
                <?php endif; ?>
              </div>
            </div>
					</div>
					<?php endwhile; ?>
				</div>
				<?php } else { ?>
			 <script type="text/javascript" src="https://www.canadapost-postescanada.ca/cpc/assets/cpc/js/lib/bodymovin.min.js"></script>
			<div class="events-empty-container">
				<div id="eventsEmpty"></div>
				<h2><?php _e( 'Looks like there are no '. strtolower( get_cat_name( get_queried_object()->parent ) ) . ' events scheduled.', 'cpc-ch' ); ?></h2>
				<p><?php _e( 'We\'re always updating our event listings, so check back soon!', 'cpc-ch'); ?></p>
			</div>
		<?php }?>
<?php endif; ?>

<?php if( $top_posts && $top_posts->have_posts() ) : ?>
	<h2><?php _e('Most recent posts', 'cpc-ch' ); ?></h2>
	<div class="tiles__container row">
		<?php while ( $top_posts->have_posts() ) : $top_posts->the_post(); ?>
			<div class="tiles__item large-4 medium-6 small-12 columns">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="card" aria-label="<?php the_title(); ?>" aria-hidden="true" tabindex="-1">
					<div class="card__img-wrapper">
						<?php if ( has_post_thumbnail( $post->ID ) ) : ?>
				  		<div class="card__img" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post->ID, (( $subcategory_count === 0 ) ? 'large' : 'thumbnail' ) ); ?>);">
				  	<?php  else : ?>
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
			<?php $subcategory_count++; ?>
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
		<?php if( is_plugin_active( 'infinite-scroll/infinite-scroll.php' ) && ( $post_count + $post_num ) > ( $post_num + 6 ) ) : ?>
			<div class="pagination large-12 columns">
				<a href="#" data-pagination="page/2" class="pagination__viewing button button--is-view-more js-view-more-button" id="<?php echo $wp_query->max_num_pages; ?>"><?php _e( 'View more posts', 'cpc-ch' ); ?></a>
				<a href="javascript:void(0)" class="pagination__loading button button--is-view-more" id="<?php echo $wp_query->max_num_pages; ?>"><?php _e( 'Loading...', 'cpc-ch' ); ?></a>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/cross-sells/full-width' ); ?>
<?php else : ?>
	<div class="row">
		<div class="large-12 columns">
			<p><?php _e( 'No posts found', 'cpc-ch' ); ?></p>
		</div>
	</div>
<?php endif; ?>
