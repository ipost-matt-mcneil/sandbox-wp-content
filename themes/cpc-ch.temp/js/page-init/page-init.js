/* eslint-disable */

/* Page initialization
  Global functions to be executed at page load
  - adjustFooter() - Pin footer to bottom of page if not enough content is present
*/

document.addEventListener('DOMContentLoaded', initializeComponent);

function initializeComponent() {
  adjustFooter();
  window.addEventListener('resize', adjustFooter, false );
}

function adjustFooter() {
  window.setTimeout(function() { // Required for orientation change
    const clientHeight = window.innerHeight || document.clientHeight || body.clientHeight;
    const mainHeight = document.querySelector('.main').offsetHeight || 0;
    const headerHeight = document.querySelector('.header ').offsetHeight || 0;
    const footerHeight = document.querySelector('.footer').offsetHeight || 0;

    if (headerHeight + mainHeight + footerHeight < clientHeight) {
      document.querySelector('.footer').classList.add('footer--is-anchored');
    } else {
      document.querySelector('.footer').classList.remove('footer--is-anchored');
    }
  }, 200);
}

