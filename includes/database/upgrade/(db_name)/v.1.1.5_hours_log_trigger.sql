-- multi_query
CREATE TRIGGER `hours_set_hourslog_on_update` AFTER UPDATE ON `hours` FOR EACH ROW BEGIN

INSERT IGNORE INTO
  hourlogs
SET
  hourlogs.team_id     = NEW.team_id,
  hourlogs.user_id     = NEW.user_id,
  hourlogs.userteam_id = NEW.userteam_id,
  hourlogs.date        = NEW.date,
  hourlogs.shamsi_date = NEW.shamsi_date,
  hourlogs.time        = NEW.end,
  hourlogs.minus       = NEW.minus,
  hourlogs.plus        = NEW.plus,
  hourlogs.type        = 'exit',
  hourlogs.diff        = NEW.diff;

END;