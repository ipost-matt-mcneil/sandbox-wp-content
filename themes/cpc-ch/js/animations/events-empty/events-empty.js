document.addEventListener('DOMContentLoaded', initializeAnimations);

function initializeAnimations() {
  if (document.getElementById('eventsEmpty')) {
    const animation = window.bodymovin.loadAnimation({
      container: document.getElementById('eventsEmpty'),
      renderer: 'svg',
      loop: false,
      autoplay: false,
      path: '/blogs/wp-c/themes/cpc-ch/js/animations/events-empty/events-empty.json'
    });
    setTimeout(() => { animation.play(); }, 250);
  }
}