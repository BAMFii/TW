<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 5/11/2015
 * Time: 3:23 PM
 */

class Profile {

    var $username;
    var $first_name;
    var $last_name;
    var $points;

    function __construct($username, $first_name, $last_name, $points)
    {
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->points = $points;
    }


}