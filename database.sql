delimiter $$

CREATE TABLE `defaultImage_Link` (
  `iddefaultImage` int(11) NOT NULL AUTO_INCREMENT,
  `defaultImage_Link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddefaultImage`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `defaultImage_Link` (
  `iddefaultImage` int(11) NOT NULL AUTO_INCREMENT,
  `defaultImage_Link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddefaultImage`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `logTweets` (
  `idlogTweets` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(45) DEFAULT NULL,
  `idtbl_newsTech` int(11) DEFAULT NULL,
  `dtSendTweet` datetime DEFAULT NULL,
  PRIMARY KEY (`idlogTweets`),
  UNIQUE KEY `uk` (`user`,`idtbl_newsTech`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `tbl_newsTech` (
  `idtbl_newsTech` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `guid` varchar(255) DEFAULT NULL,
  `category` varchar(45) DEFAULT NULL,
  `site` varchar(45) DEFAULT NULL,
  `pubDate` varchar(45) DEFAULT NULL,
  `description` longtext,
  `pubDateServer` datetime DEFAULT NULL,
  `linkImg` varchar(255) DEFAULT NULL,
  `descriptionNew` longtext,
  `dt_import` datetime DEFAULT NULL,
  PRIMARY KEY (`idtbl_newsTech`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=3626 DEFAULT CHARSET=latin1$$

