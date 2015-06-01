<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 6/1/2015
 * Time: 1:29 AM
 */

class RankingEntry {
    var $profile;
    var $ranking;

    function __construct($profile, $ranking)
    {
        $this->profile = $profile;
        $this->ranking = $ranking;
    }


}