<?php

//require_once('getCurrentProfile.php');
//$profile=getProfile('qslhoadazmcd12');
//echo json_encode($profile);
header("Location: http://localhost/gus/homepage.html ");//todo


//	$qid=$_GET['qid'];
//	$answer=$_GET['answer'];
//
//    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");
//	$result=oci_parse($c,'SELECT correct_answer FROM questions WHERE qid = :qid');
//    oci_bind_by_name($result,':qid',$qid);
//	oci_execute($result);
//    //$raspuns_corect=array();
//
//		if ($row=oci_fetch_array($result,OCI_ASSOC)!=false){
//      //  array_push($raspuns_corect,$row['CORRECT_ANSWER']);
//            $raspuns_corect=$row['CORRECT_ANSWER'];
//	}
//
//	oci_close($c);
//	if($raspuns_corect=$answer) {
//
//        echo "true";
//    }
//    else {
//        echo "false";
//    }