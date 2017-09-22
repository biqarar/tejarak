
#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:34
	---0.00058293342590332s		---1ms
	#2017-09-20 17:33:34
CREATE TABLE invoices (
`id`			   int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`date`			   datetime NOT NULL,
`user_id_seller`	 int(10) UNSIGNED NULL DEFAULT NULL,
`user_id`			 int(10) UNSIGNED NOT NULL,
`temp` 		 bit(1) NULL DEFAULT NULL,
`title`			   varchar(500) NOT NULL,
`total`			   bigint(20) NULL DEFAULT NULL,
`total_discount`	 int(10) NULL DEFAULT NULL,
`status`			 enum('enable','disable','expire') NOT NULL DEFAULT 'enable',
`date_pay`			 datetime NULL DEFAULT NULL,
`transaction_bank`	   	 varchar(255) NULL DEFAULT NULL,
`discount`			 int(10) NULL DEFAULT NULL,
`vat`			   int(10) NULL DEFAULT NULL,
`vat_pay`			 int(10) NULL DEFAULT NULL,
`final_total`		 bigint(20) NULL DEFAULT NULL,
`count_detail`	 	 smallint(5) UNSIGNED NULL DEFAULT NULL,
`createdate`		 datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified`	 	 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			   text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			   mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `inovoices_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `inovoices_user_id_seller` FOREIGN KEY (`user_id_seller`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
/* ERROR	MYSQL ERROR
Table 'invoices' already exists */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:34
	---0.00046110153198242s		---0ms
	#2017-09-20 17:33:34
CREATE TABLE invoice_details (
`id`			   int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`invoice_id`	   int(10) UNSIGNED NOT NULL,
`title`			   varchar(500) NOT NULL,
`price`			   int(10) NULL DEFAULT NULL,
`count`			   smallint(5) NULL DEFAULT NULL,
`total`			   int(10) NULL DEFAULT NULL,
`discount`			 smallint(5) NULL DEFAULT NULL,
`status`			 enum('enable','disable','expire') NOT NULL DEFAULT 'enable',
`createdate`		 datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified`	 	 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			   text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			   mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `inovoices_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
/* ERROR	MYSQL ERROR
Table 'invoice_details' already exists */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:35
	---0.00026798248291016s		---0ms
	#2017-09-20 17:33:35 ALTER TABLE `users` CHANGE `user_pass` `user_pass` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_pass' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:35
	---0.00099992752075195s		---1ms
	#2017-09-20 17:33:35
--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL,
`transactionitem_id` int(10) UNSIGNED NOT NULL,
`exchangerate_id` int(10) UNSIGNED DEFAULT NULL,
`user_id` int(10) UNSIGNED NOT NULL,
`post_id` bigint(20) UNSIGNED DEFAULT NULL,
`related_user_id` int(10) UNSIGNED DEFAULT NULL,
`type` enum('real','gift','prize','transfer') NOT NULL,
`unit_id` smallint(5) UNSIGNED NOT NULL,
`plus` double DEFAULT NULL,
`minus` double DEFAULT NULL,
`budgetbefore` double DEFAULT NULL,
`budget` double DEFAULT NULL,
`status` enum('enable','disable','deleted','expired','awaiting','filtered','blocked','spam') NOT NULL,
`meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
`desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
`parent_id` bigint(20) UNSIGNED DEFAULT NULL,
`finished` enum('yes','no') NOT NULL DEFAULT 'no',
`createdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `transactions_exchangerate_id` FOREIGN KEY (`exchangerate_id`) REFERENCES `exchangerates` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_transactionitem_id` FOREIGN KEY (`transactionitem_id`) REFERENCES `transactionitems` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_transactions_id_parent` FOREIGN KEY (`parent_id`) REFERENCES `transactions` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_units_id` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_user_id_related` FOREIGN KEY (`related_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `transactions_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8
/* ERROR	MYSQL ERROR
Table 'transactions' already exists */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:35
	---0.00056695938110352s		---1ms
	#2017-09-20 17:33:35 ALTER TABLE `users` ADD `unit_id` smallint(5) NULL DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'unit_id' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:35
	---0.0010859966278076s		---1ms
	#2017-09-20 17:33:35 ALTER TABLE `users` CHANGE `user_status` `user_status` ENUM('active','awaiting','deactive','removed','filter','unreachable') NULL DEFAULT 'awaiting' /* ERROR MYSQL ERROR Unknown column 'user_status' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:36
	---0.00026392936706543s		---0ms
	#2017-09-20 17:33:36 ALTER TABLE `users` DROP INDEX `mobile_unique` /* ERROR MYSQL ERROR Can't DROP 'mobile_unique'; check that column/key exists */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:36
	---0.00012302398681641s		---0ms
	#2017-09-20 17:33:36 ALTER TABLE `users` DROP INDEX `email_unique` /* ERROR MYSQL ERROR Can't DROP 'email_unique'; check that column/key exists */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:37
	---0.00023317337036133s		---0ms
	#2017-09-20 17:33:37 ALTER TABLE `hourrequests` CHANGE `date_shamsi` `shamsi_date` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'date_shamsi' in 'hourrequests' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:38
	---0.0001981258392334s		---0ms
	#2017-09-20 17:33:38 CREATE DATABASE `tejarak_log` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci /* ERROR MYSQL ERROR Can't create database 'tejarak_log'; database exists */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:38
	---0.0041689872741699s		---4ms
	#2017-09-20 17:33:38 INSERT INTO tejarak_log.logitems SELECT * FROM tejarak.logitems /* ERROR MYSQL ERROR Duplicate entry '18' for key 'PRIMARY' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00049614906311035s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_mobile` `mobile` varchar(15) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_mobile' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00015091896057129s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_email` `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_email' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00015997886657715s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_pass` `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_pass' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00016689300537109s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_displayname` `displayname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_displayname' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00013113021850586s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_meta` `meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin /* ERROR MYSQL ERROR Unknown column 'user_meta' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00012421607971191s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_status` `status` enum('active','awaiting','deactive','removed','filter','unreachable') DEFAULT 'awaiting' /* ERROR MYSQL ERROR Unknown column 'user_status' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00015401840209961s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_parent` `parent` int(10) UNSIGNED DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'parent' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011301040649414s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_permission` `permission` varchar(1000) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_permission' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011086463928223s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_type` `type` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_type' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011396408081055s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_createdate` `datecreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP /* ERROR MYSQL ERROR Unknown column 'user_createdate' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011301040649414s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `date_modified` `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP /* ERROR MYSQL ERROR Unknown column 'date_modified' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011706352233887s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_username` `username` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_username' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011420249938965s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_group` `group` varchar(100) CHARACTER SET utf8mb4 DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_group' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00012397766113281s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_file_id` `fileid` int(20) UNSIGNED DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_file_id' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00011706352233887s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_chat_id` `chatid` int(20) UNSIGNED DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_chat_id' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00019598007202148s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_pin` `pin` smallint(4) UNSIGNED DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_pin' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00010204315185547s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_ref` `ref` int(10) UNSIGNED DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_ref' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---9.3936920166016E-5s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_creator` `creator` int(10) UNSIGNED DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_creator' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---8.2015991210938E-5s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_two_step` `twostep` bit(1) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_two_step' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---8.9168548583984E-5s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_google_mail` `googlemail` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_google_mail' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---8.6069107055664E-5s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_facebook_mail` `facebookmail` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_facebook_mail' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00017118453979492s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_twitter_mail` `twittermail` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_twitter_mail' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00012683868408203s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_dont_will_set_mobile` `dontwillsetmobile` varchar(50) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_dont_will_set_mobile' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00016617774963379s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_file_url` `fileurl` varchar(2000) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_file_url' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00022411346435547s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_notification` `notification` text /* ERROR MYSQL ERROR Unknown column 'user_notification' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00029206275939941s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_setup` `setup` bit(1) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'setup' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00039410591125488s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_name` `name` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'name' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00016498565673828s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_family` `lastname` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'lastname' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00015497207641602s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_father` `father` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'father' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00034785270690918s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_birthday` `birthday` datetime DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'birthday' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00068211555480957s		---1ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_code` `shcode` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'shcode' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00021219253540039s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_nationalcode` `nationalcode` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'nationalcode' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00036287307739258s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_from` `shfrom` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'shfrom' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00027704238891602s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_nationality` `nationality` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'nationality' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00020217895507812s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_brithplace` `brithplace` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'brithplace' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00017499923706055s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_region` `region` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'region' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.0001530647277832s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_marital` `marital` enum('single','marride') DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'marital' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00018787384033203s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_gender` `gender` enum('male','female') DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'user_gender' in 'users' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00016999244689941s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_childcount` `childcount` smallint(2) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'childcount' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00018119812011719s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_education` `education` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'education' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00016498565673828s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_insurancetype` `insurancetype` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'insurancetype' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.0001671314239502s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_insurancecode` `insurancecode` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'insurancecode' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.0001060962677002s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_dependantscount` `dependantscount` smallint(4) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'dependantscount' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00020503997802734s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_postion` `postion` varchar(100) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'postion' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:41
	---0.00017809867858887s		---0ms
	#2017-09-20 17:33:41 ALTER TABLE `users` CHANGE `user_language` `language` char(2) DEFAULT NULL /* ERROR MYSQL ERROR Duplicate column name 'language' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00080609321594238s		---1ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_type` `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'logitem_type' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00016021728515625s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_caller` `caller` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL /* ERROR MYSQL ERROR Unknown column 'logitem_caller' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00022792816162109s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_title` `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL /* ERROR MYSQL ERROR Unknown column 'logitem_title' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00018596649169922s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_desc` `desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'logitem_desc' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00012803077697754s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_meta` `meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci /* ERROR MYSQL ERROR Unknown column 'logitem_meta' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00011205673217773s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_priority` `priority` enum('critical','high','medium','low') NOT NULL DEFAULT 'medium' /* ERROR MYSQL ERROR Unknown column 'logitem_priority' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00010395050048828s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` CHANGE `date_modified` `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP /* ERROR MYSQL ERROR Unknown column 'date_modified' in 'logitems' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00011396408081055s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logitems` ADD `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP /* ERROR MYSQL ERROR Duplicate column name 'datecreated' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00053286552429199s		---1ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` CHANGE `log_data` `data` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'log_data' in 'logs' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00017714500427246s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` CHANGE `log_meta` `meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci /* ERROR MYSQL ERROR Unknown column 'log_meta' in 'logs' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.0001680850982666s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` CHANGE `log_status` `status` enum('enable','disable','expire','deliver') DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'log_status' in 'logs' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00017499923706055s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` CHANGE `log_createdate` `createdate` datetime NOT NULL /* ERROR MYSQL ERROR Unknown column 'log_createdate' in 'logs' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00012588500976562s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` CHANGE `date_modified` `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP /* ERROR MYSQL ERROR Unknown column 'date_modified' in 'logs' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---0.00011110305786133s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` ADD `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP /* ERROR MYSQL ERROR Duplicate column name 'datecreated' */

#---------------------------------------------------------------------- /su/install?time=first_time
---2017-09-20 17:33:42
	---9.7036361694336E-5s		---0ms
	#2017-09-20 17:33:42 ALTER TABLE `tejarak_log`.`logs` CHANGE `log_desc` `desc` varchar(250) DEFAULT NULL /* ERROR MYSQL ERROR Unknown column 'log_desc' in 'logs' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 11:04:46
	---0.00041604042053223s		---0ms
	#2017-09-22 11:04:46 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:07:04
	---0.00039410591125488s		---0ms
	#2017-09-22 11:07:04 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:07:27
	---0.0002601146697998s		---0ms
	#2017-09-22 11:07:27 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl
---2017-09-22 11:07:43
	---0.00022292137145996s		---0ms
	#2017-09-22 11:07:43 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl
---2017-09-22 11:11:10
	---0.00036215782165527s		---0ms
	#2017-09-22 11:11:10 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 11:17:37
	---0.00053310394287109s		---1ms
	#2017-09-22 11:17:37 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 11:27:26
	---0.00053000450134277s		---1ms
	#2017-09-22 11:27:26 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:27:29
	---0.00028681755065918s		---0ms
	#2017-09-22 11:27:29 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:27:36
	---0.00029397010803223s		---0ms
	#2017-09-22 11:27:36 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:28:05
	---0.00019288063049316s		---0ms
	#2017-09-22 11:28:05 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:30:54
	---0.00023198127746582s		---0ms
	#2017-09-22 11:30:54 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:59:15
	---0.00022697448730469s		---0ms
	#2017-09-22 11:59:15 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 11:59:15
	---0.00022196769714355s		---0ms
	#2017-09-22 11:59:15 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 11:59:17
	---0.00029087066650391s		---0ms
	#2017-09-22 11:59:17 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools/update
---2017-09-22 11:59:18
	---0.00024509429931641s		---0ms
	#2017-09-22 11:59:18 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools' , 'tools/update') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools/translation
---2017-09-22 11:59:26
	---0.00050497055053711s		---1ms
	#2017-09-22 11:59:26 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools' , 'tools/translation') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 14:25:58
	---0.00036501884460449s		---0ms
	#2017-09-22 14:25:58 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 14:26:05
	---0.00035190582275391s		---0ms
	#2017-09-22 14:26:05 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools/log
---2017-09-22 14:26:08
	---0.00039100646972656s		---0ms
	#2017-09-22 14:26:08 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools' , 'tools/log') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/users
---2017-09-22 14:26:52
	---0.00022697448730469s		---0ms
	#2017-09-22 14:26:52 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('users') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/logs
---2017-09-22 14:28:09
	---0.00047397613525391s		---0ms
	#2017-09-22 14:28:09 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 14:30:16
	---0.00029611587524414s		---0ms
	#2017-09-22 14:30:16 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 14:30:53
	---0.00041699409484863s		---0ms
	#2017-09-22 14:30:53 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/logs
---2017-09-22 14:30:55
	---0.00049304962158203s		---0ms
	#2017-09-22 14:30:55 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl
---2017-09-22 14:31:18
	---0.00036096572875977s		---0ms
	#2017-09-22 14:31:18 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/sendnotify
---2017-09-22 14:31:19
	---0.00044083595275879s		---0ms
	#2017-09-22 14:31:19 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('sendnotify') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 14:31:24
	---0.00025010108947754s		---0ms
	#2017-09-22 14:31:24 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/users
---2017-09-22 14:32:11
	---0.00020480155944824s		---0ms
	#2017-09-22 14:32:11 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('users') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 14:32:13
	---0.00023388862609863s		---0ms
	#2017-09-22 14:32:13 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 14:32:49
	---0.00037002563476562s		---0ms
	#2017-09-22 14:32:49 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp
---2017-09-22 15:25:54
	---0.00014209747314453s		---0ms
	#2017-09-22 15:25:54 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/transactions
---2017-09-22 15:25:56
	---0.00023317337036133s		---0ms
	#2017-09-22 15:25:56 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/transactions
---2017-09-22 15:25:59
	---0.00034904479980469s		---0ms
	#2017-09-22 15:25:59 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/notifications
---2017-09-22 15:26:02
	---0.00029516220092773s		---0ms
	#2017-09-22 15:26:02 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 15:34:56
	---0.0002291202545166s		---0ms
	#2017-09-22 15:34:56 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 15:34:58
	---0.00023007392883301s		---0ms
	#2017-09-22 15:34:58 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/sendnotify
---2017-09-22 15:34:59
	---0.00024104118347168s		---0ms
	#2017-09-22 15:34:59 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('sendnotify') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/sendnotify
---2017-09-22 15:49:08
	---0.00036811828613281s		---0ms
	#2017-09-22 15:49:08 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('sendnotify') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 15:49:10
	---0.00020503997802734s		---0ms
	#2017-09-22 15:49:10 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 15:49:11
	---0.00025200843811035s		---0ms
	#2017-09-22 15:49:11 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/users
---2017-09-22 15:49:12
	---0.00023198127746582s		---0ms
	#2017-09-22 15:49:12 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('users') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 15:49:13
	---0.00024199485778809s		---0ms
	#2017-09-22 15:49:13 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 15:51:47
	---0.0003669261932373s		---0ms
	#2017-09-22 15:51:47 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/logs
---2017-09-22 15:51:48
	---0.00026106834411621s		---0ms
	#2017-09-22 15:51:48 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/users
---2017-09-22 15:51:50
	---0.00035190582275391s		---0ms
	#2017-09-22 15:51:50 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('users') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 15:51:51
	---0.0001990795135498s		---0ms
	#2017-09-22 15:51:51 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl
---2017-09-22 15:51:52
	---0.00023388862609863s		---0ms
	#2017-09-22 15:51:52 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl
---2017-09-22 15:53:18
	---0.00037288665771484s		---0ms
	#2017-09-22 15:53:18 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 15:53:20
	---0.00025105476379395s		---0ms
	#2017-09-22 15:53:20 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 15:53:21
	---0.00029802322387695s		---0ms
	#2017-09-22 15:53:21 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/logs
---2017-09-22 15:53:22
	---0.00022792816162109s		---0ms
	#2017-09-22 15:53:21 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/notifications
---2017-09-22 15:53:37
	---0.00021600723266602s		---0ms
	#2017-09-22 15:53:37 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp
---2017-09-22 15:53:38
	---0.0001981258392334s		---0ms
	#2017-09-22 15:53:38 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/transactions
---2017-09-22 15:53:43
	---0.00021600723266602s		---0ms
	#2017-09-22 15:53:43 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/logs
---2017-09-22 15:53:44
	---0.0002288818359375s		---0ms
	#2017-09-22 15:53:44 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/logs
---2017-09-22 16:34:26
	---0.00025296211242676s		---0ms
	#2017-09-22 16:34:26 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/transactions
---2017-09-22 16:34:28
	---0.00024008750915527s		---0ms
	#2017-09-22 16:34:28 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /cp/logs
---2017-09-22 16:34:29
	---0.00023794174194336s		---0ms
	#2017-09-22 16:34:29 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 16:34:33
	---0.00023317337036133s		---0ms
	#2017-09-22 16:34:33 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 16:34:33
	---0.00037002563476562s		---0ms
	#2017-09-22 16:34:33 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 16:34:35
	---0.00023198127746582s		---0ms
	#2017-09-22 16:34:35 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 16:35:21
	---0.00023412704467773s		---0ms
	#2017-09-22 16:35:21 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/logs
---2017-09-22 16:35:23
	---0.00038886070251465s		---0ms
	#2017-09-22 16:35:23 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/users
---2017-09-22 16:35:24
	---0.00023007392883301s		---0ms
	#2017-09-22 16:35:24 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('users') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 16:35:25
	---0.00023102760314941s		---0ms
	#2017-09-22 16:35:25 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 16:50:42
	---0.00024604797363281s		---0ms
	#2017-09-22 16:50:42 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 16:50:44
	---0.00023508071899414s		---0ms
	#2017-09-22 16:50:44 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/logs
---2017-09-22 16:50:44
	---0.00023603439331055s		---0ms
	#2017-09-22 16:50:44 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('logs') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 16:50:47
	---0.00025510787963867s		---0ms
	#2017-09-22 16:50:47 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 16:51:16
	---0.00031399726867676s		---0ms
	#2017-09-22 16:51:16 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 17:15:56
	---0.00037598609924316s		---0ms
	#2017-09-22 17:15:56 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su
---2017-09-22 17:15:58
	---0.00036907196044922s		---0ms
	#2017-09-22 17:15:58 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 17:15:59
	---0.00023317337036133s		---0ms
	#2017-09-22 17:15:59 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/transactions
---2017-09-22 17:16:01
	---0.00026988983154297s		---0ms
	#2017-09-22 17:16:01 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('transactions') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/notifications
---2017-09-22 17:16:03
	---0.00049304962158203s		---0ms
	#2017-09-22 17:16:03 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('notifications') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl
---2017-09-22 17:16:05
	---0.00022006034851074s		---0ms
	#2017-09-22 17:16:05 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/shorturl?val=546
---2017-09-22 17:16:08
	---0.0002291202545166s		---0ms
	#2017-09-22 17:16:08 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('shorturl') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */

#---------------------------------------------------------------------- /su/tools
---2017-09-22 17:37:40
	---0.0003669261932373s		---0ms
	#2017-09-22 17:37:40 SELECT * FROM posts WHERE `0` = 'url' AND `1` IN ('tools') /* ERROR MYSQL ERROR Unknown column '0' in 'where clause' */
