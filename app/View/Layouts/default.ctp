<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<?php echo $this->Html->charset(); ?>
	<title>にこまと！2.0</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('common/style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->fetch('image');
	?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-13210388-7', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body style="background-image:url(<?=$this->webroot ?>img/common/light_linen_v2.png);">
  <!-- 左広告枠
  <div id="left_ad">
    <?=$ad_amazon?>
    <?=$ad_dmm?>
  </div>
  -->

  <div id="container">
  	<!-- ロゴ -->
    <div id="logo"><?=$this->Html->image("common/logo_l.png", array("width"=>200)) ?></div>

    <!-- ninja admax -->
	<div id="ad_header">
      <script src="//adm.shinobi.jp/s/2969f298024310456dae2a539f152bcb"></script>
	</div>
	
	<!-- お知らせ
	<div id="information">
	  こちらで追加されたデータは、前バージョンには反映されません。<br/>
	</div>
	-->

	<!-- メニュー -->
	<div id="menu">
	  <div id="menu_content">
	    &nbsp;&nbsp;[動画更新チェックmenu]&nbsp;
	    <?= $this->Html->link("トップ", "/") ?>&nbsp;|&nbsp;
	    <?= $this->Html->link("最新動画", "/top/latest") ?>&nbsp;|&nbsp;
	    <?= $this->Html->link("ページ一覧", "/top/mypagelist") ?>&nbsp;
	    &nbsp;&nbsp;[新コンテンツmenu]&nbsp;
	    <?= $this->Html->link("開発中", "/spot/index") ?>
	  </div>
	</div>

    <!-- middle -->
    <div id="content">
      <?php echo $this->Session->flash(); ?>
      <?php echo $this->fetch('content'); ?>
	  <!-- footer -->
	  <!--
      <div id="footer" style="display:block">
        <?php echo $this->element('sql_dump'); ?>
      </div>
	  -->
    </div>
    <!--/middle -->

  </div>
</body>
</html>
