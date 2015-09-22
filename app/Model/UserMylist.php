<?php

class UserMylist extends AppModel
{
	public $name = 'UserMylist';
	public $useTable = 'user_mylists';

	/**
	 *
	 */
	public function getWithData($user_id){

		$sql = "
 SELECT
  u.id as user_mylist_id,
  d.id as data_mylist_id,
  d.data_type as data_type,
  d.mylist_str as mylist_str,
  d.title as title,
  d.author as author,
  d.last_movie_data as last_movie_data,
  d.last_checked_at as last_checked_at,
  u.check_flag as check_flag,
  u.delete_flag as delete_flag
 FROM user_mylists u
 LEFT JOIN data_mylists d ON d.id = u.data_mylist_id
 WHERE u.user_id = :user_id
 AND u.delete_flag = :delete_flag
 GROUP BY d.mylist_str;
 ";
		$params = array(
			'user_id'    => $user_id,
			'delete_flag'=> 0,
		);

		return $this->query($sql,$params);

	}//function


	/**
	 * data_mylist_idから取得
	 * @param unknown $id
	 */
	public function getAllByDataMylistId($id) {
		$user_mylist = $this->find('all', array(
				'conditions' => array( 'id' => $id ),
		));
		return $user_mylist;
	}

	/**
	 * 件数取得
	 * @param unknown $user_id
	 * @param string $check_flag
	 * @param string $delete_flag
	 */
	public function getCount($user_id, $check_flag=null, $delete_flag=null) {

		$params = array(
			'conditions' => array(
				'user_id' => $user_id
			),
			'group' => 'data_mylist_id',
		);
		if ( !is_null($check_flag) ) {
			$params['conditions']['check_flag'] = $check_flag;
		}
		if ( !is_null($delete_flag) ) {
			$params['conditions']['delete_flag'] = $delete_flag;
		}
		return $this->find('count', $params);
	}


	/**
	 * ユーザＩＤから取得
	 * @param unknown $user_id
	 */
	public function get($user_id) {

		$params = array(
			'fields' => 'data_mylist_id',
			'conditions' => array(
				'user_id'     => $user_id,
				'delete_flag' => 0,
			),
		);

		$user_mylist = $this->find('all', $params);
		$res = array();
		foreach($user_mylist as $mylist){
			$res[] = $mylist['UserMylist']['data_mylist_id'];
		}

		return $res;
	}



	/**
	 * delete_flag更新
	 * @param unknown $user_id
	 * @param unknown $data_mylist_id
	 * @param unknown $delete_flag
	 */
	public function updateDeleteFlag($user_id, $data_mylist_id, $delete_flag){
		$sql = "
 UPDATE user_mylists
 SET delete_flag = :delete_flag
 WHERE user_id = :user_id
 AND data_mylist_id = :data_mylist_id";
		$params = array(
				'delete_flag'    => $delete_flag,
				'user_id'        => $user_id,
				'data_mylist_id' => $data_mylist_id,
		);

		return $this->query($sql,$params);

	}//function
}
