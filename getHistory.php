<?php

require_once('getCurrentUsername.php');
require_once('history.php');


if (getCurrentUsername()!=null){
    $username=$_GET['username'];
    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid=oci_parse($c,'SELECT * FROM history WHERE username=\'' . $username . '\'');
    oci_execute($stid);
    $history=array();
    while (($row = oci_fetch_array($stid, OCI_ASSOC)) != false){
        array_push($history,new History($row['USERNAME'],$row['GAMEID'],$row['SCORE'],$row['PLAYING_DATE']));

    }
    oci_close($c);

    header("Content-type: application/json");
    echo json_encode($history);


} else {
    http_response_code(401);
}


