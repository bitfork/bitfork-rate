<?php
/* @var $this IntegrationController */
/* @var $model Integration */
/* @var $form CActiveForm */
?>
<style>
.form {width: 600px; heeght: 500px;}
.form .row {width: 600px; margin-bottom: 10px;}
.form label {float: left; width: 100px}
.form input, .form textarea {width: 400px;}
.form textarea {height: 150px;}
.form input[type="submit"] {width: 150px;}
</style>
<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'integration-form',
		'enableAjaxValidation'=>true,
		'action'=>$this->createUrl('/integration/create'),
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>false,
			'beforeValidate'=>'js:formBeforeValidate',
			'afterValidate'=>'js:formAfterValidate',
		),
	));
	?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'site'); ?>
		<?php echo $form->textField($model,'site'); ?>
		<?php echo $form->error($model,'site'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment'); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Send'); ?>
	</div>

	<?php echo $form->errorSummary($model, '', '', array('class'=>'msg-err')); ?>

	<div class="msg-err myerr" style="display: none"></div>
	<div class="msg-ok" style="display: none"></div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="javascript">
	function formBeforeValidate(form) {
		$(form).find('.msg-ok').html('');
		$(form).find('.myerr').html('');
		$(form).find('.msg-ok').hide();
		$(form).find('.myerr').hide();
		return true;
	}
	function formAfterValidate(form, data, hasError) {
		if(!hasError) {
			if (data.error) {
				$(form).find('.myerr').html(data.error);
				$(form).find('.myerr').show();
			} else {
				if (data.content) {
					if (data.popup) {
						$.fancybox( data.content );
					} else if (data.block) {
						$(data.block).html(data.content);
					} else {
						$(form).find('.msg-ok').html(data.content);
						$(form).find('.msg-ok').show();
					}
				}
				if (data.redirect) {
					location.href = data.redirect;
				}
			}
			return false;
		}
		return true;
	}
</script>