<?php
namespace btc\services\bitstamp;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://www.bitstamp.net/';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$data = $this->query($this->getUrl('ticker'));
		if ($data!==false) {
			$data['vol_cur'] = $data['volume'];
			unset($data['volume']);
			$data['buy'] = $data['bid'];
			unset($data['bid']);
			$data['sell'] = $data['ask'];
			unset($data['ask']);
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
		return $this->base_url .'api/'. $method .'/';
	}
}