/* global FB */
/**
 * File: page-social.js.
 *
 * Handles the click-events for social sharing that is present on each page.
 *
 */

document.addEventListener('DOMContentLoaded', initializeSocialSharing);

function initializeSocialSharing() {
  const socialShareBtns = document.querySelectorAll('.js-social');
  for (let i = 0; i < socialShareBtns.length; i += 1) {
    socialShareBtns[i].addEventListener('click', ssPluginLoadPopupJS.bind(this, socialShareBtns[i]));
    socialShareBtns[i].addEventListener('keyup', handleKeyPressSocial);
  }
}

function handleKeyPressSocial(evt) {
  const curElement = evt.target || evt.srcElement;
  const key = evt.which || evt.keyCode;

  if (key === 13) {
    curElement.click();
    curElement.focus();
  }
}

function ssPluginLoadPopupJS(em) {
  const shareurl = em.getAttribute('data-href');
  const top = (window.screen.availHeight - 500) / 2;
  const left = (window.screen.availWidth - 500) / 2;
  if (em.classList.contains('icon--facebook')) {
    const ogUrl = em.getAttribute('data-url');
    const ogTitle = em.getAttribute('data-quote');
    const ogImage = (document.querySelector("meta[property='og:image']"))
      ? document.querySelector("meta[property='og:image']").getAttribute('content')
      : '';


    // This approach isn't officially supported and while it's worked for several years eventually it will break.
    FB.ui({
      method: 'share_open_graph',
      action_type: 'og.shares',
      display: 'popup',
      action_properties: JSON.stringify({
        object: {
          'og:url': ogUrl,
          'og:title': ogTitle,
          'og:image': ogImage
        }
      })
    });
  } else {
    window.open(
      shareurl,
      'social sharing',
      `width=550,height=420,left=${left},top=${top},location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1`
    );
  }
  return false;
}
