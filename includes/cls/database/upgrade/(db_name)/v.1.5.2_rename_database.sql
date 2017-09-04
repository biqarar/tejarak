RENAME TABLE `subjects` TO `school_subjects`;
RENAME TABLE `schoolterms` TO `school_terms`;
RENAME TABLE `classtimes` TO `school_classtimes`;
RENAME TABLE `lessons` TO `school_lessons`;
RENAME TABLE `lessontimes` TO `school_lessontimes`;
RENAME TABLE `userlessons` TO `school_userlessons`;
RENAME TABLE `scores` TO `school_scores`;



ALTER TABLE `school_terms` ADD CONSTRAINT `school_terms_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
ALTER TABLE `school_classtimes` ADD CONSTRAINT `school_classtimes_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
ALTER TABLE `school_subjects` ADD CONSTRAINT `school_subjects_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
ALTER TABLE `school_lessons` ADD CONSTRAINT `school_lessons_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
ALTER TABLE `school_lessontimes` ADD CONSTRAINT `school_lessontimes_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
ALTER TABLE `school_userlessons` ADD CONSTRAINT `school_userlessons_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
ALTER TABLE `school_scores` ADD CONSTRAINT `school_scores_creator` FOREIGN KEY (`creator`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

ALTER TABLE `school_classtimes` CHANGE `place_id` `classroom`	 int(10) UNSIGNED NOT NULL;
ALTER TABLE `school_lessons` CHANGE `place_id` `classroom`	 int(10) UNSIGNED NOT NULL;
ALTER TABLE `school_userlessons` CHANGE `place_id` `classroom`	 int(10) UNSIGNED NOT NULL;
ALTER TABLE `school_scores` CHANGE `place_id` `classroom`	 int(10) UNSIGNED NOT NULL;


