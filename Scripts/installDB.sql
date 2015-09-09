CREATE DATABASE Capstone;
USE Capstone;

CREATE USER 'Capstone'@'localhost' IDENTIFIED BY 'Capstone';
GRANT ALL PRIVILEGES ON Capstone.* TO 'Capstone'@'localhost';

CREATE TABLE CS_Users
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	firstname VARCHAR(30) NOT NULL,
	lastname VARCHAR(30) NOT NULL,
	email VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL,
	question VARCHAR(50) NOT NULL,
	answer VARCHAR(50) NOT NULL,
	quota BIGINT NOT NULL,
	salt MEDIUMINT NOT NULL,
	active TINYINT NOT NULL,
	rank VARCHAR(10) NOT NULL,
	reg_date TIMESTAMP
);
CREATE TABLE CS_Folders
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30),
	userid INT(6) NOT NULL,
	folderid INT(6),
	reg_date TIMESTAMP
);
CREATE TABLE CS_Files
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30),
	filelocation VARCHAR(30) NOT NULL,
	filesize BIGINT NOT NULL,
	userid INT(6) NOT NULL,
	folderid INT(6),
	reg_date TIMESTAMP
);
CREATE TABLE CS_Avatars
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30),
	userid INT(6) NOT NULL,
	avatar BLOB,
	reg_date TIMESTAMP
);