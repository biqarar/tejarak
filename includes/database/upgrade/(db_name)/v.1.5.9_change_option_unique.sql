ALTER TABLE `options` DROP INDEX `unique_cat`;
ALTER TABLE `options` CHANGE `cat` `cat` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
ALTER TABLE `options` ADD UNIQUE `unique_key` (`key`);

