<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->script('common/jquery.slimscroll.min.js', array('inline'=>false));
echo $this->Html->script('user/mypage.js', array('inline'=>false));
echo $this->Html->css('user/mypage', array('inline'=>false));
?>
<div>
	<!-- ポップアップ -->
	<div id="mypage_popup">
		<div id="popup_top">
			<input type="submit" style="width:600px" value="閉じる">
		</div>
		<div id="popup_content">
		</div>
	</div>

	<!-- 戻る(検索時に表示) -->
	<?php if(isset($search)){ ?>
		<div style="margin:10px 0px 10px 40px;"><a href="/user/mypage/<?=$user_id?>">&lt;&lt;戻る</a></div>
	<?php }//if ?>

	<!-- マイページ名 -->
	<h2>
		<?=$users['User']['title']?>
		&nbsp;<a style="color:#fff" href="/user/setting/<?=$user_id?>">[編集]</a>
	</h2>

	<!-- ソート -->
	<div id="top_limit">
	<form action="/user/mypage/<?=$user_id?>" method="POST">
		<input type="hidden" name="page" value="1" />
		<select name="limit">
			<option value="12">12件</option>
			<option value="24">24件</option>
			<option value="32">32件</option>
			<option value="48">48件</option>
			<option value="60">60件</option>
			<option value="100">100件</option>
		</select>
		<input type="submit" value="変更" />
	</form>
	</div>

	<!-- 検索窓 -->
	<div id="top_search">
	<form action="/user/search/<?=$user_id?>" method="POST">
		<input type="text" name="search" val="" />
		<input type="submit" value="動画名で検索" />
	</form>
	</div>

	<!-- 手動更新 -->
	<div id="top_update">
	<form action="/user/mypage/<?=$user_id?>" method="POST">
		<input type="hidden" name="all_check" value="1" />
		<input type="submit" value="手動更新" />
	</form>
	</div>

	<!-- ページャ -->
	<?=$this->element('pager',array('link'=>"/user/mypage/{$user_id}"));?>

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
