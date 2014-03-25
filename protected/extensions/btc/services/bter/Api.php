<?php
namespace btc\services\bter;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'http://data.bter.com/';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'ltc')
	{
		$data = $this->query($this->getUrl('ticker', $currency_to, $currency_of));
		if ($data!==false and $data['result']!==false) {
			unset($data['result']);
			$data['vol_cur'] = $data['vol_'. mb_strtolower($currency_to, 'utf-8')];
			unset($data['vol_'. mb_strtolower($currency_to, 'utf-8')]);
			unset($data['vol_'. mb_strtolower($currency_of, 'utf-8')]);
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
	private function getUrl($method, $currency_to = 'btc', $currency_of = 'ltc')
	{
		return $this->base_url .'api/1/'. $method .'/'. $this->getIdPair($currency_to, $currency_of);
	}

	private function getIdPair($currency_to = 'btc', $currency_of = 'ltc')
	{
		return mb_strtolower($currency_to, 'utf-8') .'_'. mb_strtolower($currency_of, 'utf-8');
	}
}