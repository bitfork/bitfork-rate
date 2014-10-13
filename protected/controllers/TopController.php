<?php
class TopController extends Controller
{
	public function actionIndex()
	{
		$result = null;
		$model=new TopForm;
		if(isset($_POST['TopForm']))
		{
			$model->attributes=$_POST['TopForm'];
			if($model->validate()) {
				$result = Pair::parseAllService($model->volume, $model->id_service_1, $model->id_service_2, $model->is_buy);
			}
		}
		$this->render('index',array('model'=>$model, 'result'=>$result));
	}
}
