<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 5/13/2015
 * Time: 2:24 AM
 */

class Question
{

    var $qid;
    var $correct_answer;
    var $answer_2;
    var $answer_3;
    var $answer_4;

    function __construct($qid, $correct_answer, $answer_2, $answer_3, $answer_4)
    {
        $this->qid = $qid;
        $this->correct_answer = $correct_answer;
        $this->answer_2 = $answer_2;
        $this->answer_3 = $answer_3;
        $this->answer_4 = $answer_4;
    }


}