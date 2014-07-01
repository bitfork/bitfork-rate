<?php
namespace btc;

class Service extends \CApplicationComponent
{
	/**
	 * @var array
	 */
	public $apiService = array(
		'btce'		=> array('class' => '\btc\services\btce\Api'),
		'bitstamp'	=> array('class' => '\btc\services\bitstamp\Api'),
		'btcchina'	=> array('class' => '\btc\services\btcchina\Api'),
		'vircurex'	=> array('class' => '\btc\services\vircurex\Api'),
		'cryptsy'	=> array('class' => '\btc\services\cryptsy\Api'),
		'bter'		=> array('class' => '\btc\services\bter\Api'),
		'kraken'	=> array('class' => '\btc\services\kraken\Api'),
		'goc'	=> array('class' => '\btc\services\goc\Api'),
		'cryptotrade'	=> array('class' => '\btc\services\cryptotrade\Api'),
		'mcxnow'	=> array('class' => '\btc\services\mcxnow\Api'),
		'mintpal'	=> array('class' => '\btc\services\mintpal\Api'),
		'cryptonit'	=> array('class' => '\btc\services\cryptonit\Api'),
		'itbit'	=> array('class' => '\btc\services\itbit\Api'),
		'bitfinex'	=> array('class' => '\btc\services\bitfinex\Api'),
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

	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		return $this->getServiceAdapter()->getTicker($currency_to, $currency_of);
	}

	public function getDepth($currency_to = 'btc', $currency_of = 'usd')
	{
		return $this->getServiceAdapter()->getDepth($currency_to, $currency_of);
	}

	public function getBaseUrl()
	{
		return $this->getServiceAdapter()->getBaseUrl();
	}
}