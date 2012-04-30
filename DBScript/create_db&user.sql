

CREATE DATABASE IF NOT EXISTS 
	`single30_utility_db` 
DEFAULT CHARACTER SET 
	utf8 
COLLATE 
	utf8_general_ci;


GRANT ALL PRIVILEGES ON
	single30_utility_db.*
TO
	'single30_utlapp'@'localhost'
IDENTIFIED BY
	'BaoChangJi';
	
