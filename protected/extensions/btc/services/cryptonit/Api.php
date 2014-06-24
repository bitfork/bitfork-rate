<?php
namespace btc\services\cryptonit;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'http://www.cryptonit.net/';
	public $sercice_url = 'cryptonit.net';

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

		$data = array();

		$last = $this->query($this->getUrl('&rate', $currency_to, $currency_of), null, array("Accept: application/json"));
		if (!isset($last[0])) {
			$this->setMessageLog(__CLASS__ .' - ticker не наден нужный елемент');
			return false;
		}
		$data['last'] = $last[0];

		$vol = $this->query($this->getUrl('&volume', $currency_to, $currency_of), null, array("Accept: application/json"));
		if (!isset($vol[$currency_to])) {
			$this->setMessageLog(__CLASS__ .' - ticker не наден нужный елемент');
			return false;
		}
		$data['vol_cur'] = $vol[$currency_to];

		$data['high'] = 0;
		$data['low'] = 0;

		return $data;
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
		return $this->base_url .'apiv2/rest/public/ccorder?bid_currency='. $currency_to .'&ask_currency='. $currency_of . $method;
	}
}