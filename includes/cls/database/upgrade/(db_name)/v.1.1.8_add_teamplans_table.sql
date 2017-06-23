CREATE TABLE teamplans (
`id`					  BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`team_id`				  int(10) UNSIGNED NOT NULL,
`plan`					  int(10) NOT NULL,
`start`					  datetime NOT NULL,
`end`					  datetime NULL DEFAULT NULL,
`creator`				  int(10) UNSIGNED NOT NULL,
`desc`					  text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
`meta`					  mediumtext  CHARACTER SET utf8mb4 NULL DEFAULT NULL,
`createdate`			  datetime DEFAULT CURRENT_TIMESTAMP,
`date_modified`			  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
CONSTRAINT `teamplans_team_id` FOREIGN KEY (`team_id`) REFERENCES `teams` (`id`) ON UPDATE CASCADE,
CONSTRAINT `teamplans_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;