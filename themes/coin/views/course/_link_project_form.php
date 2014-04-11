<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'link-project-form',
	'enableAjaxValidation'=>true,
	'action'=>$this->createUrl('/course/linkProject'),
	'htmlOptions' => array('class'=>'main-padding_10', 'enctype'=>'multipart/form-data'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>true,
		'beforeValidate'=>'js:apiBeforeValidateLink',
		'afterValidate'=>'js:apiAfterValidateLink',
	),
));
?>
	<h2><?php echo Yii::t('main', 'Пользуетесь bitfork API?<br/> Разместите здесь вашу ссылку!'); ?></h2>

	<?php echo $form->textField($model,'url',array('class'=>'inp-block','placeholder'=>Yii::t('main', 'Введите url сайта *'))); ?>
	<?php echo $form->error($model,'url'); ?>
	<?php echo $form->textField($model,'email',array('class'=>'inp-block','placeholder'=>Yii::t('main', 'Ваш e-mail'))); ?>
	<?php echo $form->error($model,'email'); ?>

	<?php echo CHtml::submitButton(Yii::t('main', 'Отправить'), array('class'=>'inp-block')); ?>

	<div class="msg-ok" style="display: none"></div>

<?php $this->endWidget(); ?>
<script language="javascript">
	function apiBeforeValidateLink(form) {
		$('.msg-ok').html('').hide();
		return true;
	}
	function apiAfterValidateLink(form, data, hasError) {
		if(!hasError) {
			$('.msg-ok').html(data.content).show();
			return false;
		}
		return true;
	}
</script>