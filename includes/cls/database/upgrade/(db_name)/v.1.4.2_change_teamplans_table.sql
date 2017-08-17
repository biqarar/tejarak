ALTER TABLE `teamplans` ADD `status` ENUM('enable','disable','awaiting','paid', 'skipped') NULL;
ALTER TABLE `teamplans` ADD `lastcalcdate` DATE NULL;

