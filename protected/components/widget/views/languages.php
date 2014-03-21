<?php // echo CHtml::tag('ul', array('class'=>'language'), implode("\n", $links)); ?>

<div class="slimScrollDiv language-menu">
	<div class="page-sidebar-wrapper">
		<ul>
			<li class="language-item">
				<a href="<?php echo Yii::app()->createUrl('/'); ?>"><i class="fa fa-font"></i><span class="title">Язык</span></a>
				<ul class="sub-menu">
					<?php echo implode("\n", $links); ?>
				</ul>
			</li>
		</ul>
	</div>
</div>