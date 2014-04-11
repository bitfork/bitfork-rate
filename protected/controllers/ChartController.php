<?php
class ChartController extends Controller
{
	public function actionIndex($id_pair, $period = 0, $limit = 200)
	{
		$pair = Pair::model()->findByPk($id_pair);
		$services_pair = ServicePair::model()->findAll('id_pair=:id_pair', array('id_pair'=>$id_pair));
		$services = array();
		foreach ($services_pair as $service) {
			$services[] = $service->id;
		}
		$criteria = new CDbCriteria;
		$criteria->condition = 'servises=:servises AND period=:period AND id_currency_from=:id_currency_from AND id_currency=:id_currency';
		$criteria->params = array(
			':period'=>$period,
			':servises'=>implode(',', $services),
			':id_currency_from'=>$pair->id_currency_from,
			':id_currency'=>$pair->id_currency
		);
		if ($limit == 1) {
			$criteria->order = 'id DESC';
		}
		$criteria->limit = $limit;
		$index = RateIndex::model()->findAll($criteria);
		$history = array();
		foreach ($index as $row) {
			$history[] = array('x'=>strtotime($row['create_date']) * 1000, 'y'=>(float)$row['index'], 'name'=>ViewPrice::GetResult($row['index'], $pair->currency->symbol, $pair->currency->round));
		}
		echo CJSON::encode($history);
	}
}
