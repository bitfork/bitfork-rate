<?php
namespace btc\services\bitkonan;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://bitkonan.com/';
	public $sercice_url = 'bitkonan.com';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$data_market = $this->query($this->getUrl());
		if ($data_market!==false) {
			$data = array();
			$data['last'] = $data_market['last'];
			$data['vol_cur'] = $data_market['volume'];
			$data['high'] = $data_market['high'];
			$data['low'] = $data_market['low'];
			return $data;
		}
		$this->setMessageLog(__CLASS__ .' - getTicker не наден нужный елемент');
		return false;
	}

	/**
	 * Возвращает url к api
	 * @return string
	 */
	private function getUrl()
	{
		return $this->base_url .'api/ticker';
	}
}