/* eslint-disable */

/**
 * Method referenced from: https://codepen.io/pixelthing/pen/zGZKaQ
 */

document.addEventListener('DOMContentLoaded', initializeArticleVideo);

function initializeArticleVideo() {
  const videoReferenceAttribute = '.js-videoPoster';
  const videoRefCollection = document.querySelectorAll(`${videoReferenceAttribute}`);

  if (videoRefCollection.length > 0) {

      for (let i = 0; i < videoRefCollection.length; i++) {
      videoRefCollection[i].addEventListener('click', clickHandler.bind(videoRefCollection[i]));

      function clickHandler(e) {
        e.preventDefault();
        const item = this;
        const parent = item.parentElement;
        videoPlay(parent);
      }

      function videoPlay(parentElement) {
        const item = parentElement;
        const iframe = item.querySelector('.js-videoIframe');
        const src = iframe.getAttribute('data-src');
        // hide poster
        item.classList.add('videoWrapperActive');
        // add iframe src in, starting the video
        iframe.setAttribute('src', src);
      }

      function videoStop(parent) {
        // if we're stopping all videos on page
        if (!parent) {
          const parent = $('.js-videoWrapper');
          const iframe = $('.js-videoIframe');
          // if we're stopping a particular video
        } else {
          const iframe = parent.find('.js-videoIframe');
        }
        
        // reveal poster
        parent.removeClass('videoWrapperActive');
        // remove youtube link, stopping the video from playing in the background
        iframe.attr('src', '');
      }
    };
  }
}

/*
<div class="videoWrapper js-videoWrapper">
    <iframe class="videoIframe js-videoIframe" src="" frameborder="0" allowTransparency="true" allowfullscreen data-src="https://www.youtube.com/embed/hgzzLIa-93c?autoplay=1& modestbranding=1&rel=0&hl=sv"></iframe>
    <button class="videoPoster js-videoPoster" style="background-image:url(http://i2.wp.com/www.cgmeetup.net/home/wp-content/uploads/2015/05/Avengers-Age-of-Ultron-UI-Reel-1.jpg);">Play video</button>
</div>
*/

export default initializeArticleVideo;