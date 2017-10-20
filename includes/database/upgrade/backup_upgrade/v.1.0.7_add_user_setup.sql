ALTER TABLE `users` ADD `user_setup` bit(1) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_parent` int(10) unsigned NULL DEFAULT NULL;