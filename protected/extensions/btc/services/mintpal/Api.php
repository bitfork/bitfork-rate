<?php
namespace btc\services\mintpal;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://api.mintpal.com/';
	public $sercice_url = 'mintpal.com';

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
		$data = $this->query($this->getUrl('stats', $currency_to, $currency_of));
		if (isset($data[0])) {
			$data_market = $data[0];
			$data = array();
			$data['last'] = $data_market['last_price'];
			$data['vol_cur'] = $data_market['24hvol'];
			$data['high'] = $data_market['24hhigh'];
			$data['low'] = $data_market['24hlow'];
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
		return $this->base_url .'v1/market/'. $method .'/'. $currency_to .'/'. $currency_of;
	}
}