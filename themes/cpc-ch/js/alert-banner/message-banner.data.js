/**
 * Global message banner config and persistence.
 *
 * Messages must support the following API. Note that a default
 * message should always be specified.
 *
 * Optionally, for page specific messages, define a urlMap, which is
 * a regular expression lookup. The first matching regex is the message
 * entry that's used. If no map entries match, then the default message is used.
 *
 * window.cpcAlertBannerMsgs = {
 *   default: { 
 *     fr: 'French message',
 *     en: 'English message'
 *   },
 *   urlMap: [ 
 *     {
 *       regex: /some-url-regex/i,
 *       fr: 'French message',
 *       en: 'English message' 
 *     },
 *     {
 *       regex: /another-url-regex/i,
 *       fr: 'French message',
 *       en: 'English message' 
 *     }
 *   ]
 */
import { getPreoutClose } from './preoutClose.data';
import { setStore, storeKeys } from '../utils/data-store';
import DomainParser from '../utils/domain-utils';
import getJSON from '../utils/getJSON';

let banner;
export default class MessageBannerData {
  initialize(globalBanner) {
    banner = globalBanner;
    configureMessage.call(this);
  }

  /**
   * Returns null if there is either no message to show to users, or if the
   * user has closed the global message banner.
   *
   * @returns global message banner HTML otherwise.
   */
  getMessage() {
    return this.message;
  }
}

// Private implementation

/*
 * Populates the in-memory store based on the correct banner
 * message to show 
 */
function configureMessage() {
  if (getUserClosedBannerFlag()) {
    setMessageStore(null);
    return;
  }

  const url = getAppUrl();
  if (isDefinedCpcAlertBannerMsgs(window.cpcAlertBannerMsgs)) {
    // For compatible with the legacy banner temporarily.
    // Should be removed once the cpc-banner app deployed
    setMessageStore(findMessage(window.cpcAlertBannerMsgs, url));
    banner.initialize();
  } else {
    // call CWC
    getJSON(getBannerMessageApiUrl(), (banners) => {
      if (isEmptyMessage(banners)) {
        setMessageStore(null);
        return;
      }

      setMessageStore(findMessage(banners, url));
      banner.initialize();
    });
  }
}

function findMessage(messageMap, url) {
  // No message map defined
  if (!messageMap) return null;

  const hasMap = messageMap.urlMap && typeof messageMap.urlMap === 'object'
    && messageMap.urlMap.length > 0;

  if (hasMap) {
    const match = Array.prototype.slice.call(messageMap.urlMap).find((mapItem) => {
      if (mapItem.regex instanceof RegExp) {
        return url.match(mapItem.regex);
      }

      return mapItem.regex.split(',').find(path => url.match(new RegExp(path.trim(), 'i')));
      // mapItem => mapItem.regex && url.match(mapItem.regex)
    });
    if (match) {
      return match;
    }
  }
  return messageMap.default;
}

/*
 * Returns true if user has closed the global message banner and it should be
 * suppressed, false otherwise. 
 */
function getUserClosedBannerFlag() {
  return getPreoutClose();
}

function setMessageStore(message) {
  if (!message) return;
  setStore(storeKeys.banner, message);
}

const BANNER_MESSAGE_API_PATH = '/cwc/components/api/bannermsg';

function getBannerMessageApiUrl() {
  let domain = '';
  let crossDomain = false;

  const parser = new DomainParser(window.location);
  if (parser.isLocalhost()) {
    domain = `${window.location.hostname}:${window.location.port}`;
    //
    // Enable the below if you want to test CWC locally running on port 7080
    //
    // crossDomain = true;
    // domain = 'localhost:7080';
  } else {
    const subDomain = parser.getCanadaPostSubdomain();
    domain = `${subDomain}.canadapost-postescanada.ca`;
    if (domain !== window.location.hostname) {
      // for epost.ca domain
      crossDomain = true;
    } else if (subDomain === 'est') {
      // IA-4103
      //
      // For EST production (https://est.canadapost-postescanada.ca)
      crossDomain = true;
      domain = 'www.canadapost-postescanada.ca';
    }
  }

  const url = `${window.location.protocol}//${domain}${BANNER_MESSAGE_API_PATH}`;
  return crossDomain ? `${url}?callback=?` : url;
}

function isEmptyMessage(banners) {
  if (banners.default === null && !banners.urlMap) {
    return true;
  }
  return banners.default === null && banners.urlMap.length === 0;
}

function isDefinedCpcAlertBannerMsgs(msg) {
  return msg && (msg.default || msg.urlMap);
}

function getAppUrl() {
  let url = window.location.href;
  if (url.indexOf('EDMS/inc/header_footer')) {
    // eConnect: running header/footer in 2 separated iFrames
    url = window.parent.location.href;
  }

  return url;
}