<?php

class WebsocketDaemonHandler extends WebsocketDaemon
{
	protected $users = array();

	//вызывается при соединении с новым клиентом
    protected function onOpen($connectionId)
	{

    }

	//вызывается при закрытии соединения клиентом
    protected function onClose($connectionId)
	{
		if ($id_user = array_search($connectionId, $this->users)) {
			unset($this->users[$id_user]);
		}
    }

	//вызывается при получении сообщения от клиента
	protected function onMessage($connectionId, $data, $type)
	{
		if (!strlen($data)) {
			return;
		}

		if ($id_user = array_search($connectionId, $this->users)) {
			$message = 'пользователь_#' . $id_user . ' (' . $this->pid . '): ' . strip_tags($data);
			$this->sendPacketToClients('message', $message);
		} else {
			if (($user = @json_decode($data, true)) && is_array($user) && isset($user['id_user'],$user['token'])) {
				if (Yii::app()->tokenManager->checkToken('user', $user['id_user'], $user['token'])) {
					$this->users[$user['id_user']] = $connectionId;
					$this->sendPacketToClient($connectionId, 'message', 'hello');
				}
			}
		}

		/*if (($data_message = @json_decode($data, true)) && is_array($data_message)) {
			$this->sendPacketToClients('data', $data_message);
		} else {
			$message = 'пользователь_#' . $connectionId . ' (' . $this->pid . '): ' . strip_tags($data);
			$this->sendPacketToClients('message', $message);
		}*/

		//$this->sendPacketToClient($connectionId, 'message', 'только для меня');
		//$this->sendPacketToClient($connectionId, 'data', array('update'=>array('Page'=>'full')));
	}

	private function sendPacketToClients($cmd, $data)
	{
		$data = $this->pack($cmd, $data);
		foreach ($this->clients as $connectionId) {
			$this->sendToClient($connectionId, $data);
		}
	}

	protected function sendPacketToClient($connectionId, $cmd, $data)
	{
		$this->sendToClient($connectionId, $this->pack($cmd, $data));
	}

	public function pack($cmd, $data)
	{
		return json_encode(array('cmd' => $cmd, 'data' => $data));
	}

	//вызывается при получении сообщения от скриптов
    protected function onServiceMessage($connectionId, $data)
	{
		if (($data_send = @json_decode($data, true)) && is_array($data_send)) {
			if (isset($data_send['id_user'])) {
				if (isset($this->users[$data_send['id_user']])) {
					$user_connectionId = $this->users[$data_send['id_user']];
					unset($data_send['id_user']);
					$this->sendPacketToClient($user_connectionId, 'data', $data_send);
				}
			} else {
				$this->sendPacketToClients('data', $data_send);
			}
		} else {
			$this->sendPacketToClients('message', $data);
		}
    }
}