<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('top/m_mypagelist', array('inline'=>false));
?>
<div>

	<h2>チェックページ一覧</h2>

	<?=$this->element('pager',array('link'=>'/top/mypagelist'));?>

	<ul id="list_main">
	<?php foreach ($mypages as $mypage){ ?>
		<li style="list-style-type: none; line-height:30px;">
			<a href="/user/mypage/<?=$mypage['m']['user_id']?>"><?=$mypage['u']['title']?></a>
			&nbsp;(<?=$mypage[0]['count']?>)
		</li>
	<?php }//foreach ?>
	</ul>

	<?=$this->element('pager',array('link'=>'/top/mypagelist'));?>

</div>
