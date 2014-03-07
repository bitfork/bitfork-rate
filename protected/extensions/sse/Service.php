<?php
/**
 * Server Sent Events
 *
 * config - YiiBase::setPathOfAlias('sse', realpath(__DIR__ . '/../extensions/sse'));
 * controller -
 *	public function actionSse()
 *	{
 *		$r = new \sse\Service();
 *		$r->run();
 *	}
 * view - <?php Yii::app()->clientScript->registerScriptFile('/js/sse.js'); ?>
 * send - \sse\Service::setMessage('message');
 */

namespace sse;

class Service
{
	public $sleep = 1; // количество секунд задержки при каждой итерации
	public $retry = 2000; // переподключится через 2000 милисекунд
	public $count_step = 20; // количество шагов в цыкле
	public static $cache_id = 'sse_data'; // метка кеша где лежат данные

	/**
	 * установка необходимых заголовков
	 */
	private function showHeader()
	{
		header("Content-Type: text/event-stream");
		header("Cache-Control: no-cache");
		header("Access-Control-Allow-Origin: *");
	}

	/**
	 * запуск цыкла
	 */
	public function run()
	{
		$this->showHeader();
		$i = 0;
		while (++$i < $this->count_step) {
			$this->getMessage();
			sleep($this->sleep);
		}
	}

	/**
	 * вывод сообщения
	 *
	 * @param $data
	 * @param null $event
	 */
	public function sendMessage($data, $event = null)
	{
		if (is_array($data)) {
			$data = json_encode($data);
		}
		echo ":" . str_repeat(" ", 2048) . "\n"; // 2 kB padding for IE
		echo "retry: ". $this->retry ."\n";
		if ($event!==null) {
			echo "event: ". $event ."\n"; // если нужно вызвать конкретное событие
		}
		echo "data:". $data ."\n\n";
		ob_flush();
		flush();
	}

	/**
	 * получить сообщение
	 */
	public function getMessage()
	{
		$value = \Yii::app()->cache->get(self::$cache_id);
		if ($value!==false) {
			\Yii::app()->cache->delete(self::$cache_id);
			$this->sendMessage($value);
		}
	}

	/**
	 * записать сообщение для рассылки
	 *
	 * @param $value
	 */
	public static function setMessage($value)
	{
		\Yii::app()->cache->set(self::$cache_id, $value);
	}
}