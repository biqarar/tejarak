ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_type` `type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_caller` `caller` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_title` `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_desc` `desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_meta` `meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `tejarak_log`.`logitems` CHANGE `logitem_priority` `priority` enum('critical','high','medium','low') NOT NULL DEFAULT 'medium';
ALTER TABLE `tejarak_log`.`logitems` CHANGE `date_modified` `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;
ALTER TABLE `tejarak_log`.`logitems` ADD `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP;


ALTER TABLE `tejarak_log`.`logs` CHANGE `log_data` `data` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` CHANGE `log_meta` `meta` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
ALTER TABLE `tejarak_log`.`logs` CHANGE `log_status` `status` enum('enable','disable','expire','deliver') DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` CHANGE `log_createdate` `createdate` datetime NOT NULL;
ALTER TABLE `tejarak_log`.`logs` CHANGE `date_modified` `datemodified` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP;
ALTER TABLE `tejarak_log`.`logs` ADD `datecreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `tejarak_log`.`logs` CHANGE `log_desc` `desc` varchar(250) DEFAULT NULL;
