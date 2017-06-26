CREATE TABLE teams (
`id`					  int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`name`					  varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
`shortname`				  varchar(100) NOT NULL,
`website`				  varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`alias`					  varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`telegram_id`			  varchar(50) NULL DEFAULT NULL,
`24h`			    	  bit(1) NULL DEFAULT NULL,
`remote`			      bit(1) NULL DEFAULT NULL,
`allowminus`	    	  bit(1) NULL DEFAULT NULL,
`allowplus`		    	  bit(1) NULL DEFAULT NULL,
`showavatar`	    	  bit(1) NULL DEFAULT NULL,
`privacy` 				  ENUM('public','private') NOT NULL DEFAULT 'public',
`status`				  ENUM('enable','disable','expire','deleted', 'lock', 'awaiting', 'block', 'filter','close') NOT NULL DEFAULT 'enable',
`creator`				  int(10) UNSIGNED NOT NULL,
`fileid`				  int(20) UNSIGNED NULL DEFAULT NULL,
`fileurl`				  varchar(2000) NULL DEFAULT NULL,
`logo`					  int(20) UNSIGNED NULL DEFAULT NULL,
`logourl`				  varchar(2000) NULL DEFAULT NULL,
`plan`					  varchar(50) NULL DEFAULT NULL,
`startplan`				  datetime NULL DEFAULT NULL,
`startplanday`		      smallint(2) NULL DEFAULT NULL,
`parent`				  int(10) UNSIGNED NULL DEFAULT NULL,
`desc`					  text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`meta`					  mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`createdate`			  datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified`			  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE (`shortname`),
CONSTRAINT `teams_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE userteams (
`id`           			int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`team_id`   			int(10) UNSIGNED NOT NULL,
`user_id`      			int(10) UNSIGNED NOT NULL,
`rule`					varchar(50) NULL DEFAULT NULL,
`personnelcode`			varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`telegram_id`  			varchar(50) NULL DEFAULT NULL,
`allowplus`    			bit(1) NULL DEFAULT NULL,
`allowminus`    		bit(1) NULL DEFAULT NULL,
`24h`    				bit(1) NULL DEFAULT NULL,
`remote`       			bit(1) NULL DEFAULT NULL,
`isdefault`   			bit(1) NULL DEFAULT NULL,
`dateenter`   			datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`dateexit`   			datetime NULL DEFAULT NULL,
`fileid`				bigint(20) UNSIGNED DEFAULT NULL,
`fileurl`				varchar(2000) NULL DEFAULT NULL,
`postion`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`displayname`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`fistname`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`lastname`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`status` 				enum('active','deactive','disable','filter', 'leave', 'delete', 'parent') NOT NULL DEFAULT 'active',
`desc`          		text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
`meta`          		mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`createdate`   			datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified` 		timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE (`user_id`, `team_id`),
CONSTRAINT `userteams_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `userteams_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE userteamdetails (
`id`           			int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`team_id`   			int(10) UNSIGNED NOT NULL,
`user_id`      			int(10) UNSIGNED NOT NULL,
`userteam_id`      		int(10) UNSIGNED NOT NULL,
`father`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`birthday`				datetime NULL DEFAULT NULL,
`nationalcode`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`pasportcode`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`nationality`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`brithplace`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`religion`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`marital`				enum('single','marride') NULL DEFAULT NULL,
`childcount`			smallint(2) NULL DEFAULT NULL,
`education`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`insurancetype`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`insurancecode`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`desc`          		text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
`meta`          		mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`createdate`   			datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified` 		timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE (`userteam_id`),
CONSTRAINT `userteamdetails_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `userteamdetails_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
CONSTRAINT `userteamdetails_userteam_id` FOREIGN KEY (`userteam_id`) REFERENCES `userteams` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE getwaies (
`id`           		int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`team_id`   		int(10) UNSIGNED NOT NULL,
`user_id`      		int(10) UNSIGNED NOT NULL,
`title` 	     	varchar(255) NULL DEFAULT NULL,
`cat`		  	  	varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`code`         		int(10) UNSIGNED NULL DEFAULT NULL,
`ip`	         	int(10) UNSIGNED NULL DEFAULT NULL,
`agent_id`  	 	int(10) UNSIGNED NULL DEFAULT NULL,
`status`       		enum('enable','disable','expire') DEFAULT 'enable',
`createdate`   		datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified` 	timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`          	text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
`meta`          	mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `gateway_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `gateway_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `hours` (
`id`						bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id`					int(10) UNSIGNED NOT NULL,
`team_id`					int(10) UNSIGNED NOT NULL,
`userteam_id`				int(10) UNSIGNED NOT NULL,
`start_gateway_id`			int(10) UNSIGNED NULL,
`end_gateway_id`				int(10) UNSIGNED NULL DEFAULT NULL,
`start_userteam_id`			int(10) UNSIGNED NOT NULL,
`end_userteam_id`			int(10) UNSIGNED NULL DEFAULT NULL,
`date`						date NOT NULL,
`year`						smallint(4) UNSIGNED NOT NULL,
`month`						smallint(2) UNSIGNED NOT NULL,
`day`						smallint(2) UNSIGNED NOT NULL,
`shamsi_date`				date NOT NULL,
`shamsi_year`				smallint(4) UNSIGNED NOT NULL,
`shamsi_month`				smallint(2) UNSIGNED NOT NULL,
`shamsi_day`				smallint(2) UNSIGNED NOT NULL,
`start`						time NOT NULL,
`end`						time DEFAULT NULL,
`diff`						int(10) DEFAULT NULL,
`minus`						int(10) UNSIGNED DEFAULT NULL,
`plus`						int(10) UNSIGNED DEFAULT NULL,
`type`						enum('nothing','base','wplus','wminus','all') DEFAULT 'all',
`accepted`					int(10) UNSIGNED DEFAULT NULL,
`createdate`				datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified`				timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`status`					enum('active','awaiting','deactive','removed','filter') DEFAULT 'awaiting',
PRIMARY KEY (`id`),
CONSTRAINT `hours_users_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `hourlogs` (
`id`                 bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`team_id`		     int(10) UNSIGNED NOT NULL,
`user_id`            int(10) UNSIGNED NOT NULL,
`userteam_id`        int(10) UNSIGNED NOT NULL,
`date`     			 date NOT NULL,
`shamsi_date`    	 date NOT NULL,
`time`    			 time NOT NULL,
`minus`    			 int(10) UNSIGNED DEFAULT NULL,
`plus`     			 int(10) UNSIGNED DEFAULT NULL,
`type`     			 enum('enter','exit') DEFAULT NULL,
`diff`				 int(10) DEFAULT NULL,
`createdate`   		 datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified` 	 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
