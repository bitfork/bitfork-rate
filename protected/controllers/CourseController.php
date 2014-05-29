<?php
class CourseController extends Controller
{
	public function actionIndex($from = 'BTC', $to = 'USD', $period=0)
	{
		$pair = $this->getPair($from, $to, $period);

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
		$data[60] = RateIndex::getDateIndex($pair->id_currency_from, $pair->id_currency, 60, $modelForm->services);
		$data[1440] = RateIndex::getDateIndex($pair->id_currency_from, $pair->id_currency, 1440, $modelForm->services);
		$range = false;
		if ($period > 0) {
			$range = RateIndex::getRangeIndex($pair->id_currency_from, $pair->id_currency, $period, $modelForm->services);
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
			'linkProject'=>new LinkProject,
		));
	}

	public function actionApiExample()
	{
		$modelForm=new ApiExampleForm;
		$this->performAjaxValidation($modelForm);
		if(isset($_POST['ApiExampleForm']))
		{
			$modelForm->attributes=$_POST['ApiExampleForm'];
			$modelForm->api_example = str_replace('http://www.', '', $modelForm->api_example);
			$modelForm->api_example = str_replace('http://', '', $modelForm->api_example);
			$modelForm->api_example = str_replace('https://www.', '', $modelForm->api_example);
			$modelForm->api_example = str_replace('https://', '', $modelForm->api_example);
			$modelForm->api_example = 'http://www.'. $modelForm->api_example;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.8.0.1) Gecko');
			curl_setopt($ch, CURLOPT_URL, $modelForm->api_example);
			$data = curl_exec($ch);
			echo CJSON::encode(array('content'=>$data));
		}
		Yii::app()->end();
	}

	public function actionLinkProject()
	{
		$model=new LinkProject;
		$this->performAjaxValidation($model);
		if(isset($_POST['LinkProject']))
		{
			$model->attributes=$_POST['LinkProject'];
			if ($model->save()) {
				echo CJSON::encode(array('content'=>"Заявка отправленна"));
			}
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

	private function getPair($from, $to, $period)
	{
		$currency = mb_strtoupper($to, 'utf-8');
		$currency_from = mb_strtoupper($from, 'utf-8');

		if (!in_array($period, Course::$periods)) {
			throw new CHttpException(404, 'Not Found');
		}
		$criteria = new CDbCriteria;
		$criteria->addInCondition('name', array($currency, $currency_from));
		$currencys = Currency::model()->findAll($criteria);
		foreach ($currencys as $cur) {
			if ($cur->name == $currency) $id_currency = $cur->id;
			if ($cur->name == $currency_from) $id_currency_from = $cur->id;
		}
		if (!isset($id_currency) or !isset($id_currency_from)) {
			throw new CHttpException(404, 'Not Found');
		}
		$pair = Pair::model()->find(
			'id_currency=:id_currency and id_currency_from=:id_currency_from',
			array(':id_currency'=>$id_currency, ':id_currency_from'=>$id_currency_from)
		);
		if ($pair===null) {
			throw new CHttpException(404, 'Not Found');
		}

		return $pair;
	}
}
