<?php
namespace btc\services\kraken;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://api.kraken.com/';
	public $sercice_url = 'kraken.com';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$currency_to = $this->getCurrency($currency_to);
		$currency_of = $this->getCurrency($currency_of);
		$currency = $currency_to . $currency_of;
		$data = $this->query($this->getUrl('Ticker'), array('pair'=>$currency));

		if (isset($data['result'], $data['result']['X'.$currency_to.'Z'.$currency_of])) {
			$cur = $data['result']['X'.$currency_to.'Z'.$currency_of];
			$data = array();
			$data['high'] = $cur['h'][1];
			$data['low'] = $cur['l'][1];
			$data['vol_cur'] = $cur['v'][1];
			$data['last'] = $cur['c'][0];
			$data['buy'] = $cur['a'][1];
			$data['sell'] = $cur['b'][1];
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
	private function getUrl($method)
	{
		return $this->base_url .'0/public/'. $method;
	}

	/**
	 * вернет валюту как на серрвисе
	 * @param $currency
	 * @return string
	 */
	private function getCurrency($currency)
	{
		$currency = mb_strtoupper($currency, 'utf-8');
		if ($currency == 'BTC') {
			return 'XBT';
		}
		return $currency;
	}
}