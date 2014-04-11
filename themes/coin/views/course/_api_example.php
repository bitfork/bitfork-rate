<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'api-form',
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
?>
<table id="index-APItable" class="table-form table-bordless">
	<tbody>
	<tr>
		<td><h3>URL:</h3></td>
		<td>
			<?php echo $form->textField($apiExampleForm,'api_example',array('class'=>'inp-mid')); ?>
		</td>
		<td>
			<a class="ico-code" title="<?php echo Yii::t('main', 'Сгенерировать код'); ?>" href="javascript:;" onclick="$('#form-submit-example').trigger('click');return false;"></a>
		</td>
	</tr>
	<tr>
		<td><h3>JSON:</h3></td>
		<td>
			<textarea id="responseApi" class="inp-mid textarea-mid"></textarea>
		</td>
		<td>
			<a class="ico-reload" title="<?php echo Yii::t('main', 'Обновить код'); ?>" href="javascript:;" onclick="$('#form-submit-example').trigger('click');return false;"></a>
			<?php echo CHtml::submitButton('', array('id'=>'form-submit-example', 'style'=>'display:none;')); ?>
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
<script language="javascript">
	function apiBeforeValidate(form) {
		$('#responseApi').val('');
		return true;
	}
	function apiAfterValidate(form, data, hasError) {
		if(!hasError) {
			$('#responseApi').val(data.content);
			return false;
		}
		return true;
	}
</script>