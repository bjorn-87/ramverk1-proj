--
-- Creating a small table.
-- Create a database and a user having access to this database,
-- this must be done by hand, se commented rows on how to do it.
--



--
-- Create a database for test
--
-- DROP DATABASE ramverk1;
-- CREATE DATABASE IF NOT EXISTS ramverk1;
USE ramverk1;



--
-- Create a database user for the test database
--
-- GRANT ALL ON ramverk1.* TO anax@localhost IDENTIFIED BY 'anax';



-- Ensure UTF8 on the database connection
SET NAMES utf8mb4;



--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(50) NOT NULL,
    `firstname` VARCHAR(50),
    `surname` VARCHAR(50),
    `email` VARCHAR(50) UNIQUE NOT NULL,
    `role` CHAR(20) DEFAULT "user",
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP DEFAULT NULL
		ON UPDATE CURRENT_TIMESTAMP,
) ENGINE INNODB CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci;

INSERT INTO User
	(`password`, `email`, `username`)
VALUES
	('$2y$10$F3h89c1tc/KHZ0P1EgBeNeV09OXiDgDpfFerBhqFEiwJN1AxBZI3e', 'doe@doe.doe', 'doe');

SELECT * FROM USER;
