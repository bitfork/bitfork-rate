<?php
// cron
class CalculateCommand extends CConsoleCommand
{
	public function actionRun($period = null)
	{
		$client= new GearmanClient();
		$client->addServer('127.0.0.1', '4730');
		$pairs = Pair::model()->findAll();

		if ($period == 0) {
			while (1) {
				$this->doBackground($client, $period, $pairs);
				sleep(Yii::app()->params['sleep_step_calculate']);
			}
		} else {
			$this->doBackground($client, $period, $pairs);
		}

		return 0;
	}

	public function doBackground($client, $period, $pairs)
	{
		foreach ($pairs as $pair) {
			$client->doBackground('calculate-rate', json_encode(array('period'=>$period, 'pair'=>$pair->id)));
		}
	}
}