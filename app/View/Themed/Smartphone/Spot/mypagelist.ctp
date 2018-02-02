<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('top/mypagelist', array('inline'=>false));
?>
<div>

	<h2>神回まとめページ一覧</h2>

	<?=$this->element('pager',array('link'=>'/spot/mypagelist'));?>

	<ul id="list_main">
	<?php foreach ($mypages as $m){ ?>
		<li style="list-style-type: none; line-height:30px;">
			[ID: <?=$m['spot_users']['id']?>]&nbsp;<a href="/spot/mypage/<?=$m['spot_users']['id']?>"><?=$m['spot_users']['title']?></a>
		</li>
	<?php }//foreach ?>
	</ul>

	<?=$this->element('pager',array('link'=>'/spot/mypagelist'));?>

</div>
