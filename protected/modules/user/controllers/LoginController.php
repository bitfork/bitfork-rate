<?php

class LoginController extends Controller
{
	public $defaultAction = 'login';

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$this->loginAjax();
			Yii::app()->end();
		}

		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			$model->rememberMe = true;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
					if (Yii::app()->user->returnUrl=='/index.php')
						$this->redirect(Yii::app()->controller->module->returnUrl);
					else
						$this->redirect(Yii::app()->user->returnUrl);
				}
			}
			// display the login form
			$this->render('/user/login',array('model'=>$model));
		} else
			$this->redirect(Yii::app()->controller->module->returnUrl);
	}

	private function loginAjax()
	{
		$model=new UserLogin;
		$model->rememberMe = true;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='form-enter')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['UserLogin']))
		{
			$model->attributes=$_POST['UserLogin'];
			// validate user input and redirect to the previous page if valid
			if($model->validate()) {
				$this->lastViset();
				if (strpos(Yii::app()->user->returnUrl,'/index.php')!==false)
					$this->controller->refresh();
				else
					$this->controller->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		echo $this->renderPartial('/user/login_ajax',array('model'=>$model));
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}