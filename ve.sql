/*
SQLyog Enterprise - MySQL GUI v8.12 
MySQL - 5.5.5-10.1.13-MariaDB : Database - fithabit
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`fithabit` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `fithabit`;

/*Table structure for table `docs` */

DROP TABLE IF EXISTS `docs`;

CREATE TABLE `docs` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_programid` int(11) DEFAULT NULL,
  `doc_content` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `docs` */

/*Table structure for table `foods` */

DROP TABLE IF EXISTS `foods`;

CREATE TABLE `foods` (
  `food_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_programid` int(11) DEFAULT '0',
  `food_week` int(11) DEFAULT '0',
  `food_day` int(11) DEFAULT '0',
  `food_daytype` int(11) DEFAULT '1',
  `food_mealtype` int(11) DEFAULT '0',
  `food_name` varchar(255) DEFAULT '',
  `food_quantity` double(10,4) DEFAULT '0.0000',
  `food_quantitytype` int(11) DEFAULT '0',
  `food_protein` double(10,4) DEFAULT '0.0000',
  `food_fat` double(10,4) DEFAULT '0.0000',
  `food_carbs` double(10,4) DEFAULT '0.0000',
  `food_calories` double(10,4) DEFAULT '0.0000',
  `food_order` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `foods` */

/*Table structure for table `memberships` */

DROP TABLE IF EXISTS `memberships`;

CREATE TABLE `memberships` (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_type` int(11) DEFAULT NULL,
  `membership_price` double(10,4) DEFAULT NULL,
  `membership_duration` varchar(10) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`membership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `memberships` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `migrations` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `password_resets` */

/*Table structure for table `programs` */

DROP TABLE IF EXISTS `programs`;

CREATE TABLE `programs` (
  `program_id` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) DEFAULT NULL,
  `program_type` int(1) DEFAULT NULL,
  `program_maker` int(11) DEFAULT NULL,
  `program_image` varchar(255) DEFAULT NULL,
  `program_description` text,
  `program_price` double(10,2) DEFAULT NULL,
  `program_soldcount` int(10) DEFAULT '0',
  `program_ispublished` int(1) NOT NULL DEFAULT '0',
  `program_publishdate` datetime DEFAULT NULL,
  `program_istrial` int(1) NOT NULL DEFAULT '0',
  `program_trialdays` int(2) NOT NULL DEFAULT '0',
  `program_trialstartdate` date DEFAULT NULL,
  `program_weeks` int(11) DEFAULT NULL,
  `program_isfree` int(11) DEFAULT NULL,
  `program_kind` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`program_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `programs` */

/*Table structure for table `ptinfos` */

DROP TABLE IF EXISTS `ptinfos`;

CREATE TABLE `ptinfos` (
  `pt_id` int(11) NOT NULL AUTO_INCREMENT,
  `pt_userid` int(11) DEFAULT NULL,
  `pt_firstname` varchar(255) DEFAULT NULL,
  `pt_lastname` varchar(255) DEFAULT NULL,
  `pt_cardnumber` varchar(255) DEFAULT NULL,
  `pt_expireYear` int(11) DEFAULT NULL,
  `pt_expireMonth` int(11) DEFAULT NULL,
  `pt_securitycode` varchar(255) DEFAULT NULL,
  `pt_country` varchar(255) DEFAULT NULL,
  `pt_state` varchar(255) DEFAULT NULL,
  `pt_address` text,
  `pt_address1` text,
  `pt_city` varchar(255) DEFAULT NULL,
  `pt_postalcode` varchar(255) DEFAULT NULL,
  `pt_phonenumber` varchar(255) DEFAULT NULL,
  `pt_contactname` varchar(255) DEFAULT NULL,
  `pt_contactaddress` text,
  `pt_contactcity` varchar(255) DEFAULT NULL,
  `pt_contactcountry` varchar(255) DEFAULT NULL,
  `pt_contactstate` varchar(255) DEFAULT NULL,
  `pt_membership` int(11) DEFAULT NULL,
  `pt_startdate` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`pt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ptinfos` */

/*Table structure for table `purchases` */

DROP TABLE IF EXISTS `purchases`;

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_user` int(11) DEFAULT NULL,
  `purchase_program` int(11) DEFAULT NULL,
  `purchase_owner` int(11) DEFAULT NULL,
  `purchase_amount` double DEFAULT NULL,
  `purchase_transaction` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `purchases` */

/*Table structure for table `subscriptions` */

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_plan` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `subscriptions` */

/*Table structure for table `userprogram` */

DROP TABLE IF EXISTS `userprogram`;

CREATE TABLE `userprogram` (
  `userprogram_id` int(11) NOT NULL AUTO_INCREMENT,
  `userprogram_userid` int(11) DEFAULT NULL,
  `userprogram_programid` int(11) DEFAULT NULL,
  `userprogram_activestatus` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`userprogram_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `userprogram` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_age` int(10) unsigned NOT NULL DEFAULT '0',
  `user_sex` tinyint(4) NOT NULL DEFAULT '1',
  `user_measurement` tinyint(4) NOT NULL DEFAULT '1',
  `user_startweight` int(10) unsigned NOT NULL DEFAULT '0',
  `user_startfat` int(10) unsigned NOT NULL DEFAULT '0',
  `user_height` int(10) unsigned NOT NULL DEFAULT '0',
  `user_weight` int(10) unsigned NOT NULL DEFAULT '0',
  `user_fat` int(10) unsigned NOT NULL DEFAULT '0',
  `user_fatpercent` double(3,2) NOT NULL DEFAULT '0.00',
  `user_goalweight` int(10) unsigned NOT NULL DEFAULT '0',
  `user_waist` int(10) unsigned NOT NULL DEFAULT '0',
  `user_profileprogress` double(3,2) NOT NULL DEFAULT '0.00',
  `user_birthday` date DEFAULT NULL,
  `user_bioinfo` mediumtext,
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `user_firstlogin` tinyint(4) NOT NULL DEFAULT '0',
  `user_profilepicurl` varchar(100) NOT NULL DEFAULT '',
  `user_startdate` date DEFAULT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) NOT NULL DEFAULT '',
  `user_lastlogin` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL,
  `card_brand` varchar(255) DEFAULT NULL,
  `card_last_four` varchar(255) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `users` */

/*Table structure for table `workouts` */

DROP TABLE IF EXISTS `workouts`;

CREATE TABLE `workouts` (
  `workout_id` int(11) NOT NULL AUTO_INCREMENT,
  `workout_programid` int(11) DEFAULT NULL,
  `workout_week` int(2) DEFAULT '1',
  `workout_day` int(1) DEFAULT '0' COMMENT '0~6:monday~sunday',
  `workout_daytype` int(1) DEFAULT '1' COMMENT '0:Rest 1:Active',
  `workout_extype` int(2) DEFAULT NULL,
  `workout_musclegroup` int(2) DEFAULT NULL,
  `workout_exname` varchar(255) DEFAULT NULL,
  `workout_exid` int(11) DEFAULT NULL,
  `workout_order` int(2) DEFAULT '1',
  `workout_sets` int(11) DEFAULT NULL,
  `workout_setcontent` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`workout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `workouts` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
