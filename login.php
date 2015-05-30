<?php
    // check in db
    require_once('getCurrentUsername.php');
    require_once("randomString.php");
if (getCurrentUsername()==null) {

    $username = '';
    if (isset($_POST['user'])) {
        $username = $_POST['user'];
    }
    $password = '';
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }
//    $hashed_pass=password_hash($password, PASSWORD_DEFAULT);
    $hashed_pass = $password;

    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid = oci_parse($c, 'SELECT *
                            FROM utilizatori
                            WHERE utilizatori.username=\'' . $username . '\' AND utilizatori.passworduser=\'' . $hashed_pass . '\'');


    oci_execute($stid);
    if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
        $token = generateRandomString(20);
        $stid = oci_parse($c, 'INSERT into utilizatori_tokens values (:token, :username)');
        oci_bind_by_name($stid, ':token', $token);
        oci_bind_by_name($stid, ':username', $username);
        oci_execute($stid);
        oci_close($c);

        setcookie("sid", $token);
        header("Location: http://localhost/gus/mainPage.html ");//todo
    } else {
        die  ("Wrong username,password combination");

    }
}
    else{
        header("Location: http://localhost/gus/mainPage.html ");//todo

    }
//

