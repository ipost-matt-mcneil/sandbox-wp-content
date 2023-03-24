function setCookie(cookieName, value, expiredays, ifEscape, domain) {
  const exdate = new Date();
  let expiredate;
  let root = '';
  let cookieValue = null;

  if (domain) {
    root = `;domain=${domain}`;
  } else {
    root = '';
  }
  exdate.setDate(exdate.getDate() + expiredays);
  if (expiredays !== 0) {
    expiredate = exdate.toGMTString();
  } else {
    expiredate = 0;
  }
  const expires = ((expiredays == null) ? '' : `;expires=${expiredate}${root};path=/`);

  if (!ifEscape) {
    cookieValue = escape(value);
  }

  document.cookie = `${cookieName}=${cookieValue}${expires}`;
}

function getCookie(cookieName) {
  if (document.cookie.length > 0) {
    let start = document.cookie.indexOf(`${cookieName}=`);
    if (start !== -1) {
      start = start + cookieName.length + 1;
      let end = document.cookie.indexOf(';', start);
      if (end === -1) {
        end = document.cookie.length;
      }
      return unescape(document.cookie.substring(start, end));
    }
  }
  return '';
}

export { setCookie, getCookie };