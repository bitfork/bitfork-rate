<?php
namespace btc\services\therocktrading;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://www.therocktrading.com/';
	public $sercice_url = 'therocktrading.com';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$currency_to = mb_strtoupper($currency_to, 'utf-8');
		$currency_of = mb_strtoupper($currency_of, 'utf-8');
		$data_market = $this->query($this->getUrl('ticker', $currency_to, $currency_of));
		if ($data_market!==false and isset($data_market['result'], $data_market['result'][0])) {
			$data_market = $data_market['result'][0];
			$data = array();
			$data['last'] = $data_market['last'];
			$data['vol_cur'] = $data_market['volume'];
			$data['high'] = $data_market['high'];
			$data['low'] = $data_market['low'];
			return $data;
		}
		$this->setMessageLog(__CLASS__ .' - getTicker не наден нужный елемент');
		return false;
	}

	/**
	 * Возвращает url к api
	 *
	 * @param $method
	 * @param $currency
	 * @return string
	 */
	private function getUrl($method, $currency_to, $currency_of)
	{
		return $this->base_url .'api/'. $method .'/'. $currency_to . $currency_of;
	}
}