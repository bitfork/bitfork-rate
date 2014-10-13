<?php
class TopController extends Controller
{
	public function actionIndex()
	{
		$this->pageTitle=Yii::t('main', 'Анализатор цен на покупку Bitcoin, Litecoin, Darkcoin на популярных биржах | Bitfork-rate.com');

		$result = null;
		$currency_1 = null;
		$currency_2 = null;
		$model=new TopForm;
		$model->is_buy = 1;
		$model->id_service_1 = 2;
		$model->id_service_2 = 1;
		$model->volume = 0.3;
		if(isset($_POST['TopForm']))
		{
			$model->attributes=$_POST['TopForm'];
			if($model->validate()) {
				$result = Pair::parseAllService($model->volume, $model->id_service_1, $model->id_service_2, $model->is_buy);
				$currency_1 = Currency::model()->findByPk($model->id_service_1);
				$currency_2 = Currency::model()->findByPk($model->id_service_2);
			}
		}
		$this->render('index',array(
			'model'=>$model,
			'result'=>$result,
			'currency_1'=>$currency_1,
			'currency_2'=>$currency_2,
		));
	}
}
