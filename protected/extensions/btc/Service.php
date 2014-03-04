<?php
namespace btc;

class Service extends \CApplicationComponent
{
	/**
	 * @var array
	 */
	public $apiService = array(
		'btce' => array('class' => '\btc\services\btce\Api'),
		'bitstamp' => array('class' => '\btc\services\bitstamp\Api'),
		'btcchina' => array('class' => '\btc\services\btcchina\Api'),
	);

	/**
	 * @var string
	 */
	private $_serviceName = 'btce';

	/**
	 * @var null
	 */
	private $_serviceAdapter = null;

	/**
	 * вернет интерфейс api сервиса
	 *
	 * @return ApiBase
	 */
	public function getServiceAdapter()
	{
		if ($this->_serviceAdapter === null) {
			$this->setServiceAdapter();
		}
		return $this->_serviceAdapter;
	}

	/**
	 * назначить сервис api
	 *
	 * @param $name
	 */
	public function setServiceAdapter()
	{
		$this->_serviceAdapter = \Yii::createComponent($this->apiService[$this->_serviceName]);
	}

	/**
	 * назначить сервис api
	 *
	 * @param $name
	 */
	public function setService($name)
	{
		if (!isset($this->apiService[$name])) {
			throw new \Exception('Нет такого сервиса');
		}
		$this->_serviceName = $name;
		$this->setServiceAdapter();
	}

	/**
	 * получаем сообщения
	 */
	public function getMessageLog()
	{
		return $this->getServiceAdapter()->getMessageLog();
	}

	public function getTicker()
	{
		return $this->getServiceAdapter()->getTicker();
	}
}