-- multi_query
CREATE TRIGGER `hours_set_type_status_on_update` BEFORE UPDATE ON `hours` FOR EACH ROW BEGIN
  IF(NEW.end IS NOT NULL) THEN
    SET NEW.diff     = TIME_TO_SEC(TIMEDIFF(NEW.end, NEW.start)) / 60;
    SET NEW.accepted = NEW.diff - IFNULL(NEW.minus, 0) + IFNULL(NEW.plus, 0);
  END IF;

  CASE NEW.type
  WHEN 'base' THEN
      SET NEW.accepted = NEW.diff;
      SET NEW.status = 'filter';

  WHEN 'wplus' THEN
      SET NEW.accepted = NEW.diff + IFNULL(NEW.plus, 0);
      SET NEW.status = 'filter';

  WHEN 'wminus' THEN
      SET NEW.accepted = NEW.diff - IFNULL(NEW.minus, 0);
      SET NEW.status = 'filter';

  WHEN 'all' THEN
      SET NEW.accepted = NEW.diff - IFNULL(NEW.minus, 0) + IFNULL(NEW.plus, 0);
      SET NEW.status = 'active';

    ELSE
      SET NEW.accepted = '0';
      SET NEW.status = 'deactive';

    END CASE;
END
