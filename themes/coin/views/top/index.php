<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<h1>Где лучшая операция?</h1>

	<div class="form">

		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'top-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>

		<div class="row">
			Купить? <?php echo $form->checkBox($model,'is_buy'); ?>
			<?php echo $form->textField($model,'volume'); ?>
			<?php echo $form->dropDownList($model,'id_service_1', CHtml::listData(Currency::model()->findAll(), 'id', 'name')); ?>
			за
			<?php echo $form->dropDownList($model,'id_service_2', CHtml::listData(Currency::model()->findAll(), 'id', 'name')); ?>
		</div>

		<div style="display: none">
			<?php echo $form->error($model,'volume'); ?>
			<?php echo $form->error($model,'id_service_1'); ?>
			<?php echo $form->error($model,'id_service_2'); ?>
			<?php echo $form->error($model,'is_buy'); ?>
		</div>

		<?php echo $form->errorSummary($model); ?>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Submit'); ?>
		</div>

		<?php $this->endWidget(); ?>

	</div><!-- form -->

<?php if (!empty($result)) { ?>
	<p>
		<?php if ($model->is_buy == 1) { ?>
			лучше всего купить на
		<?php } else { ?>
			лучше всего продать на
		<?php } ?>
		<?php
		echo $result[1][$result[0]]['service'];
		?>
	</p>
	<p>
		<?php if ($model->is_buy == 1) { ?>
			можно купить
		<?php } else { ?>
			можно продать
		<?php } ?>
		<?php echo $result[1][$result[0]]['data']['volume'] .' за '. $result[1][$result[0]]['data']['summa']; ?>
	</p>
	<?php
	/*echo "<pre>";
	print_r($result);
	echo "</pre>";*/
	?>
<?php } ?>