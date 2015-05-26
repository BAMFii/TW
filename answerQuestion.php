<?php

    $answer=$_GET['answer'];
    $qid=$_GET['questionId'];

    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
    $true_answer=oci_parse($c,'SELECT correct_answer FROM questions WHERE qid=' . $qid);
    oci_execute($true_answer);
    $row = oci_fetch_array($true_answer, OCI_ASSOC);
    oci_close($c);
    if(strcasecmp($answer, $row['CORRECT_ANSWER']) == 0){
        echo 'true';
    } else{
        echo 'false';
    }