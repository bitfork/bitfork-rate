<?php
namespace btc\services\vircurex;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://api.vircurex.com/';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'ltc')
	{
		$data = $this->query($this->getUrl('get_info_for_currency'));
		if ($data!==false and isset($data[mb_strtoupper($currency_to, 'utf-8')], $data[mb_strtoupper($currency_to, 'utf-8')][mb_strtoupper($currency_of, 'utf-8')])) {
			$data = $data[mb_strtoupper($currency_to, 'utf-8')][mb_strtoupper($currency_of, 'utf-8')];

			$data['last'] = $data['last_trade'];
			unset($data['last_trade']);
			$data['vol_cur'] = $data['volume'];
			unset($data['volume']);
			$data['high'] = $data['highest_bid'];
			unset($data['highest_bid']);
			$data['low'] = $data['lowest_ask'];
			unset($data['lowest_ask']);
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
		return $this->base_url .'api/'. $method .'.json';
	}
}