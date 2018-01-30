<?php

class UserSpot extends AppModel
{
	public $name     = 'UserSpot';
	public $useTable = 'user_spots';

	/**
	 * 件数取得
	 * @param integer $user_id
	 */
	public function getCount($user_id) {

		$params = array(
			'conditions' => array(
				'user_id' => $user_id
			),
		);

		return $this->find('count', $params);
	}


	/**
	 * ユーザＩＤから取得
	 * @param unknown $user_id
	 */
	public function getByUserId($user_id)
	{
		$params = array(
			'conditions' => array(
				'user_id'    => $user_id,
				'delete_flg' => 0,
			),
		);
		return $this->find('all', $params);
	}



	/**
	 * delete_flag更新
	 * @param unknown $user_spot_id
	 * @param unknown $delete_flag
	 */
	public function updateDeleteFlag($user_spot_id, $delete_flag)
	{
		$sql    = " UPDATE user_spots SET delete_flag = {$delete_flag} WHERE id = {$user_spot_id}";
		$params = array();

		return $this->query($sql,$params);

	}//function

}
