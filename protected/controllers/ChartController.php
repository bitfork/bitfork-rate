<?php
class ChartController extends Controller
{
	public function actionIndex($id_pair, $period = 0, $limit = 200)
	{
		$pair = Pair::model()->findByPk($id_pair);
		$criteria = new CDbCriteria;
		$criteria->select = '*, UNIX_TIMESTAMP(`create_date`) as `create_date`';
		$criteria->condition = 'period=:period AND id_currency_from=:id_currency_from AND id_currency=:id_currency';
		$criteria->params = array(
			':period'=>$period,
			':id_currency_from'=>$pair->id_currency_from,
			':id_currency'=>$pair->id_currency
		);
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
			if ($min > $row['index'] or $min === null) {
				$min = $row['index'];
			}
			$index_num = round((float)$row['index'], $pair->currency->round);
			$history[] = array('x'=>$row['create_date'].'000', 'y'=>$index_num, 'name'=>ViewPrice::GetResult($row['index'], $pair->currency->symbol, $pair->currency->round));
		}
		$limit = ($max - $min);
		if ($limit > 0) {
			$max += $limit / 4;
			$min -= $limit / 4;
		}
		echo CJSON::encode(array(array_reverse($history), $max, $min));
	}
}
