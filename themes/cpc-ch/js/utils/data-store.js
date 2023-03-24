/**
 * Simple API to make CWC properties globally available
 */
const store = []; 

/**
 * Available list of in-memory persistence stores
 */
const storeKeys = { 
  cwc: 'cwc',
  nav: 'nav',
  banner: 'banner'
};

/**
 * Sets in-memory store. 
 * 
 * @param {key} - Store key. See the storeKeys const
 * @param {value} - corresponding value
 */
function setStore(key, value) {
  store[key] = value;  
}

/**
 * Gets the given in-memory store
 * @returns {key} - one of storeKeys
 */
function getStore(key) {
  return store[key];
}

function getCwc() {
  return getStore(storeKeys.cwc);
}

export {
  setStore, getStore, storeKeys, getCwc 
};