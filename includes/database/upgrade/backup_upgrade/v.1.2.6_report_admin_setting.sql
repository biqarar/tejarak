ALTER TABLE `userteams` ADD `reportdaily` bit(1) NULL DEFAULT NULL;
ALTER TABLE `userteams` ADD `reportenterexit` bit(1) NULL DEFAULT NULL;

ALTER TABLE `teams` ADD `reportheader` VARCHAR(1000) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `reportfooter` VARCHAR(1000) NULL DEFAULT NULL;