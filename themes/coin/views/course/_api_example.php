<div class="account-block">
	<h3 class="account-caption">Используете Bitfork API? Расскажите о вашем сайте!</h3>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'api-form',
		'enableAjaxValidation'=>true,
		'action'=>$this->createUrl('/course/apiExample'),
		'htmlOptions' => array('enctype'=>'multipart/form-data'),
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
			'validateOnChange'=>true,
			'afterValidate'=>'js:apiAfterValidate',
		),
	));
	?>

		<label>
			<b class="text-black">URL:</b>
			<?php echo $form->textField($apiExampleForm,'api_example',array('class'=>'your-url-input')); ?>
		</label>

		<?php echo CHtml::submitButton('Go', array('class'=>'url-submit')); ?>
		<?php echo $form->error($apiExampleForm,'api_example'); ?>

	<?php $this->endWidget(); ?>

	<div id="responseApi" style="display: none"></div>

</div>
<script language="javascript">
	function apiAfterValidate(form, data, hasError) {
		if(!hasError) {
			$('#responseApi').html(data.content).show();
			return false;
		}
		return true;
	}
</script>