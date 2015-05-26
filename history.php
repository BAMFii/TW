<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 5/27/2015
 * Time: 12:59 AM
 */

class History {

    var $username;
    var $gameId;
    var $points_won;
    var $playing_date;

    function __construct($username, $gameId, $points_won,$playing_date)
    {
        $this->username = $username;
        $this->gameId = $gameId;
        $this->points_won = $points_won;
        $this->playing_date=$playing_date;
    }


}