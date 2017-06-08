<?php
namespace content_api\v1\branch\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;
trait add
{


	/**
	 * Adds a branch.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_branch($_args = [])
	{
		// default args
		$default_args =
		[
			'method' => 'post'
		];

		if(!is_array($_args))
		{
			$_args = [];
		}

		$_args = array_merge($default_args, $_args);

		// set default title of debug
		debug::title(T_("Operation Faild"));

		// defult edit mode is false
		$edit_mode = false;
		// set log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		// check user id
		if(!$this->user_id)
		{
			logs::set('api:branch:user_id:notfound', null, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get team name
		$team = utility::request('team');
		if(!$team)
		{
			logs::set('api:branch:team:notfound', null, $log_meta);
			debug::error(T_("Team not found"), 'user', 'permission');
			return false;
		}
		// check permission to load this team for this user
		$access_load = $this->get_team();

		// the user can not access to load this team
		if(!debug::$status || !isset($access_load['id']))
		{
			return;
		}
		// get the team id
		$team_id = $access_load['id'];

		// get title of branch
		$title = utility::request('title');
		// check branch title
		if($title && mb_strlen($title) > 500)
		{
			logs::set('api:branch:maxlength:title', $this->user_id, $log_meta);
			debug::error(T_("Branch title must be less than 500 character"), 'title', 'arguments');
			return false;
		}

		// get the branch site
		$site = utility::request('site');
		// check site string
		if($site && mb_strlen($site) > 1000)
		{
			logs::set('api:branch:maxlength:site', $this->user_id, $log_meta);
			debug::error(T_("Branch site must be less than 1000 character"), 'site', 'arguments');
			return false;
		}
		// get the brand of branch
		$brand = utility::request('brand');

		// replace brand whit slog of title
		if(!$brand && $title)
		{
			$brand = \lib\utility\filter::slug($title);
		}
		// check brand or title is set
		if(!$brand && !$title)
		{
			logs::set('api:branch:brand:not:sert', $this->user_id, $log_meta);
			debug::error(T_("Brand of branch can not be null"), 'brand', 'arguments');
			return false;
		}
		// check reqular of brand
		if(!preg_match("/^[A-Za-z0-9]+$/", $brand))
		{
			logs::set('api:branch:invalid:brand', $this->user_id, $log_meta);
			debug::error(T_("Only [A-Za-z0-9] can use in branch brand"), 'brand', 'arguments');
			return false;
		}
		// if the brand was set and title not set
		// set the title = brand
		if($brand && !$title)
		{
			$title = $brand;
		}
		// get code
		$code = utility::request('code');
		// check code
		if($code &&  (mb_strlen($code) > 9 || !is_numeric($code)))
		{
			logs::set('api:branch:maxlength:code', $this->user_id, $log_meta);
			debug::error(T_("Branch code must be less than 9 character and must be number"), 'code', 'arguments');
			return false;
		}
		// get and check phone(s)
		$phone_1     = utility::request('phone_1');
		if($phone_1 &&  mb_strlen($phone_1) > 50)
		{
			logs::set('api:branch:maxlength:phone_1', $this->user_id, $log_meta);
			debug::error(T_("Branch phone_1 must be less than 50 character"), 'phone_1', 'arguments');
			return false;
		}

		$phone_2     = utility::request('phone_2');
		if($phone_2 &&  mb_strlen($phone_2) > 50)
		{
			logs::set('api:branch:maxlength:phone_2', $this->user_id, $log_meta);
			debug::error(T_("Branch phone_2 must be less than 50 character"), 'phone_2', 'arguments');
			return false;
		}

		$phone_3     = utility::request('phone_3');
		if($phone_3 &&  mb_strlen($phone_3) > 50)
		{
			logs::set('api:branch:maxlength:phone_3', $this->user_id, $log_meta);
			debug::error(T_("Branch phone_3 must be less than 50 character"), 'phone_3', 'arguments');
			return false;
		}

		$fax     = utility::request('fax');
		if($fax &&  mb_strlen($fax) > 50)
		{
			logs::set('api:branch:maxlength:fax', $this->user_id, $log_meta);
			debug::error(T_("Branch fax must be less than 50 character"), 'fax', 'arguments');
			return false;
		}

		$email     = utility::request('email');
		if($email &&  mb_strlen($email) > 50)
		{
			logs::set('api:branch:maxlength:email', $this->user_id, $log_meta);
			debug::error(T_("Branch email must be less than 50 character"), 'email', 'arguments');
			return false;
		}

		$post_code     = utility::request('post_code');
		if($post_code &&  mb_strlen($post_code) > 50)
		{
			logs::set('api:branch:maxlength:post_code', $this->user_id, $log_meta);
			debug::error(T_("Branch post_code must be less than 50 character"), 'post_code', 'arguments');
			return false;
		}

		// get full time, remote and default branch
		$full_time  = utility::request('full_time') 	? 1 : 0;
		$remote     = utility::request('remote') 		? 1 : 0;
		$is_default = utility::request('is_default') 	? 1 : 0;

		// get the address
		$address     = utility::request('address');
		if($address &&  mb_strlen($address) > 5000)
		{
			logs::set('api:branch:maxlength:address', $this->user_id, $log_meta);
			debug::error(T_("Branch address must be less than 5000 character"), 'address', 'arguments');
			return false;
		}

		$check_duplicate_brand_in_team = ['brand' => $brand, 'team_id' => $team_id, 'get_count' => true];
		$count = \lib\db\branchs::search(null, $check_duplicate_brand_in_team);

		// check duplicate branch brand and change branch brand
		if($count || in_array($brand, \content\home\controller::$static_pages))
		{
			$change_name = true;
			while ($change_name)
			{
				if(!\lib\db\branchs::get(['brand' => $brand, 'team_id' => $team_id, 'limit' => 1]))
				{
					$change_name = false;
					break;
				}
				$brand = $brand . ++$count;
				$args['brand'] = $brand;
			}
		}
		// check brand
		if($brand && mb_strlen($brand) > 100)
		{
			logs::set('api:branch:maxlength:brand', $this->user_id, $log_meta);
			debug::error(T_("Branch brand must be less than 500 character"), 'brand', 'arguments');
			return false;
		}

		// ready to insert branch record
		$args               = [];
		$args['creator']    = $this->user_id;
		$args['boss']       = $this->user_id;
		$args['team_id']    = $team_id;
		$args['technical']  = $this->user_id;
		$args['title']      = $title;
		$args['site']       = $site;
		$args['brand']      = $brand;
		$args['address']    = $address;
		$args['code']       = $code;
		$args['phone_1']    = $phone_1;
		$args['phone_2']    = $phone_2;
		$args['phone_3']    = $phone_3;
		$args['fax']        = $fax;
		$args['email']      = $email;
		$args['post_code']  = $post_code;
		$args['full_time']  = $full_time;
		$args['remote']     = $remote;
		$args['is_default'] = $is_default;

		// insert new branch
		if($_args['method'] === 'post')
		{
			// insert new branch
			\lib\db\branchs::insert($args);
		}
		elseif ($_args['method'] === 'patch')
		{
			$edit_mode = true;
			$branch = utility::request("branch");

			if(!$branch)
			{
				logs::set('api:branch:method:put:branch:not:set', $this->user_id, $log_meta);
				debug::error(T_("Branch not set"), 'branch', 'permission');
				return false;
			}

			$find_branch_id = \lib\db\branchs::search(null, ['team_id' => $team_id, 'brand' => $branch]);
			if(isset($find_branch_id[0]['id']))
			{
				$id = $find_branch_id[0]['id'];
			}
			else
			{
				logs::set('api:branch:method:put:branch:not:found', $this->user_id, $log_meta);
				debug::error(T_("Branch not found"), 'branch', 'permission');
				return false;
			}

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
				\lib\db\branchs::update($update, $check[0]['id']);
			}
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));
			if($edit_mode)
			{
				debug::true("Branch edited");
			}
			else
			{
				debug::true("Branch added");
			}
		}
	}
}
?>