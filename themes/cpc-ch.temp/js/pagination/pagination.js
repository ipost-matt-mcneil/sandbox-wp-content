document.addEventListener('DOMContentLoaded', initializeComponent);

function initializeComponent() {
  const viewing = document.querySelector('.pagination__viewing');
  const loading = document.querySelector('.pagination__loading');

  if (viewing) {
    viewing.addEventListener('click', switchButtons, false);
  }

  function switchButtons() {
    viewing.style.display = 'none';
    loading.style.display = 'inline-block';
  }
}


/*

Callback Code for Infinite Scroll plugin

const viewing = document.querySelector('.pagination__viewing');
const loading = document.querySelector('.pagination__loading');
viewing.style.display = 'inline-block';
loading.style.display = 'none';
let url =viewing.href;
let pages = viewing.id;
let pieces = url.lastIndexOf('/');
let page = parseInt(url.substring(pieces + 1));

if (page == pages) {
  viewing.style.display = 'none';
}

page += 1;
viewing.setAttribute("href", "page/" + page);

*/