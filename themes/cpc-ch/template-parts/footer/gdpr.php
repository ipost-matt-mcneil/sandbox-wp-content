<?php 
$cookies_link = "https://www.canadapost-postescanada.ca" . (get_bloginfo( 'language' ) === 'fr-CA' ? 
	'/scp/fr/soutien/bc/demandes-generales/renseignements-generaux/supprimer-les-temoins-dans-votre-navigateur' :
	'/cpc/en/support/kb/general-inquiries/general-information/delete-cookies-using-your-browser-canada-post');

$privacy_link = "https://www.canadapost-postescanada.ca" . (get_bloginfo( 'language' ) === 'fr-CA' ? 
	'/scp/fr/notre-entreprise/a-notre-sujet/politique-protection-renseignements-personnels/introduction-politique-renseignements-personnels.page' :
	'/cpc/en/our-company/about-us/privacy-policy/privacy-policy-introduction.page');

if ( is_amp() ) : ?>
	<amp-user-notification layout="nodisplay" class="gdpr" id="amp-user-notification1">
		<div class="gdpr__text">
			<?php _e('We\'ve placed cookies on your device to improve your browsing experience. They\'re safe and don\'t contain sensitive information. If you want, you can', 'cpc-ch'); ?>
			<a class="gdpr__link" href="<?php echo $privacy_link;?>">
				<?php _e('change your cookies', 'cpc-ch'); ?>
			</a>
			<?php _e('through your browser settings. If you continue without changing your settings, we\'ll assume you\'re ok to receive all cookies on the Canada Post website.', 'cpc-ch'); ?>
			<a class="gdpr__link" href="<?php echo $cookies_link;?>">
				<?php _e('For more information view our privacy policy.', 'cpc-ch'); ?>
			</a>
		</div>
		<button on="tap:amp-user-notification1.dismiss" class="gdpr__button button secondary" aria-label="<?php _e('Click button called I understand to delete the cookies message', 'cpc-ch'); ?>">
			<?php _e('I understand', 'cpc-ch'); ?>
		</button>
	</amp-user-notification>
<?php else : ?>
	<div class="gdpr gdpr--is-hidden">
		<div class="gdpr__container">
			<div class="gdpr__title"><?php _e('Cookies on the Canada Post website', 'cpc-ch'); ?></div>
			<div class="gdpr__content">
				<div class="gdpr__text">
					<?php _e('We\'ve placed cookies on your device to improve your browsing experience. They\'re safe and don\'t contain sensitive information. If you want, you can', 'cpc-ch'); ?>
					<a class="gdpr__link" href="<?php echo $privacy_link;?>"><?php _e('change your cookies', 'cpc-ch'); ?></a>
					<?php _e('through your browser settings. If you continue without changing your settings, we\'ll assume you\'re ok to receive all cookies on the Canada Post website.', 'cpc-ch'); ?>
					<a class="gdpr__link" href="<?php echo $cookies_link;?>">
					<?php _e('For more information view our privacy policy.', 'cpc-ch'); ?></a>
				</div>
				<a class="gdpr__button button secondary" tabindex="0" aria-label="<?php _e('Click button called I understand to delete the cookies message', 'cpc-ch'); ?>"><?php _e('I understand', 'cpc-ch'); ?></a>
			</div>
		</div>
	</div>
<?php endif; ?>
