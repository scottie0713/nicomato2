<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('bbs/index', array('inline'=>false));
?>
<div style="width:780px;">

	<h2>ご意見箱 改善提案/不具合報告/疑問/エールなどなどなんでもどうぞ</h2>

	<?=$this->element('pager',array('link'=>'/bbs/index'));?>

	<ul id="list_main">
	<?php foreach ($boards as $b){ ?>
		<li style="list-style-type: none; line-height:30px;">
			<?=$b['TblBoard']['comment']?>&nbsp;
			(<?=date("Y/m/d H:i", strtotime($b['TblBoard']['created_at']))?>)
		</li>
	<?php }//foreach ?>
	</ul>

	<?=$this->element('pager',array('link'=>'/bbs/index'));?>

	<!-- フォーム -->
	<h2>コメントフォーム</h2>
	<form action="/bbs/commit" method="POST">
		<textarea name="data[comment]" rows="10" cols="60"></textarea><br/>
		<input type="submit" value="工事中" disabled/>
	</form>


</div>
