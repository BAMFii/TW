create or replace PROCEDURE play_a_game(game_Id INT,points_won INT,user_name VARCHAR2) IS
BEGIN
  INSERT INTO history (username,gameId,score,playing_date) VALUES(user_name,game_Id,points_won,sysdate);
  UPDATE user_profile
  SET points=points+points_won
  WHERE username=user_name;
END play_a_game;



create or replace FUNCTION display_questions_answers(gameId INT)
RETURN questions_collection IS
i INT:=1;
ques questions_type;
questions_table questions_collection;

CURSOR questions_cursor(gId NUMBER) is
  SELECT qid,correct_answer,answer_2,answer_3,answer_4
  FROM games,questions
  WHERE gameID=gId
  AND (Q1id=Qid OR Q2id=Qid OR Q3id=Qid OR Q4id=Qid OR Q5id=Qid OR Q6id=Qid);

BEGIN
  
  questions_table:=questions_collection();
  
 
  FOR question_rec IN questions_cursor(gameId) LOOP
  
    -- create a question_type object with the cursor data and add it to questions_table
    ques:=questions_type(question_rec.qid,question_rec.correct_answer,
                question_rec.answer_2,question_rec.answer_3,question_rec.answer_4);
    questions_table.extend;  
    questions_table(i):=ques;
    i:=i+1;
  END LOOP;
  
 return questions_table;
 END display_questions_answers;



create or replace FUNCTION display_user_profile(user_name VARCHAR2)  
return profile_collection IS
var_user VARCHAR(30);
i INT:=1;
var_last_name VARCHAR(30);
var_first_name VARCHAR(30);
var_points NUMBER;
p profile_typ;
profile_table profile_collection;
BEGIN
  SELECT user_profile.username,user_profile.last_name,user_profile.first_name,user_profile.points
  INTO var_user,var_last_name,var_first_name,var_points 
  FROM utilizatori,user_profile
  WHERE user_profile.username=user_name AND utilizatori.username=user_profile.username;
  profile_table:=profile_collection();

    p:=profile_typ(var_user,var_last_name,var_first_name,var_points );
    profile_table.extend;
    profile_table(i):=p;
  return profile_table;
END display_user_profile;


create or replace FUNCTION GENERATE_RANDOM_GAME(CATEGORY VARCHAR2) RETURN INTEGER AS 
gId INTEGER;
BEGIN
  SELECT gameid
  into gId
  FROM   (
    SELECT gameid
    FROM games
    where games.category=CATEGORY
    ORDER BY DBMS_RANDOM.RANDOM)
  WHERE  rownum = 1;
  
  RETURN gId;
END GENERATE_RANDOM_GAME;



create or replace TYPE profile_collection AS TABLE OF profile_typ;



create or replace TYPE profile_typ AS OBJECT(
username VARCHAR2(30),
last_name  VARCHAR2(30),
first_name VARCHAR2(30),
points NUMBER
);




create or replace TYPE questions_collection AS TABLE OF questions_type;




create or replace TYPE questions_type AS OBJECT(
  qid integer,
  correct_answer varchar2(30),
  answer_2 varchar2(30),
  answer_3 varchar2(30),
  answer_4 varchar2(30)
);


CREATE TABLE user_profile(
username VARCHAR2(30),
last_name VARCHAR2(30),
first_name VARCHAR2(30),
points number
);





CREATE TABLE questions(
qid INT,
correct_answer VARCHAR(30),
answer_2 VARCHAR(30),
answer_3 VARCHAR(30),
answer_4 VARCHAR(30)
);




create sequence game_seq start with 4 increment by 1;

CREATE OR REPLACE TRIGGER game_trigger
BEFORE INSERT ON games FOR EACH ROW
BEGIN
  SELECT game_seq.NEXTVAL
  INTO :NEW.gameid
  FROM DUAL;
END;
DROP TABLE history;
CREATE TABLE history(
username VARCHAR(30),
gameId INT,
score INT,
playing_date DATE);





CREATE TABLE history(
username VARCHAR(30),
gameId INT,
score INT,
playing_date DATE);





CREATE TABLE utilizatori(
username VARCHAR(30) not null unique,
passworduser VARCHAR(30)
);




CREATE TABLE pictures(
qid INTEGER,
picture BFILE
);

CREATE TABLE utlizatori_token(
token VARCHAR(20),
username VARCHAR(30)
)
