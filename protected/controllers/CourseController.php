<?php
class CourseController extends Controller
{
	public function actionIndex($pair = null, $period = null)
	{
		// выбранные сервисы
		$modelForm=new ServicesForm;
		if(isset($_POST['ServicesForm']))
		{
			$modelForm->attributes=$_POST['ServicesForm'];
			if($modelForm->validate())
			{
				Yii::app()->session['select_services'] = $modelForm->services;
			}
		}

		// выбранный период
		$period = (int)$period;
		if (!in_array($period, Course::$periods)) {
			$period = 0;
		}

		if ($pair===null) {
			$pair = 1;
		}
		$pair = Pair::model()->findByPk($pair);
		if ($pair!==null) {
			// список сервисов для формы
			$servicesAll = ServicePair::model()->findAll('id_pair=:id_pair', array(':id_pair'=>$pair->id));

			// выбранные снрвисы
			if (Yii::app()->session['select_services_'.$pair->id]===null) {
				foreach ($servicesAll as $service) {
					$modelForm->services[] = $service->id_service;
				}
				Yii::app()->session['select_services_'.$pair->id] = $modelForm->services;
				$servicesList = CHtml::listData($servicesAll, 'id_service', 'id_pair');
			} else {
				$modelForm->services = Yii::app()->session['select_services_'.$pair->id];
				$servicesList = CHtml::listData($servicesAll, 'id_service', 'id_pair');
			}

			$data[0] = RateIndex::getDateIndex($pair->id_currency_from, $pair->id_currency, 0, $modelForm->services);
			$data[1] = RateIndex::getDateIndex($pair->id_currency_from, $pair->id_currency, 1, $modelForm->services);
			$data[24] = RateIndex::getDateIndex($pair->id_currency_from, $pair->id_currency, 24, $modelForm->services);
			$range = false;
			if ($period > 0) {
				$range = RateIndex::getRangeIndex($pair->id_currency_from, $pair->id_currency, $period, $modelForm->services);
			}
		} else {
			throw new CHttpException(404, 'Not Found');
		}

		$apiExampleForm=new ApiExampleForm;

		$this->render('index', array(
			'period'=>$period,
			'data'=>$data,
			'range'=>$range,
			'pair'=>$pair,
			'apiExampleForm'=>$apiExampleForm,
			'modelForm'=>$modelForm,
			'servicesList'=>$servicesList,
		));
	}

	public function actionApiExample()
	{
		$modelForm=new ApiExampleForm;
		$this->performAjaxValidation($modelForm);
		if(isset($_POST['ApiExampleForm']))
		{
			$modelForm->attributes=$_POST['ApiExampleForm'];
			$modelForm->api_example = str_replace('http://', '', $modelForm->api_example);
			$modelForm->api_example = str_replace('https://', '', $modelForm->api_example);
			$modelForm->api_example = 'http://'. $modelForm->api_example;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.1) Gecko');
			curl_setopt($ch, CURLOPT_URL, $modelForm->api_example);
			$data = curl_exec($ch);
			echo CJSON::encode(array('content'=>"<pre>".$data."</pre>"));
		}
		Yii::app()->end();
	}

	/**
	 * Performs the AJAX validation.
	 * @param Staff $model the model to be validated
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

	public function actionParse($id = 'btce')
	{
		$exchange = Yii::app()->exchange;
		$exchange->setService($id);
		$results = $exchange->getTicker();
		if ($results!==false) {
			$model = new Course;
			$model->attributes=$results;
			if ($id == 'btce')
				$model->id_service = Course::BTCE;
			if ($id == 'bitstamp')
				$model->id_service = Course::BITSTAMP;
			if ($id == 'btcchina')
				$model->id_service = Course::BTCCHINA;
			$model->id_currency = Course::USD;
			if (!$model->save()) {
				echo "<pre>";
				print_r($model->getErrors());
				echo "</pre>";
			}
		} else {
			$results = $exchange->getMessageLog();
		}

		$this->render('parse', array('results'=>$results));
	}
}
