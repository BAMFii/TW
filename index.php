<?php

require_once('getCurrentUsername.php');

if (getCurrentUsername() == null) {
    header("Location: http://localhost/gus/authenticate.html ");
} else {
    header("Location: http://localhost/gus/profile.html ");
}