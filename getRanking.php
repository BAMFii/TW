<?php

    require_once('profile.php');
    require_once('rankingEntry.php');
/**
 * @return array
 */
function getRanking()
{
    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $disp = oci_parse($c,
        'select rownum, a.*
             from ( select *
                    from user_profile
                    order by points desc
                    ) a ');
    oci_execute($disp);
    $users = array();
    while (($row = oci_fetch_array($disp, OCI_ASSOC)) != false) {

        array_push($users, new RankingEntry(new Profile($row['USERNAME'], $row['FIRST_NAME'], $row['LAST_NAME'], $row['POINTS']), $row['ROWNUM']));

    }
    oci_close($c);
    return $users;
}

