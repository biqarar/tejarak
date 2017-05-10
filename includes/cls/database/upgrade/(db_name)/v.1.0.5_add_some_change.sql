ALTER TABLE `companies` CHANGE `status` `status` ENUM('enable','disable','expire','deleted') NOT NULL DEFAULT 'enable';
ALTER TABLE `usercompanies` ADD UNIQUE (`user_id`, `company_id`);
ALTER TABLE `userbranchs` ADD UNIQUE (`user_id`, `branch_id`);
ALTER TABLE `companies` ADD UNIQUE (`brand`);
ALTER TABLE `branchs` ADD UNIQUE (`brand`, `company_id`);
ALTER TABLE `users` ADD `user_parent` int(10) unsigned NULL DEFAULT NULL;
