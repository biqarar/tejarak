<?php
namespace content_api\v1\member\tools;


trait get_barcodes
{
	public function get_barcodes(&$_data)
	{
		$multi = false;
		if(array_key_exists(0, $_data))
		{
			$multi = true;
		}

		$userteam_ids = [];

		if(!$multi)
		{
			if(isset($_data['id']))
			{
				$userteam_ids = [$_data['id']];
			}
		}
		else
		{
			$userteam_ids = array_column($_data, 'id');
		}

		$userteam_ids_decode = array_map(function($_a){return \lib\coding::decode($_a);}, $userteam_ids);

		$get_multi_codes =
		[
			'ids'     => $userteam_ids_decode,
			'related' => 'userteams',
			'status'  => 'enable',
		];

		$get_multi_codes = \lib\db\my_codes::get_multi_codes($get_multi_codes);

		$codes = [];
		if(is_array($get_multi_codes))
		{
			foreach ($get_multi_codes as $key => $value)
			{
				if(isset($value['related_id']) && isset($value['termusage_type']) && isset($value['slug']))
				{
					$related_encode = \lib\coding::encode($value['related_id']);
					$codes[$related_encode][$value['termusage_type']] = $value['slug'];
				}
			}
		}

		if(!empty($codes))
		{
			if($multi)
			{
				foreach ($_data as $key => $value)
				{
					if(isset($value['id']))
					{
						if(array_key_exists($value['id'], $codes))
						{
							$_data[$key]['codes'] = $codes[$value['id']];
						}
					}
				}
			}
			else
			{
				if(isset($_data['id']) && isset($codes[$_data['id']]))
				{
					$_data['codes'] = $codes[$_data['id']];
				}
			}
		}
	}




	/**
	 * check barcode, qrcode and rfid,
	 * update it if changed
	 * get from \lib\utility::request()
	 * check from $args
	 *
	 * @param      array  $_args  The arguments
	 */
	public function check_barcode($_id)
	{
			// set the log meta
		$log_meta =
		[
			'data' => null,
			'meta' =>
			[
				'input' => \lib\utility::request(),
			]
		];

		$barcode1 = \lib\utility::request("barcode1");
		if($barcode1 && mb_strlen($barcode1) > 100)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:barcode:max:limit:barcode1', $this->user_id, $log_meta);
			if($_args['debug']) \lib\notif::error(T_("You must set barcode less than 100 character"), 'barcode', 'arguments');
			return false;
		}

		if($barcode1 && mb_strlen($barcode1) < 3)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:barcode:min:limit:barcode1', $this->user_id, $log_meta);
			if($_args['debug']) \lib\notif::error(T_("You must set barcode larger than 3 character"), 'barcode', 'arguments');
			return false;
		}

		$qrcode1 = \lib\utility::request("qrcode1");
		if($qrcode1 && mb_strlen($qrcode1) > 100)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:qrcode:max:limit:qrcode1', $this->user_id, $log_meta);
			if($_args['debug']) \lib\notif::error(T_("You must set qrcode less than 100 character"), 'qrcode', 'arguments');
			return false;
		}

		if($qrcode1 && mb_strlen($qrcode1) < 3)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:qrcode:min:limit:qrcode1', $this->user_id, $log_meta);
			if($_args['debug']) \lib\notif::error(T_("You must set qrcode larger than 3 character"), 'qrcode', 'arguments');
			return false;
		}

		$rfid1 = \lib\utility::request("rfid1");
		if($rfid1 && mb_strlen($rfid1) > 100)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:rfid:max:limit:rfid1', $this->user_id, $log_meta);
			if($_args['debug']) \lib\notif::error(T_("You must set rfid less than 100 character"), 'rfid', 'arguments');
			return false;
		}

		if($rfid1 && mb_strlen($rfid1) < 3)
		{
			if($_args['save_log']) \dash\db\logs::set('api:member:rfid:min:limit:rfid1', $this->user_id, $log_meta);
			if($_args['debug']) \lib\notif::error(T_("You must set rfid larger than 3 character"), 'rfid', 'arguments');
			return false;
		}

		if(\lib\utility::isset_request('barcode1'))
		{
			$this->check_barcode_update($barcode1, $_id, 'barcode1');
		}

		if(\lib\utility::isset_request('qrcode1'))
		{
			$this->check_barcode_update($qrcode1, $_id, 'qrcode1');
		}

		if(\lib\utility::isset_request('rfid1'))
		{
			$this->check_barcode_update($rfid1, $_id, 'rfid1');
		}

	}


	/**
	 * check barcode exist and
	 * if not exist insert
	 * if exist update
	 * if no change return
	 *
	 * @param      <type>  $_barcode      The barcode
	 * @param      <type>  $_get_barcode  The get barcode
	 */
	public function check_barcode_update($_barcode, $_id, $_title)
	{
		$get_code =
		[
			'type'    => $_title,
			'id'      => $_id,
			'related' => 'userteams',
		];

		$check_exist_code = \lib\db\my_codes::get($get_code);

		if($_barcode)
		{
			// the code is not exist
			$set =
			[
				'code'    => $_barcode,
				'type'    => $_title,
				'related' => 'userteams',
				'id'      => $_id,
				'creator' => $this->user_id,
			];
			\lib\db\my_codes::set($set);
		}
		else
		{
			if($check_exist_code)
			{
				\lib\db\my_codes::remove($get_code);
			}
		}
	}
}
?>