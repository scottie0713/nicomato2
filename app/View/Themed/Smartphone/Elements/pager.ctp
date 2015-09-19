	<?php if(isset($page) && isset($page_max)){ ?>
	<?php echo $this->Html->css('common/pager', array('inline'=>false)); ?>
	<!-- ページング -->
	<div class="pagination">
		<?php 
			$i = (($page-4)>0) ? $page - 4 : 1;
			$max = (($i + 10) > $page_max) ? $page_max : $i + 10;
		?>
		<?php for($i; $i<=$max; $i++){ ?>
		<?php if($i == $page){ ?>
			<span class="page active"><?=$i?></span>
		<?php }else{ ?>
			<a href="<?=$link?>/<?=$i?>" class="page"><?=$i?></a>
		<?php }//if ?>
		<?php }//for ?>
	</div>
	<?php }//if ?>
