<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('spot/mypage', array('inline'=>false));
echo $this->Html->script('spot/mypage.js', array('inline'=>false));
?>

<div id="sidebar">
	<div id="sidebar_menu"></div>
	<div id="sidebar_body">
		<iframe name="player" src=""></iframe>
	</div>
</div>

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
			<!--a href="http://www.nicovideo.jp/watch/<?=$m['movie_str']?>" target="_blank"><?=$m['movie_title']?></a-->
			<iframe width="290" height="130" src="https://ext.nicovideo.jp/thumb/<?=$m['movie_str']?>" scrolling="no" style="border:solid 0px;" frameborder="0"><a href="http://www.nicovideo.jp/watch/<?=$m['movie_str']?>">【実況】４人で攻略！シュールな物理演算パズル　part2</a></iframe>
		</div>

		<!-- BOX2 comment -->
		<div class="box2">
			<?=$m['user_comment']?><br />
		</div>

		<div class="box3">
			<a class="play" movie_id="<?=$m['movie_str']?>" sec="<?=$m['spot_sec']?>" target="player">
				<?=$this->Html->image("spot/play.png", array("width"=>50))?>
			</a>
		</div>

	</article>
<?php } ?>

</div>
</div>
