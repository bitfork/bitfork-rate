<?php
/* @var $this IntegrationController */
/* @var $model Integration */

$this->breadcrumbs=array(
	'Integrations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Integration', 'url'=>array('index')),
	array('label'=>'Create Integration', 'url'=>array('create')),
	array('label'=>'View Integration', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Integration', 'url'=>array('admin')),
);
?>

<h1>Update Integration <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>