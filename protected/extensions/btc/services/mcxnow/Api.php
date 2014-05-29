<?php
namespace btc\services\mcxnow;

use btc\services\ApiBase;

class Api extends ApiBase
{
	private $base_url = 'https://mcxnow.com/';
	public $sercice_url = 'mcxnow.com';

	/**
	 * Возвращает краткую информацию о состоянии биржи.
	 *
	 * @param string $currency
	 * @return bool|mixed
	 */
	public function getTicker($currency_to = 'btc', $currency_of = 'usd')
	{
		$data = $this->query($this->getUrl('orders', mb_strtoupper($currency_to, 'utf-8')), null, null, true);

		$xml = new \SimpleXMLElement($data);
		$data = json_decode(json_encode($xml), true);

		if (isset($data['lprice'])) {
			$data_market = $data;
			$data = array();
			$data['last'] = $data_market['lprice'];
			$data['vol_cur'] = $data_market['curvol'];
			$data['high'] = $data_market['priceh'];
			$data['low'] = $data_market['pricel'];
			return $data;
		}
		$this->setMessageLog(__CLASS__ .' - getTicker не наден нужный елемент');
		return false;
	}

	public function getDepth($currency_to = 'btc', $currency_of = 'usd')
	{
		$data = $this->query($this->getUrl('orders', mb_strtoupper($currency_to, 'utf-8')), null, null, true);

		$xml = new \SimpleXMLElement($data);
		$data = json_decode(json_encode($xml), true);

		if (isset($data["sell"],  $data["sell"]["o"],  $data["sell"]["o"][0], $data["buy"], $data["buy"]["o"], $data["buy"]["o"][0])) {
			$return['ask']['price'] = $data["sell"]["o"][0]['p'];
			$return['ask']['vol'] = $data["sell"]["o"][0]['c1'];
			$return['bid']['price'] = $data["buy"]["o"][0]['p'];
			$return['bid']['vol'] = $data["buy"]["o"][0]['c1'];
			return $return;
		}
		$this->setMessageLog(__CLASS__ .' - getDepth не наден нужный елемент');
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
		return $this->base_url .''. $method .'?cur='. $currency;
	}
}