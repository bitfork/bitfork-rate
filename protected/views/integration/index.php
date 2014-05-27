<?php
/* @var $this IntegrationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Integrations',
);

$this->menu=array(
	array('label'=>'Create Integration', 'url'=>array('create')),
	array('label'=>'Manage Integration', 'url'=>array('admin')),
);
?>

<h1>Integrations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
