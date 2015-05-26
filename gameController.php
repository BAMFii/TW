<?php

    require_once("Question.php");
    require_once("Game.php");

    $category = $_GET['category'];
    $c = oci_connect("SYSTEM", "rogerfed17", "localhost/XE");

    $category_game = oci_parse($c, 'begin :gameId := GENERATE_RANDOM_GAME(:category); end;');
    oci_bind_by_name($category_game, ':category', $category);
    oci_bind_by_name($category_game, ':gameId', $gameId);

    oci_execute($category_game);

    $category_question = oci_parse($c, 'SELECT * FROM TABLE(DISPLAY_QUESTIONS_ANSWERS(:gameId))');

    oci_bind_by_name($category_question, ':gameId', $gameId);

    oci_execute($category_question);

    $questions=array();

    while (($row = oci_fetch_array($category_question, OCI_ASSOC)) != false) {

        array_push($questions,new Question($row['QID'], $row['CORRECT_ANSWER'], $row['ANSWER_2'], $row['ANSWER_3'], $row['ANSWER_4']));
    }
    $game=new Game($gameId,$category,$questions);
    oci_close($c);

    header("Content-type: application/json");
    echo json_encode($game);