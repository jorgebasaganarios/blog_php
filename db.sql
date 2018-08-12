DROP TABLE IF EXISTS `miembros`;
CREATE TABLE `miembros` (
  `idmiembro` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombreusuario` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idmiembro`)
);
LOCK TABLES `miembros` WRITE;

INSERT INTO `miembros` (`idmiembro`, `nombreusuario`, `password`, `email`)
VALUES
  (1,'Demo','$2y$10$wJxa1Wm0rtS2BzqKnoCPd.7QQzgu7D/aLlMR5Aw3O.m9jx3oRJ5R2','demo@demo.com');
UNLOCK TABLES;

DROP TABLE IF EXISTS `publicaciones`;
CREATE TABLE `publicaciones` (
  `idpubli` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `titulopubli` varchar(255) DEFAULT NULL,
  `resumen` text,
  `contenido` text,
  `fechapubli` datetime DEFAULT NULL,
  PRIMARY KEY (`idpubli`)
);
LOCK TABLES `publicaciones` WRITE;

INSERT INTO `publicaciones` (`idpubli`, `titulopubli`, `resumen`, `contenido`, `fechapubli`)
VALUES
  (1,'new','<p>resumen</p>','<p>contenido</p>','2013-05-29 00:00:00'));
UNLOCK TABLES;

DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `idpagina` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombrepagina` varchar(255) DEFAULT NULL,
  `contenido` text,
  `fechacreacion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpagina`)
);
LOCK TABLES `paginas` WRITE;

INSERT INTO `paginas` (`idpagina`, `nombrepagina`, `contenido`, `fechacreacion`)
VALUES
  (1,'Contactar','<p>Professor, make a woman out of me. I am the man with no name, Zapp Brannigan! Good man.
   Nixon\'s pro-war and pro-family. The alien mothership is in orbit here. If we can hit that bullseye, the rest of the dominoes will fall like a house of cards. Checkmate. Fry, you can\'t just sit here in the dark listening to classical music.</p>\r\n<ul>\r\n<li>Who are those horrible orange men?</li>\r\n<li>Is today\'s hectic lifestyle making you tense and impatient?</li>\r\n</ul>\r\n<h3>Lethal Inspection</h3>\r\n<p>Oh, but you can. But you may have to metaphorically make a deal with the devil. And by \"devil\", I mean Robot Devil. And by \"metaphorically\", I mean get your coat. No. We\'re on the top. Does anybody else feel jealous and aroused and worried? Well I\'da done better, but it\'s plum hard pleading a case while awaiting trial for that there incompetence. It must be wonderful.</p>\r\n<h4>Where No Fan Has Gone Before</h4>\r\n<p>Who are those horrible orange men? Bender, we\'re trying our best. Please, Don-Bot&hellip; look into your hard drive, and open your mercy file! Wow! A superpowers drug you can just rub onto your skin? You\'d think it would be something you\'d have to freebase. WINDMILLS DO NOT WORK THAT WAY! GOOD NIGHT! Look, last night was a mistake.</p>\r\n<ol>\r\n<li>I\'m sorry, guys. I never meant to hurt you. Just to destroy everything you ever believed in.</li>\r\n<li>Stop it, stop it. It\'s fine. I will \'destroy\' you!</li>\r\n<li>You guys realize you live in a sewer, right?</li>\r\n</ol>\r\n<h5>Fear of a Bot Planet</h5>\r\n<p>Why yes! Thanks for noticing. Hey, guess what you\'re accessories to. Yes, except the Dave Matthews Band doesn\'t rock. Take me to your leader! Daddy Bender, we\'re hungry.</p>','2013-06-06 08:28:35');
UNLOCK TABLES;