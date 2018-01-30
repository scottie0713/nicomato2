<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('spot/setting.js', array('inline'=>false));
?>
<div>

	<a href="/spot/mypage/<?=$user_id?>">>>戻る</a>

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
	<br />

	<h3>ページタイトル変更</h3>
	<div style="margin-left:40px">
	<input id="new_title" type="text" style="width:450px;" name="data[new_title]" value="<?=$title?>" />&nbsp;
	<input id="new_title_submit" type="submit" value="変更" />
	</div>
	<br />

	<h3>カテゴリ変更/追加</h3>
	<div style="margin-left:40px">
	<?php foreach($categorys as $id => $name){ ?>
		<div>
   			<input type="text" name="category_name" value="<?=$name?>" style="width:300px" />
			<input class="change_category_submit" type="submit" category_id="<?=$id?>" value="変更" />
		</div>
	<br />
	<?php } ?>
	<div>
   		<input id="add_category_name" type="text" name="category_name" value="" style="width:300px" />
		<input id="add_category_submit" type="submit" value="追加" />
	</div>
	</div>

	<br />
	<h3>動画追加</h3>

	<div style="margin-left:40px">
	<dl>
		<dt>カテゴリ</dt>
		<dd>
			<select name="category">
				<option value="0" default>なし</option>
				<?php foreach($categorys as $id => $name){ ?>
				<option value="<?=$id?>"><?=$name?></option>
				<?php } ?>
			</select>
		</dd>
		<dt>動画URL</dt>
		<dd><input type="text" name="movie_url" value="" style="width:500px" /></dd>
		<dt>開始時間</dt>
		<dd><input type="text" name="min" value="" style="width:30px" />:<input type="text" name="sec" value="" style="width:20px" /></dd>
	   	<dt>コメント</dt>
		<dd><input type="text" name="comment" value="" /></dd>
		<dt>&nbsp;</dt>
		<dd><input id="add_movie_submit" type="submit" value="追加" /></dd>
	</dl>
	</div>

	<br />

	<h3>動画変更</h3>
	<div style="margin-left:40px">

	<?php foreach($movies as $m){ ?>
	<dl>
		<dt>カテゴリ</dt>
		<dd>
			<select name="category">
				<option value="0" <?php if(is_null($m['spot_category_id'])){echo "selected";} ?>>なし</option>
				<?php foreach($categorys as $id => $name){ ?>
				<option value="<?=$id?>" <?php if($id == $m['spot_category_id']){echo "selected";}?>><?=$name?></option>
				<?php } ?>
			</select>
		</dd>
		<dt>動画名</dt>
		<dd><?=$m['movie_title']?>&nbsp;</dd>
    	<dt>動画ID</dt>
		<dd><input type="text" name="movie_url" value="http://www.nicovideo.jp/watch/<?=$m['movie_str']?>" style="width:300px" /></dd>
		<dt>開始時間</dt>
		<dd><input type="text" name="min" value="<?=intval(($m['spot_sec']/60))?>" style="width:30px" />:<input type="text" name="sec" value="<?=($m['spot_sec']%60)?>" style="width:20px" /></dd>
    	<dt>コメント</dt>
		<dd><input type="text" name="comment" value="<?=$m['user_comment']?>" /></dd>
		<dt>&nbsp;</dt>
		<dd><input class="change_movie_submit" type="submit" spot_movie_id="<?=$m['id']?>" value="変更" /></dd>
	</dl>
	<hr style="margin:20px 0px;"/>
	<?php } ?>
	</div>

</div>
</div>
