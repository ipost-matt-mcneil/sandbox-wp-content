/**
 * Gets the root of the current domain without the www, stgxx, or devxx prefix. 
 * 
 * Used for setting a domain specific cookie without the www, stg, dev, or prod prefixes
 * 
 * I.e. www.canadapost-postescanada.ca : returns .canadapost-postescanada.ca
 * 
 * @param {object} domain - Location object (window.location)
 */
function getRootDomain(domain) {
  const ipAddyRegEx = /\d*\.\d*\.\d*\.\d*/i; 

  if (ipAddyRegEx.test(domain.hostname)) {
    return domain.hostname;
  }

  return domain.hostname 
    ? domain.hostname.substring(domain.hostname.indexOf('.'))
    : '';
}

// Used to determine if we're in production in order to sync up all of the redundant
// LANG cookies
function isProduction() {
  return /^www.canadapost/i.test(window.location.hostname);
}

/**
 * Syncs up all redundant LANG cookies for the prod canadapost-postescanada.ca 
 * domain. 
 * 
 * There are several domain cookie LANG variants 
 * floating around, but it is
 * necessary to do this to reduce application stability risks. 
 * 
 * LANG domain www.canadapost-postescanada.ca
 * LANG domain .www.canadapost-postescanada.ca
 * 
 * @param {string} lang - Either 'e', or 'f' as required by the language module
 */
function syncAllLangCookies(lang, expiredays) { 
  if (isProduction()) {
    const domain = window.location.hostname.toLowerCase();
    setCookie('LANG', lang, expiredays, false, 
      domain);
    setCookie('LANG', lang, expiredays, false, 
      `.${domain}`);
  }
}

function setCookie(cookieName, value, expiredays, ifEscape, domain) {
  const exdate = new Date();
  let expiredate;
  let root = '';
  let cookieValue = null;

  if (domain) {
    root = `;domain=${domain}`;
  } else { 
    root = '';
  }
  exdate.setDate(exdate.getDate() + expiredays);
  if (expiredays !== 0) {
    expiredate = exdate.toGMTString();
  } else {
    expiredate = 0;
  }
  const expires = ((expiredays == null) ? '' : `;expires=${expiredate}${root};path=/`);

  if (!ifEscape) { 
    cookieValue = escape(value);
  }
  document.cookie = `${cookieName}=${cookieValue}${expires}`;
}

function getCookie(cookieName) {
  if (document.cookie.length > 0) {
    let start = document.cookie.indexOf(`${cookieName}=`);
    if (start !== -1) {
      start = start + cookieName.length + 1;
      let end = document.cookie.indexOf(';', start);
      if (end === -1) {
        end = document.cookie.length;
      }
      return unescape(document.cookie.substring(start, end));
    }
  }
  return '';
}

export {
  setCookie, getCookie, getRootDomain, syncAllLangCookies 
};