CREATE DATABASE `tejarak_log` DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `tejarak_log`.`logitems` (
`id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
`logitem_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`logitem_caller` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
`logitem_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
`logitem_desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`logitem_meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
`count` int(10) UNSIGNED NOT NULL DEFAULT '0',
`logitem_priority` enum('critical','high','medium','low') NOT NULL DEFAULT 'medium',
`date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `tejarak_log`.`logs` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`logitem_id` smallint(5) UNSIGNED NOT NULL,
`user_id` int(10) UNSIGNED DEFAULT NULL,
`log_data` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
`log_meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
`log_status` enum('enable','disable','expire','deliver') DEFAULT NULL,
`log_createdate` datetime NOT NULL,
`date_modified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
`log_desc` varchar(250) DEFAULT NULL,
PRIMARY KEY (`id`),
CONSTRAINT `logs_logitems_id` FOREIGN KEY (`logitem_id`) REFERENCES `logitems` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO tejarak_log.logitems SELECT * FROM tejarak.logitems;
INSERT INTO tejarak_log.logs SELECT * FROM tejarak.logs;

