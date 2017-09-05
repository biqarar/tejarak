ALTER TABLE `teams` CHANGE `type` `type` enum('team','school', 'classroom', 'place', 'lesson', 'other') NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `related` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `related_id` bigint(20) unsigned NULL DEFAULT NULL;
ALTER TABLE `userteams` CHANGE `type` `type` enum('teacher','student','manager','deputy','janitor','organizer','sponsor', 'takenunit_teacher', 'takenunit_student') NULL DEFAULT NULL;
ALTER TABLE `teams` ADD `gender` enum('male', 'female') NULL DEFAULT NULL;
