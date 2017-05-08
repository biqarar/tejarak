
#---------------------------------------------------------------------- /ganje
---2017-05-08 18:51:10
---
	---0.0010840892791748s		---1ms
	#2017-05-08 18:51:10

	SELECT
		users.id,
		users.user_permission AS `permission`,
		users.user_displayname AS `displayname`,
		users.user_status AS `status`,
		IFNULL(users.user_meta,'Undefined') AS meta,
		(
			SELECT
		hour_end
			FROM
		hours
			WHERE
		hours.user_id = users.id AND
		hours.hour_date = '2017-05-08'
			ORDER BY hours.id DESC
			LIMIT 1) AS `last_exit`,
		hours.hour_start
	FROM
		users
	LEFT JOIN hours
		ON hours.user_id = users.id
		AND hours.hour_date = '2017-05-08'
		AND hours.hour_end is null
	WHERE
		users.user_status IN ('active', 'deactive')
	 ORDER BY users.id 
		
/* ERROR	MYSQL ERROR
Unknown column 'hour_end' in 'field list' */

#---------------------------------------------------------------------- /fa/ganje
---2017-05-08 18:51:21
---
	---0.0010528564453125s		---1ms
	#2017-05-08 18:51:21

	SELECT
		users.id,
		users.user_permission AS `permission`,
		users.user_displayname AS `displayname`,
		users.user_status AS `status`,
		IFNULL(users.user_meta,'تعریف‌نشده') AS meta,
		(
			SELECT
		hour_end
			FROM
		hours
			WHERE
		hours.user_id = users.id AND
		hours.hour_date = '2017-05-08'
			ORDER BY hours.id DESC
			LIMIT 1) AS `last_exit`,
		hours.hour_start
	FROM
		users
	LEFT JOIN hours
		ON hours.user_id = users.id
		AND hours.hour_date = '2017-05-08'
		AND hours.hour_end is null
	WHERE
		users.user_status IN ('active', 'deactive')
	 ORDER BY users.id 
		
/* ERROR	MYSQL ERROR
Unknown column 'hour_end' in 'field list' */

#---------------------------------------------------------------------- /ganje
---2017-05-08 19:07:12
---
	---0.0009620189666748s		---1ms
	#2017-05-08 19:07:12

	SELECT
		users.id,
		users.user_permission AS `permission`,
		users.user_displayname AS `displayname`,
		users.user_status AS `status`,
		IFNULL(users.user_meta,'Undefined') AS meta,
		(
			SELECT
		hour_end
			FROM
		hours
			WHERE
		hours.user_id = users.id AND
		hours.hour_date = '2017-05-08'
			ORDER BY hours.id DESC
			LIMIT 1) AS `last_exit`,
		hours.hour_start
	FROM
		users
	LEFT JOIN hours
		ON hours.user_id = users.id
		AND hours.hour_date = '2017-05-08'
		AND hours.hour_end is null
	WHERE
		users.user_status IN ('active', 'deactive')
	 ORDER BY users.id 
		
/* ERROR	MYSQL ERROR
Unknown column 'hour_end' in 'field list' */

#---------------------------------------------------------------------- /fa/ganje
---2017-05-08 19:07:22
---
	---0.00099897384643555s		---1ms
	#2017-05-08 19:07:22

	SELECT
		users.id,
		users.user_permission AS `permission`,
		users.user_displayname AS `displayname`,
		users.user_status AS `status`,
		IFNULL(users.user_meta,'تعریف‌نشده') AS meta,
		(
			SELECT
		hour_end
			FROM
		hours
			WHERE
		hours.user_id = users.id AND
		hours.hour_date = '2017-05-08'
			ORDER BY hours.id DESC
			LIMIT 1) AS `last_exit`,
		hours.hour_start
	FROM
		users
	LEFT JOIN hours
		ON hours.user_id = users.id
		AND hours.hour_date = '2017-05-08'
		AND hours.hour_end is null
	WHERE
		users.user_status IN ('active', 'deactive')
	 ORDER BY users.id 
		
/* ERROR	MYSQL ERROR
Unknown column 'hour_end' in 'field list' */

#---------------------------------------------------------------------- /fa/ganje
---2017-05-08 19:15:36
---
	---0.0014419555664062s		---1ms
	#2017-05-08 19:15:36

	SELECT
		users.id,
		users.user_permission AS `permission`,
		users.user_displayname AS `displayname`,
		users.user_status AS `status`,
		IFNULL(users.user_meta,'تعریف‌نشده') AS meta,
		(
			SELECT
		hour_end
			FROM
		hours
			WHERE
		hours.user_id = users.id AND
		hours.hour_date = '2017-05-08'
			ORDER BY hours.id DESC
			LIMIT 1) AS `last_exit`,
		hours.hour_start
	FROM
		users
	LEFT JOIN hours
		ON hours.user_id = users.id
		AND hours.hour_date = '2017-05-08'
		AND hours.hour_end is null
	WHERE
		users.user_status IN ('active', 'deactive')
	 ORDER BY users.id 
		
/* ERROR	MYSQL ERROR
Unknown column 'hour_end' in 'field list' */
