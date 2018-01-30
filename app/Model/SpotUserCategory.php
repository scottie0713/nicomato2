<?php

class SpotUserCategory extends AppModel
{
	public $name     = 'SpotUserCategory';
	public $useTable = 'spot_user_categorys';

	/**
	 * ユーザＩＤから取得
	 * @param unknown $user_id
	 */
	public function getByUserId($spot_user_id)
	{
		$params = array(
			'conditions' => array(
				'spot_user_id' => $spot_user_id,
			),
		);
		return $this->find('all', $params);
	}

	/**
	 * 追加
	 */
	public function insert($spot_user_id, $name)
	{
		$sql = "INSERT INTO spot_user_categorys(spot_user_id, name) VALUES ({$spot_user_id}, :name);";
		$params = array(
			'name' => $name,
		);

		return $this->query($sql,$params);

	}//function


	/**
	 * 更新
	 */
	public function update($id, $name){
		$sql = "UPDATE spot_user_categorys SET name = :name WHERE id = {$id}";
		$params = array(
				'name' => $name,
		);

		return $this->query($sql,$params);

	}//function

}
