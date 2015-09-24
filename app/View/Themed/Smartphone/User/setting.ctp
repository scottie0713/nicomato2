<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('user/setting.js', array('inline'=>false));
echo $this->Html->css('user/m_setting.css');
?>
<div>
	<a href="/user/mypage/<?=$user_id?>">>>戻る</a>

	<h2>編集モード</h2>
	<input type="hidden" name="user_id" value="<?=$user_id?>" />

	<h3>パスワード認証/変更</h3>
	<div style="font-size:11px">
		編集するには、パスワード認証が必要です。<br/>
		<span style="color:green">「OK」</span>が出たら認証完了です。<br/>
		<span style="color:red">パスワードは、ブラウザに1週間保存されます。</span><br/>
	</div>
	<div class="right">
		認証:<input type="text" id="auth" value="<?=$password?>" /><span id="auth_result"></span><br/>
		変更:<input id="new_password" type="text" name="data[new_password]" value="" />
		<input id="new_password_submit" type="submit" value="変更" />
	</div>


	<h3>ページタイトル変更</h3>
	<input id="new_title" type="text" style="width:200px;" name="data[new_title]" value="<?=$title?>" />&nbsp;
	<input id="new_title_submit" type="submit" value="変更" />


	<h3>新規追加</h3>
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
	<textarea id="add_mylist" rows="6" cols="40" name="data[mylist_page]"></textarea>
	<input id="add_mylist_submit" type="submit" value="追加" />


	<h3>登録ボックスの削除 / 更新状態の切り替え</h3>
	<div style="font-size:11px;">
		更新状態とは：<br/>
		「非更新」にすると、公式へ自動更新チェックをしなくなります。<br/>
		チェック数が減ることでページの読込の高速化につながります。
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
			<td width="60">
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
			<td width="40" class="td_switch">
				<?php if( $m['u']['delete_flag'] == 1){?>
				<div class="setting_btn delete_on" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">削除</div>
				<?php } else { ?>
				<div class="setting_btn delete_off" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">表示</div>
				<?php }//if ?>
			</td>
			<td width="40" class="td_switch">
				<?php if( $m['u']['check_flag'] == 1){?>
				<div class="setting_btn check_on" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">更新</div>
				<?php } else { ?>
				<div class="setting_btn check_off" data_type="<?=$m['d']['data_type']?>" mylist_str="<?=$m['d']['mylist_str']?>">非更新</div>
				<?php }//if ?>
			</td>

		</tr>
		<?php endforeach ?>
	</table>


	<h3>確認用：登録したＵＲＬリスト</h3>
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
	<textarea rows="6" cols="40"><?=$url?></textarea>

</div>
