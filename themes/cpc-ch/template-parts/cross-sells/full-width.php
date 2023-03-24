<?php

$meta 														= get_term_meta( get_queried_object()->term_id );
$full_width_title 								= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_title' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_title' ][0] : null;
$full_width_image 								= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_image' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_image' ][0] : null;
$full_width_image_alignment 			= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_image_alignment' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_image_alignment' ][0] : null;
$full_width_button_link_1 				= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_link_1' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_link_1' ][0] : null;
$full_width_button_title_1 				= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_title_1' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_title_1' ][0] : null;
$full_width_button_target_1				= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_target_1' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_target_1' ][0] : null;
$full_width_button_analytics_id_1	= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_analytics_id_1' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_analytics_id_1' ][0] : null;
$full_width_button_link_2					= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_link_2' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_link_2' ][0] : null;
$full_width_button_title_2				= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_title_2' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_title_2' ][0] : null;
$full_width_button_target_2				= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_target_2' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_target_2' ][0] : null;
$full_width_button_analytics_id_2	= ( isset( $meta[ 'cpc_ch_category_cross_sell_full_width_button_analytics_id_2' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_full_width_button_analytics_id_2' ][0] : null;

?>

<?php if ( get_queried_object()->taxonomy === 'category' && $full_width_title ) : ?>
		<div class="cross-sell cross-sell--is-full-width">
			<div class="cross-sell__container cross-sell__container--is-full-width">
				<div class="cross-sell__text <?php echo ( $full_width_image ) ? '' : 'cross-sell__text--is-full-width' ?>">
					<span class="cross-sell__heading cross-sell__heading--is-centered"><?php echo ( $full_width_title ) ?  $full_width_title : ''; ?></span>
					<?php if ( $full_width_button_title_1 ) : ?>
						<div>
							<a href="<?php echo ( $full_width_button_link_1 ) ? $full_width_button_link_1  : '' ?>" class="cross-sell__link cross-sell__link--is-centered" id="<?php echo ( $full_width_button_analytics_id_1 ) ? $full_width_button_analytics_id_1 : '' ?>" <?php echo ( $full_width_button_target_1 ) ? 'target="_blank"' : ''; ?>>
								<?php echo ( $full_width_button_title_1 ) ? $full_width_button_title_1 : ''; ?>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( $full_width_button_title_2 ) : ?>
						<div>
							<a href="<?php echo ( $full_width_button_link_2 ) ? $full_width_button_link_2 : '' ?>" class="cross-sell__link cross-sell__link--is-secondary cross-sell__link--is-centered" id="<?php echo ( $full_width_button_analytics_id_2 ) ? $full_width_button_analytics_id_2 : '' ?>" <?php echo ( $full_width_button_target_2 ) ? 'target="_blank"' : ''; ?>>
								<?php echo ( $full_width_button_title_2 ) ? $full_width_button_title_2 : ''; ?>
							</a>
						</div>
					<?php endif; ?>
				</div>
				<?php if ( $full_width_image ) : ?>
					<div class="cross-sell__img <?php echo ( $full_width_image_alignment === 'horizontal' ) ? 'cross-sell__img--is-horizonally-aligned' : '' ?>" style="background-image: url(<?php echo ( $full_width_image ) ? $full_width_image : ''; ?>)" aria-label="<?php echo ( $full_width_title ) ? $full_width_title : ''; ?>"></div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>