<article class="mylist_box box_black">

	<!-- BOX上部分 -->
	<div class="mylist_box_top">
		<?php if($v['title'] == ''){$v['title']='要確認';} ?>
		<a href="http://www.nicovideo.jp/mylist/<?=$v['mylist_str']?>" target="_blank"><?=mb_strimwidth($v['author'].' : '.$v['title'],0,52,'…','utf-8')?></a>
	</div>

	<!-- BOX中部分 -->
	<?php $movie = json_decode($v['last_movie_data']); ?>
	<div class="mylist_box_middle">
		<!-- BOX左部分 -->
		<div class="mylist_box_left">
			<?php if(isset($movie->movie_str)){ ?>
			<img src="<?=$movie->image?>"/>
			<?php }//if ?>
		</div>
		<!-- BOX右部分 -->
		<div class="mylist_box_right">
			<?php if(isset($movie->movie_str)){ ?>
			<div class="info_large"><?=date("Y/m/d H:i", strtotime($movie->published))?>投稿</div>
			<div class="title_large"><a href="http://www.nicovideo.jp/watch/<?=$movie->movie_str?>" target="_blank"><?=$movie->title?></a></div>
			<?php }else{ ?>
				マイリスト情報が取れません。<br/>
				＜原因＞マイリストが非公開/削除済み<br/>
				マイリスト内の動画が再生不能/削除済みなど
			<?php }//if ?>
		</div>
	</div>

	<!-- BOX下部分 -->
	<?php if (isset($v['before_movie_data'])){ ?>
	<?php $movie_b = json_decode($v['before_movie_data']); ?>
	<?php if (count($movie_b)>0){ ?>
	<div class="mylist_box_bottom">
		<?php foreach($movie_b as $b){ ?>
		<div class="init_title">
			<?=date("y/m/d", strtotime($b->published))?>
			<a href="http://www.nicovideo.jp/watch/<?=$b->movie_str?>" target="_blank"><?=$b->title?></a>
		</div>
		<?php }//foreach ?>
		<div class="detail_title"></div>
	</div>
	<?php }//if ?>
	<?php }//if ?>

	<!-- BOX 右下部分 -->
	<div class="mylist_box_footer">
		最終チェック:<?=date("Y/m/d H:i", strtotime($v['updated_at']))?>
	</div>

	<div class="mylist_box_more bottom_open" type="1" str="<?=$v['mylist_str']?>">more</div>

</article>
