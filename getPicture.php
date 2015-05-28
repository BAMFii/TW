<?php

require_once('getCurrentUsername.php');
$qid=$_GET['questionId'];
$image=null;
if (getCurrentUsername()!=null) {
    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid = oci_parse($c, 'SELECT picture
                                FROM pictures
                                WHERE qid=:qid');

    oci_bind_by_name($stid, ':qid', $qid);
    oci_execute($stid);
    if (($row = oci_fetch_array($stid, OCI_ASSOC | OCI_B_BFILE)) != false) {
        $image = $row['PICTURE']->load();
    }
    oci_close($c);
    if ($image != null) {
        header("Content-type: image/JPEG");
        echo $image;
    } else {
        http_response_code(404);
    }
}
else {
    http_response_code(401);
}

