<?php $form=$this->beginWidget('CActiveForm', array(
	'enableAjaxValidation'=>true,
	'action'=>$this->createUrl('/course/apiExample'),
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>true,
		'beforeValidate'=>'js:apiBeforeValidate',
		'afterValidate'=>'js:apiAfterValidate',
	),
));
$rand = rand(0,99);
?>
<table class="table-bordless">
	<tbody>
	<tr>
		<td><h3><?php echo Yii::t('main', 'Get запрос'); ?>:</h3></td>
		<td>
			<?php echo $form->textField($apiExampleForm,'api_example',array('class'=>'inp-mid')); ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<td><h3><?php echo Yii::t('main', 'Ответ в формате JSON'); ?>:</h3></td>
		<td>
			<textarea class="inp-mid textarea-mid responseApi"></textarea>
		</td>
		<td>
			<a class="ico-reload" title="<?php echo Yii::t('main', 'Обновить код'); ?>" href="javascript:;" onclick="$('#form-submit-example<?php echo $rand; ?>').trigger('click');return false;"></a>
			<?php echo CHtml::submitButton('', array('id'=>'form-submit-example'.$rand, 'style'=>'display:none;')); ?>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<?php echo $form->error($apiExampleForm,'api_example'); ?>
		</td>
	</tr>
	</tbody>
</table>
<?php $this->endWidget(); ?>