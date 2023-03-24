/* eslint-env jquery */

/**
 * Responsible for rendering the global alert banner if a message is
 * available, and related user interactions
 */
import { getStore, storeKeys } from '../utils/data-store';
import { setPreoutClose } from './preoutClose.data';
import globals from '../utils/globals';
import MessageBannerData from './message-banner.data';

document.addEventListener('DOMContentLoaded', initializeAlertBanner);

function initializeAlertBanner() {
  const bannerEle = document.querySelector('.header');

  const globalBanner = new GlobalAlertBanner(bannerEle);
  new MessageBannerData().initialize(globalBanner);
}

export default class GlobalAlertBanner {
  constructor(parentElement) {
    this.parentElement = parentElement;
  }

  initialize() {
    const bannerHtml = getBanner();
    if (bannerHtml) {
      if (this.parentElement) this.parentElement.insertAdjacentElement('afterend', bannerHtml.firstChild);
      this.alertBanner = document.querySelector(`.${constants.globalAlertBannerClass}`);
      this.closeButton = this.alertBanner.querySelector(`.${constants.closeIconClass}`);
      setEventHandlers.call(this);
    }
  }
}

// Private implementation

const htmlTag = document.querySelector('html');
const locale = { 
  en: { 
    close: 'Close'
  },
  fr: { 
    close: 'Fermer'
  }
};
let language = 'en';
const frString = 'fr';

if (htmlTag && ((htmlTag.getAttribute('class') && htmlTag.getAttribute('class').indexOf(frString) !== -1)
  || (htmlTag.getAttribute('lang') && htmlTag.getAttribute('lang').indexOf(frString) !== -1))) {
  language = frString;
}

const constants = { 
  globalAlertBannerClass: 'cpc-global-alert-banner',
  closeIconClass: 'close-icon'
};

const template = items => `
<div class="cpc-global-alert-banner-inner">
<div class="message">
  <div class="info"></div>
  ${items.message}
</div>
</div>
<a href="#" class="${constants.closeIconClass}" ${globals.a11y.ariaLabel}="${items.closeAriaLabel}"></a>
`;

/**
 * Returns null if there is no global alert banner, otherwise 
 * returns a populated document fragment
 */
function getBanner() {
  const message = getStore(storeKeys.banner);
  if (!message) return null;
  const fragment = document.createDocumentFragment();
  const containerDiv = createBannerContainer();
  containerDiv.innerHTML = template({
    message: message[language],
    closeAriaLabel: locale[language].close
  });
  fragment.appendChild(containerDiv);
  return fragment;
}

function createBannerContainer() {
  const containerDiv = document.createElement('article');
  containerDiv.setAttribute(globals.a11y.ariaRole, 'banner');
  containerDiv.className = constants.globalAlertBannerClass;
  return containerDiv;
}

function setEventHandlers() {
  this.closeButton.addEventListener(globals.events.click, onCloseClick.bind(this));
}

function onCloseClick(evt) {
  evt.preventDefault();
  setBannerHeight.call(this);
  // close class animates height of banner to 0

  setTimeout(() => {
    this.alertBanner.addEventListener('transitionend', () => {
      this.alertBanner.parentNode.removeChild(this.alertBanner);
    });
    this.alertBanner.classList.add('close');
  }, 0);
  setPreoutClose('1');
}

/**
 * In order to animate a slide up well, you need to set the actual height of the element as a CSS style property and then animate the height to 0
 */
function setBannerHeight() {
  this.alertBanner.style.height = '';
  const bannerHeight = getBannerHeight.call(this);
  this.alertBanner.style.height = `${bannerHeight}px`;
}

function getBannerHeight() {
  return this.alertBanner.getClientRects()[0].height;
}
