﻿DROP TABLE IF EXISTS CS_Files;

CREATE TABLE CS_Files
(
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(30),
	filesize BIGINT NOT NULL,
	userid INT(6) NOT NULL,
	folderid INT(6),
	reg_date TIMESTAMP
);