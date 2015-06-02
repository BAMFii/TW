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

    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid = oci_parse($c, 'SELECT passworduser
                            FROM utilizatori
                            WHERE utilizatori.username=:username');
    oci_bind_by_name($stid,':username',$username);


    oci_execute($stid);
    if (($row = oci_fetch_array($stid, OCI_ASSOC)) != false) {
        if (password_verify($password, $row['PASSWORDUSER'])) {

            $token = generateRandomString(20);
            $stid = oci_parse($c, 'INSERT into utilizatori_token values (:token, :username)');
            oci_bind_by_name($stid, ':token', $token);
            oci_bind_by_name($stid, ':username', $username);
            oci_execute($stid);
            oci_close($c);

            setcookie('sid', $token);
            header("Location: http://localhost/gus/profile.html ");//todo
        } else {
            die  ("Wrong username,password combination");

        }
    }else {
        die  ("Wrong username,password combination");
    }
}
else{
    header("Location: http://localhost/gus/profile.html ");//todo

}

