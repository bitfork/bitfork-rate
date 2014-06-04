<?php
namespace btc\services\cryptsy;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'http://pubapi.cryptsy.com/';
	public $sercice_url = 'cryptsy.com';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'ltc')
	{
		$data = $this->query($this->getUrl('singlemarketdata', $currency_to, $currency_of));
		if ($data!==false and isset($data['return'],$data['return']['markets'],$data['return']['markets'][mb_strtoupper($currency_to, 'utf-8')])) {
			$data_market = $data['return']['markets'][mb_strtoupper($currency_to, 'utf-8')];
			$data = array();
			$data['last'] = $data_market['lasttradeprice'];
			$data['vol_cur'] = $data_market['volume'];
			$data['high'] = 0;
			$data['low'] = 0;
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
		$currency_to = mb_strtolower($currency_to, 'utf-8');
		$currency_of = mb_strtolower($currency_of, 'utf-8');
		$currency = 3;
		if ($currency_to == 'ltc' and $currency_of == 'btc') {
			$currency = 3;
		} elseif ($currency_to == 'btc' and $currency_of == 'usd') {
			$currency = 2;
		} elseif ($currency_to == 'vtc' and $currency_of == 'btc') {
			$currency = 151;
		} elseif ($currency_to == 'doge' and $currency_of == 'btc') {
			$currency = 132;
		} elseif ($currency_to == 'ppc' and $currency_of == 'btc') {
			$currency = 28;
		} elseif ($currency_to == 'drk' and $currency_of == 'btc') {
			$currency = 155;
		}
		return $currency;
	}
}