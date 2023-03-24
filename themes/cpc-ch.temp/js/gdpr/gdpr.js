/* eslint-disable */
/* global _satellite:true */

/* GDPR Cookie Warning banner

This is the code controlling the display of the `Accept Cookies?` banner

 */

import { getCookie, setCookie } from '../utils/cookies';

document.addEventListener('DOMContentLoaded', GdprCookieBanner);

/**
 * Display Canada post cookie collecting policy per GDPR
 */
function GdprCookieBanner(_options) {
  const SELECTOR_MAIN_CONTAINER = '.main__container';
  const SELECTOR_DISMISS_BANNER_CTAS = '.gdpr__button';
  const SELECTOR_GDPR_COOKIE_BANNER_CONTAINER = '.gdpr';
  const COOKIE_POLICY_ACCEPT = 'cpc-gdpr-cookie-policy-accept';
  const CFG_EXCLUDED_PAGES = [
    '/home.page'
  ];

  // Unlike other domains, the cookie for this site need to inherit it's width
  window.onresize = () => {
    setTimeout(() => {
      resizeCookieWidth();
    }, 250);
  };
  resizeCookieWidth();

  const excludedPages = _options
    ? _options.excludedPages || CFG_EXCLUDED_PAGES
    : CFG_EXCLUDED_PAGES;

    if (userHasAccepted() || isExcludedPage()) return;

    loadBanner();

  /**
   * Check cookie value 'cpc-gdpr-cookie-policy-accept', if value is 'true', return true, otherwise return false.
   */
  function userHasAccepted() {
    return getCookie(COOKIE_POLICY_ACCEPT) === 'true';
  }

  function isExcludedPage() {
    const path = window.location.pathname;
    for (let i = 0; i < excludedPages.length; i += 1) {
      //
      // TODO: to support regexp
      //
      if (path.indexOf(excludedPages[i]) !== -1) return true;
    }

    return false;
  }

  function loadBanner() {
    createBannerElement();
    registerEventHandler();

    // When display the banner fire this call
    track('cookiepolicy_presented');
  }
  function registerEventHandler() {
    const dismissCtaElms = document.querySelectorAll(SELECTOR_DISMISS_BANNER_CTAS);
    for (let i = 0; i < dismissCtaElms.length; i += 1) {
      dismissCtaElms[i].addEventListener('click', onClick);
      dismissCtaElms[i].addEventListener('keyup', onKeyup);
    }
  }

  function onClick() {
    dismissBanner();
  }

  function onKeyup(e) {
    const key = e.which || e.keyCode;
    if (key === 13) {
      // enter key
      e.preventDefault();
      dismissBanner();
    }
  }

  function dismissBanner() {
    setCookie(COOKIE_POLICY_ACCEPT, 'true', 730, false, 'canadapost-postescanada.ca');

    // when click, fire this to track
    track('cookiepolicy_clicked');

    const bannerElm = document.querySelector(SELECTOR_GDPR_COOKIE_BANNER_CONTAINER);
    bannerElm.parentNode.removeChild(bannerElm);
  }

  function createBannerElement() {
    const bannerElm = document.querySelector(SELECTOR_GDPR_COOKIE_BANNER_CONTAINER);
    bannerElm.classList.remove('gdpr--is-hidden');

    return
  }

  function track() {
    if (typeof _satellite === 'undefined') {
      console.debug('Ignore analytics as not defined');
      return;
    }

    // _satellite.track(value);
  }

  function resizeCookieWidth() {
    const bannerElm = document.querySelector(SELECTOR_GDPR_COOKIE_BANNER_CONTAINER);
    const mainContainerWidth = document.querySelector(SELECTOR_MAIN_CONTAINER).offsetWidth;

    if (bannerElm) {
      bannerElm.style.width = mainContainerWidth + 'px';
    }
  }
}

export default GdprCookieBanner;
