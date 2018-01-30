<?php

class SpotUserMovie extends AppModel
{
	public $name     = 'SpotUserMovie';
	public $useTable = 'spot_user_movies';

	/**
	 * 件数取得
	 * @param unknown $user_id
	 * @param string $check_flag
	 * @param string $delete_flag
	 */
	public function getCount($spot_user_id)
	{

		$params = array(
			'conditions' => array(
				'spot_user_id' => $spot_user_id,
				'delete_flg'  => 0,
			),
		);
		return $this->find('count', $params);
	}


	/**
	 * ユーザＩＤから取得
	 * @param unknown $user_id
	 */
	public function getByUserId($spot_user_id)
	{

		$params = array(
			'conditions' => array(
				'spot_user_id' => $spot_user_id,
				'delete_flg'  => 0,
			),
		);
		return $this->find('all', $params);
	}

	/**
	 * movie_categoryから取得
	 * @param unknown $user_id
	 */
	public function getByMovieCategory($movie_category)
	{

		$params = array(
			'conditions' => array(
				'movie_category' => $movie_category,
				'delete_flg'    => 0,
			),
		);
		return $this->find('all', $params);
	}

	/**
	 * ユーザＩＤから取得
	 * @param unknown $user_id
	 */
	public function get($spot_user_id, $spot_category_id = null)
	{
		if($spot_category_id <= 0)
		{
			$spot_category_id = null;
		}

		$params = array(
			'conditions' => array(
				'spot_user_id'     => $spot_user_id,
				'spot_category_id' => $spot_category_id,
				'delete_flg'       => 0,
			),
		);
		return $this->find('all', $params);
	}



	/**
	 * 追加
	 */
	public function insert(
		$spot_user_id, $spot_category_id, $data_type,
		$movie_str,    $movie_title,      $movie_category,
		$user_comment, $spot_sec,         $delete_flg)
	{
		$sql = "INSERT INTO spot_user_movies(spot_user_id,spot_category_id,data_type,movie_str,movie_title,movie_category,user_comment,spot_sec,delete_flg) VALUES(
					{$spot_user_id},
   					:spot_category_id,
					{$data_type},
					:movie_str,
   					:movie_title,
   					:movie_category,
   					:user_comment,
   					{$spot_sec},
   					{$delete_flg})";
		$params = array(
				'spot_category_id' => $spot_category_id,
				'movie_str'        => $movie_str,
				'movie_title'      => $movie_title,
				'movie_category'   => $movie_category,
				'user_comment'     => $user_comment,
		);

		return $this->query($sql,$params);

	}//function


	/**
	 * 更新
	 * @param unknown $user_id
	 * @param unknown $data_mylist_id
	 * @param unknown $delete_flag
	 */
	public function update($spot_movie_id, $spot_category_id, $movie_str, $movie_title, $movie_category, $user_comment, $spot_sec, $delete_flg){
		$sql = "
 UPDATE spot_user_movies
 SET
   spot_category_id = :spot_category_id,
   movie_str        = :movie_str,
   movie_title      = :movie_title,
   movie_category   = :movie_category,
   user_comment     = :user_comment,
   spot_sec         = {$spot_sec},
   delete_flg      = {$delete_flg}
 WHERE id = {$spot_movie_id}";
		$params = array(
				'spot_category_id' => $spot_category_id,
				'movie_str'        => $movie_str,
				'movie_title'      => $movie_title,
				'movie_category'   => $movie_category,
				'user_comment'     => $user_comment,
		);

		return $this->query($sql,$params);

	}//function


	/**
	 * 汎用更新
	 * @param unknown $column
	 * @param unknown $value
	 * @param unknown $user_id
	 */
	public function updateColumn($user_id, $column, $value)
	{
		$sql = "
 UPDATE spot_user_movies
 SET :column = :value
 WHERE user_id = :user_id";
		$params = array(
				'column'  => $column,
				'value'   => $value,
				'user_id' => $user_id,
		);

		return $this->query($sql,$params);

	}//function


	/**
	 *	公式から動画情報取得
	 *
	 */
	public function getMovieDataByApi($mylist_str)
	{
		$strXml = $this->getRss("http://ext.nicovideo.jp/api/getthumbinfo/{$mylist_str}");
		if (preg_match('/ページが見つかりません/', $strXml)){
			return array(
				'title'  => 'ページが見つかりません',
				'author' => '',
				'last_movie_data' => json_encode(array()),
				'before_movie_data' => json_encode(array()),
				'last_published_at' => '2000-01-01 00:00:00',
			);
		}else if(preg_match('/このマイリストは非公開に設定されています/', $strXml)){
			return array(
				'title'  => '非公開マイリスト',
				'author' => '',
				'last_movie_data' => json_encode(array()),
				'before_movie_data' => json_encode(array()),
				'last_published_at' => '2001-01-01 00:00:00',
			);
		}
		if ( !preg_match("/^<\?xml.+/", $strXml) ){
			return false;
		}
		$xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);

		// ---- 動画名
		$title  = $xml->thumb->title;
		return array(
			'title'  => $title,
		);

	}//function



	private function getRss($url) {
		// Curlで取得開始
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		return curl_exec($ch);
	}


}
