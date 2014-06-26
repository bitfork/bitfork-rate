<?php
namespace btc\services\itbit;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://www.itbit.com/';
	public $sercice_url = 'itbit.com';

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

		$data = $this->query($this->getUrl('ticker', $currency_to, $currency_of));

		if ($data!==false) {
			$data_market = $data;
			$data = array();
			$data['vol_cur'] = $data_market['volume'];
			$data['high'] = $data_market['high'];
			$data['low'] = $data_market['low'];

			$last_price = $this->query($this->getUrl('trades', $currency_to, $currency_of));
			if (isset($last_price[0], $last_price[0]['price'])) {
				$data['last'] = (float)$last_price[0]['price'];
				return $data;
			}
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
		if ($method=='trades')
			return $this->base_url .'api/v2/markets/'. $currency_to . $currency_of .'/trades?since=0';
		return $this->base_url .'api/feeds/'. $method .'/'. $currency_to . $currency_of;
	}

	private function getCurrency($currency)
	{
		$currency = mb_strtoupper($currency, 'utf-8');
		if ($currency == 'BTC') {
			$currency = 'XBT';
		}
		return $currency;
	}
}