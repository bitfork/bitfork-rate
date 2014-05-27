<?php
/* @var $this IntegrationController */
/* @var $model Integration */

$this->breadcrumbs=array(
	'Integrations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Integration', 'url'=>array('index')),
	array('label'=>'Manage Integration', 'url'=>array('admin')),
);
?>

<h1>Create Integration</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>