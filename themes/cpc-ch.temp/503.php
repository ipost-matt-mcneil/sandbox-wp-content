<?php 

$accessibility_link = "https://www.canadapost-postescanada.ca" . (get_bloginfo( 'language' ) === 'fr-CA' ? 
	'/scp/fr/notre-entreprise/a-notre-sujet/responsabilite-dentreprise/accessibilite.page' :
	'/cpc/en/our-company/about-us/corporate-responsibility/accessibility.page');

$legal_link = "https://www.canadapost-postescanada.ca" . (get_bloginfo( 'language' ) === 'fr-CA' ? 
	'/scp/fr/soutien/bc/demandes-generales/renseignements-generaux/juridiques-conditions-dutilisation' :
	'/cpc/en/support/kb/general-inquiries/general-information/legal-terms-of-use-and-conditions');

$privacy_link = "https://www.canadapost-postescanada.ca" . (get_bloginfo( 'language' ) === 'fr-CA' ? 
	'/scp/fr/notre-entreprise/a-notre-sujet/politique-protection-renseignements-personnels/introduction-politique-renseignements-personnels.page' :
	'cpc/en/our-company/about-us/privacy-policy/privacy-policy-introduction.page');

$suffix  = ( ( WP_ENV !== 'production' ) && ( WP_ENV !== 'staging' ) ) ? 'dev' : 'min'; ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
	<link type="image/x-icon" href="/cpc/assets/cpc/img/logos/favicon.ico" rel="shortcut icon">
	<title>Canada Post/Postes Canada – Server Busy/Serveur occupé</title>
	<link rel="stylesheet" id="cpc-ch-styles-css" href="/blogs/wp-c/themes/cpc-ch/dist/style.<?php echo $suffix ?>.css" type="text/css" media="all" />
</head>
<body class="maintenance">
	<div class="header">
		<div class="header__container">
			<div class="header__hamburger"></div> 
			<div class="header__logo">
				<a href="https://www.canadapost-postescanada.ca/cpc/en/home.page" title="Canada Post/Postes Canada" aria-label="Canada Post/Postes Canada">
					<img class="logo logo--desktop" src="/blogs/wp-c/themes/cpc-ch/img/logo-desktop-en.svg" alt="Canada Post/Postes Canada">
					<img class="logo logo--mobile" src="/blogs/wp-c/themes/cpc-ch/img/logo-mobile.svg" alt="Canada Post/Postes Canada">
				</a>
			</div>		
		</div>
	</div>
	<section class="main" role="main" id="main" aria-label="Main/Principale" tabindex="-1">
		<div class="main__container"> 
			<div class="main__content">  
				<div class="row">
					<div class="large-12 columns">
						<div class="tiles">
								<div class="tiles__container row">
									<div class="tiles__item large-12 columns">
										<div class="card__img-wrapper">
											<img src="/blogs/wp-c/themes/cpc-ch/img/maintenance.svg" class="card__img" alt="A laptop with a sad face on a desk. / Un ordinateur portable avec un visage triste sur un bureau.">
										</div>
									</div>
									<div class="tiles__item large-6 medium-6 small-12 columns">
										<h2>Looks like our server is busy</h2>
										<p>We're experiencing some technical issues at the moment. We apologize for the inconvenience. <strong>Try refreshing the page</strong> or head back to the homepage.</p>
										<a href="https://www.canadapost-postescanada.ca/cpc/en/home.page" class="button secondary" aria-label="Go to homepage">Go to homepage</a>
									</div>
									<div class="tiles__item large-6 medium-6 small-12 columns">
										<h2>Notre serveur est occupé</h2>
										<p>Nous éprouvons quelques problèmes techniques en ce moment. Nous nous excusons de cet inconvénient. <strong>Essayez d’actualiser la page</strong> ou retournez à la page d’accueil.</p>
										<a href="https://www.canadapost-postescanada.ca/scp/fr/home.page" class="button secondary" aria-label="Aller à la page d'accueil">Aller à la page d'accueil</a>
									</div>
								</div>
							</div>
						</div>
					</div>  
				</div> 
			</div>  
		</div> 
	</section> 
	<div class="footer" role="contentinfo" aria-label="Content information/Informations sur le contenu">
		<div class="footer__container">
			<div class="footer__canada-post">
				<a href="https://www.canadapost-postescanada.ca/cpc/en/home.page" class="footer__link" aria-label="Go to the Canada Post homepage/">Go to the Canada Post homepage</a>
				<span class="icon icon--open-in-new-window"></span>
			</div>
			<div class="footer__copyright">
				<span>&copy; Canada Post Corporation</span>
			</div>
			<div class="footer__navigation">
				<nav role="navigation" aria-label="Footer navigation/Navigation dans le pied de page">
					<a href="<?php echo $privacy_link;?>"  class="footer__link footer__link--list">Privacy</a>
					<a href="<?php echo $legal_link;?>"  class="footer__link footer__link--list">Legal</a>
					<a href="<?php echo $accessibility_link;?>"  class="footer__link footer__link--list">Accessibility</a>
				</nav>
			</div>      
			<div class="footer__canada">
				<a href="https://www.canada.ca/" title="Canada" aria-label="Canada">
					<span class="icon icon--canada"></span>
				</a>
			</div>
		</div>
	</div>
	<script type='text/javascript' src='/blogs/wp-c/themes/cpc-ch/dist/script.<?php echo $suffix ?>.js'></script>
</body>	
