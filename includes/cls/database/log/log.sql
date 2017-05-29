
#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:47:45
---
	---0.00025796890258789s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:47:45
---
	---0.00029206275939941s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:47:45
---
	---0.00036311149597168s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:47:54
---
	---0.00017809867858887s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:47:54
---
	---0.0003049373626709s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:47:54
---
	---0.00038599967956543s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:34
---
	---0.00025010108947754s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:34
---
	---0.00023078918457031s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:34
---
	---0.0003049373626709s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:36
---
	---0.00029897689819336s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:36
---
	---0.00026893615722656s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:36
---
	---0.00018715858459473s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:code:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:36
---
	---0.0085289478302002s		---9ms
	INSERT INTO logitems SET `logitem_caller` = 'api:getway:code:invalid' , `logitem_title` = 'api:getway:code:invalid'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:36
---
	---0.00059795379638672s		---1ms
	SELECT id AS `id` FROM logitems WHERE logitems.logitem_caller = 'api:getway:code:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:36
---
	---0.0070829391479492s		---7ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 23 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"","cat":"","code":"","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:48:36'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:47
---
	---0.00030303001403809s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:47
---
	---0.00032806396484375s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:47
---
	---0.00020885467529297s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:ip:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:47
---
	---0.0033080577850342s		---3ms
	INSERT INTO logitems SET `logitem_caller` = 'api:getway:ip:invalid' , `logitem_title` = 'api:getway:ip:invalid'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:47
---
	---0.00031208992004395s		---0ms
	SELECT id AS `id` FROM logitems WHERE logitems.logitem_caller = 'api:getway:ip:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:48:47
---
	---0.0033330917358398s		---3ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 24 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"","cat":"","code":"12","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:48:47'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:35
---
	---0.00025486946105957s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:35
---
	---0.00021886825561523s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:35
---
	---0.00020718574523926s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:title:is:null' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:35
---
	---0.0080440044403076s		---8ms
	INSERT INTO logitems SET `logitem_caller` = 'api:getway:title:is:null' , `logitem_title` = 'api:getway:title:is:null'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:35
---
	---0.00025796890258789s		---0ms
	SELECT id AS `id` FROM logitems WHERE logitems.logitem_caller = 'api:getway:title:is:null' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:35
---
	---0.0063400268554688s		---6ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 25 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"","cat":"","code":"12","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:50:35'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:52
---
	---0.00022315979003906s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:52
---
	---0.00027894973754883s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:52
---
	---0.00021886825561523s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:ip:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:52
---
	---0.015975952148438s		---16ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 24 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"asdasd","cat":"","code":"12","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:50:52'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:56
---
	---0.00027799606323242s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:56
---
	---0.00026893615722656s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:56
---
	---0.00024199485778809s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:ip:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:50:56
---
	---0.0067038536071777s		---7ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 24 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"asdasd","cat":"","code":"","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:50:56'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:51:20
---
	---0.00025415420532227s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:51:20
---
	---0.00029993057250977s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:51:20
---
	---0.00023317337036133s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:status:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:51:20
---
	---0.00211501121521s		---2ms
	INSERT INTO logitems SET `logitem_caller` = 'api:getway:status:invalid' , `logitem_title` = 'api:getway:status:invalid'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:51:20
---
	---0.00033092498779297s		---0ms
	SELECT id AS `id` FROM logitems WHERE logitems.logitem_caller = 'api:getway:status:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:51:20
---
	---0.0023989677429199s		---2ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 26 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"asdasd","cat":"","code":"","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:51:20'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:52:35
---
	---0.00022411346435547s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:52:35
---
	---0.000244140625s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:52:35
---
	---0.00048398971557617s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:status:invalid' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:52:35
---
	---0.0080289840698242s		---8ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 26 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"asdasd","cat":"","code":"","ip":"","status":"","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:52:35'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:44
---
	---0.00027894973754883s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:44
---
	---0.0001828670501709s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:44
---
	---0.00029492378234863s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:52
---
	---0.00023698806762695s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:52
---
	---0.00029516220092773s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:52
---
	---0.00039100646972656s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:52
---
	---0.00020313262939453s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:52
---
	---0.00024008750915527s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:52
---
	---0.00028586387634277s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:57
---
	---0.00023293495178223s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:57
---
	---0.00019598007202148s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:54:57
---
	---0.00032210350036621s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:04
---
	---0.00019383430480957s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:04
---
	---0.0001981258392334s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:04
---
	---0.00048398971557617s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:27
---
	---0.00025200843811035s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:27
---
	---0.0002131462097168s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:27
---
	---0.00025296211242676s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:37
---
	---0.00021505355834961s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:37
---
	---0.0002129077911377s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:37
---
	---0.00032591819763184s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:39
---
	---0.00016999244689941s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:39
---
	---0.0002598762512207s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:39
---
	---0.00038313865661621s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:44
---
	---0.00025820732116699s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:44
---
	---0.00023698806762695s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:44
---
	---0.00016093254089355s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:title:is:null' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:44
---
	---0.008059024810791s		---8ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 25 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"","cat":"","code":"","ip":"","status":"enable","desc":"","company":"ermile"}}' , `log_createdate` = '2017-05-12 18:55:44'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:55
---
	---0.00033903121948242s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:55
---
	---0.00038003921508789s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:55:55
---
	---0.00053000450134277s		---1ms
	INSERT INTO getwaies SET `title` = 'درگاه اول' , `cat` = 'وروودی' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:58:14
---
	---0.00023984909057617s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:58:14
---
	---0.00026392936706543s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:59:55
---
	---0.00025415420532227s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:59:55
---
	---0.00021600723266602s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 18:59:55
---
	---0.00022292137145996s		---0ms
	INSERT INTO getwaies SET `title` = 'درگاه اول' , `cat` = 'وروودی' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:00:18
---
	---0.00024700164794922s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:00:18
---
	---0.00028800964355469s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:00:18
---
	---0.00038504600524902s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.00022292137145996s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.00020885467529297s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.00072002410888672s		---1ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.00017213821411133s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:access:to:load:branch' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.0027909278869629s		---3ms
	INSERT INTO logitems SET `logitem_caller` = 'api:getway:access:to:load:branch' , `logitem_title` = 'api:getway:access:to:load:branch'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.00025820732116699s		---0ms
	SELECT id AS `id` FROM logitems WHERE logitems.logitem_caller = 'api:getway:access:to:load:branch' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:12:59
---
	---0.0047810077667236s		---5ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 27 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"درگاه اول","cat":"وروودی","code":"12","ip":"","status":"enable","desc":"","company":"ermile","branch":"sarshomar"}}' , `log_createdate` = '2017-05-12 19:12:59'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:14:40
---
	---0.00021100044250488s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:14:40
---
	---0.00019502639770508s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:14:40
---
	---0.00026607513427734s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-12 19:15:05
---
	---0.0004429817199707s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-12 19:15:05
---
	---0.00049304962158203s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-12 19:15:05
---
	---0.00018477439880371s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-12 19:15:05
---
	---0.00023984909057617s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00020003318786621s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00013899803161621s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00012016296386719s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00011587142944336s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00020813941955566s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00028896331787109s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00021791458129883s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.0001671314239502s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.00022602081298828s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:07
---
	---0.0002748966217041s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:08
---
	---0.00022196769714355s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:08
---
	---0.00030303001403809s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:08
---
	---0.00015687942504883s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:08
---
	---0.00023579597473145s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:08
---
	---0.00026512145996094s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:08
---
	---0.00022697448730469s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/edit
---2017-05-12 19:15:10
---
	---0.00021505355834961s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/edit
---2017-05-12 19:15:10
---
	---0.00030612945556641s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/edit
---2017-05-12 19:15:10
---
	---0.00043797492980957s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/edit
---2017-05-12 19:15:10
---
	---0.00019121170043945s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/edit
---2017-05-12 19:15:10
---
	---0.0003821849822998s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/edit
---2017-05-12 19:15:10
---
	---0.00028610229492188s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00015902519226074s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.0001530647277832s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00013494491577148s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00014710426330566s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00023508071899414s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00028419494628906s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00025606155395508s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00015997886657715s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.00019097328186035s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-12 19:15:13
---
	---0.0002601146697998s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:15
---
	---0.00022292137145996s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:15
---
	---0.00022506713867188s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:15
---
	---0.00018000602722168s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:15
---
	---0.00021505355834961s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:15
---
	---0.00029110908508301s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-12 19:15:15
---
	---0.00024509429931641s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:16
---
	---0.00054001808166504s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:16
---
	---0.00054597854614258s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:16
---
	---0.00038385391235352s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:16
---
	---0.00024008750915527s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:16
---
	---0.00023007392883301s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:16
---
	---0.00032901763916016s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:53
---
	---0.00025391578674316s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:53
---
	---0.00026202201843262s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:53
---
	---0.00027179718017578s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:58
---
	---0.00030303001403809s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:58
---
	---0.00029993057250977s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:15:58
---
	---0.00027108192443848s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:23
---
	---0.00024223327636719s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:23
---
	---0.0013191699981689s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:23
---
	---0.00043392181396484s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:38
---
	---0.00021696090698242s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:38
---
	---0.00022387504577637s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:38
---
	---0.00026512145996094s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:38
---
	---0.003870964050293s		---4ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:41
---
	---0.0002739429473877s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:41
---
	---0.0002892017364502s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:41
---
	---0.00030899047851562s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:16:41
---
	---0.0023698806762695s		---2ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00032687187194824s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.0002288818359375s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00049281120300293s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.008897066116333s		---9ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.0001981258392334s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00019192695617676s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00023698806762695s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.004863977432251s		---5ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00021910667419434s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00015091896057129s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00043988227844238s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.0021548271179199s		---2ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00034904479980469s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00024294853210449s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00033402442932129s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.0024909973144531s		---2ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00026893615722656s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00030803680419922s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.00030088424682617s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:17:20
---
	---0.0023248195648193s		---2ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:20:58
---
	---0.00039887428283691s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:20:58
---
	---0.00041103363037109s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:20:58
---
	---0.00028181076049805s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:20:58
---
	---0.00032305717468262s		---0ms
	SELECT COUNT(getwaies.id) AS `count` FROM getwaies WHERE getwaies.`company_id` = 1 AND getwaies.`title` = 'sdfsdf' AND getwaies.`branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:20:58
---
	---0.00025701522827148s		---0ms
	SELECT * FROM getwaies WHERE getwaies.`company_id` = 1 AND getwaies.`title` = 'sdfsdf' AND getwaies.`branch_id` = 2 ORDER BY getwaies.id DESC LIMIT 0, 15 -- getwaies::search() -- [null,{"company_id":1,"title":"sdfsdf","branch_id":2}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:33
---
	---0.00021100044250488s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:33
---
	---0.00021886825561523s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:33
---
	---0.00027298927307129s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:33
---
	---0.00033783912658691s		---0ms
	SELECT COUNT(getwaies.id) AS `count` FROM getwaies WHERE getwaies.`company_id` = 1 AND getwaies.`title` = 'sdfsdf' AND getwaies.`branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:33
---
	---0.00030803680419922s		---0ms
	SELECT * FROM getwaies WHERE getwaies.`company_id` = 1 AND getwaies.`title` = 'sdfsdf' AND getwaies.`branch_id` = 2 ORDER BY getwaies.id DESC LIMIT 0, 15 -- getwaies::search() -- [null,{"company_id":1,"title":"sdfsdf","branch_id":2}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:33
---
	---0.0076818466186523s		---8ms
	INSERT INTO getwaies SET `title` = 'sdfsdf' , `cat` = 'sdfsd' , `code` = 12 , `ip` = NULL, `status` = 'enable' , `desc` = NULL, `company_id` = 1 , `user_id` = 4 , `branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.0003359317779541s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.00028896331787109s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.00031805038452148s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.00035309791564941s		---0ms
	SELECT COUNT(getwaies.id) AS `count` FROM getwaies WHERE getwaies.`company_id` = 1 AND getwaies.`title` = 'sdfsdf' AND getwaies.`branch_id` = 2

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.00031399726867676s		---0ms
	SELECT * FROM getwaies WHERE getwaies.`company_id` = 1 AND getwaies.`title` = 'sdfsdf' AND getwaies.`branch_id` = 2 ORDER BY getwaies.id DESC LIMIT 0, 15 -- getwaies::search() -- [null,{"company_id":1,"title":"sdfsdf","branch_id":2}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.00019288063049316s		---0ms
	SELECT id FROM logitems WHERE logitems.logitem_caller = 'api:getway:title:duplicate' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.0096430778503418s		---10ms
	INSERT INTO logitems SET `logitem_caller` = 'api:getway:title:duplicate' , `logitem_title` = 'api:getway:title:duplicate'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.00029778480529785s		---0ms
	SELECT id AS `id` FROM logitems WHERE logitems.logitem_caller = 'api:getway:title:duplicate' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:31:44
---
	---0.0091769695281982s		---9ms
	INSERT IGNORE INTO	logs SET  `logitem_id` = 28 , `user_id` = 4 , `log_data` = NULL , `log_status` = 'enable' , `log_meta` = '{"input":{"title":"sdfsdf","cat":"sdfsd","code":"12","ip":"","status":"enable","desc":"","company":"ermile","branch":"sarshomar"}}' , `log_createdate` = '2017-05-12 19:31:44'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:38
---
	---0.00022292137145996s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:38
---
	---0.00028395652770996s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:38
---
	---0.0017209053039551s		---2ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:41
---
	---0.00017404556274414s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:41
---
	---0.00016999244689941s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:41
---
	---0.00023889541625977s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:41
---
	---0.00022411346435547s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:41
---
	---0.0002138614654541s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:35:41
---
	---0.00029778480529785s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:13
---
	---0.00034403800964355s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:13
---
	---0.00043201446533203s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:13
---
	---0.00060915946960449s		---1ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/list
---2017-05-12 19:36:15
---
	---0.00019598007202148s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/list
---2017-05-12 19:36:47
---
	---0.0001530647277832s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:48
---
	---0.00025200843811035s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:48
---
	---0.00020098686218262s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:48
---
	---0.00032186508178711s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:48
---
	---0.00022006034851074s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:48
---
	---0.00018620491027832s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:48
---
	---0.00022292137145996s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/list
---2017-05-12 19:36:49
---
	---0.00014495849609375s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:56
---
	---0.0004580020904541s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:56
---
	---0.00027084350585938s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/add
---2017-05-12 19:36:56
---
	---0.00031495094299316s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway/list
---2017-05-12 19:36:59
---
	---0.00024700164794922s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:10
---
	---0.00031685829162598s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:10
---
	---0.0002439022064209s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:10
---
	---0.00061488151550293s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:17
---
	---0.00023317337036133s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:17
---
	---0.00024104118347168s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:17
---
	---0.00033283233642578s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:51
---
	---0.0003509521484375s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:51
---
	---0.00022292137145996s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:37:51
---
	---0.0003969669342041s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:38:02
---
	---0.00021195411682129s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:38:02
---
	---0.00018405914306641s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:38:02
---
	---0.0004878044128418s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:48:50
---
	---0.00031590461730957s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:48:50
---
	---0.00022411346435547s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:48:50
---
	---0.00037789344787598s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:51:23
---
	---0.00018596649169922s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:51:23
---
	---0.0001981258392334s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:51:23
---
	---0.00038290023803711s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:51:46
---
	---0.00057578086853027s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:51:46
---
	---0.00018596649169922s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:51:46
---
	---0.00034689903259277s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:52:18
---
	---0.00049877166748047s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:52:18
---
	---0.00020098686218262s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar/getway
---2017-05-12 19:52:18
---
	---0.00040698051452637s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 11:58:50
	---0.00040006637573242s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 11:58:50
	---0.00038790702819824s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 11:58:50
	---0.00036406517028809s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 11:59:51
	---0.00032401084899902s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 11:59:51
	---0.00032186508178711s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 11:59:51
	---0.00029706954956055s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/1/edit
---2017-05-29 12:00:01
	---0.0006709098815918s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/1/edit
---2017-05-29 12:00:04
	---0.00038909912109375s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:00:45
	---0.00038003921508789s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:00:45
	---0.0004429817199707s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:00:45
	---0.00049805641174316s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:00:48
	---0.00036406517028809s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:00:48
	---0.00034093856811523s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:02:08
	---0.00026798248291016s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:02:08
	---0.00028491020202637s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:02:43
	---0.00042605400085449s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:02:43
	---0.0004730224609375s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:03:54
	---0.00037908554077148s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:03:54
	---0.00030398368835449s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:03:54
	---0.0003199577331543s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:03:54
	---0.00081682205200195s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:04:01
	---0.00032997131347656s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:04:01
	---0.00046896934509277s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:04:08
	---0.00031590461730957s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:04:08
	---0.0005190372467041s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:20
	---0.00067996978759766s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:20
	---0.00051188468933105s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:39
	---0.0002589225769043s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:39
	---0.00052118301391602s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:46
	---0.00028800964355469s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:46
	---0.00026702880859375s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:50
	---0.0003352165222168s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:05:50
	---0.00027894973754883s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:06:26
	---0.0003359317779541s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:06:26
	---0.00036811828613281s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:09:42
	---0.00031709671020508s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:09:42
	---0.00040793418884277s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:09:42
	---0.00023484230041504s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:10:12
	---0.00041985511779785s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:10:12
	---0.00030612945556641s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:10:12
	---0.00028800964355469s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:10:12
	---0.0004270076751709s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:10:12
	---0.00038003921508789s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:10:12
	---0.00040102005004883s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:15
	---0.00031089782714844s		---0ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:15
	---0.00024914741516113s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:16
	---0.00047707557678223s		---0ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:16
	---0.00041484832763672s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:20
	---0.00037193298339844s		---0ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:20
	---0.0004122257232666s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:20
	---0.00054407119750977s		---1ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:10:20
	---0.00040102005004883s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:10:21
	---0.00034999847412109s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:10:21
	---0.00029516220092773s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:10:21
	---0.00036406517028809s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:10:21
	---0.0004119873046875s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00041007995605469s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00027990341186523s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00014686584472656s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.0005650520324707s		---1ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00026106834411621s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00030517578125s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.0002892017364502s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00020813941955566s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00027704238891602s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:24
	---0.00025701522827148s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00030994415283203s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00026297569274902s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00014495849609375s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00023794174194336s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00023794174194336s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.0003359317779541s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00028800964355469s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00018191337585449s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00029516220092773s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:29
	---0.00034499168395996s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:10:31
	---0.00026893615722656s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:10:31
	---0.00021600723266602s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:10:31
	---0.00036406517028809s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:10:31
	---0.00043988227844238s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00025606155395508s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00023007392883301s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.0001220703125s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00019001960754395s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00020003318786621s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00043988227844238s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.0003361701965332s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00026583671569824s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00031399726867676s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:32
	---0.00028705596923828s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-29 12:10:34
	---0.00041699409484863s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-29 12:10:34
	---0.00092911720275879s		---1ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-29 12:10:34
	---0.00028681755065918s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-29 12:10:35
	---0.00026202201843262s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-29 12:10:35
	---0.00034093856811523s		---0ms
	SELECT branchs.* FROM branchs INNER JOIN companies ON companies.id = branchs.company_id WHERE branchs.brand = 'sarshomar' AND companies.brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/sarshomar
---2017-05-29 12:10:35
	---0.00019001960754395s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00052285194396973s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00024199485778809s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.0001530647277832s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00031089782714844s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.0002598762512207s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00039410591125488s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00027918815612793s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00055789947509766s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00045895576477051s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:10:37
	---0.00048708915710449s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00034403800964355s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.0003359317779541s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00017714500427246s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00026702880859375s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00025796890258789s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00037193298339844s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.0003349781036377s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00018811225891113s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00020980834960938s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:09
	---0.00031399726867676s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:13:11
	---0.00027108192443848s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:13:11
	---0.00022602081298828s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:13:11
	---0.00038003921508789s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch/add
---2017-05-29 12:13:11
	---0.00042104721069336s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00033211708068848s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00030112266540527s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00022101402282715s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00035500526428223s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00032591819763184s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00030398368835449s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00024604797363281s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00033283233642578s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00030398368835449s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:13:13
	---0.00029397010803223s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:14:11
	---0.00027298927307129s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:14:11
	---0.00023698806762695s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:14:11
	---0.00014591217041016s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:14:11
	---0.00024294853210449s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:14:11
	---0.00027608871459961s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:14:17
	---0.00026702880859375s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:14:17
	---0.00045585632324219s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:14:17
	---0.00053501129150391s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:14:17
	---0.00054788589477539s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:22
	---0.0004429817199707s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:22
	---0.00030207633972168s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:22
	---0.00030398368835449s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:22
	---0.0003209114074707s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:22
	---0.00053501129150391s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:22
	---0.00051093101501465s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:24
	---0.00033998489379883s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:24
	---0.00077605247497559s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:24
	---0.00055098533630371s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:25
	---0.00029397010803223s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:25
	---0.00037002563476562s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:25
	---0.00023007392883301s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:28
	---0.00025415420532227s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:28
	---0.00024700164794922s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:28
	---0.00045585632324219s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:28
	---0.00052189826965332s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:28
	---0.00026488304138184s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:14:28
	---0.00028514862060547s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:32
	---0.00035905838012695s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:32
	---0.00035691261291504s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:32
	---0.00026917457580566s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:32
	---0.0003049373626709s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:32
	---0.00036287307739258s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:14:32
	---0.00024676322937012s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:46
	---0.00040912628173828s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:46
	---0.00033402442932129s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:46
	---0.00019407272338867s		---0ms
	SELECT * FROM users WHERE users.user_mobile = '989109610612' LIMIT 1 -- users::get_id()

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:46
	---0.00025010108947754s		---0ms
	UPDATE usercompanies SET `postion` = NULL, `code` = NULL, `full_time` = 0 , `remote` = 0 , `is_default` = 0 , `date_enter` = NULL, `date_exit` = NULL WHERE id = 1 LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:48
	---0.00037717819213867s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:48
	---0.00039410591125488s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:16:48
	---0.00050711631774902s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:20:54
	---0.00031208992004395s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.0003209114074707s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.00037789344787598s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.00020408630371094s		---0ms
	SELECT * FROM users WHERE users.user_mobile = '989109610612' LIMIT 1 -- users::get_id()

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.010056018829346s		---10ms
	UPDATE usercompanies SET `postion` = NULL, `code` = NULL, `full_time` = 1 , `remote` = 0 , `is_default` = 0 , `date_enter` = NULL, `date_exit` = NULL WHERE id = 1 LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.00050210952758789s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.00042295455932617s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:52
	---0.00047016143798828s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:55
	---0.00029087066650391s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:55
	---0.00028705596923828s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:55
	---0.00021505355834961s		---0ms
	SELECT * FROM users WHERE users.user_mobile = '989109610612' LIMIT 1 -- users::get_id()

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:55
	---0.0032308101654053s		---3ms
	UPDATE usercompanies SET `postion` = NULL, `code` = NULL, `full_time` = 0 , `remote` = 0 , `is_default` = 0 , `date_enter` = NULL, `date_exit` = NULL WHERE id = 1 LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:56
	---0.00026893615722656s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:56
	---0.00029802322387695s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:56
	---0.00020790100097656s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:57
	---0.00034403800964355s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:57
	---0.0003809928894043s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:21:57
	---0.00033307075500488s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:30:58
	---0.00034689903259277s		---0ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:30:58
	---0.00028896331787109s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:02
	---0.00028610229492188s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:02
	---0.00021004676818848s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:02
	---0.00036883354187012s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:02
	---0.00046706199645996s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:04
	---0.00030112266540527s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:04
	---0.00032901763916016s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:04
	---0.00087690353393555s		---1ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:04
	---0.00029802322387695s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:04
	---0.00029206275939941s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:04
	---0.00029993057250977s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:31:05
	---0.00033688545227051s		---0ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:31:05
	---0.0002598762512207s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:31:05
	---0.00037288665771484s		---0ms
	SELECT COUNT(companies.id) AS `count` FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted'

#---------------------------------------------------------------------- /fa/admin/company
---2017-05-29 12:31:05
	---0.00024700164794922s		---0ms
	SELECT * FROM companies WHERE companies.`boss` = 4 AND companies.`status` <> 'deleted' ORDER BY companies.id DESC LIMIT 0, 15 -- companies::search() -- [null,{"boss":"4","status":["<>","'deleted'"]}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:09
	---0.00030398368835449s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:09
	---0.00052380561828613s		---1ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:09
	---0.00038385391235352s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:09
	---0.00039291381835938s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00039386749267578s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00026917457580566s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00014305114746094s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00016307830810547s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00022482872009277s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00057291984558105s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00031304359436035s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00028204917907715s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00023007392883301s		---0ms
	SELECT COUNT(branchs.id) AS `count` FROM branchs WHERE branchs.`company_id` = 1

#---------------------------------------------------------------------- /fa/admin/ermile/branch
---2017-05-29 12:31:11
	---0.00024604797363281s		---0ms
	SELECT * FROM branchs WHERE branchs.`company_id` = 1 ORDER BY branchs.id DESC LIMIT 0, 15 -- branchs::search() -- [null,{"company_id":"1"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:12
	---0.00034499168395996s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:12
	---0.00040507316589355s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:12
	---0.0003359317779541s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile
---2017-05-29 12:31:12
	---0.00048995018005371s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/add
---2017-05-29 12:31:15
	---0.00031709671020508s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/add
---2017-05-29 12:31:15
	---0.00029683113098145s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/add
---2017-05-29 12:31:15
	---0.00035285949707031s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/add
---2017-05-29 12:31:15
	---0.0002448558807373s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:17
	---0.00032305717468262s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:17
	---0.00025391578674316s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:17
	---0.00029897689819336s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:17
	---0.00032401084899902s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:17
	---0.00032496452331543s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff
---2017-05-29 12:31:17
	---0.00047397613525391s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		WHERE
			 company_id = '1'

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:19
	---0.00059795379638672s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:19
	---0.00029301643371582s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:19
	---0.00020503997802734s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:20
	---0.00032901763916016s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:20
	---0.00039482116699219s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:20
	---0.00033092498779297s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:23
	---0.00058603286743164s		---1ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:23
	---0.00040316581726074s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:23
	---0.00023603439331055s		---0ms
	SELECT * FROM users WHERE users.user_mobile = '989109610612' LIMIT 1 -- users::get_id()

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:23
	---0.0032529830932617s		---3ms
	UPDATE usercompanies SET `postion` = NULL, `code` = NULL, `full_time` = 0 , `remote` = 1 , `is_default` = 0 , `date_enter` = NULL, `date_exit` = NULL WHERE id = 1 LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:25
	---0.00027799606323242s		---0ms
	SELECT COUNT(companies.id) AS 'companiescount' FROM companies WHERE companies.`brand` = 'ermile' AND companies.`boss` = 4 ORDER BY companies.id DESC -- companies::search() -- [null,{"brand":"ermile","boss":"4"}]

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:25
	---0.00032401084899902s		---0ms
	SELECT
			usercompanies.*,
			users.user_mobile AS `mobile`,
			users.user_displayname AS `displayname`,
			users.user_email AS `email`
		FROM
			usercompanies
		INNER JOIN users ON users.id = usercompanies.user_id
		INNER JOIN companies ON companies.id = usercompanies.company_id
		WHERE
			usercompanies.id = 1 AND companies.boss = 4
		LIMIT 1

#---------------------------------------------------------------------- /fa/admin/ermile/staff/1/edit
---2017-05-29 12:31:25
	---0.00043892860412598s		---0ms
	SELECT * FROM companies WHERE brand = 'ermile' LIMIT 1
