<?php

    $username=$_POST['username'];
    $gameId=$_POST['gameId'];
    $points_won=$_POST['points'];

    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid=oci_parse($c,'begin PLAY_A_GAME(:gameId, :points_won, :username); end;');
    oci_bind_by_name($stid, ':gameId', $gameId,-1,OCI_B_INT);
    oci_bind_by_name($stid, ':points_won', $points_won,-1,OCI_B_INT) ;
    oci_bind_by_name($stid, ':username', $username);
    oci_execute($stid);
    oci_close($c);