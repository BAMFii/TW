<?php

require_once('getCurrentUsername.php');

if (getCurrentUsername()!=null){
    $c=oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid=oci_parse($c,'DELETE FROM utilizatori_tokens WHERE token=:token');
    oci_bind_by_name($stid,':token',$_COOKIE['sid']);
    oci_execute($stid);
    oci_close($c);
    setcookie ('sid', '', time() - 3600);
    header("Location: http://localhost/gus/homepage.html ");//todo

}
