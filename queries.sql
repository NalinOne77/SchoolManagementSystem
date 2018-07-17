CREATE TABLE users(
	user_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name varchar(50),
    user_type int,
    photo varchar(200),
    gender varchar(10),
    address varchar(50),
    username varchar(20),
    password varchar(20),
 	  school int,
  	status int,

  	FOREIGN KEY(user_type)REFERENCES user_types(user_type_id),
  	FOREIGN KEY(school)REFERENCES schools(school_id)
)

CREATE TABLE schools(
  school_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name varchar(50),
  city varchar(20)
)

CREATE TABLE user_types(
  user_type_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  userType varchar(20)
)

CREATE TABLE logs(
  log_id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  school int,
  time date,
  action varchar(20),
  comment varchar(200),
  recipient int

  FOREIGN KEY(school)REFERENCES schools(school_id),
  FOREIGN KEY(recipient)REFERENCES user_types(user_type_id)

)

