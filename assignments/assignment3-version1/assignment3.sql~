DROP TABLE if EXISTS users;
CREATE TABLE users (
	username varchar(50) PRIMARY KEY,
	password varchar(255) NOT NULL
);

DROP TABLE IF EXISTS posts;
CREATE TABLE posts (
	id int(11) PRIMARY KEY AUTO_INCREMENT,
	title varchar(255) NOT NULL,
	text text NOT NULL,
	published datetime DEFAULT NULL,
	owner varchar(50),
	FOREIGN KEY (owner) REFERENCES users(username) ON DELETE CASCADE
);

DROP TABLE IF EXISTS comments;
CREATE TABLE comments (
	id int(11) PRIMARY KEY AUTO_INCREMENT,
	title varchar(255) NOT NULL,
	content text NOT NULL,
	commmenter varchar(255),
	time datetime DEFAULT NULL,
	postid int(11),
	FOREIGN KEY (postid) REFERENCES posts(id) ON DELETE CASCADE
);
