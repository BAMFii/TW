<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 5/13/2015
 * Time: 9:40 AM
 */

class Game {

    var $gameID;
    var $category;
    var $questions;

    function __construct($gameID, $category, $questions)
    {
        $this->gameID = $gameID;
        $this->category = $category;
        $this->questions = $questions;
    }


}

