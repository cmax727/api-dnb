DROP TABLE IF EXISTS `dnb_api`.`dnb_company`;
CREATE TABLE  `dnb_api`.`dnb_company` (
  `com_id` varchar(45) NOT NULL,
  `duns_num` varchar(45) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `description` blob,
  `address` blob,
  `industry` blob,
  `executives` blob,
  `urls` varchar(1024) DEFAULT NULL,
  `yearFounded` varchar(45) DEFAULT NULL,
  `parent_duns` varchar(45) DEFAULT NULL,
  `parent_name` varchar(445) DEFAULT NULL,
  `keyFinancials` blob,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dnb_api`.`dnb_com_rival`;
CREATE TABLE  `dnb_api`.`dnb_com_rival` (
  `com_a` varchar(255) NOT NULL,
  `com_b` varchar(255) NOT NULL,
  `level` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`com_a`,`com_b`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;