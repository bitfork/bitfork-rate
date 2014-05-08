<?php
// cron
class ArchiveCommand extends CConsoleCommand
{
	public function actionRun()
	{
		RateIndex::partition();
		Course::partition();
		
		echo "stop";
	}
}