<?php
namespace btc\services\btce;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://btc-e.com/';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$currency = mb_strtolower($currency_to .'_'. $currency_of, 'utf-8');
		$data = $this->query($this->getUrl('ticker', $currency));
		if (isset($data['ticker'])) {
			$data = $data['ticker'];
			$data['updated'] = date('Y-m-d H:i:s', $data['updated']);
			$data['server_time'] = date('Y-m-d H:i:s', $data['server_time']);
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
	private function getUrl($method, $currency)
	{
		return $this->base_url .'api/2/'. $currency .'/'. $method;
	}
}