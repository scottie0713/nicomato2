<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="0">
	<?php echo $this->Html->charset(); ?>
	<title>にこまと！2.0</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('common/m_style');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
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
<body bgcolor="#666">

  <!-- 左広告枠 -->
  <div id="left_ad">
<!--
  	<?=$this->element('ad_left',array());?>
-->
  </div>

  <!-- メイン -->
  <div id="container">
    <!-- header -->
    <div id="header">
      <div class="left"><img src="/img/common/logo_s.png"></div>
      <div id="menu">
	    [動画更新チェックmenu]<br />
	    <a href="/">トップ</a>&nbsp;|&nbsp;<a href="/top/latest">最新動画</a>&nbsp;|&nbsp;<a href="/top/mypagelist">ページ一覧</a>
	    <br />[神回まとめ(α)menu]<br />
	    <a href="/spot/index">トップ</a>&nbsp;|&nbsp;<a href="/spot/mypagelist">ページ一覧</a>
	  </div>
    </div>
    <!--/header -->


    <!-- middle -->
    <div id="content">
      <?php echo $this->Session->flash(); ?>
      <?php echo $this->fetch('content'); ?>
    </div>
    <!--/middle -->

    <!-- footer -->
	<!--
    <div id="footer" style="display:block">
      <?php echo $this->element('sql_dump'); ?>
    </div>
	-->
    <!--/footer -->
  </div>
</body>
</html>
