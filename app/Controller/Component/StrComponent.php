<?php

App::uses('Component', 'Controller');
class StrComponent extends Component {

	/**
	 * マイリスト/ユーザURLから、ＩＤとtypeを抜き取る
	 *
	 */
	public function getMylistStr($str)
	{
		if (
			$this->getDataType($str) == DATA_MYLIST_DATA_TYPE_MYLIST ||
			$this->getDataType($str) == DATA_MYLIST_DATA_TYPE_USER
		){
			$str = preg_replace("/^(.+)\?.+$/", "\\1", $str);
			$str = preg_replace("/^(http|https):\/\/www.nicovideo.jp\/[a-z]+\/([0-9]+)$/", "\\2", $str);
			return (preg_match("/^[0-9]+$/", $str)) ? $str : false;
		} else if(
			$this->getDataType($str) == DATA_MYLIST_DATA_TYPE_BLOMAGA ||
			$this->getDataType($str) == DATA_MYLIST_DATA_TYPE_LIVE
		) {
			$str = preg_replace("/^(http|https):\/\/ch.nicovideo.jp\/([0-9a-zA-Z]+)\/.*$/", "\\2", $str);
			return (preg_match("/^[0-9a-zA-Z]+$/", $str)) ? $str : false;
		} else if(
			$this->getDataType($str) == DATA_MYLIST_DATA_TYPE_YOUTUBE_PLAYLIST
		) {
			if(preg_match("/\/watch/", $str)) {
			    $str = preg_replace("/^https:\/\/www.youtube.com\/watch\?v=[^&]+\&list=([\w\-]+)$/", "\\1", $str);
			} else if(preg_match("/\/playlist/", $str)){
            	$str = preg_replace("/^https:\/\/www.youtube.com\/playlist\?list=([\w\-]+)$/", "\\1", $str);
			}
			return (preg_match("/^[\w\-]+$/", $str)) ? $str : false;
		}
        
	}//function

	/**
	 * 動画ＵＲＬから動画ＩＤを抜き取る
	 *
	 */
	public function getMovieStr($url)
	{
		preg_match("/^(http|https):\/\/www.nicovideo.jp\/watch\/([a-z0-9]+)$/", $url, $matches);
		if(isset($matches[2]))
		{
			return $matches[2];
		}
		else
		{
			return null;
		}
	}//function

	public function getDataType($str)
	{
		// マイリスト
		if (preg_match("/mylist/", $str)){
			return DATA_MYLIST_DATA_TYPE_MYLIST;
		// ユーザ
		} else if(preg_match("/\/user\//", $str)) {
			return DATA_MYLIST_DATA_TYPE_USER;
		// ブロマガ
		} else if(preg_match("/\/blomaga/", $str)) {
			return DATA_MYLIST_DATA_TYPE_BLOMAGA;
		// チャンネル生放送
		} else if(preg_match("/\/live/", $str)) {
			return DATA_MYLIST_DATA_TYPE_LIVE;
		// youtube ぷれいりすと
		} else if(preg_match("/youtube/", $str) && preg_match("/list=/", $str)) {
			return DATA_MYLIST_DATA_TYPE_YOUTUBE_PLAYLIST;
		} else {
			return 0;
		}
	}//function


	public function validatePassword($str)
	{
		if (preg_match("/^[0-9a-zA-Z]+$/", $str)) {
			return true;
		} else {
			return false;
		}
	}

}


