-- Información sobre Collations-Charts en MySQL.
-- http://collation-charts.org/mysql60/

-- Estructura de las tablas del blog.

CREATE TABLE IF NOT EXISTS `users` (
  `nickname` varchar(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `password` varchar(130) NOT NULL,
  `email` varchar(50) NOT NULL,
  `birthday` date DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `privilege` bit(1) NOT NULL,
  `lastconnection` datetime DEFAULT NULL,
  `ipaddress` varchar(15) NOT NULL,
  PRIMARY KEY (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fatherid` int(11) DEFAULT NULL,
  `nickname` varchar(20) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `tags` varchar(250) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(nickname) REFERENCES users(nickname) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;