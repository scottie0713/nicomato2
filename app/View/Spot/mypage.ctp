<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('spot/mypage', array('inline'=>false));
echo $this->Html->script('spot/mypage.js', array('inline'=>false));
?>


<h2><?=$users['SpotUser']['title']?>&nbsp;<a href="/spot/setting/<?=$users['SpotUser']['id']?>">[編集]</a></h2>

<div style="margin: 12px 0px 12px 20px;">
	<select name="category">
		<option value="0" <?php if($category_id == 0){echo "selected";} ?>>なし</option>
		<?php foreach($categorys as $id => $name){ ?>
		<option value="<?=$id?>" <?php if($id == $category_id){echo "selected";}?>><?=$name?></option>
		<?php } ?>
	</select>
	<input type="hidden" name="user_id" value="<?=$user_id?>" />
	<input id="category_submit" type="submit" value="表示" />
</div>

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
