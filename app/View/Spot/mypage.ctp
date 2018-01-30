<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('spot/mypage', array('inline'=>false));
echo $this->Html->script('spot/mypage.js', array('inline'=>false));
?>

管理人は動画の好きな場面（神回）は何回でも見たくなります。<br />
ここでは動画の見始めたい時間を登録することで、すぐにお気に入り場面を再生できます。<br />
(開発中です)

<h2><?=$users['SpotUser']['title']?>&nbsp;<a href="/spot/setting/<?=$users['SpotUser']['id']?>">[編集]</a></h2>
<br />

<?php foreach($movies as $m){ ?>
	<article class="mylist_box box_black">

		<!-- BOX1 title -->
		<div class="box1">
			<a href="http://www.nicovideo.jp/watch/<?=$m['movie_str']?>" target="_blank"><?=$m['movie_title']?></a>
		</div>

		<!-- BOX2 comment -->
		<div class="box2">
			<?=$m['user_comment']?>
		</div>

		<!-- BOX3 player -->
		<div class="movie">
  			<script type="application/javascript" src="https://embed.nicovideo.jp/watch/<?=$m["movie_str"]?>/script?w=520&h=390&from=<?=$m["spot_sec"]?>"></script><noscript>movie cannot load.</noscript>
		</div>

	</article>
<?php } ?>


<!--
  <script type="application/javascript" src="https://embed.nicovideo.jp/watch/sm<?=$m["movie_str"]?>/script?w=640&h=360&from=<?=$m["spot_sec"]?>"></script><noscript>movie cannot load.</noscript>
<iframe id="ytplayer" type="text/html" width="640" height="360"
  src="http://www.youtube.com/embed/<?=$m["movie_str"]?>?start=600&autoplay=0&origin=http://example.com"
frameborder="0"/>
  -->

</div>
</div>
