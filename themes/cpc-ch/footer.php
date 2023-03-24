<?php 
$home_page_link = "https://www.canadapost-postescanada.ca" . (get_bloginfo( 'language' ) === 'fr-CA' ? 
	'/scp/fr/accueil.page' :
	'/cpc/en/home.page');
?>

  <div class="footer" role="contentinfo" aria-label="<?php _e( 'Content information', 'cpc-ch' ); ?>">
    <div class="footer__container">
      <div class="footer__canada-post">
        <a href="<?php echo $home_page_link; ?>" class="footer__link" aria-label="<?php _e( 'Go to the Canada Post homepage', 'cpc-ch' ); ?>">
        <?php _e( 'Go to the Canada Post homepage', 'cpc-ch' ) ?>
        </a>
        <span class="icon icon--open-in-new-window"></span>
      </div>
      <div class="footer__copyright">
        <span>&copy; <?php _e( 'Canada Post Corporation', 'cpc-ch' ); ?></span>
      </div>
      <?php echo build_footer_navigation(); ?>
      <div class="footer__canada">
        <a href="https://www.canada.ca/" title="<?php _e( 'Canada', 'cpc-ch' ); ?>" aria-label="<?php _e( 'Canada' , 'cpc-ch' ); ?>">
          <span class="icon icon--canada"></span>
        </a>
      </div>
    </div>
  </div>	
  <?php get_template_part( 'template-parts/footer/gdpr' );  ?> 
  <?php if ( ! is_amp() ) get_template_part( 'template-parts/search/search' );  ?> 
  <?php if ( ! is_amp() ) wp_footer();  ?>
  </body>
</html>
