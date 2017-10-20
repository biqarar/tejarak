ALTER TABLE `teams` ADD `allowdescenter` bit(1) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `allowdescexit` bit(1) NULL DEFAULT NULL;
ALTER TABLE `userteams` ADD `allowdescenter` bit(1) NULL DEFAULT NULL;
ALTER TABLE `userteams` ADD `allowdescexit` bit(1) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `cardsize` smallint(3) NULL DEFAULT NULL;
