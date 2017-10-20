ALTER TABLE `teamplans` ADD `status` ENUM('enable','disable','awaiting','paid', 'skipped') NULL;
ALTER TABLE `teamplans` ADD `lastcalcdate` DATETIME NULL;
UPDATE teamplans SET teamplans.lastcalcdate = teamplans.start WHERE teamplans.end is null;
UPDATE teamplans SET teamplans.lastcalcdate = teamplans.end WHERE teamplans.end is not null;
