ALTER TABLE `tejarak_log`.`logs` CHANGE `caller` `caller` varchar(200) NULL DEFAULT NULL AFTER `id`;
ALTER TABLE `tejarak_log`.`logs` CHANGE `data` `data` varchar(200) NULL DEFAULT NULL AFTER `user_id`;
ALTER TABLE `tejarak_log`.`logs` ADD `datalink` varchar(100) NULL DEFAULT NULL AFTER `data`;
ALTER TABLE `tejarak_log`.`logs` ADD `subdomain` varchar(100) NULL DEFAULT NULL AFTER `caller`;
ALTER TABLE `tejarak_log`.`logs` DROP `before`;
ALTER TABLE `tejarak_log`.`logs` DROP `after`;
ALTER TABLE `tejarak_log`.`logs` DROP `desc`;
ALTER TABLE `tejarak_log`.`logs` DROP `vars`;
ALTER TABLE `tejarak_log`.`logs` DROP FOREIGN KEY `logs_logitems_id`;
ALTER TABLE `tejarak_log`.`logs` DROP INDEX `logs_logitems_id`;
ALTER TABLE `tejarak_log`.`logs` DROP `logitem_id`;
ALTER TABLE `tejarak_log`.`logs` DROP `createdate`;
ALTER TABLE `tejarak_log`.`logs` CHANGE `datecreated` `datecreated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP AFTER `status`;
ALTER TABLE `tejarak_log`.`logs` CHANGE `meta` `meta` MEDIUMTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL AFTER `visitor_id`;

