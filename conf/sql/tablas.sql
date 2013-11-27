-- Información sobre Collations-Charts en MySQL.
-- http://collation-charts.org/mysql60/

-- Estructura de las tablas del blog.

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fatherid` int(11) DEFAULT NULL,
  `nickname` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `title` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `content` text COLLATE utf8_spanish_ci NOT NULL,
  `tags` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nickname` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1 ;

--
-- Volcar la base de datos para la tabla `messages`
--


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `nickname` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `name` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `datecreated` int(11) NOT NULL,
  `privilege` tinyint(1) NOT NULL,
  `lastconnection` datetime DEFAULT NULL,
  `ipaddress` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `checking` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Filtros para la tabla `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`nickname`) REFERENCES `users` (`nickname`) ON DELETE CASCADE ON UPDATE CASCADE;