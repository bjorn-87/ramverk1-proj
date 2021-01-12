DROP TABLE IF EXISTS `Answercomment`;
DROP TABLE IF EXISTS `Questioncomment`;
DROP TABLE IF EXISTS `Tags`;
DROP TABLE IF EXISTS `Answer`;
DROP TABLE IF EXISTS `Question`;
DROP TABLE IF EXISTS `User`;
SHOW WARNINGS;
-- -----------------------------------------------------
-- Table `User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `User`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `firstname` VARCHAR(45) NULL,
    `surname` VARCHAR(45) NULL,
    `email` VARCHAR(45) NOT NULL,
    `role` CHAR(20) NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` TIMESTAMP NULL DEFAULT NULL,
    `ranking` INT NULL DEFAULT 0,
    `votes` INT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username_UNIQUE` (`username`),
    UNIQUE INDEX `email_UNIQUE` (`email`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_swedish_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Question`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(45) NOT NULL,
    `title` VARCHAR(100) NULL,
    `text` TEXT NULL,
    `vote` INT NULL DEFAULT 0,
    `answers` INT NULL DEFAULT 0,
    `created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` TIMESTAMP NULL DEFAULT NULL,
     PRIMARY KEY (`id`),
     INDEX `username_idx` (`username`),
     CONSTRAINT `username`
        FOREIGN KEY (`username`)
        REFERENCES `User` (`username`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_swedish_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Answer`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `questionid` INT NOT NULL,
    `username` VARCHAR(45) NOT NULL,
    `text` TEXT NOT NULL,
    `accepted` TINYINT NULL DEFAULT 0,
    `vote` INT NULL DEFAULT 0,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `questionid_idx` (`questionid`),
    CONSTRAINT `questionid`
        FOREIGN KEY (`questionid`)
        REFERENCES `Question` (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_swedish_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Questioncomment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Questioncomment`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `commentquestionid` INT NOT NULL,
    `username` VARCHAR(45) NOT NULL,
    `text` TEXT NOT NULL,
    `vote` INT NULL DEFAULT 0,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `commentquestionid_idx` (`commentquestionid`),
    CONSTRAINT `commentquestionid`
        FOREIGN KEY (`commentquestionid`)
        REFERENCES `Question` (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_swedish_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Answercomment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `Answercomment`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `answerid` INT NOT NULL,
    `username` VARCHAR(45) NOT NULL,
    `text` TEXT NOT NULL,
    `vote` INT NULL DEFAULT 0,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `answerid_idx` (`answerid`),
    CONSTRAINT `answerid`
        FOREIGN KEY (`answerid`)
        REFERENCES `Answer` (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_swedish_ci;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `tags`
-- -----------------------------------------------------
SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Tags`
(
    `id` INT NOT NULL AUTO_INCREMENT,
    `tagquestionid` INT NOT NULL,
    `text` TEXT NULL,
    `created` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `tagquestionid_idx` (`tagquestionid`),
    CONSTRAINT `tagquestionid`
        FOREIGN KEY (`tagquestionid`)
        REFERENCES `Question` (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_swedish_ci;

SHOW WARNINGS;


-- DELETE FROM Questioncomment;
-- DELETE FROM Answercomment;
-- DELETE FROM Answer;
-- DELETE FROM Question;
-- DELETE FROM `User`;

INSERT INTO `User`
	(`username`, `password`, `email`, `role`)
VALUES
	('bjos19', '$2y$10$F3h89c1tc/KHZ0P1EgBeNeV09OXiDgDpfFerBhqFEiwJN1AxBZI3e', 'bjos19@student.bth.se', "admin"),
    ('doe', '$2y$10$OLLVEziRMxZ2thPbvRbwhuL6tIIdoYGKKlXMD./ptyVgeJl98Q6Nq', 'doe@doe.doe', "user")
;

SELECT * FROM `User`;

INSERT INTO `Question`
	(`username`, `title`, `text`, `answers`)
VALUES
	('bjos19', 'När kommer min PS5', 'När får jag min ps5  Är det någon annan som fått sin?', 1);

SELECT * FROM Question;

INSERT INTO `Questioncomment`
	(`username`, `text`, `commentquestionid`)
VALUES
	('doe', 'Nej jag har inte fått min iallafall', 1);

SELECT * FROM Questioncomment;

INSERT INTO `Answer`
	(`username`, `text`, `questionid`)
VALUES
	('doe', 'Nu fick jag leveransbesked från posten!', 1);

SELECT * FROM Answer;

INSERT INTO `Answercomment`
	(`username`, `text`, `answerid`)
VALUES
	('bjos19', 'Vilken lycka, jag har inte fått min :/', 1);

SELECT * FROM Answercomment;
