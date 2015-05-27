<?php

require_once('profile.php');
function getCurrentUsername()
    {
        if (isset($_COOKIE['login']) && $_COOKIE['login'] != '') {
            return $_COOKIE['login'];
        } else {
            return null;
        }
    }

if (getCurrentUsername()!=null) {
    $username = $_GET['username'];
    if ($username != null) {

        $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
        $get_profile = oci_parse($c, 'SELECT * FROM TABLE(SGBD_PKG.DISPLAY_USER_PROFILE(:username))');
        oci_bind_by_name($get_profile, ':username', $username);
        oci_execute($get_profile);
        $profile = null;
        if (($row = oci_fetch_array($get_profile, OCI_ASSOC)) != false) {
            $profile = new Profile($row['USERNAME'], $row['FIRST_NAME'], $row['LAST_NAME'], $row['POINTS']);
        }
        oci_close($c);
        header("Content-type: application/json");
        echo json_encode($profile);

    } else {
        return null;
    }
}
else{
    http_response_code(401);
}





