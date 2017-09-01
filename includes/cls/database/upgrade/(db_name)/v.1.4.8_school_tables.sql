CREATE TABLE subjects (
`id`			      	 bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`school_id`				 int(10) UNSIGNED NOT NULL,
`title`			         varchar(100) NOT NULL,
`creator`				 int(10) UNSIGNED NULL,
`privacy`				 enum('public','private') NULL DEFAULT NULL,
`status`				 enum('enable','disable','expire') NULL DEFAULT 'enable',
`isprerequisite`		 bit(1) NULL DEFAULT NULL,
`prerequisite`			 bigint(20) UNSIGNED NULL DEFAULT NULL,
`gender`				 enum('male','female','all') NULL DEFAULT NULL,
`age`					 varchar(1000) NULL DEFAULT NULL,
`classtype`				 enum('physical','unphysical','virtual') NULL DEFAULT NULL,
`needtest`				 enum('test','exam','chat', 'all', 'other') NULL DEFAULT NULL,
`signupprice`			 int(10) NULL DEFAULT NULL,
`price`			 		 int(10) NULL DEFAULT NULL,
`priceexpire`			 int(10) NULL DEFAULT NULL,
`absentcount`			 int(10) NULL DEFAULT NULL,
`absenttype`			 varchar(255) NULL DEFAULT NULL,
`presencecount`			 int(10) NULL DEFAULT NULL,
`acceptscore`			 int(10) NULL DEFAULT NULL,
`havecertificate`		 bit(1) NULL DEFAULT NULL,
`certificationexpire`	 int(10) UNSIGNED NULL DEFAULT NULL,
`minstudent`			 int(10) NULL DEFAULT NULL,
`maxstudent`			 int(10) NULL DEFAULT NULL,
`meetingcount`			 int(10) NULL DEFAULT NULL,
`timecount`				 int(10) NULL DEFAULT NULL,
`createdate`			 datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			         text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			         mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `subjects_school_id` FOREIGN KEY (`school_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE schoolterms (
`id`			      	bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`school_id`				int(10) UNSIGNED NOT NULL,
`start`			 		datetime NULL DEFAULT NULL,
`end`			 		datetime NULL DEFAULT NULL,
`title`			        varchar(100) NULL,
`creator`				int(10) UNSIGNED NULL,
`status`				enum('enable','disable','expire')  NULL DEFAULT 'enable',
`createdate`			datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			        text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			        mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `schoolterms_school_id` FOREIGN KEY (`school_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




CREATE TABLE classtimes (
`id`			      	 bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`school_id`				 int(10) UNSIGNED NOT NULL,
`place_id`				 int(10) UNSIGNED NOT NULL,
`schoolterm_id`			 bigint(20) UNSIGNED NULL DEFAULT NULL,
`title`			         varchar(100) NULL,
`creator`				 int(10) UNSIGNED NULL,
`weekday`				 enum('sunday','monday','tuesday','wednesday','thursday','friday','saturday') NULL DEFAULT NULL,
`start`			 		 time NULL DEFAULT NULL,
`end`			 		 time NULL DEFAULT NULL,
`status`				 enum('enable','disable','expire')  NULL DEFAULT 'enable',
`createdate`			 datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			         text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			         mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `classtimes_place_id` FOREIGN KEY (`place_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `classtimes_schoolterm_id` FOREIGN KEY (`schoolterm_id`) REFERENCES `schoolterms` (`id`) ON UPDATE CASCADE,
CONSTRAINT `classtimes_school_id` FOREIGN KEY (`school_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE lessons (
`id`			      	 bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`school_id`				 int(10) UNSIGNED NOT NULL,
`place_id`				 int(10) UNSIGNED NOT NULL,
`schoolterm_id`			 bigint(20) UNSIGNED NOT NULL,
`teacher`				 int(10) UNSIGNED NOT NULL,
`subject_id`			 bigint(20) UNSIGNED NOT NULL,
`creator`				 int(10) UNSIGNED NULL,
`status`				 enum('awaiting','full','enable','disable','expire')  NULL DEFAULT 'enable',
`createdate`			 datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			         text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			         mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `lessons_school_id` 		FOREIGN KEY (`school_id`) 		REFERENCES `teams` 			(`id`) ON UPDATE CASCADE,
CONSTRAINT `lessons_place_id` 		FOREIGN KEY (`place_id`) 		REFERENCES `teams` 			(`id`) ON UPDATE CASCADE,
CONSTRAINT `lessons_schoolterm_id` 	FOREIGN KEY (`schoolterm_id`) 	REFERENCES `schoolterms` 	(`id`) ON UPDATE CASCADE,
CONSTRAINT `lessons_teacher` 		FOREIGN KEY (`teacher`) 		REFERENCES `userteams` 		(`id`) ON UPDATE CASCADE,
CONSTRAINT `lessons_subject_id` 	FOREIGN KEY (`subject_id`) 		REFERENCES `subjects` 		(`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE lessontimes (
`id`			      	 bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`lesson_id`				 bigint(20) UNSIGNED NOT NULL,
`classtimes_id`			 bigint(20) UNSIGNED NOT NULL,
`creator`				 int(10) UNSIGNED NULL,
`status`				 enum('enable','disable','expire')  NULL DEFAULT 'enable',
`createdate`			 datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			         text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			         mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `lessontimes_classtime_id` FOREIGN KEY (`classtimes_id`) REFERENCES `classtimes` (`id`) ON UPDATE CASCADE,
CONSTRAINT `lessontimes_lesson_id` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE userlessons (
`id`			      	 bigint(20) 	UNSIGNED NOT NULL AUTO_INCREMENT,
`school_id`				 int(10) 		UNSIGNED NOT NULL,
`place_id`				 int(10) 		UNSIGNED NOT NULL,
`schoolterm_id`			 bigint(20) 	UNSIGNED NOT NULL,
`lesson_id`				 bigint(20) 	UNSIGNED NOT NULL,
`teacher`				 int(10) 		UNSIGNED NOT NULL,
`subject_id`			 bigint(20) 	UNSIGNED NOT NULL,
`student`				 int(10) 		UNSIGNED NOT NULL,
`creator`				 int(10) 		UNSIGNED NULL,
`status`				 enum('enable','disable','expire')  NULL DEFAULT 'enable',
`start`					 datetime  NULL DEFAULT NULL,
`end`					 datetime  NULL DEFAULT NULL,
`createdate`			 datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			         text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			         mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `userlessons_school_id` 		FOREIGN KEY (`school_id`) 		REFERENCES `teams` 			(`id`) ON UPDATE CASCADE,
CONSTRAINT `userlessons_place_id` 		FOREIGN KEY (`place_id`) 		REFERENCES `teams` 			(`id`) ON UPDATE CASCADE,
CONSTRAINT `userlessons_schoolterm_id` 	FOREIGN KEY (`schoolterm_id`) 	REFERENCES `schoolterms` 	(`id`) ON UPDATE CASCADE,
CONSTRAINT `userlessons_teacher` 		FOREIGN KEY (`teacher`) 		REFERENCES `userteams` 		(`id`) ON UPDATE CASCADE,
CONSTRAINT `userlessons_student` 		FOREIGN KEY (`student`) 		REFERENCES `userteams` 		(`id`) ON UPDATE CASCADE,
CONSTRAINT `userlessons_subject_id` 		FOREIGN KEY (`subject_id`) 		REFERENCES `subjects` 		(`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE scores (
`id`			      	 bigint(20) 	UNSIGNED NOT NULL AUTO_INCREMENT,
`school_id`				 int(10) 		UNSIGNED NOT NULL,
`place_id`				 int(10) 		UNSIGNED NOT NULL,
`schoolterm_id`			 bigint(20) 	UNSIGNED NOT NULL,
`lesson_id`				 bigint(20) 	UNSIGNED NOT NULL,
`teacher`				 int(10) 		UNSIGNED NOT NULL,
`subject_id`			 bigint(20) 	UNSIGNED NOT NULL,
`student`				 int(10) 		UNSIGNED NOT NULL,
`creator`				 int(10) 		UNSIGNED NULL,
`status`				 enum('enable','disable','expire')  NULL DEFAULT 'enable',
`type`					 enum('default','classroom','endterm')  NULL DEFAULT NULL,
`date`					 datetime  NULL DEFAULT NULL,
`shamsidate`			 varchar(20)  NULL DEFAULT NULL,
`score`					 float(10) NULL DEFAULT NULL,
`createdate`			 datetime  NOT NULL DEFAULT CURRENT_TIMESTAMP,
`date_modified`			 timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`desc`			         text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`meta`			         mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `scores_school_id` 		FOREIGN KEY (`school_id`) 		REFERENCES `teams` 			(`id`) ON UPDATE CASCADE,
CONSTRAINT `scores_place_id` 		FOREIGN KEY (`place_id`) 		REFERENCES `teams` 			(`id`) ON UPDATE CASCADE,
CONSTRAINT `scores_schoolterm_id` 	FOREIGN KEY (`schoolterm_id`) 	REFERENCES `schoolterms` 	(`id`) ON UPDATE CASCADE,
CONSTRAINT `scores_teacher` 		FOREIGN KEY (`teacher`) 		REFERENCES `userteams` 		(`id`) ON UPDATE CASCADE,
CONSTRAINT `scores_student` 		FOREIGN KEY (`student`) 		REFERENCES `userteams` 		(`id`) ON UPDATE CASCADE,
CONSTRAINT `scores_subject_id` 		FOREIGN KEY (`subject_id`) 		REFERENCES `subjects` 		(`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

