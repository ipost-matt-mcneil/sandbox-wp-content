<?php 

// IA 5702 - Temporary fix for Magazine to hide subcategories

if ( is_plugin_active( 'cmb2/init.php' ) && is_plugin_active( 'cpc-contenthub/cpc-contenthub.php' )  ) {
	if ( ! cmb2_get_option( 'cpc_ch_theme_options', 'cpc_ch_theme_options_hide_subcategories' ) ) {
		$quicklinks_count	= 0;
		$quicklinks 			= get_terms( 'category', array('parent' => get_queried_object_id(), 'hide_empty' => false ) ); 
	}
}
?>

<?php if ( isset( $quicklinks ) ) : ?>
	<div class="quicklinks">
		<div class="quicklinks__container row">
			<?php foreach( $quicklinks as $quicklink ) : ?>
				<?php if ( $quicklinks_count < 4 ) : ?>
					<div class="quicklinks__item large-3 small-12 columns">
						<a href="<?php echo get_category_link( $quicklink->term_id ); ?>">
							<div class="quicklinks__title">
								<?php echo get_cat_name( $quicklink->term_id ); ?>
								<span class="icon icon--arrow quicklinks__icon"></span>
							</div>
							<div class="quicklinks__desc">
								<?php echo strip_tags( category_description( $quicklink->term_id ) ); ?>
							</div>				
						</a>
					</div>
					<div class="subcategory-card-non-clickable medium-6 columns">
						<div class="quicklinks__wrapper">
							<a class="quicklinks__title" href="<?php echo get_category_link( $quicklink->term_id ); ?>">
								<?php echo get_cat_name( $quicklink->term_id ); ?>
								<span class="icon icon--arrow quicklinks__icon"></span>
							</a>
							<div class="quicklinks__desc quicklinks__desc--is-tablet">
								<?php echo strip_tags( category_description( $quicklink->term_id )); ?>
							</div>
						</div>				
					</div> 
				<?php $quicklinks_count++;	?>
				<?php endif;	?>
			<?php endforeach;	?>
		</div>
	</div>
<?php endif; ?>
