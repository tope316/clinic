/*
SQLyog Ultimate v8.62 
MySQL - 5.1.41 : Database - clinic
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `bottles` */

DROP TABLE IF EXISTS `bottles`;

CREATE TABLE `bottles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `bottles` */

insert  into `bottles`(`ID`,`description`) values (1,'60 ml bottle');

/*Table structure for table `brand` */

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `brand` */

insert  into `brand`(`ID`,`description`) values (1,'Biogesic');

/*Table structure for table `capsules` */

DROP TABLE IF EXISTS `capsules`;

CREATE TABLE `capsules` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `capsules` */

insert  into `capsules`(`ID`,`description`) values (1,'caps');

/*Table structure for table `dosages` */

DROP TABLE IF EXISTS `dosages`;

CREATE TABLE `dosages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `dosages` */

insert  into `dosages`(`ID`,`description`) values (1,'5 ml every 4 hours');

/*Table structure for table `durations` */

DROP TABLE IF EXISTS `durations`;

CREATE TABLE `durations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `durations` */

insert  into `durations`(`ID`,`description`) values (1,'for 7 days');

/*Table structure for table `frequencies` */

DROP TABLE IF EXISTS `frequencies`;

CREATE TABLE `frequencies` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `frequencies` */

insert  into `frequencies`(`ID`,`description`) values (1,'1 capsule 3 times daily');

/*Table structure for table `generic` */

DROP TABLE IF EXISTS `generic`;

CREATE TABLE `generic` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `generic` */

insert  into `generic`(`ID`,`description`) values (3,'Paracetamol');

/*Table structure for table `medical_records` */

DROP TABLE IF EXISTS `medical_records`;

CREATE TABLE `medical_records` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `reg_id` int(11) NOT NULL,
  `checkup_date` date DEFAULT NULL,
  `diagnosis` longtext COLLATE utf8_unicode_ci,
  `treatment` longtext COLLATE utf8_unicode_ci,
  `datecreated` timestamp NULL DEFAULT NULL,
  `lastmodified` timestamp NULL DEFAULT NULL,
  `findings` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `medical_records` */

insert  into `medical_records`(`ID`,`reg_id`,`checkup_date`,`diagnosis`,`treatment`,`datecreated`,`lastmodified`,`findings`) values (2,5,'2014-08-13','test','test','2014-08-13 08:56:56',NULL,NULL);
insert  into `medical_records`(`ID`,`reg_id`,`checkup_date`,`diagnosis`,`treatment`,`datecreated`,`lastmodified`,`findings`) values (3,1,'2014-08-14','test 214','test 214','2014-08-13 09:29:34','2014-12-31 08:55:40','test');
insert  into `medical_records`(`ID`,`reg_id`,`checkup_date`,`diagnosis`,`treatment`,`datecreated`,`lastmodified`,`findings`) values (5,1,'2014-12-31','AIDS','Hopeless','2014-12-31 08:56:22',NULL,'AIDS');
insert  into `medical_records`(`ID`,`reg_id`,`checkup_date`,`diagnosis`,`treatment`,`datecreated`,`lastmodified`,`findings`) values (6,5,'2015-01-07','cvbcvbcvbcvb','ioiouiouio','2015-01-07 15:23:37',NULL,'werwwerwr');
insert  into `medical_records`(`ID`,`reg_id`,`checkup_date`,`diagnosis`,`treatment`,`datecreated`,`lastmodified`,`findings`) values (8,6,'2016-02-24','',NULL,'2016-02-24 12:02:55',NULL,'');
insert  into `medical_records`(`ID`,`reg_id`,`checkup_date`,`diagnosis`,`treatment`,`datecreated`,`lastmodified`,`findings`) values (9,6,'2016-02-25','',NULL,'2016-02-24 12:11:06',NULL,'');

/*Table structure for table `preparations` */

DROP TABLE IF EXISTS `preparations`;

CREATE TABLE `preparations` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `preparations` */

insert  into `preparations`(`ID`,`description`) values (1,'250mg/xxx');

/*Table structure for table `registration` */

DROP TABLE IF EXISTS `registration`;

CREATE TABLE `registration` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fathers_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mothers_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `delivery` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bw` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bl` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hc` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hosp` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bcg_date_1` date DEFAULT NULL,
  `hepa_b_date_1` date DEFAULT NULL,
  `hepa_b_date_2` date DEFAULT NULL,
  `hepa_b_date_3` date DEFAULT NULL,
  `hepa_b_date_4` date DEFAULT NULL,
  `dpt_date_1` date DEFAULT NULL,
  `dpt_date_2` date DEFAULT NULL,
  `dpt_date_3` date DEFAULT NULL,
  `dpt_date_4` date DEFAULT NULL,
  `dpt_date_5` date DEFAULT NULL,
  `opv_date_1` date DEFAULT NULL,
  `opv_date_2` date DEFAULT NULL,
  `opv_date_3` date DEFAULT NULL,
  `opv_date_4` date DEFAULT NULL,
  `opv_date_5` date DEFAULT NULL,
  `hib_date_1` date DEFAULT NULL,
  `hib_date_2` date DEFAULT NULL,
  `hib_date_3` date DEFAULT NULL,
  `hib_date_4` date DEFAULT NULL,
  `measle_date_1` date DEFAULT NULL,
  `rota_date_1` date DEFAULT NULL,
  `rota_date_2` date DEFAULT NULL,
  `rota_date_3` date DEFAULT NULL,
  `typhoid_date_1` date DEFAULT NULL,
  `influenza_date_1` date DEFAULT NULL,
  `influenza_date_2` date DEFAULT NULL,
  `influenza_date_3` date DEFAULT NULL,
  `influenza_date_4` date DEFAULT NULL,
  `influenza_date_5` date DEFAULT NULL,
  `influenza_date_6` date DEFAULT NULL,
  `varicella_date_1` date DEFAULT NULL,
  `varicella_date_2` date DEFAULT NULL,
  `hepa_a_date_1` date DEFAULT NULL,
  `hepa_a_date_2` date DEFAULT NULL,
  `hepa_a_date_3` date DEFAULT NULL,
  `pcv_date_1` date DEFAULT NULL,
  `pcv_date_2` date DEFAULT NULL,
  `pcv_date_3` date DEFAULT NULL,
  `pcv_date_4` date DEFAULT NULL,
  `pneumo_date_1` date DEFAULT NULL,
  `pneumo_date_2` date DEFAULT NULL,
  `mmr_date_1` date DEFAULT NULL,
  `mmr_date_2` date DEFAULT NULL,
  `meningo_date_1` date DEFAULT NULL,
  `hpv_date_1` date DEFAULT NULL,
  `hpv_date_2` date DEFAULT NULL,
  `hpv_date_3` date DEFAULT NULL,
  `newborn_period` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `datecreated` timestamp NULL DEFAULT NULL,
  `lastmodified` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `registration` */

insert  into `registration`(`ID`,`fullname`,`birthdate`,`sex`,`phone`,`mobile`,`fathers_name`,`mothers_name`,`address`,`delivery`,`bw`,`bl`,`hc`,`hosp`,`bcg_date_1`,`hepa_b_date_1`,`hepa_b_date_2`,`hepa_b_date_3`,`hepa_b_date_4`,`dpt_date_1`,`dpt_date_2`,`dpt_date_3`,`dpt_date_4`,`dpt_date_5`,`opv_date_1`,`opv_date_2`,`opv_date_3`,`opv_date_4`,`opv_date_5`,`hib_date_1`,`hib_date_2`,`hib_date_3`,`hib_date_4`,`measle_date_1`,`rota_date_1`,`rota_date_2`,`rota_date_3`,`typhoid_date_1`,`influenza_date_1`,`influenza_date_2`,`influenza_date_3`,`influenza_date_4`,`influenza_date_5`,`influenza_date_6`,`varicella_date_1`,`varicella_date_2`,`hepa_a_date_1`,`hepa_a_date_2`,`hepa_a_date_3`,`pcv_date_1`,`pcv_date_2`,`pcv_date_3`,`pcv_date_4`,`pneumo_date_1`,`pneumo_date_2`,`mmr_date_1`,`mmr_date_2`,`meningo_date_1`,`hpv_date_1`,`hpv_date_2`,`hpv_date_3`,`newborn_period`,`datecreated`,`lastmodified`) values (1,'Kristoffer Enriquez','1982-06-25','M','4147672','09325072411','Manuel Enriquez','Julieta Perales','Lahug','C Section','','','','','2014-07-31',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-04-08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','2014-08-13 07:52:06','2014-07-31 08:10:45');
insert  into `registration`(`ID`,`fullname`,`birthdate`,`sex`,`phone`,`mobile`,`fathers_name`,`mothers_name`,`address`,`delivery`,`bw`,`bl`,`hc`,`hosp`,`bcg_date_1`,`hepa_b_date_1`,`hepa_b_date_2`,`hepa_b_date_3`,`hepa_b_date_4`,`dpt_date_1`,`dpt_date_2`,`dpt_date_3`,`dpt_date_4`,`dpt_date_5`,`opv_date_1`,`opv_date_2`,`opv_date_3`,`opv_date_4`,`opv_date_5`,`hib_date_1`,`hib_date_2`,`hib_date_3`,`hib_date_4`,`measle_date_1`,`rota_date_1`,`rota_date_2`,`rota_date_3`,`typhoid_date_1`,`influenza_date_1`,`influenza_date_2`,`influenza_date_3`,`influenza_date_4`,`influenza_date_5`,`influenza_date_6`,`varicella_date_1`,`varicella_date_2`,`hepa_a_date_1`,`hepa_a_date_2`,`hepa_a_date_3`,`pcv_date_1`,`pcv_date_2`,`pcv_date_3`,`pcv_date_4`,`pneumo_date_1`,`pneumo_date_2`,`mmr_date_1`,`mmr_date_2`,`meningo_date_1`,`hpv_date_1`,`hpv_date_2`,`hpv_date_3`,`newborn_period`,`datecreated`,`lastmodified`) values (6,'Manuel Enriquez Jr.','2016-06-18','M','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','2016-02-24 12:02:14',NULL);
insert  into `registration`(`ID`,`fullname`,`birthdate`,`sex`,`phone`,`mobile`,`fathers_name`,`mothers_name`,`address`,`delivery`,`bw`,`bl`,`hc`,`hosp`,`bcg_date_1`,`hepa_b_date_1`,`hepa_b_date_2`,`hepa_b_date_3`,`hepa_b_date_4`,`dpt_date_1`,`dpt_date_2`,`dpt_date_3`,`dpt_date_4`,`dpt_date_5`,`opv_date_1`,`opv_date_2`,`opv_date_3`,`opv_date_4`,`opv_date_5`,`hib_date_1`,`hib_date_2`,`hib_date_3`,`hib_date_4`,`measle_date_1`,`rota_date_1`,`rota_date_2`,`rota_date_3`,`typhoid_date_1`,`influenza_date_1`,`influenza_date_2`,`influenza_date_3`,`influenza_date_4`,`influenza_date_5`,`influenza_date_6`,`varicella_date_1`,`varicella_date_2`,`hepa_a_date_1`,`hepa_a_date_2`,`hepa_a_date_3`,`pcv_date_1`,`pcv_date_2`,`pcv_date_3`,`pcv_date_4`,`pneumo_date_1`,`pneumo_date_2`,`mmr_date_1`,`mmr_date_2`,`meningo_date_1`,`hpv_date_1`,`hpv_date_2`,`hpv_date_3`,`newborn_period`,`datecreated`,`lastmodified`) values (5,'Ryan Enriquez','1985-06-15','M','','','','','','','','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','2014-08-13 08:02:32',NULL);

/*Table structure for table `security` */

DROP TABLE IF EXISTS `security`;

CREATE TABLE `security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `security` */

insert  into `security`(`id`,`username`,`password`,`fullname`) values (1,'admin','clinic','Kristoffer');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `license_no` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ptr_no` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `s2_no` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`license_no`,`ptr_no`,`s2_no`) values ('79011','1927985','');

/*Table structure for table `tablets` */

DROP TABLE IF EXISTS `tablets`;

CREATE TABLE `tablets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tablets` */

/*Table structure for table `treatment` */

DROP TABLE IF EXISTS `treatment`;

CREATE TABLE `treatment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `mr_id` int(11) NOT NULL,
  `generic_id` int(11) DEFAULT NULL,
  `generic_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `brand_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prep_id` int(11) DEFAULT NULL,
  `prep_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bottle_id` int(11) DEFAULT NULL,
  `bottle_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tablet_id` int(11) DEFAULT NULL,
  `tablet_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `capsule_id` int(11) DEFAULT NULL,
  `capsule_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dosage_id` int(11) DEFAULT NULL,
  `dosage_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `freq_id` int(11) DEFAULT NULL,
  `freq_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dur_id` int(11) DEFAULT NULL,
  `dur_desc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `treatment` */

insert  into `treatment`(`ID`,`mr_id`,`generic_id`,`generic_desc`,`brand_id`,`brand_desc`,`prep_id`,`prep_desc`,`bottle_id`,`bottle_desc`,`tablet_id`,`tablet_desc`,`capsule_id`,`capsule_desc`,`dosage_id`,`dosage_desc`,`freq_id`,`freq_desc`,`dur_id`,`dur_desc`) values (6,3,3,'Paracetamol',1,'Biogesic',1,'',0,'',0,'',0,'',0,'',0,'',0,'');
insert  into `treatment`(`ID`,`mr_id`,`generic_id`,`generic_desc`,`brand_id`,`brand_desc`,`prep_id`,`prep_desc`,`bottle_id`,`bottle_desc`,`tablet_id`,`tablet_desc`,`capsule_id`,`capsule_desc`,`dosage_id`,`dosage_desc`,`freq_id`,`freq_desc`,`dur_id`,`dur_desc`) values (5,3,3,'Paracetamol',0,'',0,'',0,'',0,'',1,'caps',1,'5 ml every 4 hours',0,'',0,'');
insert  into `treatment`(`ID`,`mr_id`,`generic_id`,`generic_desc`,`brand_id`,`brand_desc`,`prep_id`,`prep_desc`,`bottle_id`,`bottle_desc`,`tablet_id`,`tablet_desc`,`capsule_id`,`capsule_desc`,`dosage_id`,`dosage_desc`,`freq_id`,`freq_desc`,`dur_id`,`dur_desc`) values (4,3,3,'Paracetamol',1,'Biogesic',1,'250mg/xxx',1,'60 ml bottle',0,'testes',1,'caps',0,'testosterone',1,'1 capsule 3 times daily',1,'for 7 days');
insert  into `treatment`(`ID`,`mr_id`,`generic_id`,`generic_desc`,`brand_id`,`brand_desc`,`prep_id`,`prep_desc`,`bottle_id`,`bottle_desc`,`tablet_id`,`tablet_desc`,`capsule_id`,`capsule_desc`,`dosage_id`,`dosage_desc`,`freq_id`,`freq_desc`,`dur_id`,`dur_desc`) values (7,8,3,'Paracetamol',1,'Biogesic',1,'250mg/xxx',1,'60 ml bottle',0,'testing',1,'caps',1,'5 ml every 4 hours',1,'1 capsule 3 times daily',1,'for 7 days');
insert  into `treatment`(`ID`,`mr_id`,`generic_id`,`generic_desc`,`brand_id`,`brand_desc`,`prep_id`,`prep_desc`,`bottle_id`,`bottle_desc`,`tablet_id`,`tablet_desc`,`capsule_id`,`capsule_desc`,`dosage_id`,`dosage_desc`,`freq_id`,`freq_desc`,`dur_id`,`dur_desc`) values (9,9,3,'Paracetamol',1,'Biogesic',1,'',0,'',0,'',0,'',0,'',0,'',0,'');
insert  into `treatment`(`ID`,`mr_id`,`generic_id`,`generic_desc`,`brand_id`,`brand_desc`,`prep_id`,`prep_desc`,`bottle_id`,`bottle_desc`,`tablet_id`,`tablet_desc`,`capsule_id`,`capsule_desc`,`dosage_id`,`dosage_desc`,`freq_id`,`freq_desc`,`dur_id`,`dur_desc`) values (10,10,3,'Paracetamol',0,'',0,'250mg/xxx',0,'',0,'',0,'',0,'',0,'',0,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
