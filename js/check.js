/**
 * Created by Timothy K Banda on 5/11/2022.
 */

function checkUsername() {

    var u = document.getElementById('Username').value;

    var myRequest;

// feature check!
    if (window.XMLHttpRequest) {  // does it exist? we're in Firefox, Safari etc.
        myRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // if not, we're in IE
        myRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }

// 2: create an event handler for our request to call back
    myRequest.onreadystatechange = function(){
        if (myRequest.readyState === 4 ){
            document.getElementById("cU").innerHTML = myRequest.responseText;
        }
    };
// open and send it
    myRequest.open("GET", "checkU.php?username=" + u, true);
// any parameters?
    myRequest.send(null);
}