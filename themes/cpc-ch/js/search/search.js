/* eslint no-console: 0 */
/* eslint no-new: 0 */
/* eslint no-undef: 0 */

// import setLocaleEn from './locale_en';
// import setLocaleFr from './locale_fr';
import globals from '../utils/globals';
import DomainParser from '../utils/domain-utils';

const cpDomain = new DomainParser(window.location.href).getCanadaPostDomainUrl('');
const searchTriggerValue = (document.getElementById('search_auto_suggest_trigger') && document.getElementById('search_auto_suggest_trigger').value) 
  ? document.getElementById('search_auto_suggest_trigger').value : 0;
const ptaSearchLengthTrigger = (searchTriggerValue > 0) ? searchTriggerValue : 400;

document.addEventListener('DOMContentLoaded', initializeSearch);

function initializeSearch(initOptions) {
  let lang = document.querySelector('html').getAttribute('lang') ? document.querySelector('html').getAttribute('lang') : 'en';
  if (lang.toLowerCase().indexOf('fr') !== -1) {
    lang = 'fr';
  } else {
    lang = 'en';
  }
  const $ = window.jQuery;
  const mobileWidth = globals.mobileUpperBound;
  const searchURL = (document.getElementById('type_ahead_url') && document.getElementById('type_ahead_url').value) 
    ? document.getElementById('type_ahead_url').value : '/cpc/en/home/1514511013474.ajax';
  const searchPageURL = `/web/${lang}/search.page?rankboost=&searchInput=`;

  // const nav = lang === 'fr' ? setLocaleFr({ cpDomain }) : setLocaleEn({ cpDomain }); 

  const searchModal = document.createElement('section');
  const cpcSearchModalId = 'cpcSearchModal';  
  const bodyElement = document.querySelector('body');

  /**
   * Content Hub/Blog specific Logic
   */  
  // ole switch-a-roo

  /*

  const navItems = document.querySelectorAll('.navigation__item');
  const searchDiv = document.querySelector('.navigation__container .nav-search');
  const searchListItem = document.createElement('li');
  searchListItem.innerHTML = searchDiv.innerHTML;
  searchListItem.setAttribute('class', searchDiv.getAttribute('class'));
  searchDiv.parentElement.removeChild(searchDiv);
  navItems[navItems.length - 1].parentElement
    .insertBefore(searchListItem, navItems[navItems.length - 1]);

  */

  const searchBtnElement = document.getElementById('searchBtn');
  const searchBtnElementMobile = document.getElementById('searchMobileBtn');  

  if (!searchBtnElement || !searchBtnElementMobile) return;

  /**
   * End of Content Hub/Blog specific Logic
   */

  // const searchContainer = document.querySelector('.utility-business-nav-search');
  // if (!searchContainer) return;
  // const searchBtnElement = document.querySelector('.utility-business-nav-search').querySelector('a');
  // const searchBtnElementMobile = document.querySelector('.menu-search');

  searchModal.setAttribute('id', cpcSearchModalId);
  if (initOptions && initOptions.isCommonComponent) {
    searchModal.classList.add(globals.cwc.componentClassName);
  }
  const searchModalElement = document.getElementById(`${cpcSearchModalId}`);
  
  searchBtnElement.addEventListener('click', showSearchClick);
  searchBtnElement.addEventListener('keydown', showSearchKeyPress);
  searchBtnElementMobile.addEventListener('click', showSearchClick);
  searchBtnElementMobile.addEventListener('keydown', showSearchKeyPress);

  const cpcSearchModal = document.getElementById('cpcSearchModal');
  cpcSearchModal.addEventListener('click', hideSearchClick);

  const searchPopup = document.getElementById('searchPopup');
  searchPopup.addEventListener('click', cancelHideSearchClick);

  const searchModalClose = document.getElementById('searchModalClose');
  searchModalClose.addEventListener('click', hideSearchClick);
  searchModalClose.addEventListener('keydown', hideSearchKeyPress);

  const searchModalInput = document.getElementById('searchModalInput');
  searchModalInput.addEventListener('keydown', searchKeyPress);

  const searchInputError = document.getElementById('searchInputError');
  searchInputError.addEventListener('click', hideInputError);
  searchInputError.addEventListener('keydown', hideInputErrorKeyPress);

  const searchModalBtn = document.getElementById('searchModalBtn');
  searchModalBtn.addEventListener('click', () => { performSearch(false); });
  searchModalBtn.addEventListener('keydown', performSearchKeypress);

  const searchModalResults = document.getElementById('searchModalResults');

  /* const searchModalQuickLinks = document.getElementById('searchModalQuickLinks');
  const quickLinks = nav.nodes.find(ele => ele.labelId === 'QuickLinks');
  searchModalQuickLinks.querySelector(':first-child').innerHTML = quickLinks.label;
  quickLinks.nodes.forEach((n, i) => {
    const quickLink = document.createElement('div');
    quickLink.classList.add('search-modal-quick-link');
    quickLink.setAttribute('role', 'option');
    quickLink.innerHTML = n.label;
    quickLink.addEventListener('click', () => { 
      window.location.href = n.link; 
    });
    quickLink.addEventListener('keydown', (e) => {
      const key = e.which || e.keyCode;
      if (key === 13) {
        window.location.href = n.link;
      } else if (key === 27) {
        hideSearchClick();
      }      
    });    
    quickLink.tabIndex = 0;

    if (i === quickLinks.nodes.length - 1) {
      quickLink.addEventListener('keydown', (e) => {
        const key = e.which || e.keyCode;
        if (key === 9 && !e.shiftKey) {
          e.preventDefault();
          searchModalClose.focus();
        }     
      });     
    }
    searchModalQuickLinks.appendChild(quickLink);
  }); */

  /**
   * Content Hub/Blog specific Logic
   */  

  const quickLinks = document.querySelectorAll('#searchModalQuickLinks .search-modal-quick-link');
  quickLinks.forEach((quickLink, i) => {
    quickLink.addEventListener('click', () => { 
      window.location.href = quickLink.getAttribute('data-href'); 
    });
    quickLink.addEventListener('keydown', (e) => {
      const key = e.which || e.keyCode;
      if (key === 13) {
        window.location.href = quickLink.getAttribute('data-href');
      } else if (key === 27) {
        hideSearchClick();
      }      
    });

    if (i === quickLinks.length - 1) {
      quickLink.addEventListener('keydown', (e) => {
        const key = e.which || e.keyCode;
        if (key === 9 && !e.shiftKey) {
          e.preventDefault();
          searchModalClose.focus();
        }     
      });     
    }
  });

  /**
   * End of Content Hub/Blog specific Logic
   */

  function showSearchClick(e) {
    e.preventDefault();
    searchModalElement.classList.add('show');
    searchBtnElement.style.display = 'none';
    searchBtnElement.setAttribute('aria-hidden', true);
    searchPopup.setAttribute('aria-hidden', false);
    searchBtnElementMobile.style.display = 'none';
    bodyElement.classList.add('no-scroll');
    bodyElement.classList.add('tingle-enabled');
    const navIcon = document.getElementById('trigger');
    if (navIcon) {
      navIcon.classList.remove('active');
    }

    // screen reader may require a delay
    setTimeout(() => {
      searchModalInput.focus();
    }, 500);    
  }

  function showSearchKeyPress(e) {
    const key = e.which || e.keyCode;
    if (key === 13) {
      searchBtnElement.click();
    } else if (key === 27) {
      hideSearchClick();
    }
  }

  function hideSearchClick() { 
    searchModalElement.classList.remove('show');
    searchBtnElement.removeAttribute('style');
    searchBtnElementMobile.removeAttribute('style');
    bodyElement.classList.remove('no-scroll');
    bodyElement.classList.remove('tingle-enabled');
    searchModalInput.value = '';
    searchModalResults.innerHTML = '';
    searchModalBtn.classList.remove('highlight-search-icon');
    searchModalBtn.classList.remove('show');
    searchBtnElement.removeAttribute('aria-hidden');
    hideInputError();
    // screen reader may require a delay
    if (searchBtnElement.getAttribute('data-activated-via') === 'keyboard') {
      setTimeout(() => {
        searchBtnElement.focus();
      }, 500);
    }
  }

  function cancelHideSearchClick(e) {
    e.stopPropagation();
  }

  function hideSearchKeyPress(e) {
    const key = e.which || e.keyCode;
    if (key === 13) {
      searchModalClose.click();
    } else if (key === 27) {
      hideSearchClick();
    } else if (key === 9 && e.shiftKey) {
      e.preventDefault();
      const lastTabindex = searchModalElement.querySelectorAll('[tabindex]');      
      lastTabindex[lastTabindex.length - 1].focus();
    }
  }

  function searchKeyPress(e) {
    const key = e.which || e.keyCode;
    if (searchModalInput.value !== '' || key === 13 || key === 27) {
      if (key !== 13 && key !== 27) {
        searchModalBtn.classList.add('highlight-search-icon');
        searchModalBtn.classList.add('show');
      }

      if (key === 13) {
        performSearch(false, e);
      } else if (key === 27) {
        hideSearchClick();
      } else if (searchModalInput.value.length > ptaSearchLengthTrigger) {
        performSearch(true, e);
      } else {
        searchModalResults.innerHTML = '';
        hideInputError();
      }
    } else {
      searchModalBtn.classList.remove('highlight-search-icon');
      searchModalBtn.classList.remove('show');
    }
  }

  function performSearch(doSearch, evt) {
    if (doSearch) {  
      $.ajax({
        type: 'POST',
        url: searchURL,
        data: { searchInput: searchModalInput.value },
        success: function successHandler(data) {
          const payload = JSON.parse($(data).find('SearchResult').text());
          if (payload.ResultSet.length > 0) {
            searchModalResults.innerHTML = '';
            for (let i = 0, len = payload.ResultSet.length; i < len && i < 10; i += 1) {
              const searchResult = document.createElement('div');
              searchResult.classList.add('search-result');
              searchResult.addEventListener('click', () => { 
                window.location.href = `${cpDomain}${searchPageURL}${payload.ResultSet[i].entry}`; 
              });
              searchResult.addEventListener('keydown', (e) => {
                const key = e.which || e.keyCode;
                if (key === 13) {
                  window.location.href = `${cpDomain}${searchPageURL}${payload.ResultSet[i].entry}`;
                } else if (key === 27) {
                  hideSearchClick();
                }      
              });                          

              const regEx = new RegExp(searchModalInput.value, 'gi');
              const innerHTML = payload.ResultSet[i].entry.replace(regEx, (match) => { 
                const resultMatch = `<b>${match}</b>`; 
                return resultMatch;
              });

              searchResult.innerHTML = innerHTML;
              searchResult.tabIndex = 0;
              searchModalResults.appendChild(searchResult);            
            }
          } else {
            searchModalResults.innerHTML = '';
          }
        }
      });
    } else if ((document.body.clientWidth > mobileWidth && !doSearch)) {
      if (searchModalInput.value !== '') {
        window.location.href = `${cpDomain}${searchPageURL}${searchModalInput.value}`;
      } else {
        searchInputError.style.display = 'inline';
        searchInputError.tabIndex = 0;
        searchModalInput.tabIndex = -1;

        const key = evt.which || evt.keyCode;
        if (key === 13) {
          searchInputError.focus();
        }
      }    
    } else {
      const searchEle = document.activeElement;
      if (searchEle !== searchModalBtn) {
        if (searchModalInput.value !== '') {
          window.location.href = `${cpDomain}${searchPageURL}${searchModalInput.value}`;
        } else {
          searchInputError.style.display = 'inline';
          searchInputError.tabIndex = 0;
          searchModalInput.tabIndex = -1;

          const key = evt.which || evt.keyCode;
          if (key === 13) {
            searchInputError.focus();
          }
        } 
      } else {
        searchModalInput.value = '';
        searchModalResults.innerHTML = '';
        searchModalInput.focus();
        searchModalBtn.classList.remove('highlight-search-icon');
        searchModalBtn.classList.remove('show');      
        hideInputError();
      }
    }
  }

  function performSearchKeypress(e) {
    const key = e.which || e.keyCode;
    if (key === 13) {
      searchModalBtn.click();
    } else if (key === 27) {
      hideSearchClick();
    }  
  }

  function hideInputError() {
    searchInputError.removeAttribute('style');
    searchModalInput.focus();
    searchInputError.tabIndex = -1;
    searchModalInput.tabIndex = 0;   
  }

  function hideInputErrorKeyPress() {
    hideInputError();
  }
}

export default initializeSearch;