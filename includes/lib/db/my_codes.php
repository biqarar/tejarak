<?php
namespace lib\db;

/** codes managing **/
class my_codes extends \lib\db\codes
{

	public static function set($_args)
	{
		if(isset($_args['code']))
		{
			$get_term =
			[
				'type'  => 'code',
				'slug'  => "$_args[code]",
				'limit' => 1,
			];
			$term_detail = \dash\db\terms::get($get_term);

			if(isset($term_detail['id']))
			{
				$term_id = $term_detail['id'];
				if(isset($_args['related']) && $_args['related'] === 'userteams' && isset($_args['id']))
				{
					$userteam_id = $_args['id'];
					$query =
					"
						SELECT
							COUNT(*) AS `count`
						FROM
							termusages
						WHERE
							termusages.term_id = $term_id AND
							termusages.related = 'userteams' AND
							termusages.status  = 'enable' AND
 							termusages.related_id IN
							(
								SELECT
									userteams.id
								FROM
									userteams
								WHERE
									userteams.id <> $userteam_id AND
									userteams.team_id =
									(
										SELECT
											userteams.team_id
										FROM
											userteams
										WHERE
											userteams.id = $userteam_id
										LIMIT 1
									)
							)
					";
					$check_duplicate_code = \dash\db::get($query, 'count', true);

					if($check_duplicate_code)
					{
						\lib\notif::error(T_("Duplicate code in team"));
						return false;
					}
				}
			}
		}
		parent::set($_args);
	}
}
?>