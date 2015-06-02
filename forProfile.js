/**
 * Created by mihai on 6/2/2015.
 */
xmlhttp=new XMLHttpRequest();
var uname;
var fname;
var lname;
var scor;

function getProfile(){
    xmlhttp=new XMLHttpRequest();
    if(xmlhttp.readyState===0||xmlhttp.readyState===4){
        xmlhttp.open("GET","http://localhost/gus/getCurrentProfile.php?username=annouk",true);
        xmlhttp.onreadystatechange = handleJSONProfile;
        xmlhttp.send(null);
    }
    else {
        setTimeout('processor()',1000);
    }
}

function handleJSONProfile(){
    if (xmlhttp.status === 200 && xmlhttp.readyState === 4) {
        var result = JSON.parse(xmlhttp.responseText);
            uname = result.username;

            fname = result.first_name;

            lname = result.last_name;

            scor = result.points;


        replacement=document.getElementById("BUMBUM");
        replacement.innerHTML="<div class=\'Profile\'> <h3 id=\'uname\'>"+uname+" </h3>First name: <p id=\'fname\'>"+ fname+" </p>Last name: <p id=\'lname\'>"+ lname+" </p>Points: <p id=\'scor\'>"+ scor+" </p> </div>";
        return true;

    }
    else {
        console.log(xmlhttp.status);
        return false;
    }
}