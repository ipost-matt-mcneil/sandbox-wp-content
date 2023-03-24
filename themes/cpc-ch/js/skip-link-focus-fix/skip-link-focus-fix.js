/* eslint-disable  */
/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
// (function () {
//   var isIe = /(trident|msie)/i.test(navigator.userAgent);

//   if (isIe && document.getElementById && window.addEventListener) {
//     window.addEventListener('hashchange', () => {
//       var id = location.hash.substring(1);

        
//       var element;

//       if (!(/^[A-z0-9_-]+$/.test(id))) {
//         return;
//       }

//       element = document.getElementById(id);

//       if (element) {
//         if (!(/^(?:a|select|input|button|textarea)$/i.test(element.tagName))) {
//           element.tabIndex = -1;
//         }

//         element.focus();
//       }
//     }, false);
//   }
// }());

class SkipNavigation {
  constructor(element) {
    this.element = element;
    this.target = element.hash;
  }

  static initialize(element) {
    new SkipNavigation(element).addEvent();
  }

  addEvent() {
    if (this.target) {
      const tabindex = document.querySelector(`${this.target}`).hasAttribute('tabindex');
      if (!tabindex) {
        const mainContent = document.querySelector(`${this.target}`); 
        const mainContentAttr = document.createAttribute('tabindex'); 
        mainContentAttr.value = 0;
        mainContent.setAttributeNode(mainContentAttr); 
      }
    }
  }
}

document.addEventListener('DOMContentLoaded', SkipNavigation.initialize(
  document.getElementsByClassName('header__skip-to-main-content')[0]
));
