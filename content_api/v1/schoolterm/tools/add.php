<?php
namespace content_api\v1\schoolterm\tools;
use \lib\utility;
use \lib\debug;
use \lib\db\logs;

trait add
{

	use check_args;

	/**
	 * Adds a schoolterm.
	 *
	 * @param      array    $_args  The arguments
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	public function add_schoolterm($_args = [])
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
		// merge default args and args
		$_args = array_merge($default_args, $_args);

		// set default title of debug
		debug::title(T_("Operation Faild"));

		// delete schoolterm mode
		$delete_mode = false;

		// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => utility::request(),
			]
		];

		// check user id is exist
		if(!$this->user_id)
		{
			logs::set('api:schoolterm:user_id:notfound', $this->user_id, $log_meta);
			debug::error(T_("User not found"), 'user', 'permission');
			return false;
		}

		// get school and check it
		$school = utility::request('school');
		$school = utility\shortURL::decode($school);
		if(!$school)
		{
			logs::set('api:schoolterm:school:not:set', $this->user_id, $log_meta);
			debug::error(T_("School not set"), 'user', 'permission');
			return false;
		}
		// load school data
		$school_detail = \lib\db\teams::access_team_id($school, $this->user_id, ['action' => 'add_school_schoolterm']);
		// check the school exist
		if(isset($school_detail['id']))
		{
			$school_id = $school_detail['id'];
		}
		else
		{
			logs::set('api:schoolterm:school:notfound:invalid', $this->user_id, $log_meta);
			debug::error(T_("school not found"), 'user', 'permission');
			return false;
		}


		// ready to insert userschool or userbranch record
		$args              = [];
		$args['school_id'] = $school_id;

		$check_args = $this->schoolterm_check_args($_args, $args, $log_meta);

		if(!debug::$status || $check_args === false)
		{
			return false;
		}


		if($_args['method'] === 'post')
		{
			\lib\db\school_terms::insert($args);
		}
		elseif($_args['method'] === 'patch')
		{
			$id = utility::request('id');
			$id = utility\shortURL::decode($id);
			if(!$id)
			{
				logs::set('api:schoolterm:pathc:id:not:set', $this->user_id, $log_meta);
				debug::error(T_("Id not set"), 'id', 'arguments');
				return false;
			}

			$check_user_in_school = \lib\db\school_terms::get(['id' => $id, 'school_id' => $school_id, 'limit' => 1]);

			if(!$check_user_in_school || !isset($check_user_in_school['id']))
			{
				logs::set('api:schoolterm:user:not:in:school', $this->user_id, $log_meta);
				debug::error(T_("This user is not in this school"), 'id', 'arguments');
				return false;
			}

			unset($args['school_id']);

			if(!utility::isset_request('title')) unset($args['title']);
			if(!utility::isset_request('desc'))  unset($args['desc']);
			if(!utility::isset_request('start')) unset($args['start']);
			if(!utility::isset_request('end'))   unset($args['end']);
			if(!utility::isset_request('status'))unset($args['status']);

			if(!empty($args))
			{
				\lib\db\school_terms::update($args, $check_user_in_school['id']);
			}


		}
		elseif ($_args['method'] === 'delete')
		{
			// \lib\db\school_terms::remove($args);
		}

		if(debug::$status)
		{
			debug::title(T_("Operation Complete"));

			if($_args['method'] === 'post')
			{
				debug::true(T_("schoolterm successfully added"));
			}
			elseif($_args['method'] === 'patch')
			{
				debug::true(T_("schoolterm successfully updated"));
			}
			else
			{
				debug::true(T_("schoolterm successfully removed"));
			}
		}

	}
}
?>