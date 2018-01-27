<article class="mylist_box box_red">

	<!-- BOX上部分 -->
	<div class="mylist_box_top">
		<a href="http://ch.nicovideo.jp/<?=$v['mylist_str']?>/live" target="_blank"><?=mb_strimwidth($v['author'],0,52,'…','utf-8')?></a>
	</div>

	<!-- BOX中部分 -->
	<?php $movie = json_decode($v['last_movie_data']); ?>
	<div class="mylist_box_middle">
		<!-- BOX左部分 -->
		<div class="mylist_box_left_square">
			<img src="<?=$movie->image?>"/>
		</div>
		<!-- BOX右部分 -->
		<div class="mylist_box_right">
			<div class="info_large"><?=date("Y/m/d H:i", strtotime($movie->published))?>開演</div>
			<div class="title_large"><a href="<?=$movie->link?>" target="_blank"><?=$movie->title?></a></div>
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
			<a href="<?=$b->link?>" target="_blank"><?=$b->title?></a>
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
