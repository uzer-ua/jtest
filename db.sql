DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(255) DEFAULT NULL,
	`tel` varchar(255) DEFAULT NULL,
	PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `contacts` VALUES (1,'John Snower','111222111'),(3,'Jtest','12-3569420'),(5,'Chess Knock','111 888 00 55');
