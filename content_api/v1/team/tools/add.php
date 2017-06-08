<?php
namespace content_api\v1\team\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{


	public function add_team($_args = [])
	{
		$edit_mode = false;
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		debug::title(T_("Operation Faild"));
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		if(!$this->user_id)
		{
			logs::set('api:team:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		$title = utility::request('title');

		if(mb_strlen($title) > 500)
		{
			logs::set('api:team:maxlength:title', $this->user_id, $log_meta);
			debug::error(T_("Team title must be less than 500 character"), 'title', 'arguments');
			return false;
		}

		$site = utility::request('site');
		if($site && mb_strlen($site) > 1000)
		{
			logs::set('api:team:maxlength:site', $this->user_id, $log_meta);
			debug::error(T_("Team site must be less than 1000 character"), 'site', 'arguments');
			return false;
		}

		$brand = utility::request('brand');

		if(!$brand && !$title)
		{
			logs::set('api:team:brand:not:sert', $this->user_id, $log_meta);
			debug::error(T_("Brand of team can not be null"), 'brand', 'arguments');
			return false;
		}

		// get slug of title in brand if the brand is not set
		if(!$brand && $title)
		{
			$brand = \lib\utility\filter::slug($title);
		}

		if(mb_strlen($brand) < 5)
		{
			logs::set('api:team:minlength:brand', $this->user_id, $log_meta);
			debug::error(T_("Team brand must be larger than 5 character"), 'brand', 'arguments');
			return false;
		}

		if(!preg_match("/^[A-Za-z0-9]+$/", $brand))
		{
			logs::set('api:team:invalid:brand', $this->user_id, $log_meta);
			debug::error(T_("Only [A-Za-z0-9] can use in team brand"), 'brand', 'arguments');
			return false;
		}

		$register_code = utility::request('register_code');
		if($register_code && !is_numeric($register_code))
		{
			logs::set('api:team:invalid:register_code', $this->user_id, $log_meta);
			debug::error(T_("Only numeric value can set in Register code"), 'register_code', 'arguments');
			return false;
		}

		$economical_code = utility::request('economical_code');
		if($economical_code && !is_numeric($economical_code))
		{
			logs::set('api:team:invalid:economical_code', $this->user_id, $log_meta);
			debug::error(T_("Only numeric value can set in Economical code"), 'economical_code', 'arguments');
			return false;
		}

		$id = null;
		if($_args['method'] === 'patch')
		{
			$temp_team = \lib\db\teams::get_brand(utility::request('team'));
			if(isset($temp_team['id']))
			{
				$id = $temp_team['id'];
			}
		}

		$check_duplicate_title = ['brand' => $brand];

		$check = \lib\db\teams::search(null, $check_duplicate_title);

		if($check || in_array($brand, \content\home\controller::$static_pages))
		{
			$change_name = true;
			if($_args['method'] === 'post')
			{
				// the name of this team must be changed
			}
			else
			{
				if(isset($check[0]['id']) && intval($check[0]['id']) === intval($id))
				{
					// the user id edit team name and needless to change name of team
					$change_name = false;
				}
				else
				{
					// the name of this team must be changed
				}
			}
			// replase name of team to team1
			if($change_name)
			{

				$get_similar_brand['brand']     = ['LIKE', "'$brand%'"];
				$get_similar_brand['get_count'] = true;
				$count = \lib\db\teams::search(null, $get_similar_brand);

				while ($change_name)
				{
					if(!\lib\db\teams::get(['brand' => $brand, 'limit' => 1]))
					{
						$change_name = false;
						break;
					}
					$brand = $brand . ++$count;
				}
			}
		}
		// check brand
		if(mb_strlen($brand) > 100)
		{
			logs::set('api:team:maxlength:brand', $this->user_id, $log_meta);
			debug::error(T_("Team brand must be less than 500 character"), 'brand', 'arguments');
			return false;
		}

		$args                    = [];
		$args['creator']         = $this->user_id;
		$args['boss']            = $this->user_id;
		$args['technical']       = $this->user_id;
		$args['title']           = $title;
		$args['brand']           = $brand;
		$args['site']            = $site;
		$args['register_code']   = $register_code;
		$args['economical_code'] = $economical_code;

		\lib\storage::set_last_team_added($brand);

		if($_args['method'] === 'post')
		{
			if($id)
			{
				logs::set('api:team:method:post:set:id', $this->user_id, $log_meta);
				debug::error(T_("Can not set id in adding team"), 'id', 'access');
				return false;
			}

			$team_id = \lib\db\teams::insert($args);

			$branch               = [];
			$branch['team_id'] = $team_id;
			$branch['brand']      = 'centeral';
			$branch['title']      = 'centeral';
			$branch['site']       = $site;
			$branch['creator']    = $this->user_id;
			$branch['boss']       = $this->user_id;
			$branch['technical']  = $this->user_id;
			$branch['is_default'] = 1;

			\lib\db\branchs::insert($branch);
		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;

			if(!$id || !is_numeric($id))
			{
				logs::set('api:team:method:put:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id of team not found"), 'id', 'permission');
				return false;
			}

			$check_is_my_team = $this->get_team();
			if($check_is_my_team)
			{
				$update = [];
				foreach ($args as $key => $value)
				{
					if(utility::isset_request($key))
					{
						$update[$key] = $value;
					}
				}
				if(!empty($update))
				{
					\lib\db\teams::update($update, $id);
				}
			}
		}
		else
		{
			logs::set('api:team:method:invalid', $this->user_id, $log_meta);
			debug::error(T_("Invalid method of api"), 'method', 'permission');
			return false;
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($edit_mode)
			{
				debug::true("team successfuly edited");
			}
			else
			{
				debug::true("team successfuly added");
			}
		}
	}
}
?>