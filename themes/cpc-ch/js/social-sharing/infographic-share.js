/**
 * infographic-share
 * This component will attach listeners to social-share buttons located in an
 * inforgraphic ribbon and execute the sharing functionality.  It will also
 * execute show/hide animation for the ribbon for large & above resolutions.
 */

document.addEventListener('DOMContentLoaded', initializeInfographicSharing);
const shareToggleRibbon = document.querySelectorAll('.share-toggle');

function initializeInfographicSharing() {
  if (shareToggleRibbon.length === 0) return;

  window.onresize = () => {
    resizeRibbon();
  };
  resizeRibbon();

  const socialToggles = document.querySelectorAll('.share-toggle-button');
  for (let i = 0; i < socialToggles.length; i += 1) {
    socialToggles[i].addEventListener('click', handleClickSocialToggle.bind(this, socialToggles[i]));
    socialToggles[i].addEventListener('keyup', handleKeyPressSocialToggle);
  }

  const socialBtns = document.querySelectorAll('.share-button');
  for (let i = 0; i < socialBtns.length; i += 1) {
    socialBtns[i].addEventListener('click', handleClickSocialShare.bind(this, socialBtns[i]));
    socialBtns[i].addEventListener('keyup', handleKeyPressSocialToggle);
  }
}

function resizeRibbon() {
  const shareImage = document.querySelectorAll('.infographic-container img');
  const curWindowWidth = document.body.clientWidth;

  if (curWindowWidth > 640) {
    shareToggleRibbon[0].style.cssText = '';
    return;
  }

  if (curWindowWidth <= 640) {
    shareToggleRibbon[0].style.cssText = `width: ${shareImage[0].width + 25}px`;
  } else {
    shareToggleRibbon[0].style.cssText = '';
  }
}

function handleClickSocialToggle(ele) {
  // const shareToggleRibbon = document.querySelectorAll('.share-button');

  ele.parentElement.classList.toggle('share-clicked-state');
  let newTabIndex = '0';
  if (ele.parentElement.classList.contains('share-clicked-state')) {
    ele.parentElement.setAttribute('aria-expanded', true);
    ele.setAttribute('aria-label', 'close links');
    newTabIndex = '0';
  } else {
    ele.setAttribute('aria-label', 'expand links');
    ele.parentElement.setAttribute('aria-expanded', false);
    newTabIndex = '-1';
  }
  const socialLinks = document.querySelectorAll('.infographic-container a');
  for (let i = 1; i < socialLinks.length; i += 1) {
    socialLinks[i].tabIndex = newTabIndex;
  }
  ele.blur();
}

function handleClickSocialShare(ele) {
  let shareURL = '';

  if (ele.classList.contains('share-linkedin')) {
    // const linkedin_title = ele.getAttribute('data-title') || ''; * Titles have been deprecated for LI shares
    const linkedinUrl = ele.getAttribute('data-url') || '';
    // shareURL = `http://www.linkedin.com/shareArticle?mini=true&url=${linkedinUrl}&title=${linkedin_title}`;
    shareURL = `http://www.linkedin.com/shareArticle?mini=true&url=${linkedinUrl}`;
  } else if (ele.classList.contains('share-facebook')) {
    const FBDesc = ele.getAttribute('data-description') || '';
    const FBTitle = ele.getAttribute('data-caption') || '';
    const FBPic = ele.getAttribute('data-img') || '';

    // This approach isn't officially supported and while it's worked for several years eventually it will break.
    window.FB.ui({
      method: 'share_open_graph',
      action_type: 'og.shares',
      display: 'popup',
      action_properties: JSON.stringify({
        object: {
          'og:url': FBPic,
          'og:title': FBTitle,
          'og:description': FBDesc,
          'og:image': FBPic
        }
      })
    });
    return false;
  } else if (ele.classList.contains('share-twitter')) {
    const twitterText = ele.getAttribute('data-text') || '';
    const twitterUrl = ele.getAttribute('data-url') || '';
    shareURL = `http://twitter.com/intent/tweet/?text=${twitterText}&url=${twitterUrl}`;
  } else if (ele.classList.contains('share-email')) {
    const emailSubject = ele.getAttribute('data-subject') || '';
    const emailBody = ele.getAttribute('data-body') || '';
    window.location.href = `mailto:?subject=${emailSubject}&body=${emailBody}`;
    return false;
  } else if (ele.classList.contains('share-download')) {
    return false;
  }

  const top = (window.screen.availHeight - 500) / 2;
  const left = (window.screen.availWidth - 500) / 2;
  window.open(
    shareURL,
    'social sharing',
    `width=550,height=420,left=${left},top=${top},location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1`
  );
  ele.blur();

  return false;
}

function handleKeyPressSocialToggle(evt) {
  const curElement = evt.target || evt.srcElement;
  const key = evt.which || evt.keyCode;

  if (key === 13) {
    curElement.click();
    curElement.focus();
  }
}
