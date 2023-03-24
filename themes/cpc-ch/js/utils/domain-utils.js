const linkParser = document.createElement('a');
const localhostRegEx = /localhost/i;
const constants = { 
  www: 'www',
  cpDotCa: '.canadapost-postescanada.ca'
};

/**
 * Utilities for parsing URL to get current domain / subdomain, map 
 * SSO domain URLs to canadapost-postescanada.ca domain URLs
 */
export default class DomainParser { 
  /**
   * Constructs a new instance of domain parser
   * @param {string} url - full URL with scheme. If scheme is not provided, 
   *        url is assumed related to current domain
   */
  constructor(url) {
    this.url = getLocation(url);
  }

  /**
   * Returns a string representing the subdomain of the current environment. I.e.: 
   * www.canadapost-postescanada.ca -> returns www
   * stg12.canadapost-postescanada.ca -> returns stg12
   * localhost -> www.
   * 
   * SSO domains return an appropriately mapped stg12, www., 
   * etc. domain i.e.: 
   * stg002-sso.epost.ca -> returns stg12 since stg002-sso maps
   *                        to the stg12 environment
   */
  getCanadaPostSubdomain() {
    if (isSubdomainSSO.call(this)) {
      return mapSSODomain(this.url);
    }
    return localhostRegEx.test(this.url.hostname) ? constants.www
      : this.url.hostname.split('.')[0];
  }

  /**
   * Takes a relative URL and converts it to a canadapost-postescanada.ca domain URL
   * @param {string} url - relative URL
   */
  getCanadaPostDomainUrl(url) {
    const parsedUrl = url.startsWith('/') || url.length === 0 ? url : `/${url}`;
    return localhostRegEx.test(this.url.hostname)
      ? url
      : `https://${this.getCanadaPostDomain()}${parsedUrl}`;
  }

  /**
   * Returns a string representing the canadapost-postescanada.ca domain URL for the current environment. I.e.: 
   * www.canadapost-postescanada.ca/blah -> returns www.canadapost-postescanada.ca
   * stg12.canadapost-postescanada.ca/blah -> returns stg12.canadapost-postescanada.ca
   * localhost -> www.canadapost-postescanada.ca
   * 
   * SSO domains return an appropriately mapped stg12, www., 
   * etc. domain i.e.: 
   * stg002-sso.epost.ca -> returns stg12.canadapost-postescanada.ca since stg002-sso maps
   *                        to the stg12 environment
   */
  getCanadaPostDomain() {
    if (isSubdomainSSO.call(this)) {
      return `${mapSSODomain(this.url)}${constants.cpDotCa}`;
    }

    if (isSubdomainEST.call(this)) {
      return this.url.hostname.replace('est', 'www');
    }

    return localhostRegEx.test(this.url.hostname) 
      ? `${constants.www}${constants.cpDotCa}`
      : this.url.hostname.replace('.est', '');
  }

  /**
   * Compares the given url's scheme + host + port
   * to the scheme + host + port of the current page
   *  
   * @param {string} url 
   * @returns {boolean} true if everything matches, false otherwise
   */
  isUrlSameDomain(url) {
    const testUrlParser = document.createElement('a'); 
    testUrlParser.href = url;
    
    // IE fun - IA-3772
    if (testUrlParser.host === '') {
      testUrlParser.href = testUrlParser.href; // eslint-disable-line no-self-assign
    }

    return this.url.protocol === testUrlParser.protocol 
      && this.url.host === testUrlParser.host
      && this.url.port === testUrlParser.port;
  }

  isLocalhost() {
    return localhostRegEx.test(this.url.hostname);
  }
}

function isSubdomainEST() {
  return /^est\./i.test(this.url.hostname);
}

function isSubdomainSSO() {
  return /\.epost\.ca/i.test(this.url.hostname);
}

/**
 * Receives an epost.ca SSO URL and depending on the sub-domain, maps it to 
 * one of our dev / stg / prod environments. If no mapping is found, 
 * falls back to www. Examples: 
 * 
 * https://sso.epost.ca/sso/blah -> 'www'
 * https://stg002-sso.epost.ca/sso/blah -> 'stg12'
 * 
 * At this time, dev10 and dev11 both use dev001-sso, but
 *   dev001-sso maps to dev10
 * At this time, stg10 and stg11 both use stg001-sso, but
 *   stg001-sso maps to stg10
 * At this time, sso maps to www, but beta* and prd* environments
 *   also use www. 
 * 
 * @param {string} - Canada Post SSO URL 
 * @return {string} - matching dev/stg/prd environment, or www
 *   if SSO environment doesn't match with anything
 */
function mapSSODomain(ssoUrl) {
  const ssoLocation = getLocation(ssoUrl);
  const ssoSubdomain = localhostRegEx.test(ssoLocation.hostname) ? constants.www 
    : ssoLocation.hostname.split('.')[0].replace('-sso', '').replace('-www', '');

  const ssoMap = { 
    sso: 'www',
    stg004: 'stg14',
    stg003: 'stg13',
    stg002: 'stg12',
    stg001: 'stg10',
    dev003: 'dev13',
    dev002: 'dev12',
    dev001: 'dev10'
  };

  return ssoMap[ssoSubdomain] || constants.www; 
}

/**
 * Takes a string location, and returns a corresponding Location object
 * @param {string} url 
 * @returns {Location} corresponding Location object
 */
function getLocation(url) {
  linkParser.href = url;
  return linkParser;
}