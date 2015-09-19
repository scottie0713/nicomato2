<?php
echo $this->Html->script('common/jquery-2.0.0.min.js', array('inline'=>false));
echo $this->Html->script('common/ajax.js', array('inline'=>false));
//echo $this->Html->script('common/iscroll-lite.js', array('inline'=>false));
echo $this->Html->css('user/ranking.css');
echo $this->Html->script('user/ranking.js', array('inline'=>false));
?>
<div>

    <table class="main">
      <tr>
        <?php foreach ($user_rankings as $r): ?>
        <td>
          <div class="row_edit" user_ranking_id="<?= $r['UserRanking']['id'] ?>">
            <select name="category">
              <?php foreach ($categorys as $c): ?>
              <option value="<?=$c['id']?>" <?php if($r['UserRanking']['category']==$c['id']): ?>selected<?php endif ?>><?=$c['name']?></option>
              <?php endforeach ?>
            </select>
            <input type="text" class="mask" value="<?= $r['UserRanking']['mask'] ?>">
          </div>
          <div class="ranking_list"></div>
        </td>
        <?php endforeach ?>
      </tr>
    </table>

</div>



