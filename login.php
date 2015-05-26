<?php
    // check in db
    require_once("Profile.php");
    $username = '';
    if(isset($_POST['user'])){
        $username = $_POST['user'];
    }
    $password = '';
    if(isset($_POST['password'])){
        $password = $_POST['password'];
    }
//    $hashed_pass=password_hash($password, PASSWORD_DEFAULT);
    $hashed_pass = $password;

    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid = oci_parse($c, 'SELECT user_profile.username,last_name,first_name,points
                            FROM utilizatori,user_profile
                            WHERE utilizatori.username=\'' . $username . '\' AND utilizatori.passworduser=\''. $hashed_pass . '\'
                            AND utilizatori.username=user_profile.username');


    oci_execute($stid);
    if(($row = oci_fetch_array($stid, OCI_ASSOC))!=false){
        setcookie("login", $username);
        $profile = new Profile($row['USERNAME'], $row['LAST_NAME'], $row['FIRST_NAME'], $row['POINTS']);
        oci_close($c);
        header("Content-type: application/json");
        echo json_encode($profile);
    }
    else {
        die  ("Wrong username,password combination");

    }
//

