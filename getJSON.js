
function Question(qid,game,q,a1,a2,a3,a4){
    this.qid=qid;
    this.game=game;
    this.q=q;
    this.a1=a1;
    this.a2=a2;
    this.a3=a3;
    this.a4=a4;
}

var xmlhttp = new XMLHttpRequest();
var quiz = [];
var question="Who is this person?";
var qid;
var game=0;
var a1;
var a2;
var a3;
var a4;
var score=0;
var currentQuestion=1;
var userAnswer;
var replacement;


function processor(){

    if(xmlhttp.readyState===0||xmlhttp.readyState===4){
        xmlhttp.open("GET","http://localhost/gus/gameController.php?category=music",true);
        xmlhttp.onreadystatechange = handleQuizJSON;
        xmlhttp.send(null);
    }
    else {
        setTimeout('processor()',1000);
    }
}

function verifyAnswer(givenAnswer){
    if(xmlhttp.readyState===0||xmlhttp.readyState===4){
        xmlhttp.open("GET","http://localhost/gus/answerQuestion.php?answer="+encodeURI(givenAnswer)+"&questionId="+quiz[currentQuestion-1].qid,true);
        xmlhttp.onreadystatechange = checkIfCorrect;
        xmlhttp.send(null);
    }
    else {
        setTimeout('processor()',1000);
    }
}

function handleQuizJSON() {
    if (xmlhttp.status === 200 && xmlhttp.readyState === 4) {
        var result = JSON.parse(xmlhttp.responseText);
        for (var k = 0; k < result.length; k++) {
            var obj = result[k];
            qid = obj.qid;

            game=obj.gid;

            a1 = obj.correct_answer;

            a2 = obj.answer_2;

            a3 = obj.answer_3;

            a4 = obj.answer_4;


            quiz.push(new Question(qid, game, question, a1, a2, a3, a4));
        }
        playQuiz(quiz[0]);
        return true;

    }
    else {
        console.log(xmlhttp.status);
        return false;
    }
}


function playQuiz(intrebare){
    var answers=[intrebare.a1,intrebare.a2,intrebare.a3,intrebare.a4];
    answers=shuffle(answers);
    replacement=document.getElementById("BUMBUM");
    replacement.innerHTML="<div id=\'question\'> <h1>"+intrebare.q+"</h1> </div> <div> <div class=\'imaginare\' id=\"image\"> <img src=\"http://localhost/gus/getPicture.php?questionId="+intrebare.qid+"\"> </img> </div> <div class=\"answer\" id=\'ans1\'> <button id=\'a1\' value=\'"+answers[0]+"\' onclick=\"answerQuestion(this.id)\">"+answers[0]+"</button> </div> <div class=\"answer\" id=\'ans2\'> <button id=\'a2\' value=\'"+answers[1]+"\' onclick=\"answerQuestion(this.id)\">"+answers[1]+"</button> </div> <div class=\"answer\" id=\'ans3\'> <button id=\'a3\' value=\'"+answers[2]+"\' onclick=\"answerQuestion(this.id)\">"+answers[2]+"</button> </div> <div class=\"answer\" id=\'ans4\'> <button id=\'a4\' value=\'"+answers[3]+"\' onclick=\"answerQuestion(this.id)\">"+answers[3]+"</button> </div> </div>";
}

function nextQuestion(){
    currentQuestion++;
    if(currentQuestion===7) {
        setTimeout('',1000);
        xmlhttp.open("POST","http://localhost/gus/playGame.php?gameId=1&points="+score,true);
        xmlhttp.send();
        replacement.innerHTML="<div id=\'endOfQuiz\'> <h1> Congrats! You nailed "+ score +" out of 6!</h1> </div>";
    }
    else
        playQuiz(quiz[currentQuestion-1]);
}

function answerQuestion(clickedId){
    userAnswer=document.getElementById(clickedId).value;
    verifyAnswer(userAnswer);



    return clickedId;
}

function checkIfCorrect(){
    if (xmlhttp.status === 200 && xmlhttp.readyState === 4) {
        var rezultat=xmlhttp.responseText;
        if(rezultat==='true'){
            score++;
            console.log(score);
            nextQuestion();
        }
        else
            nextQuestion();

        /*var result = JSON.parse(xmlhttp.responseText);
         var obj = result[0];
         for (var key in obj){
         if(obj[key]==='true')
         return true;
         else
         return false;
         }*/
    }
    else {
        console.log(22222);
        return false;
    }
}


function shuffle(array) {
    var currentIndex = array.length, temporaryValue, randomIndex ;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex -= 1;

        // And swap it with the current element.
        temporaryValue = array[currentIndex];
        array[currentIndex] = array[randomIndex];
        array[randomIndex] = temporaryValue;
    }

    return array;
}

