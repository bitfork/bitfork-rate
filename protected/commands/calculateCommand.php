<?php
// cron
class CalculateCommand extends CConsoleCommand
{
	public function actionRun($period = null)
	{
		$client= new GearmanClient();
		$client->addServer('127.0.0.1', '4730');
		$pairs = Pair::model()->findAll();
		foreach ($pairs as $pair) {
			$client->doBackground('calculate-rate', json_encode(array('period'=>$period, 'pair'=>$pair->id)));
		}
	}
}