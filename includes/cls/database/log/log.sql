
#---------------------------------------------------------------------- /favicon.ico
---2017-05-08 19:11:21
---
	---0.00031304359436035s		---0ms
	SELECT * FROM posts WHERE ( posts.post_language IS NULL OR posts.post_language = 'en' ) AND posts.post_url = 'favicon.ico' LIMIT 1

#---------------------------------------------------------------------- /fa/ganje
---2017-05-08 19:15:36
---
	---0.0014419555664062s		---1ms
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

#---------------------------------------------------------------------- /fa/ap
---2017-05-08 19:15:39
---
	---0.00022506713867188s		---0ms
	SELECT * FROM posts WHERE ( posts.post_language IS NULL OR posts.post_language = 'fa' ) AND posts.post_url = 'ap' LIMIT 1

#---------------------------------------------------------------------- /fa/ai
---2017-05-08 19:15:41
---
	---0.00033998489379883s		---0ms
	SELECT * FROM posts WHERE ( posts.post_language IS NULL OR posts.post_language = 'fa' ) AND posts.post_url = 'ai' LIMIT 1
