<?php


        $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
        $disp=oci_parse($c, 'SELECT u.username,p.points  FROM utilizator u, profil p WHERE u.username=p.username  ORDER BY points ASC ');
        oci_execute($disp);
        $users = array();
        while (($row = oci_fetch_array($disp, OCI_ASSOC)) != false) {

            array_push($users, $row['USERNAME'],$row['POINTS']);

        }
        oci_close($c);
        echo $users;

