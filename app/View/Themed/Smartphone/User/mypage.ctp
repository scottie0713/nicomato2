<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('user/mypage.js', array('inline'=>false));
echo $this->Html->css('user/m_mypage', array('inline'=>false));
?>
<div>

	<!-- マイページ名 -->
	<h2>
		<?=$users['User']['title']?>&nbsp;
		<a style="color:#fff" href="/user/setting/<?=$user_id?>">[編集]</a>
	</h2>

	<!-- ページャ -->
	<?=$this->element('pager',array('link'=>"/user/mypage/{$user_id}"));?>

	<!-- 検索窓 -->
	<div style="margin:10px 0px 10px 10px">
	<form action="/user/search/<?=$user_id?>" method="POST">
		<input type="text" name="search" val="" />
		<input type="submit" value="動画名で検索" />
	</form>
	</div>

	<!-- マイリストＢＯＸ -->
	<?php
		foreach ($mylists as $m) {
			$v = $m['DataMylist'];
			if ($v['data_type'] == DATA_MYLIST_DATA_TYPE_MYLIST) {
				echo $this->element('mypage_box_mylist',array('v'=>$m['DataMylist']));
			} else if($v['data_type'] == DATA_MYLIST_DATA_TYPE_USER) {
				echo $this->element('mypage_box_user',array('v'=>$m['DataMylist']));
			} else if($v['data_type'] == DATA_MYLIST_DATA_TYPE_LIVE) {
				echo $this->element('mypage_box_live',array('v'=>$m['DataMylist']));
			} else if($v['data_type'] == DATA_MYLIST_DATA_TYPE_BLOMAGA) {
				echo $this->element('mypage_box_blomaga',array('v'=>$m['DataMylist']));
			}
		}//foreach
	?>

	<!-- ページャ -->
	<?=$this->element('pager',array('link'=>"/user/mypage/{$user_id}"));?>

</div>
