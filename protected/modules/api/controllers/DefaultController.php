<?php

class DefaultController extends ApiController
{
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ApiRateIndex');
		$this->render('index',array(
			'data' => $dataProvider->getData()
		));
	}

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function loadModel($id)
	{
		$model=ApiRateIndex::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}