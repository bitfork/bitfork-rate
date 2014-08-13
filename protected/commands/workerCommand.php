<?php
class WorkerCommand extends CConsoleCommand
{
	public function calculate($job)
	{
		$workload = $job->workload();
		$data = json_decode($workload, true);
		Course::calculateIndex($data['pair'], $data['period']);
	}
		
	public function actionRun()
	{
		$worker = new GearmanWorker();
		$worker->addServer("127.0.0.1", 4730);

		$worker->addFunction('calculate-rate', array($this, 'calculate'));

		while (1)
		{
			$ret = $worker->work();
			if ($worker->returnCode() != GEARMAN_SUCCESS) break;
		}
	}
}