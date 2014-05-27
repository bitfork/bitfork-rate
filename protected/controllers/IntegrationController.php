<?php

class IntegrationController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Integration;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Integration']))
		{
			$model->attributes=$_POST['Integration'];
			$return = $model->save();

			if(Yii::app()->request->isAjaxRequest){
				if ($return===true) {
					echo CJSON::encode(array('content'=>"Заявка отправленна!"));
				} else {
					echo CJSON::encode(array('error'=>Yii::t('main', 'ошибка')));
				}
				Yii::app()->end();
			} else {
				if($return===true)
					$this->redirect(array('view','id'=>$model->id));
			}
		}

		if(Yii::app()->request->isAjaxRequest){
			$this->renderPartial('create', array('model'=>$model), false, true);
		} else {
			$this->render('create', array('model'=>$model));
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param Integration $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			$error = CActiveForm::validate($model);
			if ($error != '[]') {
				echo $error;
				Yii::app()->end();
			}
		}
	}
}
