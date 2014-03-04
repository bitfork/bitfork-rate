<?php
namespace btc\services\btcchina;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://data.btcchina.com/';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$currency = mb_strtolower($currency_to .'_'. $currency_of, 'utf-8');
		$data = $this->query($this->getUrl('ticker'));
		if (isset($data['ticker'])) {
			$data = $data['ticker'];
			$data['vol_cur'] = $data['vol'];
			unset($data['vol']);
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
		return $this->base_url .'data/'. $method;
	}
}