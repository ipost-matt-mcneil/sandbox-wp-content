<?php 

/* Template Name: Landing Template */ 

get_header();
$blog_path = get_blogs_path();
$business_path = get_business_path();
$personal_path = get_personal_path();
?>

<section class="main" role="main" id="main" aria-label="<?php _e( 'Main', 'cpc-ch' ); ?>" tabindex="-1">
	<div class="main__container"> 
		<div class="main__content">  
			<div class="row">
				<div class="large-12 columns">
					<div class="tiles tiles--is-landing">
						<h1><?php _e( 'Canada Post blogs', 'cpc-ch' ); ?></h1>
							<div class="tiles__container tiles__container--no-flexbox row">
								<div class="tiles__item  large-6 medium-6 small-12 columns">
									<div class="card__img-wrapper">
										<img src="<?php echo get_template_directory_uri(); ?>/img/business-matters.svg" class="card__img card__img--is-landing" alt="<?php _e( 'Business Matters', 'cpc-ch' ); ?>">
									</div>
									<h2><?php _e( 'Business Matters', 'cpc-ch' ); ?></h2>
									<p>
									<?php _e( build_title( 'Read industry reports and get articles on shipping, marketing and e-commerce strategies for your business.' ), 'cpc-ch' ); ?></p>
									<a href="<?php echo "/${blog_path}/${business_path}/"; ?>" class="card__link" aria-label="<?php _e( 'Business Matters', 'cpc-ch' ); ?>"><?php _e( 'Go to Business Matters', 'cpc-ch' ); ?><span class="icon icon--arrow"></span></a>
								</div>
								<div class="tiles__item  large-6 medium-6 small-12 columns">
									<div class="card__img-wrapper">
										<img src="<?php echo get_template_directory_uri(); ?>/img/magazine.svg" class="card__img card__img--is-landing" alt="<?php _e( 'Magazine', 'cpc-ch' ); ?>">
									</div>
									<h2><?php _e( 'Magazine', 'cpc-ch' ); ?></h2>
									<p><?php _e( build_title( 'Read the Canadian stories that inspire our stamp designs and get tips on products and shipping.' ) , 'cpc-ch' ); ?></p>
									<a href="<?php echo "/${blog_path}/${personal_path}/"; ?>" class="card__link" aria-label="<?php _e( 'Magazine', 'cpc-ch' ); ?>"><?php _e( 'Go to Magazine', 'cpc-ch' ); ?><span class="icon icon--arrow"></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>  
			</div> 
		</div>  
	</div> 
</section> 

<?php get_footer(); ?>
