<h1><?php echo Yii::t('main', 'Site map'); ?></h1>

<h2>EN</h2>
<ul>
	<li>
		<?php echo CHtml::link('Home', array('/en')); ?>
		<ul>
			<li><?php echo CHtml::link('Formula', array('/en/site/formula')); ?></li>
			<li><?php echo CHtml::link('Free API', array('/en/site/api')); ?></li>
			<?php foreach ($pairs as $pair) { ?>
				<li><?php echo CHtml::link($pair->currency_from->name .' / '. $pair->currency->name, array('/en/course/index', 'from'=>$pair->currency_from->name, 'to'=>$pair->currency->name)); ?></li>
			<?php } ?>
		</ul>
	</li>
</ul>

<h2>RU</h2>
<ul>
	<li>
		<?php echo CHtml::link('Главная', array('/ru')); ?>
		<ul>
			<li><?php echo CHtml::link('Формула расчета', array('/ru/site/formula')); ?></li>
			<li><?php echo CHtml::link('Free API', array('/ru/site/api')); ?></li>
			<?php foreach ($pairs as $pair) { ?>
				<li><?php echo CHtml::link($pair->currency_from->name .' / '. $pair->currency->name, array('/ru/course/index', 'from'=>$pair->currency_from->name, 'to'=>$pair->currency->name)); ?></li>
			<?php } ?>
		</ul>
	</li>
</ul>