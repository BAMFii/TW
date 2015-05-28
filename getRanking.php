<?php

    require_once('getCurrentUsername.php');
if (getCurrentUsername()!=null) {

    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $disp = oci_parse($c, 'SELECT u.username,p.first_name, p.last_name, p.points  FROM utilizatori u, user_profile p WHERE u.username=p.username  ORDER BY points DESC ');
    oci_execute($disp);
    $users = array();
    while (($row = oci_fetch_array($disp, OCI_ASSOC)) != false) {

        array_push($users, new Profile($row['USERNAME'], $row['FIRST_NAME'], $row['LAST_NAME'], $row['POINTS']));

    }
    oci_close($c);
    header("Content-type: application/json");
    echo json_encode($users);

}
    else {
        http_response_code(401);
    }