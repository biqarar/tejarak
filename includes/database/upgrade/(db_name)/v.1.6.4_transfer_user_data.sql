INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'creator', users.creator  FROM users WHERE users.creator IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'fileid', users.fileid  FROM users WHERE users.fileid IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'googlemail', users.googlemail  FROM users WHERE users.googlemail IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'facebookmail', users.facebookmail  FROM users WHERE users.facebookmail IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'twittermail', users.twittermail  FROM users WHERE users.twittermail IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'dontwillsetmobile', users.dontwillsetmobile  FROM users WHERE users.dontwillsetmobile IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'notification', users.notification  FROM users WHERE users.notification IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'setup', users.setup  FROM users WHERE users.setup IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'name', users.name  FROM users WHERE users.name IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'lastname', users.lastname  FROM users WHERE users.lastname IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'father', users.father  FROM users WHERE users.father IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'shcode', users.shcode  FROM users WHERE users.shcode IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'nationalcode', users.nationalcode  FROM users WHERE users.nationalcode IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'shfrom', users.shfrom  FROM users WHERE users.shfrom IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'nationality', users.nationality  FROM users WHERE users.nationality IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'birthplace', users.birthplace  FROM users WHERE users.birthplace IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'region', users.region  FROM users WHERE users.region IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'pasportcode', users.pasportcode  FROM users WHERE users.pasportcode IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'marital', users.marital  FROM users WHERE users.marital IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'childcount', users.childcount  FROM users WHERE users.childcount IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'education', users.education  FROM users WHERE users.education IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'insurancetype', users.insurancetype  FROM users WHERE users.insurancetype IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'insurancecode', users.insurancecode  FROM users WHERE users.insurancecode IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'dependantscount', users.dependantscount  FROM users WHERE users.dependantscount IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'job', users.job  FROM users WHERE users.job IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'cardnumber', users.cardnumber  FROM users WHERE users.cardnumber IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'shaba', users.shaba  FROM users WHERE users.shaba IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'personnelcode', users.personnelcode  FROM users WHERE users.personnelcode IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'passportexpire', users.passportexpire  FROM users WHERE users.passportexpire IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'paymentaccountnumber', users.paymentaccountnumber  FROM users WHERE users.paymentaccountnumber IS NOT NULL;

INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'mobile', users.mobile  FROM users WHERE users.mobile IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'email', users.email  FROM users WHERE users.email IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'chatid', users.chatid  FROM users WHERE users.chatid IS NOT NULL;
INSERT INTO contacts (`user_id`, `key`, `value`) SELECT users.id, 'language', users.language  FROM users WHERE users.language IS NOT NULL;



ALTER TABLE users ADD `avatar` varchar(2000) DEFAULT NULL;
UPDATE users SET users.avatar = users.fileurl;
ALTER TABLE users DROP `fileurl`;



ALTER TABLE users ADD `title` varchar(100) DEFAULT NULL;
UPDATE users SET users.title = users.postion;
ALTER TABLE users DROP `postion`;



ALTER TABLE users DROP `creator`;
ALTER TABLE users DROP `fileid`;
ALTER TABLE users DROP `googlemail`;
ALTER TABLE users DROP `facebookmail`;
ALTER TABLE users DROP `twittermail`;
ALTER TABLE users DROP `dontwillsetmobile`;
ALTER TABLE users DROP `notification`;
ALTER TABLE users DROP `setup`;
ALTER TABLE users DROP `name`;
ALTER TABLE users DROP `lastname`;
ALTER TABLE users DROP `father`;
ALTER TABLE users DROP `shcode`;
ALTER TABLE users DROP `nationalcode`;
ALTER TABLE users DROP `shfrom`;
ALTER TABLE users DROP `nationality`;
ALTER TABLE users DROP `birthplace`;
ALTER TABLE users DROP `region`;
ALTER TABLE users DROP `pasportcode`;
ALTER TABLE users DROP `marital`;
ALTER TABLE users DROP `childcount`;
ALTER TABLE users DROP `education`;
ALTER TABLE users DROP `insurancetype`;
ALTER TABLE users DROP `insurancecode`;
ALTER TABLE users DROP `dependantscount`;
ALTER TABLE users DROP `job`;
ALTER TABLE users DROP `cardnumber`;
ALTER TABLE users DROP `shaba`;
ALTER TABLE users DROP `personnelcode`;
ALTER TABLE users DROP `passportexpire`;
ALTER TABLE users DROP `paymentaccountnumber`;




