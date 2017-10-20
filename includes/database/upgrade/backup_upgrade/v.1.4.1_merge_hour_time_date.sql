ALTER TABLE `hours` ADD `start_time` datetime NULL;
ALTER TABLE `hours` ADD `end_time` datetime NULL;
UPDATE hours SET hours.start_time = concat(hours.date, ' ', hours.start);
UPDATE hours SET hours.end_time = concat(hours.enddate, ' ', hours.end) WHERE hours.end IS NOT NULL;