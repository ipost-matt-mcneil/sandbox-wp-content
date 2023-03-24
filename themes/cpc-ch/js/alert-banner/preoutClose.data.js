/**
 * Simple API to get/set "preoutClose" cookie, which is the cookie 
 * responsible for determining if a user has closed the global 
 * alert banner. 
 * 
 * This implementation brings in the behaviour of the previous 
 * cookie reading logic from the old personal site, which evaluated 
 * the cookie as follows:
 * 
 * - if no preoutClose cookie - show global alert banner
 * - if preoutClose cookie exists and value is set to an empty string - show global alert banner
 * - if preoutClose cookie exists no matter what the value (0, 1, whatever) - suppress the global alert banner
 */
import { getCookie, setCookie } from './cookies';

const cookieName = 'preoutClose';

/**
 * Sets the preoutClose cookie, with an expiration of 1 day. Recommend
 * to set with either a blank value, or a 1 value
 * 
 * @param {string} value - value of cookie
 */
function setPreoutClose(value) {
  setCookie(cookieName, value, 1, false);
}

/**
 * Returns a boolean representation of preoutClose cookie reflecting 
 * whether or not user has closed the global alert banner
 */
function getPreoutClose() {
  return getCookie(cookieName) !== '';
}

export { setPreoutClose, getPreoutClose };