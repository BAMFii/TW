/**
 * Created by Bogdan Nechita on 6/1/2015.
 */

    //create the object

function Question(qid,q,a1,a2,a3,a4){
    this.qid=qid;
    this.q=q;
    this.a1=a1;
    this.a2=a2;
    this.a3=a3;
    this.a4=a4;
}

 xmlhttp = new XMLHttpRequest();
 var quiz;
 var question="Who is this person?";
 var qid;
 var a1;
 var a2;
 var a3;
 var a4;
 var score=0;
 var currentQuestion=1;
 var userAnswer;


    function processor(){
        if(xmlhttp.readyState===0||xmlhttp.readyState===4){
            xmlhttp.open("GET","http://localhost/gus/gameController.php?category=movies",true);
            xmlhttp.onreadystatechange = handleQuizJSON;
            xmlhttp.send(null);
        }
        else {
            setTimeout('processor()',1000);
        }
    }

    function verifyAnswer(){
        if(xmlhttp.readyState===0||xmlhttp.readyState===4){
            xmlhttp.open("GET","localhost/gus/answerQuestion.php?answer="+userAnswer+"&questionId="+quiz[currentQuestion-1].qid,true);
            xmlhttp.onreadystatechange = handleQuizJSON;
            xmlhttp.send(null);
        }
        else {
            setTimeout('processor()',1000);
        }
    }

function handleQuizJSON() {
    quiz = [];
    if (xmlhttp.status === 200 && xmlhttp.readyState === 4) {
        var result = JSON.parse(xmlhttp.responseText);
        for (var k = 0; k < result.length; k++) {
            var obj = result[k];
            qid = obj.qid;

            a1 = obj.correct_answer;

            a2 = obj.answer_2;

            a3 = obj.answer_3;

            a4 = obj.answer_4;


            quiz.push(new Question(qid, question, a1, a2, a3, a4));
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
    var replacement=document.getElementById("rep");
    replacement.innerHTML="<div id=\'question\'> <h1>"+intrebare.q+"</h1> </div> <div> <div id=\"image\"> <img src=\"http://localhost/gus/getPicture.php?questionId="+intrebare.qid+"\"> </img> </div> <div class=\"answer\" id=\'a1\'> <button id=\'a1\' value=\'"+answers[0]+"\' onclick=\"answerQuestion(this.id)\">"+answers[0]+"</button> </div> <div class=\"answer\" id=\'a2\'> <button id=\'a2\' value=\'"+answers[1]+"\' onclick=\"answerQuestion(this.id)\">"+answers[1]+"</button> </div> <div class=\"answer\" id=\'a3\'> <button id=\'a3\' value=\'"+answers[2]+"\' onclick=\"answerQuestion(this.id)\">"+answers[2]+"</button> </div> <div class=\"answer\" id=\'a4\'> <button id=\'a4\' value=\'"+answers[3]+"\' onclick=\"answerQuestion(this.id)\">"+answers[3]+"</button> </div> </div>";
}

function nextQuestion(){
    currentQuestion++;
    if(currentQuestion===8) {
        replacement.innerHTML="<div id=\'endOfQuiz\'> <h1> Congrats! You nailed "+ score +" out of 6!</h1> </div>";
    }
    else
        playQuiz(quiz[currentQuestion-1]);
}

function answerQuestion(clickedId){
    userAnswer=document.getElementById(clickedId).value;
    if(checkIfCorrect(givenAnswer) === true)
        score++;
    nextQuestion();

    return clickedId;
}

function checkIfCorrect(givenAnswer){
    if (xmlhttp.status === 200 && xmlhttp.readyState === 4) {
        var rezultat=xmlhttp.responseText;
        if(rezultat==='true')
            return true;
        else
            return false;
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