<?php
namespace btc\services\cryptsy;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'http://pubapi.cryptsy.com/';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'ltc')
	{
		$data = $this->query($this->getUrl('singlemarketdata', $currency_to, $currency_of));
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
	private function getUrl($method, $currency_to = 'btc', $currency_of = 'ltc')
	{
		return $this->base_url .'api.php?method='. $method .'&marketid='. $this->getIdPair($currency_to, $currency_of);
	}

	/**
	 * возвращает id пары валют по именам
	 *
	 * @param string $currency_to
	 * @param string $currency_of
	 * @return int
	 */
	private function getIdPair($currency_to = 'btc', $currency_of = 'ltc')
	{
		$currency = 3;
		if ($currency_to == 'btc' and $currency_of == 'ltc') {
			$currency = 3;
		}
		return $currency;
	}
}