<?php
/* @var $this IntegrationController */
/* @var $model Integration */

$this->breadcrumbs=array(
	'Integrations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Integration', 'url'=>array('index')),
	array('label'=>'Create Integration', 'url'=>array('create')),
	array('label'=>'Update Integration', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Integration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Integration', 'url'=>array('admin')),
);
?>

<h1>View Integration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'email',
		'site',
		'comment',
		'is_active',
		'create_date',
		'mod_date',
	),
)); ?>
