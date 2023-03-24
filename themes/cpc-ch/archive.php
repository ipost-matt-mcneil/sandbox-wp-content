<?php 

/* Archive Page */ 

$meta                 = ( get_queried_object() ) ? get_term_meta( get_queried_object()->term_id ) : null;
$parent_meta          = ( get_queried_object() ) ? get_term_meta( get_queried_object()->parent ) : null;
$category_type        = ( isset( $meta[ 'cpc_ch_category_type' ][0] ) ) ? $meta[ 'cpc_ch_category_type' ][0] : null;
$category_parent_type = ( isset( $parent_meta[ 'cpc_ch_category_type' ][0] ) ) ? $parent_meta[ 'cpc_ch_category_type' ][0] : null;

get_header();

?>

<section class="main" role="main" id="main" aria-label="<?php _e( 'Main', 'cpc-ch' ); ?>" tabindex="-1"> 
  <div class="main__container"> 
    <div class="main__content">  
      <div class="row">
        <div class="large-12 columns">
          <div class="tiles"> 
            <?php if ( is_author() ) : ?>
              <?php if ( ( get_the_author_meta('user_nicename', $author) != 'canadapost' || get_the_author_meta('user_nicename', $author) != 'canada-post') && get_the_author_meta( 'description', $author ) != '' && get_the_author_meta( 'cpc_user_description_fr', $author ) != '' ) : ?>
                <div class="bio">
                  <div class="bio__img-wrapper <?php echo ( get_the_author_meta( 'cpc_user_profile_pic', $author ) && get_the_author_meta( 'cpc_user_profile_pic_display', $author ) ) ? '' : 'bio__img-wrapper--no-profile-picture' ;  ?>">
                    <img src="<?php echo get_the_author_meta( 'cpc_user_profile_pic', $author ); ?>" alt="<?php  echo get_the_author_meta('display_name', $author); ?>" class="bio__img" />
                  </div>
                <div class="bio__text-wrapper">
                  <div class="bio__text">
                    <h1 class="bio__heading"><?php echo get_the_author_meta('display_name', $author); ?></h1>
                    <?php if ( get_locale() === 'fr_CA' ) : ?>
                      <span><?php echo get_the_author_meta( 'cpc_user_description_fr', $author ); ?><span>
                    <?php else : ?>
                      <span><?php echo get_the_author_meta( 'description', $author ); ?><span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
              <h2><?php _e( 'All posts by ', 'cpc-ch' ); ?> <?php echo get_the_author_meta('display_name', $author); ?></h2>
            <?php else : ?>
              <h1><?php _e( 'All posts by ', 'cpc-ch' ); ?> <?php echo get_the_author_meta('display_name', $author); ?></h1>
            <?php endif; ?>
            <?php get_template_part( 'template-parts/archive/list' ); ?>
          <?php else : ?>
            <?php echo build_breadcrumbs(); ?>
            <?php if( get_queried_object() ) : ?>
              <h1 class="heading <?php echo ( get_queried_object()->taxonomy === 'post_tag' ) ? 'heading--is-tags' : '' ; ?>"><?php echo get_queried_object()->name; ?></h1>
            <?php endif; ?>
            <?php if ( $category_type != 'resources' && !is_date() ) : ?>
              <?php get_template_part( 'template-parts/archive/quicklinks' ); ?>
            <?php endif; ?>
            <?php if ( isset( get_queried_object()->taxonomy  ) && get_queried_object()->taxonomy === 'category' ) : ?>
              <?php if ( get_queried_object()->category_parent > 0  ) : ?>
                <?php if ( $category_parent_type === 'resources' ) : ?>
                  <?php get_template_part( 'template-parts/archive/list' ); ?>
                <?php else : ?>
                  <?php if ( $category_type === 'resources' ) : ?>
                    <?php get_template_part( 'template-parts/archive/resources' ); ?>
                  <?php elseif ( $category_type === 'events' ) : ?>
                    <?php get_template_part( 'template-parts/archive/events' ); ?>
                  <?php else : ?>
                    <?php get_template_part( 'template-parts/archive/subcategory' ); ?>
                  <?php endif; ?>
                <?php endif; ?>
              <?php else : ?>
                <?php get_template_part( 'template-parts/archive/category' ); ?>
              <?php endif; ?>
            <?php else : ?>
              <?php get_template_part( 'template-parts/archive/list' ); ?>
            <?php endif; ?>
          <?php endif; ?>
          </div> 	
        </div> 	
      </div> 	
    </div> 	
  </div> 	
</section> 

<?php get_footer(); ?>