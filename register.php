<?php

    $username=$_POST['username'];
    $password=$_POST['password'];
    $first_name=$_POST['First_name'];
    $last_name=$_POST['Last_name'];

    include("profile.php");


    $hashed_pass =password_hash($password,PASSWORD_DEFAULT);
    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $stid = oci_parse($c, 'SELECT username FROM utilizatori WHERE username=\'' . $username . '\'' );
    oci_execute($stid);
    if(($row = oci_fetch_array($stid, OCI_ASSOC))!=true){
        $stmt=oci_parse($c, 'INSERT INTO utilizatori (username,passworduser) VALUES(\'' .  $username . '\', \''  .  $hashed_pass . '\')');

        oci_execute($stmt);
        $points=0;
        $profile=oci_parse($c,'insert into user_profile(username,last_name,first_name,points) values(\'' .  $username . '\', \'' .
            $last_name . '\', \'' .   $first_name . '\', ' .   $points . ')');

        oci_execute($profile);
        oci_commit($c);
        oci_close($c);
        header("Location: http://localhost/gus/profile.html ");//todo
    }
    else{
        die ("Username already exists. Try another one");
    }




