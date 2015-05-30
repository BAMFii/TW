<?php

require_once('getCurrentUsername.php');
$old_password = $_POST['oldPassword'];
$new_password = $_POST['newPassword'];
$user = getCurrentUsername();

$c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
$stid=oci_parse($c,'select * from utilizatori where username=:user and password=:pass');
oci_bind_by_name($stid, ':user', $user);
oci_bind_by_name($stid, ':pass', $old_password);
oci_execute($stid);
if (($row=oci_fetch_array($stid, OCI_ASSOC)) != false) {
    $insert = oci_parse($c,'insert into utilizatori values (:user, :pass)');
    oci_bind_by_name($insert, ':user', $user);
    oci_bind_by_name($insert, ':pass', $new_password);
    oci_execute($insert);
    oci_close($c);
    header('Location: http://localhost/gus/login.html');

} else {
    oci_close($c);
    http_status_code(401);
}
