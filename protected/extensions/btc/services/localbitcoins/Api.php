<?php
namespace btc\services\localbitcoins;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://localbitcoins.com/';
	public $sercice_url = 'localbitcoins.com';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$data_market = $this->query($this->getUrl('ticker-all-currencies'));
		if ($data_market!==false and isset($data_market['USD'])) {
			$data = array();
			$data['last'] = $data_market['USD']['rates']['last'];
			$data['vol_cur'] = $data_market['USD']['volume_btc'];
			$data['high'] = 1;
			$data['low'] = 1;
			return $data;
		}
		$this->setMessageLog(__CLASS__ .' - getTicker не наден нужный елемент');
		return false;
	}

	/**
	 * Возвращает url к api
	 *
	 * @param $method
	 * @return string
	 */
	private function getUrl($method)
	{
		return $this->base_url .'bitcoinaverage/'. $method .'/';
	}
}