<?php

function getCurrentUsername()
{
    $username = null;
    if (isset($_COOKIE['sid'])) {
        $token = $_COOKIE['sid'];
        $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
        $stid = oci_parse($c, 'SELECT username
                            FROM utilizatori_token
                            WHERE token = :token');
        oci_bind_by_name($stid, ":token", $token);
        oci_execute($stid);

        if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {

            $username = $row['USERNAME'];
        }
        oci_close($c);

    }
    return $username;
}