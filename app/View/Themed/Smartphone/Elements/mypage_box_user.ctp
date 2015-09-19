<article class="mylist_box box_blue">

	<!-- BOX上部分 -->
	<div class="mylist_box_top">
		<a href="http://www.nicovideo.jp/user/<?=$v['mylist_str']?>/video" target="_blank"><?=mb_strimwidth($v['author'].' : '.$v['title'],0,52,'…','utf-8')?></a>
	</div>

	<!-- BOX中部分 -->
	<?php $movie = json_decode($v['last_movie_data']); ?>
	<div class="mylist_box_middle">
		<!-- BOX左部分 -->
		<div class="mylist_box_left">
			<img src="<?=$movie->image?>"/>
		</div>
		<!-- BOX右部分 -->
		<div class="mylist_box_right">
			<div class="info_large"><?=date("Y/m/d H:i", strtotime($movie->published))?>投稿</div>
			<div class="title_large"><a href="http://www.nicovideo.jp/watch/sm<?=$movie->movie_str?>" target="_blank"><?=$movie->title?></a></div>
		</div>
	</div>

	<!-- BOX下部分 -->
	<?php if (isset($v['before_movie_data'])){ ?>
	<?php $movie_b = json_decode($v['before_movie_data']); ?>
	<?php if (count($movie_b)>0){ ?>
	<div class="mylist_box_bottom">
		<?php foreach($movie_b as $b){ ?>
		<div class="title">
			<?=date("y/m/d", strtotime($b->published))?>
			<a href="http://www.nicovideo.jp/watch/sm<?=$b->movie_str?>" target="_blank"><?=mb_strimwidth($b->title,0,48,'…','utf-8')?></a>
		</div>
		<?php }//foreach ?>
	</div>
	<?php }//if ?>
	<?php }//if ?>

	<!-- BOX 右下部分 -->
	<div class="mylist_box_footer">
		最終チェック:<?=date("Y/m/d H:i", strtotime($v['updated_at']))?>
	</div>

</article>
