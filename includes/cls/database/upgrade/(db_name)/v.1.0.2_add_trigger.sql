-- multi_query
CREATE TRIGGER `updateTime` BEFORE UPDATE ON `hours` FOR EACH ROW BEGIN

    IF (NEW.type = 'base') THEN
      SET NEW.accepted = NEW.diff;
      SET NEW.status = 'filter';

    ELSEIF (NEW.type = 'wplus') THEN
      SET NEW.accepted = NEW.diff + IFNULL(NEW.plus, 0);
      SET NEW.status = 'filter';

    ELSEIF (NEW.type = 'wminus') THEN
      SET NEW.accepted = NEW.diff - IFNULL(NEW.minus, 0);
      SET NEW.status = 'filter';

    ELSEIF (NEW.type = 'all') THEN
      SET NEW.accepted = NEW.diff - IFNULL(NEW.minus, 0) + IFNULL(NEW.plus, 0);
      SET NEW.status = 'active';

    ELSE
      SET NEW.accepted = '0';
      SET NEW.status = 'deactive';

    END IF;


  IF (NEW.end IS NOT NULL ) THEN
    SET NEW.diff     = TIME_TO_SEC(TIMEDIFF(NEW.end, NEW.start)) / 60;
    SET NEW.accepted = NEW.diff - IFNULL(NEW.minus, 0) + IFNULL(NEW.plus, 0);
  END IF;


END
