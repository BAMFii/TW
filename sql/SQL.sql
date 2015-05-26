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

INSERT INTO user_profile values ('gffzr23','Nechita','Bogdan',0);
INSERT INTO user_profile values ('qxtkfzmfqmm22','Drob','Gica',0);
INSERT INTO user_profile values ('kdqeuopeb17','Daneliuc','Mihai',0);
INSERT INTO user_profile values ('qslhoadazmcd12','Coca','Cola',0);




CREATE TABLE questions(
qid INT,
correct_answer VARCHAR(30),
answer_2 VARCHAR(30),
answer_3 VARCHAR(30),
answer_4 VARCHAR(30)
);
BEGIN
  INSERT INTO questions
   VALUES (1,'Usher','Ricky Martin','P Diddy','Daren Hayes');

INSERT INTO questions 
   VALUES (2,'Roger Federer', 'Rafael Nadal','Novak Djokovic','Andy Murray');
   
INSERT INTO questions 
   VALUES (3,'Angus T Jones', 'Jon Cryer','Ashton Kutcher','Vin Diesel');

INSERT INTO questions 
   VALUES (4,'P Diddy','Ricky Martin','Justin Bieber','Sam Smith');
   
INSERT INTO questions 
   VALUES (5,'Andy Roddick','Tiger Woods','Shaun Murphy','Andy Murray');
   
INSERT INTO questions 
   VALUES (6,'Charlie Sheen','Jon Cryer','Tobey Maguire','Brad Pitt');
   
INSERT INTO questions
   VALUES (7,'Rafael Nadal','Lleyton Hewitt','Muhammad Ali','Novak Djokovic');
   
INSERT INTO questions 
   VALUES (8,'Adele','Christina Aguilera','Amy Winehouse','Keisha');
   
INSERT INTO questions 
   VALUES (9,'Mickey Rourke','Robert Downey jr','Brad Pitt','Angus T Jones');
   
INSERT INTO questions 
   VALUES (10,'Lleyton Hewitt','Andy Roddick','Tiger Woods','Roger Federer');
   
INSERT INTO questions 
   VALUES (11,'Shakira','Adele','Janet Jackson','Nicole Scherzinger');
   
INSERT INTO questions 
   VALUES (12,'Denise Richards','Allison Hannigan','Cobie Smulders','Kirsten Dunst');
   
INSERT INTO questions 
   VALUES (13,'Novak Djokovic','Tiger Woods','Rafael Nadal','Andy Murray');
   
INSERT INTO questions 
   VALUES (14,'Janet Jackson','Beyonce','Keisha','Fergie');
   
INSERT INTO questions
   VALUES (15,'Angelina Jolie','Emma Stone','Jennifer Morrison','Emma Watson');
   
INSERT INTO questions
   VALUES (16,'Maria Sharapova','Simona Halep','Venus Williams','Victoria Azarenka');
   
INSERT INTO questions 
   VALUES (17,'Ricky Martin','Sam Smith','Justin Timberlake','Robbie Williams');
   
INSERT INTO questions 
   VALUES (18,'Allison Hannigan','Sharon Stone','Kirsten Dunst','Emma Stone');
END;





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

create or replace PROCEDURE add_all_users (number_of_users IN INT)
IS
    random_length_user int;
    random_length_pass int;
    random_username varchar(30);
    passwd varchar(30);
    the_username varchar(40);
    OK int;
      
BEGIN
    FOR i IN 1..number_of_users
    LOOP  
        random_length_user:=trunc(DBMS_RANDOM.value(5,25));
        random_username:=DBMS_RANDOM.string('L',random_length_user);
        the_username:=random_username||i;
        passwd:='user'||i;
       
           INSERT INTO utilizatori(username,passwordUser) VALUES(the_username,passwd);
               END LOOP;
END add_all_users;




CREATE TABLE pictures(
qid INTEGER,
picture BFILE
);

INSERT INTO pictures (qid, picture)
   VALUES (1, BFILENAME('DIR_1', 'usher.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (2, BFILENAME('DIR_2', 'Federer.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (3, BFILENAME('DIR_3', 'jones.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (4, BFILENAME('DIR_4', 'p diddy.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (5, BFILENAME('DIR_5', 'roddick.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (6, BFILENAME('DIR_6', 'sheen.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (7, BFILENAME('DIR_7', 'nadal.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (8, BFILENAME('DIR_8', 'adele.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (9, BFILENAME('DIR_9', 'rourke.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (10, BFILENAME('DIR_10', 'hewitt.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (11, BFILENAME('DIR_11', 'shakira.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (12, BFILENAME('DIR_12', 'richards.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (13, BFILENAME('DIR_13', 'djokovic.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (14, BFILENAME('DIR_14', 'janet jackson.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (15, BFILENAME('DIR_15', 'jolie.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (16, BFILENAME('DIR_16', 'sharapova.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (17, BFILENAME('DIR_17', 'martin.jpg'));
INSERT INTO pictures (qid, picture)
   VALUES (18, BFILENAME('DIR_18', 'hannigan.jpg'));

