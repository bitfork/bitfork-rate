<?php

class Websocket extends CApplicationComponent
{
    public $class = 'WebsocketDaemonHandler';
    public $pid = '/websocket_chat.pid';
    public $websocket = 'tcp://127.0.0.1:8000';
    public $localsocket = 'tcp://127.0.0.1:8001';
    public $master = '';//tcp://127.0.0.1:8020
    public $eventDriver = 'event';

    protected $instance = null;

    public function getInstance() {
        if (!$this->instance) {
            //$this->instance = stream_socket_client ($this->getOwner()->localsocket, $errno, $errstr);//соединямся с мастер-процессом:
            $this->instance = @stream_socket_client ($this->localsocket, $errno, $errstr);//соединямся с мастер-процессом:
			if ($this->instance===false){
				Yii::log("ERROR: " . $errno ." - ". $errstr, CLogger::LEVEL_WARNING, __METHOD__);
			}
        }
        return $this->instance;
    }

    //можно вызывать из своих скриптов
    //отправляет данные в мастер, который перенаправляет их во все воркеры, которые пересылают клиентам
    public function send($message)
	{
		if (is_array($message)) {
			$message = json_encode($message);
		}
		$instance = $this->getInstance();
		if ($instance===false) {
			return false;
		}
        return fwrite($instance, $message . "\n");
    }
}