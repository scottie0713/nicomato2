<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
echo $this->Html->css('top/latest', array('inline'=>false));
?>
<div>

<?php foreach($spots as $spot){ ?>
<?php     if($spot["UserSpot"]["data_type"] == 1){ ?>
  <script type="application/javascript" src="https://embed.nicovideo.jp/watch/sm<?=$spot["UserSpot"]["movie_str"]?>/script?w=640&h=360&from=<?=$spot["UserSpot"]["spot_sec"]?>"></script><noscript>movie cannot load.</noscript>
<?php }elseif($spot["UserSpot"]["data_type"] == 2){ ?>
<!--
  <div id="ytplayer"></div>
  <script>
  // Load the IFrame Player API code asynchronously.
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/player_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // Replace the 'ytplayer' element with an <iframe> and
  // YouTube player after the API code downloads.
  var player;
  function onYouTubePlayerAPIReady() {
    player = new YT.Player('ytplayer', {
      height: '360',
      width: '640',
      videoId: '<?=$spot["UserSpot"]["movie_str"]?>',
	  playerVars: {
	    'startSeconds' : '<?=$spot["UserSpot"]["spot_sec"]?>',
	  }
    });
  }
</script>
-->

<iframe id="ytplayer" type="text/html" width="640" height="360"
  src="http://www.youtube.com/embed/<?=$spot["UserSpot"]["movie_str"]?>?start=600&autoplay=0&origin=http://example.com"
frameborder="0"/>
<?php } ?>
<?php } ?>

</div>
</div>
