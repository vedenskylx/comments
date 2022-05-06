<?php

/** @var yii\web\View $this */
/** @var \app\models\Comment[] $comments */

rmrevin\yii\fontawesome\AssetBundle::register($this);
?>




<div class="site-index">
    <div class="row">

    </div>
</div>

<div id="collapseDVR3" class="panel-collapse in">
    <div class="tree ">
        <ul>
            {foreach from=$comments item=$comment}
            <li>{$comment->content}</li>
            {/foreach}
            <?php foreach ($comments as $comment) { ?>
            <li>
                <span>
                    <i class="fa fa-folder-open"></i> Менюшка
                </span>
                <ul>
                    <li><span><i class="fa fa-minus-square"></i> другая Менюшка</span>
                        <ul>
                            <li><span> ещё одна Менюшка </span></li>
                        </ul>
                    </li>
                    <li><span><i class="fa fa-minus-square"></i> другая </span>
                        <ul>
                            <li><span> Менюшка </span></li>
                            <li><span><i class="fa fa-minus-square"></i> Менюшка</span>
                                <ul>
                                    <li><span><i class="fa fa-minus-square"></i> Менюшка</span>
                                        <ul>
                                            <li><span> Менюшка</span></li>
                                            <li><span> Менюшка</span></li>
                                        </ul>
                                    </li>
                                    <li><span> Менюшка</span></li>
                                    <li><span> Менюшка</span></li>
                                </ul>
                            </li>
                            <li><span> Менюшка</span></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li>

            </li>
            <li><span><i class="fa fa-folder-open"></i> Менюшка2</span>
                <ul>
                    <li><span> Менюшка</span></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<?php
$js = <<<JS
$(document).ready(function(){
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
      $('.tree li.parent_li > span').on('click', function (e) {
          var children = $(this).parent('li.parent_li').find(' > ul > li');
          if (children.is(":visible")) {
              children.hide('fast');
              $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus-square').removeClass('fa-minus-square');
          } else {
              children.show('fast');
              $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus-square').removeClass('fa-plus-square');
          }
          e.stopPropagation();
      });
});
JS;
$this->registerJs($js, \yii\web\View::POS_LOAD);
?>
