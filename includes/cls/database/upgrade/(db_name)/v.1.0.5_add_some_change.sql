ALTER TABLE `teams` CHANGE `status` `status` ENUM('enable','disable','expire','deleted') NOT NULL DEFAULT 'enable';
ALTER TABLE `userteams` ADD UNIQUE (`user_id`, `team_id`);
ALTER TABLE `userbranchs` ADD UNIQUE (`user_id`, `branch_id`);
ALTER TABLE `teams` ADD UNIQUE (`brand`);
ALTER TABLE `branchs` ADD UNIQUE (`brand`, `team_id`);
ALTER TABLE `users` ADD `user_parent` int(10) unsigned NULL DEFAULT NULL;
