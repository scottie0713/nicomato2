<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('user/setting.js', array('inline'=>false));
echo $this->Html->css('user/m_setting.css');
?>
<div>

	<h2>神回まとめ（仮）について</h2>
	<div style="margin-left:20px; font-size:14px;">
		動画の中で好きなシーンをすぐ見れるように登録できます。<br />
		動画は外部プレーヤーを使ってその場で見ることができます。<br />
		<span style="color:red;">開発版です。データはなるべく残していきますが、動作不良が発生する可能性があります。</span>
	</div>
	<br />

	<!--
	<h2>説明</h2>
	<div style="margin-left:20px; font-size:14px;">
	</div>
	-->

	<h2>新規作成</h2>
	<h3>ページ名 <span style="color:red">&lt;必須&gt;</span></h3>
	<div style="margin-left:20px; font-size:14px;">
		自分のページのタイトルになります。お好きに記入してください。<br/>
		<input id="title" type="text" style="width:400px;" value="" /><br/>
	</div>
	<h3>編集用パスワード</h3>
	<div style="margin-left:20px; font-size:14px;">
		<span style="color:red">※半角英数字20文字まで</span><br/>
		なくてもOKです。他人に編集されるのが嫌な人は、パスワードを設定してください。<br/>
	    <input id="password" type="text" value="" />&nbsp;
	</div>
	<h3>登録する！</h3>
	<div style="margin-left:20px; font-size:14px;">
	    <input id="regist_submit" type="submit" value="登録" />
	</div>
    <br />

</div>
