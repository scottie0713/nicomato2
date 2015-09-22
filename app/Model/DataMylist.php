<?php

class DataMylist extends AppModel
{
    public $name = 'DataMylist';
    public $useTable = 'data_mylists';

	/**
	 *	更新チェック
	 *  @param array mylist_strs
	 */
	public function check($ids) {
		$id_str = implode(",", $ids);
		$sql = "SELECT * FROM {$this->useTable} WHERE id IN({$id_str}) AND next_check_at <= :dt LIMIT 100;";
		$params = array( 'dt'=> date("Y-m-d H:i:s") );
		$data_mylist = $this->query($sql,$params);

		$this->log("checking: ".count($data_mylist), LOG_DEBUG);
		foreach( $data_mylist as $mylist ) {
			$d = $mylist[$this->useTable];
			// RSS取得
			$res = $this->getByRss($d['data_type'], $d['mylist_str']);
			if (!$res){
				continue;
			}
			$sql = "UPDATE {$this->useTable}
 SET title=:title, author=:author, last_movie_data=:last_movie_data,
 before_movie_data=:before_movie_data, last_checked_at=:last_checked_at,
 last_published_at=:last_published_at, updated_at=:updated_at, next_check_at=:next_check_at
 WHERE id = :id ;";
			$params = array(
				'title'             => $res['title'],
				'author'            => $res['author'],
				'last_movie_data'   => $res['last_movie_data'],
				'before_movie_data' => $res['before_movie_data'],
				'last_checked_at'   => date("Y-m-d H:i:s"),
				'last_published_at' => $res['last_published_at'],
				'updated_at'        => date("Y-m-d H:i:s"),
				'next_check_at'     => $this->getNextCheckAt($res['last_published_at']),
				'id'                => $d['id'],
			);
			$this->query($sql,$params);
			usleep(10000);
		}//foreach

		return;
	}

	/**
	 *  一覧取得
	 *
	 */
	public function getList(
		$ids       = array(),
		$data_type = array(),
		$page      = 1,
		$limit     = 10
	) {
		$params = array(
			'order' => array('last_published_at DESC'),
			'limit' => $limit,
			'offset'=> ($page - 1) * $limit,
		);
		if (count($data_type) > 0) {
			$params['conditions']['data_type'] = $data_type;
		}
		if (count($ids) > 0) {
			$params['conditions']['id'] = $ids;
		}
		$res = $this->find('all', $params);
		return $res;
	}

	/**
	 *  data_mylist_id取得
	 *  @param int data_type
	 *  @param string mylist_str
	 *  @return DataMylist
	 */
	public function getOneByMylistStr($data_type, $mylist_str) {
		$res = $this->find('first', array(
				'conditions' => array(
					'data_type'  => $data_type,
					'mylist_str' => $mylist_str,
				),
		));
		return $res;
	}

	/**
	 *  検索
	 *
	 */
	public function searchList($ids=array(), $search_str) {
		// テーブル内はユニコードエスケープされているので、検索ワードもエスケープ
		$search_encoded = json_encode($search_str);
		$search_encoded = preg_replace("/\"(.+)\"/", "$1", $search_encoded);
		// エスケープ文字をさらにエスケープ
		$search_encoded = str_replace('\\', '\\\\', $search_encoded);
		$params = array(
			'conditions' => array(
				'OR' => array(
					'last_movie_data like' => "%{$search_encoded}%",
					'before_movie_data like' => "%{$search_encoded}%",
				),
			),
			'order' => array('last_published_at DESC'),
		);
		if (count($ids) > 0) {
			$params['conditions']['id'] = $ids;
		}
		$res = $this->find('all', $params);
		return $res;
	}


	/**
	 *  登録
	 *  @param  data_type 1:マイリスト,2:ユーザ
	 *  @param  mylist_str
	 *	@return int PK
	 */
	public function add($data_type, $mylist_str) {

		$data_mylist = $this->find('first', array(
			'conditions' => array(
				'data_type' => $data_type,
				'mylist_str' => $mylist_str,
			),
		));

		if (!isset($data_mylist['DataMylist'])){
			// RSS取得
			$res = $this->getByRss($data_type, $mylist_str);
			if (!$res) {
				return false;
			}//if
			// 登録
			$res['data_type']       = $data_type;
			$res['mylist_str']      = $mylist_str;
			$res['last_checked_at'] = date("Y-m-d H:i:s");
			$res['created_at']      = date("Y-m-d H:i:s");
			$res['updated_at']      = date("Y-m-d H:i:s");
			$res['next_check_at']   = $this->getNextCheckAt($res['last_published_at']);
			$data_mylist = $this->create();
			$data_mylist = $this->save($res);
			$hoge = $this->getLastInsertId();

			return $this->getLastInsertId();
		} else {
			return $data_mylist['DataMylist']['id'];
		}//if

	}//function


	/**
	 *	RSS取得ターミナル
	 *
	 */
	public function getByRss($data_type, $mylist_str, $max_cnt=DATA_MYLIST_DATA_BEFORE_MOVIE_DATA_NUM)
	{
		switch($data_type)
		{
			case DATA_MYLIST_DATA_TYPE_MYLIST:
				return $this->getMylistByRss($mylist_str, $max_cnt);
				break;
			case DATA_MYLIST_DATA_TYPE_USER:
				return $this->getUserPublishedByRss($mylist_str, $max_cnt);
				break;
			case DATA_MYLIST_DATA_TYPE_LIVE:
				return $this->getChannelLiveByRss($mylist_str, $max_cnt);
				break;
			case DATA_MYLIST_DATA_TYPE_BLOMAGA:
				return $this->getChannelBlomagaByRss($mylist_str, $max_cnt);
				break;
			default:
				return false;
		}
	}


	/**
	 *	公式からマイリスト情報取得
	 *
	 */
	private function getMylistByRss($mylist_str, $max_cnt)
	{
		$strXml = $this->getRss("http://www.nicovideo.jp/mylist/{$mylist_str}?rss=atom&sort=6");
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
		// ---- 投稿者
		$author = $xml->author->name;
		// ---- マイリスト名
		$title = $xml->title;
		$title = mb_ereg_replace("‐ニコニコ動画","",$title);
		$title = mb_ereg_replace("マイリスト","",$title);
		// ---- 最新投稿日時
		$last_published_at = '';
		// ---- 動画データ
		$now_cnt = 0;
		$last_movie_data = array();
		$before_movie_data = array();
		foreach ($xml->entry as $entry) {
			$movie_data['movie_str'] = preg_replace("/^http:\/\/[a-z\.]+\/watch\/([a-z0-9]+)$/", "$1", $entry->link->attributes()->href);
			$movie_data['title'] = (string)$entry->title;
			$movie_data['published'] = (string)$entry->published;
			if (preg_match('/src="([^"]+)"/', $entry->content, $matches)) {
				$movie_data['image'] = $matches[1];
			} else {
				$movie_data['image'] = "";
			}

			if ($now_cnt == 0) {
				$last_published_at = $movie_data['published'];
				$last_movie_data = $movie_data;
			} else {
				$before_movie_data[] = $movie_data;
			}
			if ($max_cnt <= $now_cnt) {
				break;
			}
			$now_cnt++;
		}//foreach
		return array(
			'title'  => $title,
			'author' => $author,
			'last_movie_data' => json_encode($last_movie_data),
			'before_movie_data' => json_encode($before_movie_data),
			'last_published_at' => $last_published_at,
		);

	}//function


	/**
	 *	公式からユーザ投稿動画情報取得
	 *
	 */
	private function getUserPublishedByRss($mylist_str, $max_cnt)
	{
		$strXml = $this->getRss("http://www.nicovideo.jp/user/{$mylist_str}/video?rss=atom");
		if ( !preg_match("/^<\?xml.+/", $strXml) ){
			return false;
		}
		$xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);

		// ---- 投稿者
		$author = $xml->author->name;
		// ---- マイリスト名
		$title = '投稿動画';
		// ---- 最新投稿日時
		$last_published_at = '';
		// ---- 動画データ
		$now_cnt = 0;
		$last_movie_data = array();
		$before_movie_data = array();
		foreach ($xml->entry as $entry) {
			$movie_data['movie_str'] = preg_replace("/^http:\/\/[a-z\.]+\/watch\/([a-z0-9]+)$/", "$1", $entry->link->attributes()->href);
			$movie_data['title'] = (string)$entry->title;
			$movie_data['published'] = (string)$entry->published;
			if (preg_match('/src="([^"]+)"/', $entry->content, $matches)) {
				$movie_data['image'] = $matches[1];
			} else {
				$movie_data['image'] = "";
			}

			if ($now_cnt == 0) {
				$last_published_at = $movie_data['published'];
				$last_movie_data = $movie_data;
			} else {
				$before_movie_data[] = $movie_data;
			}
			if ($max_cnt <= $now_cnt) {
				break;
			}
			$now_cnt++;
		}//foreach
		$data_mylist['title']  = $title;
		$data_mylist['author'] = $author;
		$data_mylist['last_movie_data'] = json_encode($last_movie_data);
		$data_mylist['before_movie_data'] = json_encode($before_movie_data);
		$data_mylist['last_published_at'] = $last_published_at;

		return $data_mylist;

	}//function


	/**
	 *	ブロマガ取得
	 *
	 */
	private function getChannelBlomagaByRss($mylist_str,$max_cnt)
	{
		$strXml = $this->getRss("http://ch.nicovideo.jp/{$mylist_str}/blomaga/nico/feed");
		if ( !preg_match("/^<\?xml.+/", $strXml) ){
			return false;
		}
		$xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);
		// ---- 投稿者
		$author = (string)$xml->channel->title;
		// ---- マイリスト名
		$title = '';
		// ---- 最新投稿日時
		$last_published_at = '';
		// ---- 動画データ
		$now_cnt = 0;
		$last_movie_data = array();
		$before_movie_data = array();
		foreach ($xml->channel->item as $i) {
			$movie_data['title'] = (string)$i->title;
			$movie_data['link'] = (string)$i->link;
			$nicoch = $i->children("nicoch",true);
			$movie_data['image'] = (string)$nicoch->article_thumbnail;
			$movie_data['published'] = date("Y-m-d H:i:s", strtotime((string)$i->pubDate));
			if ($now_cnt == 0) {
				$last_published_at = $movie_data['published'];
				$last_movie_data = $movie_data;
			} else {
				$before_movie_data[] = $movie_data;
			}//if
			if ($max_cnt <= $now_cnt) {
				break;
			}//if
			$now_cnt++;
		}//foreach
		$data_mylist['title']  = $title;
		$data_mylist['author'] = $author;
		$data_mylist['last_movie_data'] = json_encode($last_movie_data);
		$data_mylist['before_movie_data'] = json_encode($before_movie_data);
		$data_mylist['last_published_at'] = $last_published_at;
		return $data_mylist;
	}//function

	/**
	 *	チャンネル生放送取得
	 *
	 */
	private function getChannelLiveByRss($mylist_str,$max_cnt)
	{
		$strXml = $this->getRss("http://ch.nicovideo.jp/{$mylist_str}/live?rss=2.0");
		if ( !preg_match("/^<\?xml.+/", $strXml) ){
			return false;
		}
		$xml = simplexml_load_string($strXml, 'SimpleXMLElement', LIBXML_NOCDATA);
		// ---- 投稿者
		$author = (string)$xml->channel->title;
		$author = mb_ereg_replace("チャンネル生放送 - niconico","",$author);
		// ---- マイリスト名
		$title = '';
		// ---- 最新投稿日時
		$last_published_at = '';
		// ---- 動画データ
		$now_cnt = 0;
		$last_movie_data = array();
		$before_movie_data = array();
		foreach ($xml->channel->item as $i) {
			$movie_data['title'] = (string)$i->title;
			$movie_data['link'] = (string)$i->link;
			$nicoch = $i->children("nicoch",true);
			$movie_data['image'] = (string)$nicoch->live_thumbnail;
			$movie_data['published'] = date("Y-m-d H:i:s", strtotime((string)$nicoch->open_time));
			if ($now_cnt == 0) {
				$last_published_at = $movie_data['published'];
				$last_movie_data = $movie_data;
			} else {
				$before_movie_data[] = $movie_data;
			}//if
			if ($max_cnt <= $now_cnt) {
				break;
			}//if
			$now_cnt++;
		}//foreach
		$data_mylist['title']  = $title;
		$data_mylist['author'] = $author;
		$data_mylist['last_movie_data'] = json_encode($last_movie_data);
		$data_mylist['before_movie_data'] = json_encode($before_movie_data);
		$data_mylist['last_published_at'] = $last_published_at;
		return $data_mylist;
	}//function




	/**
	 *  次の更新チェック可能日時を計算
	 *
	 */
	private function getNextCheckAt($last_published_at) {
		$dt = time();
		$p_dt = strtotime($last_published_at);

		// ページが削除された場合、永久チェック停止
		if ($p_dt == strtotime('2000-01-01 00:00:00')) {
			return '3000-01-01 00:00:00';
		}
		// 非公開マイリストの場合、3day後
		if ($p_dt == strtotime('2001-01-01 00:00:00')) {
			return date("Y-m-d H:i:s", strtotime("3 day", $dt));
		}

		if (($dt - $p_dt) <= (86400*30) ) {
			return date("Y-m-d H:i:s", strtotime("10 minute", $dt));
		} else if(($dt - $p_dt) <= (86400*180)){
			return date("Y-m-d H:i:s", strtotime("24 hour", $dt));
		} else {
			return date("Y-m-d H:i:s", strtotime("3 day", $dt));
		}
	}

	private function getRss($url) {
		// Curlで取得開始
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		return curl_exec($ch);
	}

}

