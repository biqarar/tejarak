ALTER TABLE `school_subjects` ADD `category` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `school_terms` CHANGE `start` `start` varchar(20) NULL DEFAULT NULL;
ALTER TABLE `school_terms` CHANGE `end` `end` varchar(20) NULL DEFAULT NULL;