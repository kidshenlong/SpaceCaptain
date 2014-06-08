SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `battlelog` (
  `battleid` int(15) NOT NULL AUTO_INCREMENT,
  `player` int(15) NOT NULL,
  `opponent` int(15) NOT NULL,
  `time` int(15) NOT NULL,
  `winnerid` int(15) NOT NULL,
  `playerattack` int(15) NOT NULL,
  `opdefence` int(15) NOT NULL,
  `shielddamage` int(15) NOT NULL,
  PRIMARY KEY (`battleid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=81 ;

CREATE TABLE IF NOT EXISTS `cooldown` (
  `cooldownid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`cooldownid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `crew` (
  `crewid` int(11) NOT NULL AUTO_INCREMENT,
  `shipid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `speciality` int(11) NOT NULL,
  `onmission` int(11) NOT NULL,
  `wages` int(11) NOT NULL,
  `happiness` int(11) NOT NULL,
  PRIMARY KEY (`crewid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `inventory` (
  `playerid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `inventoryold` (
  `userid` int(10) unsigned NOT NULL,
  `credit` int(10) unsigned NOT NULL,
  `inventoryid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`inventoryid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

CREATE TABLE IF NOT EXISTS `itemlog` (
  `itemusageid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `usage` int(11) NOT NULL,
  `time` int(15) NOT NULL,
  PRIMARY KEY (`itemusageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `items` (
  `itemid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `itemdesc` varchar(200) NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

CREATE TABLE IF NOT EXISTS `joblog` (
  `jobid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) NOT NULL,
  `crewid` int(11) NOT NULL,
  `crewskill` int(11) NOT NULL,
  `jobskill` int(11) NOT NULL,
  `timestart` int(15) NOT NULL,
  `timeend` int(15) NOT NULL,
  `success` int(11) NOT NULL,
  `experience` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `itemquantity` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `crewonmission` int(11) NOT NULL,
  PRIMARY KEY (`jobid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

CREATE TABLE IF NOT EXISTS `location` (
  `locationid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `population` int(10) unsigned NOT NULL,
  `difficulty` int(11) NOT NULL,
  `marketplace` int(11) NOT NULL,
  PRIMARY KEY (`locationid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=57 ;

CREATE TABLE IF NOT EXISTS `marketplace` (
  `marketplaceid` int(11) NOT NULL AUTO_INCREMENT,
  `locationid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `timeposted` int(15) NOT NULL,
  PRIMARY KEY (`marketplaceid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

CREATE TABLE IF NOT EXISTS `marketplacebuylog` (
  `transactionid` int(11) NOT NULL AUTO_INCREMENT,
  `marketplaceid` int(11) NOT NULL,
  `sellerid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `buyerid` int(11) NOT NULL,
  `time` int(15) NOT NULL,
  `locationid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `marketplaceselllog` (
  `transcationid` int(11) NOT NULL AUTO_INCREMENT,
  `marketplaceid` int(11) NOT NULL,
  `sellerid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `time` int(15) NOT NULL,
  `locationid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`transcationid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `message` (
  `messageid` int(11) NOT NULL AUTO_INCREMENT,
  `senderid` int(11) NOT NULL,
  `receiverid` int(11) NOT NULL,
  `message` text NOT NULL,
  `time` int(15) NOT NULL,
  `haveread` int(11) NOT NULL,
  PRIMARY KEY (`messageid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `missioncont` (
  `missioncontid` int(11) NOT NULL AUTO_INCREMENT,
  `playerid` int(11) NOT NULL,
  `defenceoffer` int(11) NOT NULL,
  `experienceoffer` int(11) NOT NULL,
  `joboffer` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `locationid` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`missioncontid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=94 ;

CREATE TABLE IF NOT EXISTS `missionlog` (
  `missionid` int(11) NOT NULL AUTO_INCREMENT,
  `player` int(11) NOT NULL,
  `time` int(20) NOT NULL,
  `success` int(11) NOT NULL,
  `gold` int(11) NOT NULL,
  `exp` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `difficulty` int(11) NOT NULL,
  PRIMARY KEY (`missionid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

CREATE TABLE IF NOT EXISTS `ship` (
  `shipid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `level` bigint(20) unsigned NOT NULL,
  `attack` bigint(20) unsigned NOT NULL,
  `defence` bigint(20) unsigned NOT NULL,
  `shield` bigint(20) unsigned NOT NULL,
  `crewAttack` bigint(20) unsigned NOT NULL,
  `crewDefence` bigint(20) unsigned NOT NULL,
  `experience` bigint(20) unsigned NOT NULL,
  `crew` bigint(20) unsigned NOT NULL,
  `class` int(11) NOT NULL,
  `attackmod` int(11) NOT NULL,
  `defencemod` int(11) NOT NULL,
  PRIMARY KEY (`shipid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

CREATE TABLE IF NOT EXISTS `shipbuff` (
  `shipid` int(10) unsigned NOT NULL,
  `slot1` int(10) unsigned NOT NULL,
  `slot2` int(10) unsigned NOT NULL,
  `slot3` int(10) unsigned NOT NULL,
  `slot4` int(10) unsigned NOT NULL,
  `slot5` int(10) unsigned NOT NULL,
  PRIMARY KEY (`shipid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `travellog` (
  `travelid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `locationid` int(11) NOT NULL,
  `oldlocation` int(11) NOT NULL,
  `time` int(15) NOT NULL,
  PRIMARY KEY (`travelid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `passwd` varchar(64) NOT NULL,
  `lastlogin` bigint(20) unsigned NOT NULL,
  `active` int(11) NOT NULL,
  `verify` int(11) NOT NULL,
  `setup` int(11) NOT NULL,
  `verifycode` varchar(32) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

CREATE TABLE IF NOT EXISTS `userinfo` (
  `userid` int(10) unsigned NOT NULL,
  `name` varchar(200) NOT NULL,
  `turns` int(10) unsigned NOT NULL,
  `shipid` int(10) unsigned NOT NULL,
  `locationid` int(11) NOT NULL,
  `credit` int(15) unsigned NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
