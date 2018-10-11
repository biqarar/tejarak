<?php
namespace content_a;

class controller
{

	public static function routing()
	{
		if(!\dash\user::login())
		{
			\dash\redirect::to(\dash\url::kingdom(). '/enter');
			return;
		}

		if(\dash\url::module() === null)
		{

		}
		else
		{

			if(self::reservedNames(\dash\url::module()))
			{
				return;
			}

			$team_id = \dash\request::get('id');
			$team_id = \dash\coding::decode($team_id);

			if(!$team_id)
			{
				\dash\header::status(404, T_("Id not set"));
			}

			\lib\app\team::rule($team_id);

			self::have_permission(\dash\url::module());
		}

	}




	/**
	 * check reserved names
	 * @return [type] [description]
	 */
	public static function reservedNames($_name)
	{
		$result = null;
		switch ($_name)
		{
			case null:
			case 'team':
			case 'card':
			case 'ref':
			case 'billing':
			case 'profile':
			case 'notifications':
				$result = true;
				break;

			default:
				$result = false;
				break;
		}
		return $result;
	}


	/**
	 * check permission
	 *
	 * @param      <type>  $_controller  The controller
	 */
	public static function have_permission($_controller)
	{
		switch ($_controller)
		{
			case 'setting':
				if(\dash\url::child() === 'plan')
				{
					if(!\dash\temp::get('isCreator'))
					{
						\dash\header::status(403, T_("Can not access to load this page"));
					}
				}
				else
				{
					if(!\dash\temp::get('isAdmin'))
					{
						\dash\header::status(403, T_("Can not access to load this page"));
					}
				}
				return true;
				break;

			case 'report':
			case 'request':
				return true;
				break;

			case 'setting':
			case 'member':
			default:
				if(!\dash\temp::get('isAdmin'))
				{
					\dash\redirect::to(\dash\url::here(). '/report/last?id='. \dash\request::get('id'));
				}
				break;
		}

	}
}
?>