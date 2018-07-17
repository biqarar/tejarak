ALTER TABLE `tejarak_log`.`logs` ADD `caller` varchar(500) NULL DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` ADD `before`  text CHARACTER  SET utf8mb4 NULL DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` ADD `after`  text CHARACTER  SET utf8mb4 NULL DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` ADD `vars`  text CHARACTER  SET utf8mb4 NULL DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` ADD `visitor_id`  bigint(20) unsigned  NULL DEFAULT NULL;
ALTER TABLE `tejarak_log`.`logs` CHANGE `logitem_id` `logitem_id` SMALLINT(5) UNSIGNED NULL;