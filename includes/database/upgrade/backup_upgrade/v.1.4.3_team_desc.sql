ALTER TABLE `hours` ADD `desc2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `lang` char(2) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `manualtimeenter` bit(1) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `manualtimeexit` bit(1) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `sendphoto` bit(1) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `eventtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `eventdate` datetime NULL DEFAULT NULL;
ALTER TABLE `userteams` ADD `manualtimeenter` bit(1) NULL DEFAULT NULL;
ALTER TABLE `userteams` ADD `manualtimeexit` bit(1) NULL DEFAULT NULL;

ALTER TABLE `termusages` CHANGE `related` `related` ENUM('teams','userteams','posts','products','attachments','files','comments','users') CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
