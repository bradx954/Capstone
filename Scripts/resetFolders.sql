﻿DROP TABLE IF EXISTS CS_Folders;

CREATE TABLE CS_Folders
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30),
	userid INT(6) NOT NULL,
	folderid INT(6),
	reg_date TIMESTAMP
);