<?php

$meta 											= get_term_meta( get_queried_object()->term_id );
$inline_title 							= ( isset( $meta[ 'cpc_ch_category_cross_sell_inline_title' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_inline_title' ][0] : null;
$inline_icon_image					= ( isset( $meta[ 'cpc_ch_category_cross_sell_inline_icon_image' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_inline_icon_image' ][0] : null;
$inline_button_title				= ( isset( $meta[ 'cpc_ch_category_cross_sell_inline_button_title' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_inline_button_title' ][0] : null;
$inline_button_link					= ( isset( $meta[ 'cpc_ch_category_cross_sell_inline_button_link' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_inline_button_link' ][0] : null;
$inline_button_target				= ( isset( $meta[ 'cpc_ch_category_cross_sell_inline_button_target' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_inline_button_target' ][0] : null;
$inline_button_analytics_id	= ( isset( $meta[ 'cpc_ch_category_cross_sell_inline_button_analytics_id' ][0] ) ) ? $meta[ 'cpc_ch_category_cross_sell_inline_button_analytics_id' ][0] : null;

?>

<div class="cross-sell">
	<div class="cross-sell__container">
		<div class="cross-sell__title">
			<?php if ( $inline_icon_image ) :  ?>
				<span class="cross-sell__icon" style="background-image: url(<?php echo $inline_icon_image; ?>"></span>
			<?php endif; ?>
			<span class="cross-sell__heading"><?php echo ( $inline_title ) ? $inline_title : '' ?></span>
		</div>
		<?php if ( $inline_button_title  ) :  ?>
			<a href="<?php echo ( $inline_button_link ) ?  $inline_button_link : '' ?>" class="cross-sell__link cross-sell__link--is-positioned" id="<?php echo  ( $inline_button_analytics_id  ) ? $inline_button_analytics_id  : '' ?>" <?php echo ( $inline_button_target ) ? 'target="_blank"' : '' ?>>
				<?php echo ( $inline_button_title ) ? $inline_button_title : '' ?>
			</a>
		<?php endif; ?>	
		<div class="cross-sell__ratio"></div>
	</div>
</div>