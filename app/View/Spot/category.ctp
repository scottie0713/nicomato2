<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('top/latest', array('inline'=>false));
?>
<div>
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

	<h3>カテゴリ変更</h3>
	<div style="margin-left:40px">
	<?php foreach($categorys as $id => $name){ ?>
	<form method="POST">
   		<input type="text" name="category_name" value="<?=$name?>" style="width:400px" />
		<input type="submit" value="変更" />
	</form>
	<br />
	<?php } ?>
	<div>
   		<input id="add_category_name" type="text" name="category_name" value="" style="width:300px" />
		<input id="add_category_submit" type="submit" value="追加" />
	</form>
	</div>



</div>
</div>
