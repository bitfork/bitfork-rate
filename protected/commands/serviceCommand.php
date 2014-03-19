<?php
class ServiceCommand extends CConsoleCommand
{
	private $_pidFile = '.pid';
	private $_sleep = 3;

	public function __construct()
	{
		$this->_pidFile = Yii::app()->getRuntimePath().'/'.$this->_pidFile;
		register_shutdown_function(array($this, 'shutdown'));
		Yii::app()->attachEventHandler('onError',array($this,'handleError'));
		Yii::app()->attachEventHandler('onException',array($this,'handleError'));
	}

	public function handleError(CEvent $event)
	{
		if ($event instanceof CExceptionEvent) {
			$this->stopProcess();
		}
		elseif($event instanceof CErrorEvent) {
			$this->stopProcess();
		}

		$event->handled = false;
	}

	public function shutdown()
	{
		if ($error = error_get_last()) {
			$this->stopProcess();
			Yii::app()->end();
		}
	}

	public function stopProcess()
	{
		@unlink($this->_pidFile);
	}

	public function startProcess()
	{
		@file_put_contents($this->_pidFile, '');
	}

	public function isProcess()
	{
		if (file_exists($this->_pidFile)) {
			return true;
		}
		return false;
	}

	public function actionRun()
	{
		if ($this->isProcess()) {
			echo "процесс уже запущен";
			Yii::app()->end();
		}
		$this->startProcess();

		$i = 0;
		while ($i<Yii::app()->params['count_step_service_run']) {
			// собрать данные со всех сервисов
			Course::parseAllService();
			// расчет индекса для каждой комбинации
			Course::calculateIndex();
			//echo $i;
			$i++;
			sleep($this->_sleep);
		}
		echo "stop";

		$this->stopProcess();
	}
}