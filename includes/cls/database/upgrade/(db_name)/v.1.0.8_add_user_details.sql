ALTER TABLE `users` ADD `user_name` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_family` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_father` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_birthday` 		datetime NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_code` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_nationalcode` 	varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_from` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_nationality` 		varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_brithplace` 		varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_region` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_pasportcode` 		varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_marital` 			enum('single', 'married') NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_childcount` 		smallint(2) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_education` 		varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_insurancetype` 	varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_insurancecode` 	varchar(100) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_dependantscount` 	smallint(4) NULL DEFAULT NULL;
ALTER TABLE `users` ADD `user_postion` 			varchar(100) NULL DEFAULT NULL;
ALTER TABLE `logs` ADD `log_desc` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `users` CHANGE `user_pass` `user_pass` VARCHAR(64) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL;