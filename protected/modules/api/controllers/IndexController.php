<?php

class IndexController extends ApiController
{
	/**
	 * только индекс по параметрам
	 *
	 * @param string $from
	 * @param string $to
	 * @param int $period
	 */
	public function actionIndex($from = 'BTC', $to = 'USD', $period=0)
	{
		$currencys = $this->getCurrencys($from, $to, $period);
		$id_currency_from = $currencys[0];
		$id_currency = $currencys[1];

		$data=ApiRateIndex::getDateIndex($id_currency_from, $id_currency, $period);
		$response['index'] = $data['index']['index'];
		$response['period'] = $period;
		$this->render('view',array(
			'data'=>$response,
		));
	}

	/**
	 * индекс и все данные
	 *
	 * @param string $from
	 * @param string $to
	 * @param int $period
	 */
	public function actionAlldata($from = 'BTC', $to = 'USD', $period=0)
	{
		$currencys = $this->getCurrencys($from, $to, $period);
		$id_currency_from = $currencys[0];
		$id_currency = $currencys[1];

		$data=ApiRateIndex::getDateIndex($id_currency_from, $id_currency, $period);

		$response['index']['index'] = $data['index']['index'];
		$response['index']['change_state'] = RateIndex::getStrChangeId($data['index']['change_state']);
		$response['index']['change_percent'] = $data['index']['change_percent'];
		foreach ($data['services'] as $item) {
			$response['services'][$item['name_service']]['price'] = $item['avg_price'];
			$response['services'][$item['name_service']]['volume'] = $item['avg_volume'];
			$response['services'][$item['name_service']]['change_state'] = RateIndex::getStrChangeId($item['change_state']);
			$response['services'][$item['name_service']]['change_percent'] = $item['change_percent'];
		}

		$response['period'] = $period;
		$this->render('view',array(
			'data'=>$response,
		));
	}

	/**
	 * проверка входных данных
	 * и вернет id запрашиваемых валют
	 *
	 * @param $from
	 * @param $to
	 * @param $period
	 * @return array
	 */
	private function getCurrencys($from, $to, $period)
	{
		$currency = mb_strtoupper($to, 'utf-8');
		$currency_from = mb_strtoupper($from, 'utf-8');

		if (!in_array($period, Course::$periods)) {
			$this->showError(Yii::t('api', 'Не верно задан параметр period'));
		}
		$criteria = new CDbCriteria;
		$criteria->addInCondition('name', array($currency, $currency_from));
		$currencys = Currency::model()->findAll($criteria);
		foreach ($currencys as $cur) {
			if ($cur->name == $currency) $id_currency = $cur->id;
			if ($cur->name == $currency_from) $id_currency_from = $cur->id;
		}
		if (!isset($id_currency) or !isset($id_currency_from)) {
			$this->showError(Yii::t('api', 'Не верно указана валюта'));
		}
		$pair = Pair::model()->find(
			'id_currency=:id_currency and id_currency_from=:id_currency_from',
			array(':id_currency'=>$id_currency, ':id_currency_from'=>$id_currency_from)
		);
		if ($pair===null) {
			$this->showError(Yii::t('api', 'Не верно указана пара валют'));
		}

		return array($id_currency_from, $id_currency);
	}
}