<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('top/latest', array('inline'=>false));
?>
<div>

	<h2>にこまと！登録 最新動画</h2>

	<?=$this->element('pager',array('link'=>'/top/latest'));?>

	<?php foreach ($mylists as $m): ?>
	<?php
		$v = $m['DataMylist'];
		$movie = json_decode($v['last_movie_data']);
	?>
	<article class="mylist_box box_black" value="<?=$v['mylist_str']?>">

		<!-- BOX上部分 -->
		<div class="mylist_box_top">
			<a href="http://www.nicovideo.jp/mylist/<?=$v['mylist_str']?>" target="_blank"><?=$v['author'].' : '.$v['title']?></a>
		</div>

		<!-- BOX中部分 -->
		<div class="mylist_box_middle">
			<!-- BOX左部分 -->
			<div class="mylist_box_left">
				<img src="<?=$movie->image?>"/>
			</div>
			<!-- BOX右部分 -->
			<div class="mylist_box_right">
				<div class="title_large"><a href="http://www.nicovideo.jp/watch/<?=$movie->movie_str?>" target="_blank"><?=$movie->title?></a></div>
				<div class="info_large"><?=date("Y/m/d H:i", strtotime($movie->published))?>投稿</div>
			</div>
		</div>

		<!-- BOX下部分 -->
		<?php if (isset($v['before_movie_data'])){ ?>
		<?php $movie_b = json_decode($v['before_movie_data']); ?>
		<?php if (count($movie_b)>0){ ?>
		<div class="mylist_box_bottom">
			<?php foreach($movie_b as $b){ ?>
			<div class="title">
				<a href="http://www.nicovideo.jp/watch/<?=$b->movie_str?>" target="_blank"><?=$b->title?></a>
				<?=date("Y/m/d", strtotime($b->published))?>
			</div>
			<?php }//foreach ?>
		</div>
		<?php }//if ?>
		<?php }//if ?>

		<!-- BOX 右下部分 -->
		<div class="mylist_box_footer">
			最終チェック:<?=date("Y/m/d H:i", strtotime($v['updated_at']))?>
		</div>

		<!-- BOX 動画再生部分 -->
		<div class="mylist_box_movie">
			<script type="text/javascript" src="http://ext.nicovideo.jp/thumb_watch/<?=$movie->movie_str?>?w=400&h=300&f=10"></script><noscript></noscript>
		</div>

	</article>
	<?php endforeach ?>

	<?=$this->element('pager',array('link'=>'/top/latest'));?>

</div>
