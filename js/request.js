var getHttpRequest = function () {
  var httpRequest = false;

  if (window.XMLHttpRequest) { // Mozilla, Safari,...
    httpRequest = new XMLHttpRequest();
    if (httpRequest.overrideMimeType) {
      httpRequest.overrideMimeType('text/xml');
    }
  }
  else if (window.ActiveXObject) { // IE
    try {
      httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch (e) {
      try {
        httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch (e) {}
    }
  }

  if (!httpRequest) {
    alert('Abandon :( Impossible de créer une instance XMLHTTP');
    return false;
  }

  return httpRequest
}

function delete_picture(id)
{
  var img = document.getElementById(id);
  img.parentNode.removeChild(img);
  //console.log(id);
  var xhr = getHttpRequest()
  var data = new FormData()
  data.append('image_id', id);
  xhr.open('POST', 'http://localhost:8080/Camagru/picture.php', true);
  xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        console.log(xhr.responseText);
      } else {
        console.log("wrong link");
      }
    }
  }
  xhr.send(data);
}

function selectOnlyThis(id) {
  for (var i = 1;i <= 4; i++)
  {
    document.getElementById("cbox" + i).checked = false;
  }
  document.getElementById(id).checked = true;
}

