<?php

class WebsocketCommand extends CConsoleCommand
{
	public function __construct()
	{
		register_shutdown_function(array($this, 'shutdown'));
		Yii::app()->attachEventHandler('onError',array($this,'handleError'));
		Yii::app()->attachEventHandler('onException',array($this,'handleError'));
	}

	public function handleError(CEvent $event)
	{
		if ($event instanceof CExceptionEvent) {
			$this->actionStop();
		}
		elseif($event instanceof CErrorEvent) {
			$this->actionStop();
		}

		$event->handled = false;
	}

	public function shutdown()
	{
		if ($error = error_get_last()) {
			$this->actionStop();
			Yii::app()->end();
		}
	}

	public function actionStart()
    {
        $WebsocketServer = new WebsocketServer( (array) Yii::app()->websocket);
        $WebsocketServer->start();
    }

    public function actionStop()
    {
        $WebsocketServer = new WebsocketServer( (array) Yii::app()->websocket);
        $WebsocketServer->stop();
    }

    public function actionRestart()
    {
        $WebsocketServer = new WebsocketServer( (array) Yii::app()->websocket);
        $WebsocketServer->start();
        $WebsocketServer->stop();
    }

    public function actionTest()
    {
        $WebsocketClient = new WebsocketTest( (array) Yii::app()->websocket);
        $WebsocketClient->start();
    }
}