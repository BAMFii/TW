<?php

function generateRandomString($length = 10) {

    return substr(str_shuffle(MD5(microtime())), 0, $length);
}