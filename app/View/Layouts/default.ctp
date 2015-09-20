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
<body>
  <!-- 左広告枠 -->
  <div id="left_ad">
    <?=$ad_amazon?>
    <?=$ad_dmm?>
  </div>

  <!-- メイン -->
  <div id="container">
    <!-- header -->
    <div id="header">
      <div class="left"><img src="/img/common/logo_l.png"></div>
      <div id="menu">
	    <a href="/">トップ</a>&nbsp;|&nbsp;
        <a href="/top/latest">最新動画</a>&nbsp;|&nbsp;
        <a href="/top/mypagelist">ページ一覧</a>&nbsp;|&nbsp;
        <a href="/bbs/index">意見箱</a>
	  </div>
	  <div id="information">
  		<span style="font-size:14px;">- 試験運転中 -</span><br/>
		こちらで追加されたデータは、前バージョンには反映されません。<br/>
		数日様子見して問題ないようなら、前バージョンのチェック機能を停止します。
	  </div>
    </div>
    <!--/header -->


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
