<!doctype html>
<html <?php if (is_amp()) : ?>amp<?php endif; ?> <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link type="image/x-icon" href="/cpc/assets/cpc/img/logos/favicon.ico" rel="shortcut icon">
	<?php wp_head(); ?>
</head>

<body>
	<?php if (is_amp()) echo build_main_navigation(); ?>
	<div class="header">
		<?php echo build_skip_to_main_content(); ?>
		<div class="header__container">
			<?php echo build_hamburger(); ?>
			<?php echo build_logo(); ?>
			<?php if (!is_amp()) echo build_main_navigation(); ?>
			<?php echo build_search(); ?>
			<?php echo build_language(); ?>
		</div>
	</div>