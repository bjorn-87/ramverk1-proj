--
-- CREATE DATABASE ramverk1proj;
--
-- DROP DATABASE IF EXISTS ramverk1proj;
--
-- CREATE DATABASE IF NOT EXISTS ramverk1proj CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci;

CREATE SCHEMA IF NOT EXISTS `ramverk1proj` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci ;
USE `ramverk1proj` ;

USE ramverk1proj;

SET NAMES 'utf8mb4';

-- Create user with backwards compatible password algorithm.
CREATE USER IF NOT EXISTS 'user'@'%'
IDENTIFIED
WITH mysql_native_password -- MySQL with version > 8.0.4
BY 'pass'
;


GRANT ALL PRIVILEGES
	ON ramverk1proj.*
	TO 'user'@'%'
;
