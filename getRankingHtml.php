<?php

require_once('getCurrentUsername.php');
require_once('getRanking.php');

if (getCurrentUsername()!=null) {

    $users = getRanking();
    header("Content-type: application/json");
    echo json_encode($users);

}
else {
    http_response_code(401);
}