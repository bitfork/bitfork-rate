<?php
class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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

			$data = RateIndex::getDateIndex($pair->id_currency_from, $pair->id_currency, $period, $modelForm->services);
			$range = RateIndex::getRangeIndex($pair->id_currency_from, $pair->id_currency, $period, $modelForm->services);
		} else {
			throw new CHttpException(404, 'Not Found');
		}
		$this->render('index', array(
			'index'=>$data['index'],
			'range'=>$range,
			'data'=>$data['services'],
			'period'=>$period,
			'modelForm'=>$modelForm,
			'servicesList'=>$servicesList,
		));
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
