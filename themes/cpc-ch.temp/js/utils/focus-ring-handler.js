/**
 * Determines if an element was focused via keyboard or mouse. 
 * 
 * Purpose is to prevent Chrome from adding a focus ring around an element
 * that is mouse clicked. There is currently a known Chromium bug around this 
 * (https://bugs.chromium.org/p/chromium/issues/detail?id=271023) and a CSS
 * level 4 selector that is in the works to address it 
 * (https://drafts.csswg.org/selectors/#the-focusring-pseudo)
 * 
 * This accomplishes the same goal as the what-input plugin, https://github.com/ten1seven/what-input, 
 * but with a smaller footprint
 */
class FocusRingHandler {
  /**
   * 
   * @param {string} elementTypes - querySelectorAll friendly list of 
   *        elements types 
   */
  constructor(elementTypes) {
    this.elementTypes = elementTypes;
  }

  /**
   * Wires up focus and click handlers for outline determination
   */
  initialize() {
    Array.prototype.slice.call(document.querySelectorAll(this.elementTypes)).forEach((element) => { 
      element.addEventListener('focus', onFocus);
    });
    Array.prototype.slice.call(document.querySelectorAll(this.elementTypes)).forEach((element) => { 
      element.addEventListener('click', onClick);
    });
  }
}

function onClick(evt) {
  const isKeyboardActivated = isActivatedByKeyboard(evt);
  if (evt.target) {
    evt.target.setAttribute('data-activated-via', isKeyboardActivated ? 'keyboard' : 'mouse');
  }
}

function onFocus(evt) {
  if (evt.target) {
    evt.target.removeAttribute('data-activated-via');
  }
}

function isActivatedByKeyboard(evt) {
  return (!evt.detail && (!evt.pointerType
    || (evt.pointerType && !evt.pointerType))) || evt.mozInputSource === 6;
}

/**
 * Content hub - initialize on load
 */

function setupFocusRingActivation() {
  new FocusRingHandler('a').initialize();
}

document.addEventListener('DOMContentLoaded', setupFocusRingActivation);

/**
 * End of Content hub specific code
 */

export default FocusRingHandler;