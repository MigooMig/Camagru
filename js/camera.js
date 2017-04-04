(function() {
	var streaming = false,
		video        = document.querySelector('#video'),
    cover        = document.querySelector('#cover'),
    canvas       = document.querySelector('#canvas'),
    photo        = document.querySelector('#photo'),
    startbutton  = document.querySelector('#startbutton'),
    fileInput    = document.getElementById('file'),
    upload    = document.getElementById('upload'),
    width = 420,
    height = 0;

      navigator.getMedia = ( navigator.getUserMedia ||
                         	 navigator.webkitGetUserMedia ||
                         	 navigator.mozGetUserMedia ||
                         	 navigator.msGetUserMedia);

      navigator.getMedia(
    	{
      		video: true,
      		audio: false
    	},
    	function(stream) {
      		if (navigator.mozGetUserMedia) {
        		video.mozSrcObject = stream;
      		} else {
        	  var vendorURL = window.URL || window.webkitURL;
        	  video.src = vendorURL.createObjectURL(stream);
      		}
      		video.play();
    	},
    	function(err) {
      		console.log("An error occured! " + err);
    	}
     );

     video.addEventListener('canplay', function(ev) {
     	if (!streaming) {
      		height = video.videoHeight / (video.videoWidth/width);
      		video.setAttribute('width', width);
      		video.setAttribute('height', height);
      		canvas.setAttribute('width', width);
      		canvas.setAttribute('height', height);
      		streaming = true;
    	}
      }, false);

    function loadImage(src) {
    var img = new Image();
    
    img.onload = onload = function(){};
    img.src = src;

    return img;
  }

  upload.addEventListener('click', function() {
  var reader = new FileReader();
  reader.addEventListener('load', function() {
    if (fileInput.files[0].size > 2097152)
    {
      window.alert("fichier trop volumineux !");
    }
    
    var photo = reader.result;
    var img = witchOne();
    if (img)
    {
      var xhr = getHttpRequest()
      var post = new FormData()
      post.append('img', photo) ;
      post.append('filter', img.link);
      xhr.open('POST', 'http://localhost:8080/Camagru/picture.php', true);
      xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
      xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) { 
      /*  var code = xhr.responseText;  //contient le résultat de la page
          console.log(code);
          if(code)
          {            
            //console.log("bien recu");
            window.alert("fichier invalide ou incorecte, seul PNG autorisé");
          }
          location.reload();
        } else {
          console.log("Error Header !?");*/
        }
      }
    }
    xhr.send(post);
    location.reload();
  }
  else{
    window.alert("Vous devez obligatoirement choisir une image !")
    }
  });
  if (fileInput.files[0])
  reader.readAsDataURL(fileInput.files[0]);
});

	 function takepicture() {
      var img = witchOne();
      if (img)
      {
    	canvas.width = width;
    	canvas.height = height;
    	canvas.getContext('2d').drawImage(video, 0, 0, width, height);
      var data = canvas.toDataURL('image/png');
      var photo = canvas.toDataURL('image/png');
    	canvas.setAttribute('src', data);
      var xhr = getHttpRequest();
        var post = new FormData();
        post.append('img', data);
        post.append('filter', img.link);
        xhr.open('POST', 'http://localhost:8080/Camagru/picture.php', true);
        xhr.setRequestHeader('X-Requested-With', 'xmlhttprequest');
        xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
            if (xhr.status === 200) {
              console.log(xhr.responseText); // contient le résultat de la page
            }
            else {
              // window.alert("This filter does not exist");
             // alert(xhr.status);
            }
          }
        }
        xhr.send(post);
        location.reload();
  	 }
    }

function witchOne()
{
  var check1 = document.getElementById('cbox1');
  var check2 = document.getElementById('cbox2');
  var check3 = document.getElementById('cbox3');
  var check4 = document.getElementById('cbox4');

  if (check1.checked)
  {
    var img = loadImage('images/image1.png');
    img.link = 'images/image1.png';
  }
  if (check2.checked)
  {
    var img = loadImage('images/image2.png');
    img.link = 'images/image2.png';
  }
  if (check3.checked)
  {
    var img = loadImage('images/image3.png');
    img.link = 'images/image3.png';
  }
  if (check4.checked)
  {
    var img = loadImage('images/image4.png');
    img.link = 'images/image4.png';
  }
  return img
}

  	startbutton.addEventListener('click', function(ev){
      	takepicture();
      ev.preventDefault();
  	}, false);

})();
