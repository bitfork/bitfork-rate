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
		$criteria->select = '*, (round((UNIX_TIMESTAMP(`create_date`))/60)*60) as `create_date`';
		$criteria->condition = 'servises=:servises AND period=:period AND id_currency_from=:id_currency_from AND id_currency=:id_currency';
		$criteria->params = array(
			':period'=>$period,
			':servises'=>implode(',', $services),
			':id_currency_from'=>$pair->id_currency_from,
			':id_currency'=>$pair->id_currency
		);
		$criteria->group = 'create_date';
		$criteria->order = 'id DESC';
		$criteria->limit = $limit;
		$index = RateIndex::model()->findAll($criteria);
		$history = array();
		$max = null;
		$min = null;
		foreach ($index as $row) {
			if ($max < $row['index'] or $max === null) {
				$max = $row['index'];
			}
			if ($min > $row['index'] or $max === null) {
				$min = $row['index'];
			}
			$history[] = array('x'=>$row['create_date'] * 1000, 'y'=>(float)$row['index'], 'name'=>ViewPrice::GetResult($row['index'], $pair->currency->symbol, $pair->currency->round));
		}
		$end = end($history);
		$limit = ($max - $min) / 4;
		$max = $end['y'] + $limit;
		$min = $end['y'] - $limit;
		echo CJSON::encode(array(array_reverse($history), $max, $min));
	}
}
