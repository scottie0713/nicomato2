<?php

class DataIchiba extends AppModel
{
    public $name = 'DataIchiba';
    public $useTable = 'data_ichibas';

	/**
	 *	公式からマイリスト情報取得
	 *
	 */
	private function getMylistByRss($mylist_str) {

		// Curlで取得開始
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$url = "http://www.nicovideo.jp/mylist/{$mylist_str}?rss=atom&sort=6";
		curl_setopt($ch, CURLOPT_URL, $url);
		$strXml = curl_exec($ch);
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
		$max_cnt = 2;
		$now_cnt = 0;
		$last_movie_data = array();
		$before_movie_data = array();
		foreach ($xml->entry as $entry) {
			$now_cnt++;
			$movie_data['movie_str'] = preg_replace("/^http:\/\/[a-z\.]+\/watch\/sm([0-9]+)$/", "$1", $entry->link->attributes()->href);
			$movie_data['title'] = (string)$entry->title;
			$movie_data['published'] = (string)$entry->published;

			if ($now_cnt == 1) {
				$last_published_at = $movie_data['published'];
				$last_movie_data = $movie_data;
			} else {
				$before_movie_data[] = $movie_data;
			}

			if ($max_cnt <= $now_cnt) {
				break;
			}
		}


		return array(
			'title'  => $title,
			'author' => $author,
			'last_movie_data' => json_encode($last_movie_data),
			'before_movie_data' => json_encode($before_movie_data),
			'last_published_at' => $last_published_at,
		);

	}//function

}

