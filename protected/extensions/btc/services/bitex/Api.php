<?php
namespace btc\services\bitex;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://bitex.la/';
	public $sercice_url = 'bitex.la';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$currency_to = mb_strtolower($currency_to, 'utf-8');
		$data_market = $this->query($this->getUrl('ticker', $currency_to));
		if ($data_market!==false) {
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
	private function getUrl($method, $currency_to)
	{
		return $this->base_url .'api-v1/rest/'. $currency_to .'/market/'. $method;
	}
}