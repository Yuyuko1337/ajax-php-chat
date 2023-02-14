var Loadtime;

function Load() {
  Loadtime = setTimeout(showPage, 1500);
}

function showPage() {
  document.getElementById("load").style.display = "none";
  document.getElementById("show").style.display = "block";


  function loadXMLDoc(pageUrl, elementId) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById(elementId).innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", pageUrl, true);
  xhttp.send();
}

setInterval(() => {
  loadXMLDoc("live.php", "box");
}, 1000);

setInterval(() => {
  loadXMLDoc("online.php", "header");
}, 1500);

window.onload = loadXMLDoc;

var messagesInput = document.getElementById("messages");
var errorDiv = document.getElementById("error");

if (document.getElementById('send')) {
messagesInput.addEventListener("input", function() {
  var messages = messagesInput.value;
  if (messages.length > 1500) {
    errorDiv.innerHTML = '<p style="color: red; text-align: center; margin-top: -30px; left: 50%; transform: translateX(-50%); position: absolute;">Messages is too long</p>';
  } else if (messages.length < 1500) {
    errorDiv.innerHTML = '';
  }
});
}

}

if (document.getElementById('send')) {
document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('send').addEventListener('submit', function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    var messages = document.getElementById('messages').value;
    xhr.open('POST', 'send.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
      if (xhr.status === 200 && messages.length < 1500) {
        document.getElementById('messages').value = ''; 
      }
    };
    xhr.send('messages=' + encodeURIComponent(document.getElementById('messages').value));
  });
});
}