CREATE TABLE teams (
`id`					  int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`name`					  varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
`shortname`				  varchar(100) NOT NULL,
`website`				  varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`alias`					  varchar(2000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`address`			      text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`telegram_id`			  varchar(50) NULL DEFAULT NULL,
`24h`			    	  bit(1) NULL DEFAULT NULL,
`remote`			      bit(1) NULL DEFAULT NULL,
`privacy` 				  ENUM('public','private') NOT NULL DEFAULT 'public',
`status`				  ENUM('enable','disable','expire','deleted', 'lock', 'awaiting', 'block', 'filter') NOT NULL DEFAULT 'enable',
`creator`				  int(10) UNSIGNED NOT NULL,
`fileid`				  int(20) UNSIGNED NULL DEFAULT NULL,
`logo`					  int(20) UNSIGNED NULL DEFAULT NULL,
`plan`					  varchar(50) NULL DEFAULT NULL,
`startplan`				  datetime NULL DEFAULT NULL,
`startplanday`		      smallint(2) NULL DEFAULT NULL,
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
`code`         			int(10) NULL DEFAULT NULL,
`telegram_id`  			varchar(50) NULL DEFAULT NULL,
`24h`    				bit(1) NULL DEFAULT NULL,
`remote`       			bit(1) NULL DEFAULT NULL,
`isdefault`   			bit(1) NULL DEFAULT NULL,
`dateenter`   			datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
`dateexit`   			datetime NULL DEFAULT NULL,
`permission`			varchar(1000) NULL DEFAULT NULL;
`rule`					varchar(50) NULL DEFAULT NULL;
`fileid`				bigint(20) UNSIGNED DEFAULT NULL;
`postion`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`displayname`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`name`					varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`family`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`father`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`birthday`				datetime NULL DEFAULT NULL;
`nationalcode`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`from`					varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`nationality`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`brithplace`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`region`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`pasportcode`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`marital`				enum('single','marride') NULL DEFAULT NULL;
`childcount`			smallint(2) NULL DEFAULT NULL;
`education`				varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`insurancetype`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`insurancecode`			varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
`status` 				enum('enable','disable','expire','removed','filter', 'leave') NOT NULL DEFAULT 'enable';
`desc`          		text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
`meta`          		mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`createdate`   			datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified` 		timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
ADD UNIQUE (`user_id`, `team_id`);
CONSTRAINT `userteams_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `userteams_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
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
CONSTRAINT `getway_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `getway_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `hours` (
`id`						bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`user_id`					int(10) UNSIGNED NOT NULL,
`team_id`					int(10) UNSIGNED NOT NULL,
`userteam_id`				int(10) UNSIGNED NOT NULL,
`start_getway_id`			int(10) UNSIGNED NOT NULL,
`end_getway_id`				int(10) UNSIGNED NULL DEFAULT NULL,
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
`id`                 int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
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
