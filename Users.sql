CREATE TABLE  login (
	 userID INTEGER PRIMARY KEY AUTO_INCREMENT,
	 userName varchar(25),
	 password varchar(200)
);
CREATE TABLE  activities (
	transactionKey varchar(100),
	fromUserName varchar(25),
	ToUserName varchar(25),
	Amount FLOAT
);

CREATE TRIGGER before_insert_activities
BEFORE INSERT ON activities
FOR EACH ROW
	SET new.transactionKey = uuid();

INSERT INTO activities(fromUserName, ToUserName, Amount) VALUES ('admin','Simon',100);
INSERT INTO activities(fromUserName, ToUserName, Amount) VALUES ('admin','Robert',500);
INSERT INTO activities(fromUserName, ToUserName, Amount) VALUES ('Simon','admin',800);
INSERT INTO activities(fromUserName, ToUserName, Amount) VALUES ('Simon','Robert',600);

ALTER TABLE login
	ADD userToken VARCHAR(36);

CREATE TRIGGER before_insert_login
BEFORE INSERT ON login
FOR EACH ROW
	SET new.userToken = uuid();


CREATE TABLE  chating (
	chatText varchar(1000)
);

CREATE TABLE  sessions (
	session varchar(1000)
);

INSERT INTO login(userName, password) VALUES ('admin','admin');
INSERT INTO login(userName, password) VALUES ('Simon','7777');
INSERT INTO login(userName, password) VALUES ('Robert','1234');