ALTER TABLE `hours` ADD `enddate`						date NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endyear`						smallint(4) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endmonth`						smallint(2) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endday`						smallint(2) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endshamsi_date`				date NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endshamsi_year`				smallint(4) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endshamsi_month`				smallint(2) UNSIGNED NULL DEFAULT NULL;
ALTER TABLE `hours` ADD `endshamsi_day`					smallint(2) UNSIGNED NULL DEFAULT NULL;





ALTER TABLE `hourlogs` CHANGE `team_id` `team_id` INT(10) UNSIGNED NULL;
ALTER TABLE `hourlogs` CHANGE `user_id` `user_id` INT(10) UNSIGNED NULL;
ALTER TABLE `hourlogs` CHANGE `userteam_id` `userteam_id` INT(10) UNSIGNED NULL;
ALTER TABLE `hourlogs` CHANGE `date` `date` DATE NULL;
ALTER TABLE `hourlogs` CHANGE `shamsi_date` `shamsi_date` DATE NULL;
ALTER TABLE `hourlogs` CHANGE `time` `time` TIME NULL;
