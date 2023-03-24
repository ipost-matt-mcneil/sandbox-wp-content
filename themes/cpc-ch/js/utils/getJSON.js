function getJSON(url, callback) {
  const xhr = new XMLHttpRequest();
  xhr.open('GET', url, true);
  xhr.responseType = 'json';
  xhr.onload = () => {
    if (xhr.status >= 200 && xhr.status < 400) {
      let responseData = xhr.response;
      if (/Trident/.test(navigator.userAgent)) {
        responseData = JSON.parse(xhr.response);
      }
      callback(responseData);
    }
  };
  xhr.send();
}

export default getJSON;