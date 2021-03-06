<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('user/setting.js', array('inline'=>false));
echo $this->Html->css('user/setting.css');
?>
<div>

	<a href="/user/mypage/<?=$user_id?>">>>戻る</a>

	<h2>編集モード</h2>
	<input type="hidden" name="user_id" value="<?=$user_id?>" />

	<h3>パスワード認証/変更</h3>
	<div style="margin-left:40px">
	<div style="font-size:11px">
		編集するには、パスワード認証が必要です。<span style="color:green">「OK」</span>が出たら認証完了です。<br/>
		<span style="color:red">パスワードは、ブラウザに1週間保存されます。</span><br/>
	</div>
	<div class="right">
		認証:<input type="text" id="auth" value="<?=$password?>" /><span id="auth_result"></span>&nbsp;&nbsp;
		変更:<input id="new_password" type="text" name="data[new_password]" value="" />
		<input id="new_password_submit" type="submit" value="変更" />
	</div>
	</div>


	<h3>ページタイトル変更</h3>
	<div style="margin-left:40px">
	<input id="new_title" type="text" style="width:450px;" name="data[new_title]" value="<?=$title?>" />&nbsp;
	<input id="new_title_submit" type="submit" value="変更" />
	</div>


	<h3>新規追加</h3>
	<div style="margin-left:40px">
	<div style="font-size:11px;">
		次の形でURLを入れてください。<br/>
		<span style="color:#060;">
		ニコニコ動画：<br />
		公開マイリスト: http(s)://www.nicovideo.jp/mylist/【数字】<br/>
		ユーザ投稿動画: http(s)://www.nicovideo.jp/user/【数字】<br/>
		CHのブロマガ　: http(s)://ch.nicovideo.jp/【文字列】/blomaga<br/>
		CHの生放送　　: http(s)://ch.nicovideo.jp/【文字列】/live<br/>
		<br />
		youtube：<br />
		プレイリスト： https://www.youtube.com/playlist?list=【文字列】 または https://www.youtube.com/watch?v=【文字列】&list=【文字列】<br />
		</span>
		<span style="color:orange">※１行に１ＵＲＬでお願いします。</span><br/>
	</div>
	<textarea id="add_mylist" rows="6" cols="50" name="data[mylist_page]"></textarea>
	<input id="add_mylist_submit" type="submit" value="追加" />
	</div>


	<h3>登録ボックスの削除 / 更新状態の切り替え</h3>
	<div style="margin-left:40px">
		<div style="font-size:13px;">
			更新状態とは：<br/>
			「非更新」にすると、公式へ自動更新チェックをしなくなります。<br/>
			チェック数が減ることでページの読込の高速化につながります。
		</div>
	<table style="font-size:12px">
		<?php foreach ($mylists as $m): ?>
		<?php $movie = json_decode($m['d']['last_movie_data']); ?>
		<tr>
			<td width="60">
				<?php if(isset($movie->image)){ ?>
				<img width="60" src="<?=$movie->image?>">
				<?php }else{ ?>
				画像なし
				<?php }//?>
			</td>
			<td width="80">
				<?php if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_MYLIST){ ?>
					<a href="http://www.nicovideo.jp/mylist/<?=$m['d']['mylist_str']?>" target="_blank">マイリスト</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_USER){ ?>
					<a href="http://www.nicovideo.jp/user/<?=$m['d']['mylist_str']?>" target="_blank">ユーザ</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_LIVE){ ?>
					<a href="http://ch.nicovideo.jp/<?=$m['d']['mylist_str']?>/live" target="_blank">CH生放送</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_BLOMAGA){ ?>
					<a href="http://ch.nicovideo.jp/<?=$m['d']['mylist_str']?>/blomaga" target="_blank">CHブロマガ</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_YOUTUBE_PLAYLIST){ ?>
					<a href="https://www.youtube.com/playlist?list=<?=$m['d']['mylist_str']?>" target="_blank">Youtubeプレイリスト</a>
				<?php }//if ?>
			</td>
			<td width="*">
				<?=$m['d']['author']?><br/>
				<?=$m['d']['title']?><br/>
			</td>
			<td width="100" class="td_switch">
				<?php if( $m['u']['delete_flag'] == 1){?>
				<div class="setting_btn delete_on" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">削除</div>
				<?php } else { ?>
				<div class="setting_btn delete_off" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">表示</div>
				<?php }//if ?>
			</td>
			<td width="100" class="td_switch">
				<?php if( $m['u']['check_flag'] == 1){?>
				<div class="setting_btn check_on" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">更新</div>
				<?php } else { ?>
				<div class="setting_btn check_off" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">非更新</div>
				<?php }//if ?>
			</td>

		</tr>
		<?php endforeach ?>
	</table>
	</div>


	<h3>確認用：登録したＵＲＬリスト</h3>
	<div style="margin-left:40px">
	<?php
		$url = '';
		foreach ($mylists as $m){
			if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_MYLIST){
				$url .= "https://www.nicovideo.jp/mylist/{$m['d']['mylist_str']}\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_USER){
				$url .= "https://www.nicovideo.jp/user/{$m['d']['mylist_str']}\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_LIVE){
				$url .= "https://ch.nicovideo.jp/{$m['d']['mylist_str']}/live\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_BLOMAGA){
				$url .= "https://ch.nicovideo.jp/{$m['d']['mylist_str']}/blomaga\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_YOUTUBE_PLAYLIST){
				$url .= "https://www.youtube.com/playlist?list={$m['d']['mylist_str']}\n";
			}//if
		}//foreach
	?>
	<textarea rows="10" cols="100"><?=$url?></textarea>
	</div>

</div>
