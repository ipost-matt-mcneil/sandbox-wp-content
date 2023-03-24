const body = document.querySelector('body');
const headerContainer = document.querySelector('.header__container');
const headerContainerClass = 'header__container';
const headerContainerStickyClass = 'header__container header__container--is-sticky';
const headerContainerScrollingClass = 'header__container header__container--is-scrolling';
const navigation = document.querySelector('.navigation');
const navigationClass = 'navigation';
const navigationActiveClass = 'navigation navigation--is-active';
const navigationContainer = document.querySelector('.navigation__container');
const navigationContainerClass = 'navigation__container';
const navigationContainerActiveClass = 'navigation__container navigation__container--is-active';
const navigationOverlay = document.querySelector('.navigation__overlay');
const navigationOverlayClass = 'navigation__overlay';
const navigationOverlayActiveClass = 'navigation__overlay navigation__overlay--is-active';
const navigationItemClass = 'navigation__item';
const navigationParent = document.querySelectorAll('.navigation__item--is-parent > a');
const navigationLast = document.querySelectorAll('.navigation__item--is-last > a');
const navigationParentClass = 'navigation__item--is-parent';
const navigationItemActiveClass = 'navigation__item--is-active';
const navigationCurrentParentClass = 'navigation__item--is-current-parent';
const navigationHamburger = document.querySelector('.navigation__hamburger');
const navigationHamburgerClass = 'navigation__hamburger';
const navigationHamburgerActiveClass = 'navigation__hamburger navigation__hamburger--is-active';
const hamburgerActiveClass = 'hamburger--is-active';
const hamburgerIcon = document.querySelectorAll('.hamburger');
const subMenu = document.querySelectorAll('.navigation__submenu');
const subMenuClass = 'navigation__submenu';
const subMenuClassActive = 'navigation__submenu navigation__submenu--is-active';
const banner = document.querySelector('.banner.banner--is-post');

let lastScrollTop = 0;
let shiftOn = false;

function navigationDropdown(event) {
  const clientWidth = window.innerWidth || document.clientWidth || body.clientWidth;
  if (event.keyCode === 13 || event.type === 'click') {
    if (clientWidth < 1025 || event.type !== 'click') {
      event.preventDefault();
    }
    
    if (hasClass(this.nextElementSibling, subMenuClassActive)) {
      this.nextElementSibling.setAttribute('class', subMenuClass); 
      this.setAttribute('aria-expanded', 'false');
      if (hasClass(this.parentElement, navigationCurrentParentClass)) {
        this.parentElement.setAttribute('class', `${navigationItemClass} ${navigationParentClass} ${navigationCurrentParentClass}`);
      } else {
        this.parentElement.setAttribute('class', `${navigationItemClass} ${navigationParentClass}`);
      } 
    } else {
      if (clientWidth > 1024) { // Only allow 1 dropdown open at once on desktop
        navigationRemoveActiveClass();
      }
      this.nextElementSibling.setAttribute('class', subMenuClassActive); 
      this.setAttribute('aria-expanded', 'true');
      if (hasClass(this.parentElement, navigationCurrentParentClass)) {
        this.parentElement.setAttribute('class', `${navigationItemClass} ${navigationParentClass} ${navigationCurrentParentClass} ${navigationItemActiveClass}`); 
      } else {
        this.parentElement.setAttribute('class', `${navigationItemClass} ${navigationParentClass} ${navigationItemActiveClass}`); 
      } 
    }
  }
}

function navigationRemoveActiveClass() { // TS added this function so only 1 submenu can open at once on keyboard
  const activeSubMenu = document.getElementsByClassName('navigation__submenu--is-active');
  if (activeSubMenu.length > 0) {
    activeSubMenu[0].parentElement.classList.remove(navigationItemActiveClass);
    activeSubMenu[0].previousElementSibling.setAttribute('aria-expanded', 'false');
    activeSubMenu[0].classList.remove('navigation__submenu--is-active');
  }
}


function navigationDropdownLast(event) {
  const clientWidth = window.innerWidth || document.clientWidth || body.clientWidth;
  
  if (clientWidth > 1024) {
    if (shiftOn && event.keyCode === 9) {
      shiftOn = false;
    } else if (event.keyCode === 16) {
      shiftOn = true;
    } else {
      this.parentElement.parentElement.setAttribute('class', subMenuClass);
      this.parentElement.parentElement.parentElement.firstChild.setAttribute('aria-expanded', 'false');
      this.parentElement.parentElement.parentElement.classList.remove(navigationItemActiveClass);
    }
  }
}

function navigationDropdownLeave() {
  const clientWidth = window.innerWidth || document.clientWidth || body.clientWidth;
  if (clientWidth > 1024) {
    navigationRemoveActiveClass();
  }
}

function hamburgerMenu(event) {
  if (event.keyCode === 13 || event.type === 'click') {
    event.preventDefault();
    if (hasClass(this, hamburgerActiveClass)) {
      body.setAttribute('class', ''); 
      navigation.setAttribute('class', navigationClass);
      navigationContainer.setAttribute('class', navigationContainerClass);
      navigationOverlay.setAttribute('class', navigationOverlayClass);
      navigationHamburger.setAttribute('class', navigationHamburgerClass);
      headerContainer.setAttribute('class', headerContainerStickyClass);
      body.removeEventListener('touchmove', touchMovePreventDefault, false);
      navigationOverlay.removeEventListener('touchmove', touchMovePreventDefault, false);
      navigationContainer.removeEventListener('touchmove', touchMoveStopPropagation, false);
    } else {
      body.setAttribute('class', 'is-no-scroll'); 
      navigation.setAttribute('class', navigationActiveClass);
      navigationContainer.setAttribute('class', navigationContainerActiveClass);
      navigationOverlay.setAttribute('class', navigationOverlayActiveClass);
      navigationHamburger.setAttribute('class', navigationHamburgerActiveClass);
      headerContainer.setAttribute('class', headerContainerStickyClass);
      body.addEventListener('touchmove', touchMovePreventDefault, false);
      navigationOverlay.addEventListener('touchmove', touchMovePreventDefault, false);
      navigationContainer.addEventListener('touchmove', touchMoveStopPropagation, false);
    }
  }
}

function stickyHeader() {
  const pageHeight = document.documentElement.scrollHeight;
  const currentScrollTop = window.pageYOffset
    || document.documentElement.scrollTop
    || document.body.scrollTop || 0;
  const clientWidth = window.innerWidth || document.clientWidth || body.clientWidth;
  const clientHeight = window.innerHeight || document.clientHeight || body.clientHeight;
  const headerHeight = (clientWidth < 1025) ? 52 : 72; // TS header height on desktop is 72 now
  // const bannerHeight = (clientWidth < 641) ? 312 : 380;
  // const isSafari = (navigator.userAgent.toLocaleLowerCase().indexOf('safari') > -1);
  // const hasBanner = Boolean(document.getElementsByClassName('banner__img')[0]);

  //  if (isSafari && currentScrollTop <= bannerHeight && clientWidth < 1025 && hasBanner) { // TS iphone ipad Safari disable sticky header until scroll is biger than banner only on page has banner
  // headerContainer.classList.remove('header__container--is-sticky', 'header__container--is-scrolling');
  // } else

  if (banner) {
    if (window.pageYOffset < 1) {
      banner.setAttribute('class', 'banner banner--is-post banner--is-top');
    } else if (window.pageYOffset > clientHeight) {
      banner.setAttribute('class', 'banner banner--is-post banner--is-hidden');
    } else {
      banner.setAttribute('class', 'banner banner--is-post');
    } 
  }
  
  if (hasClass(navigation, navigationActiveClass)) {
    headerContainer.setAttribute('class', headerContainerStickyClass);
  } else if (currentScrollTop > lastScrollTop) { 
    if (currentScrollTop < headerHeight) {
      headerContainer.setAttribute('class', headerContainerClass);
    } else {
      headerContainer.setAttribute('class', headerContainerScrollingClass);
    }
  } else if (currentScrollTop > pageHeight - clientHeight + headerHeight) {
    headerContainer.setAttribute('class', headerContainerScrollingClass);
  } else if (currentScrollTop < 1) { // TS adde this fix to remove fixed postion when scroll back to top
    headerContainer.classList.remove('header__container--is-sticky', 'header__container--is-scrolling');
  } else {
    headerContainer.setAttribute('class', headerContainerStickyClass);
  }
  lastScrollTop = currentScrollTop;
}

function stickyHeaderIE(event) {
  event.preventDefault();
  const wd = event.wheelDelta;
  const csp = window.pageYOffset;
  window.scrollTo(0, csp - wd);
}

function overlayClose() {
  if (hasClass(navigation, navigationActiveClass)) {
    body.setAttribute('class', ''); 
    navigation.setAttribute('class', navigationClass);
    navigationContainer.setAttribute('class', navigationContainerClass);
    navigationHamburger.setAttribute('class', navigationHamburgerClass);
    body.removeEventListener('touchmove', touchMovePreventDefault, false);
    navigationOverlay.removeEventListener('touchmove', touchMovePreventDefault, false);
    navigationContainer.removeEventListener('touchmove', touchMoveStopPropagation, false);
  } 
}

function touchMovePreventDefault(event) {
  event.stopPropagation();
  event.preventDefault();
}

function touchMoveStopPropagation(event) {
  event.stopPropagation();
}

function hasClass(element, cls) {
  return (` ${element.className} `).indexOf(` ${cls} `) > -1;
}


function insertMobileLanguageToggle() {
  const mobileMenuElement = document.querySelector('#menu-main-navigation, #menu-main-navigation-fr, #menu-main-navigation-french');
  const translationMenuElement = document.querySelector('#menu-translation-menu');
  
  if (mobileMenuElement && translationMenuElement) {
    const clone = translationMenuElement.cloneNode(true);
    mobileMenuElement.appendChild(clone);
    const mobileTranslationMenu = mobileMenuElement.querySelector('#menu-translation-menu');
    mobileTranslationMenu.classList.add('navigation__item');
  }
}


function initializeNavigation() {
  window.addEventListener('scroll', stickyHeader, false);
  if (navigationOverlay) navigationOverlay.addEventListener('click', overlayClose, false);
  if (navigator.userAgent.match(/Trident\/7\./)) { body.addEventListener('mousewheel', stickyHeaderIE, false); }
  for (let i = 0; i < hamburgerIcon.length; i += 1) { 
    hamburgerIcon[i].addEventListener('click', hamburgerMenu, false);
    hamburgerIcon[i].addEventListener('keypress', hamburgerMenu, false);
  }
  for (let i = 0; i < navigationParent.length; i += 1) { 
    navigationParent[i].addEventListener('click', navigationDropdown, false); 
    navigationParent[i].addEventListener('mouseout', navigationDropdownLeave, false);
    navigationParent[i].addEventListener('keypress', navigationDropdown, false);
    navigationParent[i].addEventListener('mousein', navigationDropdown, false);
  }
  for (let i = 0; i < subMenu.length; i += 1) { subMenu[i].addEventListener('mouseout', navigationDropdownLeave, false); }
  for (let i = 0; i < navigationLast.length; i += 1) { navigationLast[i].addEventListener('keydown', navigationDropdownLast, false); }
  insertMobileLanguageToggle();
}

window.addEventListener('DOMContentLoaded', initializeNavigation);
