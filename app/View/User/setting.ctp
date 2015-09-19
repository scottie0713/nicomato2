<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('user/setting.js', array('inline'=>false));
echo $this->Html->css('user/setting.css');
?>
<div>

	<a href="/user/mypage/<?=$user_id?>">>>戻る</a>

	<h2>チェックページ 編集</h2>

	<h3>パスワード認証</h3>
	<div style="margin-left:40px">
	<div style="font-size:11px">
		更新を行うにはこちらにパスワードを入力してください。<br/>
		<span style="color:green">「OK」</span>が出たら認証完了です。
	</div>
	<div class="right">
		Password:<input type="text" id="auth" value="" /><span id="auth_result"></span>
	</div>
	</div>

	<h3>マイリスト・ユーザ変更/ 更新チェック変更</h3>
	<div style="margin-left:40px">
	<div style="font-size:11px;">
		パスワード認証すると更新することができます。<br/>
		<div style="color:red">
		！注意！<br />
		・「更新チェックＯＮ」は全体で２０件まで設定できます。<br/>
		</div>
	</div>

	<table>
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
			<td width="100">
				<?php if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_MYLIST){ ?>
					<a href="http://www.nicovideo.jp/mylist/<?=$m['d']['mylist_str']?>" target="_blank">マイリスト</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_USER){ ?>
					<a href="http://www.nicovideo.jp/user/<?=$m['d']['mylist_str']?>" target="_blank">ユーザ</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_LIVE){ ?>
					<a href="http://ch.nicovideo.jp/<?=$m['d']['mylist_str']?>/live" target="_blank">CH生放送</a>
				<?php }else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_BLOMAGA){ ?>
					<a href="http://ch.nicovideo.jp/<?=$m['d']['mylist_str']?>/blomaga" target="_blank">CHブロマガ</a>
				<?php }//if ?>
			</td>
			<td width="*">
				<?=$m['d']['author']?><br/>
				<?=$m['d']['title']?><br/>
			</td>
			<td width="100" class="td_switch">
				<?php if( $m['u']['delete_flag'] == 1){?>
				<div class="delete_btn delete_on" value="<?=$m['u']['user_mylist_id']?>">削除</div>
				<?php } else { ?>
				<div class="delete_btn delete_off" value="<?=$m['u']['user_mylist_id']?>">表示</div>
				<?php }//if ?>
			</td>

		</tr>
		<?php endforeach ?>
	</table>
	</div>


	<h3>新規追加</h3>
	<div style="margin-left:40px">
	<div style="font-size:11px;">
		次の形でURLを入れてください。<br/>
		<span style="color:#060;">
		公開マイリスト: http://www.nicovideo.jp/mylist/【数字】<br/>
		ユーザ投稿動画: http://www.nicovideo.jp/user/【数字】<br/>
		CHのブロマガ　: http://ch.nicovideo.jp/【文字列】/blomaga<br/>
		CHの生放送　　: http://ch.nicovideo.jp/【文字列】/live<br/>
		</span>
		<span style="color:orange">※１行に１ＵＲＬでお願いします。</span><br/>
	</div>
	<textarea id="add_mylist" rows="10" cols="60" name="data[mylist_page]"></textarea>
	<input id="add_mylist_submit" type="submit" value="登録" />
	</div>

	<h3>ページタイトル変更</h3>
	<div style="margin-left:40px">
	<input id="new_title" type="text" style="width:400px;" name="data[new_title]" value="" />&nbsp;
	<input id="new_title_submit" type="submit" value="変更" />
	</div>

	<h3>パスワード変更</h3>
	<div style="margin-left:40px">
	<input id="new_password" type="text" name="data[new_password]" value="" />&nbsp;
	<input id="new_password_submit" type="submit" value="変更" />
	</div>

	<h3>確認用：登録したＵＲＬリスト</h3>
	<div style="margin-left:40px">
	<?php
		$url = '';
		foreach ($mylists as $m){
			if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_MYLIST){
				$url .= "http://www.nicovideo.jp/mylist/{$m['d']['mylist_str']}\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_USER){
				$url .= "http://www.nicovideo.jp/user/{$m['d']['mylist_str']}\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_LIVE){
				$url .= "http://ch.nicovideo.jp/{$m['d']['mylist_str']}/live\n";
			} else if($m['d']['data_type'] == DATA_MYLIST_DATA_TYPE_BLOMAGA){
				$url .= "http://ch.nicovideo.jp/{$m['d']['mylist_str']}/blomaga\n";
			}//if
		}//foreach
	?>
	<textarea rows="10" cols="60"><?=$url?></textarea>
	</div>

<script>
$("input").iCheck({
	radioClass: "iradio_flat-red" //使用するテーマのスキンを指定する
});
</script>
</div>
