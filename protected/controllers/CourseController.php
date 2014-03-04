<?php
class CourseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function actionIndex($period = null)
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
		if ($period != 1 and $period != 24 and $period != 168) {
			$period = 1;
		}
		$date_start = new DateTime();
		$date_start->modify('-'. $period .' hour');
		$date_start = $date_start->format('Y-m-d H:i:s');

		$data = Course::model()->getAvgData(
			$date_start,
			date('Y-m-d H:i:s'),
			Yii::app()->session['select_services']
		);

		// список сервисов для формы
		$servicesAll = Service::model()->findAll();
		if (Yii::app()->session['select_services']===null) {
			foreach ($servicesAll as $service) {
				$modelForm->services[] = $service->id;
			}
			$servicesList = CHtml::listData($servicesAll, 'id', 'name');
		} else {
			$modelForm->services = Yii::app()->session['select_services'];
			$servicesList = CHtml::listData($servicesAll, 'id', 'name');
		}

		$this->render('index', array('index'=>$data[0], 'data'=>$data[1], 'period'=>$period, 'modelForm'=>$modelForm, 'servicesList'=>$servicesList));
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
