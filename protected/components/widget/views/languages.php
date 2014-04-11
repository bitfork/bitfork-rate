<?php // echo CHtml::tag('ul', array('class'=>'language'), implode("\n", $links)); ?>

<aside class="aside-lang main-inlineBlock">
	<p class="aside-lang-current"><span class="ico-lang<?php echo mb_strtoupper(Yii::app()->language,'utf-8'); ?>"></span><span class="ico-triangleGray"></span></p>
	<div class="aside-lang-list">
		<?php echo implode("\n", $links); ?>
	<div>
</aside>