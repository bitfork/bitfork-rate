<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $id
 * @property integer $id_service
 * @property integer $id_currency
 * @property integer $id_currency_from
 * @property double $high
 * @property double $low
 * @property double $avg
 * @property double $vol
 * @property double $vol_cur
 * @property double $last
 * @property double $buy
 * @property double $sell
 * @property string $updated
 * @property string $server_time
 * @property integer $change_state
 * @property double $change_percent
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class Course extends MyActiveRecord
{
	const BTCE		= 1;
	const BITSTAMP	= 2;
	const BTCCHINA	= 3;

	const USD		= 1;
	const BTC		= 2;

	// переоды времени за которые считается индекс
	public static $periods = array('последняя'=>0, '15м'=>15, '1ч'=>60, '24ч'=>1440, '7д'=>10080);
	// возможные пары валют
	public static $pairs = array(array(self::BTC,self::USD));

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_service, id_currency, id_currency_from, high, low, create_date, mod_date', 'required'),
			array('id_service, id_currency, id_currency_from, change_state, is_active', 'numerical', 'integerOnly'=>true),
			array('high, low, avg, vol, vol_cur, last, buy, sell, change_percent', 'numerical'),
			array('updated, server_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_service, id_currency, id_currency_from, high, low, avg, vol, vol_cur, last, buy, sell, updated, server_time, change_state, change_percent, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'currency' => array(self::BELONGS_TO, 'Currency', 'id_currency'),
			'currency_from' => array(self::BELONGS_TO, 'Currency', 'id_currency_from'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_service' => 'Id Service',
			'id_currency' => 'Id Currency',
			'id_currency_from' => 'Id Currency From',
			'high' => 'High',
			'low' => 'Low',
			'avg' => 'Avg',
			'vol' => 'Vol',
			'vol_cur' => 'Vol Cur',
			'last' => 'Last',
			'buy' => 'Buy',
			'sell' => 'Sell',
			'updated' => 'Updated',
			'server_time' => 'Server Time',
			'change_state' => 'Change State',
			'change_percent' => 'Change Percent',
			'is_active' => 'Is Active',
			'create_date' => 'Create Date',
			'mod_date' => 'Mod Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_service',$this->id_service);
		$criteria->compare('id_currency',$this->id_currency);
		$criteria->compare('id_currency_from',$this->id_currency_from);
		$criteria->compare('high',$this->high);
		$criteria->compare('low',$this->low);
		$criteria->compare('avg',$this->avg);
		$criteria->compare('vol',$this->vol);
		$criteria->compare('vol_cur',$this->vol_cur);
		$criteria->compare('last',$this->last);
		$criteria->compare('buy',$this->buy);
		$criteria->compare('sell',$this->sell);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('server_time',$this->server_time,true);
		$criteria->compare('change_state',$this->change_state);
		$criteria->compare('change_percent',$this->change_percent);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('mod_date',$this->mod_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Course the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * получает средние данные за переод и считает индекс
	 * если $period = 0, то учитываются только последние цены от каждой биржи
	 *
	 * @param $period
	 * @param $date_start
	 * @param $date_finish
	 * @param null $id_services
	 * @return array
	 */
	public static function getAvgData($id_currency_from, $id_currency, $period, $date_start, $date_finish, $id_services = null)
	{
		$select = "t.id_service, t2.name as name_service, AVG(t.last) as avg_price, AVG(t.vol_cur) as avg_volume, t.change_state, t.change_percent";
		$where = array();
		$order = '';
		$where[] = "`id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency;
		if ($period > 0 and $date_start!==null and $date_finish!==null) {
			$where[] = "`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'";
		} else {
			// с каждой биржи получаем только последние данные
			$select = "t.id_service, t2.name as name_service, t.last as avg_price, t.vol_cur as avg_volume, t.change_state, t.change_percent";
			$order = 'ORDER BY id DESC';
		}
		// по сервисам смотрим тк какие то сервисы могут быть выключенны
		if (is_array($id_services) and count($id_services)>0) {
			$where[] = 'id_service IN ('. implode(',', $id_services) .')';
		}
		if (count($where)>0) {
			$where = 'WHERE '. implode(' AND ', $where);
		} else {
			$where = '';
		}
		$sql = "
			SELECT ". $select ."
			FROM (
				SELECT *
				FROM `". Course::model()->tableName() ."`
				". $where ."
				". $order ."
			) as `t`
			JOIN `". Service::model()->tableName() ."` as t2 ON t.id_service = t2.id
			GROUP BY t.id_service
			ORDER BY t.`id`
		";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryAll();

		$sum = 0;
		foreach ($data as $r) {
			$sum += $r['avg_volume'];
		}

		$index = array();
		$index['index'] = 0;
		$index['change_state'] = RateIndex::CHANGE_NULL;
		$index['change_percent'] = 0;
		foreach ($data as $k => $r) {
			$data[$k]['percent_for_index'] = $r['avg_volume'] / $sum; // процент объема биржи от суммы всех объемов бирж
			$data[$k]['percent_price_for_index'] = $r['avg_price'] * $data[$k]['percent_for_index']; // цена курса которая влияет на индекс
			$index['index'] += $data[$k]['percent_price_for_index']; // сумма всех курсов
			$data[$k]['change_state'] = $r['change_state'];
			$data[$k]['change_percent'] = $r['change_percent'];
		}
		$change = RateIndex::getChangePercent($index['index'], $id_currency_from, $id_currency, $period);
		$index['change_state'] = $change[0];
		$index['change_percent'] = $change[1];

		return array($index, $data);
	}

	/**
	 * сохраняем индекс в db
	 *
	 * @param $period
	 * @param $combination
	 * @param $data
	 */
	public static function saveIndex($id_currency_from, $id_currency, $period, $combination, $data)
	{
		$index = new RateIndex();
		$index->period = $period;
		$index->servises = implode(',', $combination);
		$index->services_hash = md5($index->servises);
		$index->index = floor($data[0]['index'] * pow(10, 8)) / pow(10, 8); // округляем до 8 знаков в меньшую
		$index->id_currency = $id_currency;
		$index->id_currency_from = $id_currency_from;
		$index->change_state = $data[0]['change_state'];
		$index->change_percent = $data[0]['change_percent'];
		$index->data = json_encode($data[1]);
		if (!$index->save()) {
			Yii::log(serialize($index->getErrors()), 'error', 'modelIndex');
		}
	}

	/**
	 * расчет индекса для всех пар валют и каждой комбинации сервисов
	 *
	 * @param bool $id_pair
	 * @param null $period
	 */
	public static function calculateIndex($id_pair=false, $period=null)
	{
		$services = self::getPairServices($id_pair);

		foreach ($services as $values) {
			if (count($values['services'])>0)
				self::calculateByServices($values['services'], $values['id_currency_from'], $values['id_currency'], $period);
		}
	}

	/**
	 * вернет массив список сервисов для каждой пары
	 *
	 * @param bool $object id или объекты серисов
	 * @return array
	 */
	public static function getPairServices($id_pair=false, $object=false)
	{
		$services = array();
		if ($id_pair===false)
			$pairs = Pair::model()->findAll();
		else
			$pairs = Pair::model()->findAll('id=:id', array(':id'=>$id_pair));
		foreach ($pairs as $pair) {
			$services[$pair->id]['id_currency'] = $pair->id_currency;
			$services[$pair->id]['id_currency_from'] = $pair->id_currency_from;
			if ($object) {
				$services[$pair->id]['currency'] = $pair->currency;
				$services[$pair->id]['currency_from'] = $pair->currency_from;
			}
			$services[$pair->id]['services'] = array();
			foreach ($pair->service_pair as $service_pair) {
				if ($object) {
					$services[$pair->id]['services'][] = $service_pair->service;
				} else {
					$services[$pair->id]['services'][] = $service_pair->id_service;
				}
			}
		}
		return $services;
	}

	/**
	 * подсчет индекса для сервисов, всех комбинаций
	 *
	 * @param $services
	 * @param $id_currency_from
	 * @param $id_currency
	 * @param null $set_period
	 */
	public static function calculateByServices($services, $id_currency_from, $id_currency, $set_period = null)
	{
		$combinations = self::getComb($services);
		if ($set_period === null) {
			$periods = self::$periods;
		} else {
			$periods = array((int)$set_period);
		}
		foreach ($periods as $period) {
			foreach ($combinations as $combination) {
				$date_start = new DateTime();
				$date_start->modify('-'. $period .' minutes');
				$date_start = $date_start->format('Y-m-d H:i:s');
				$data = Course::model()->getAvgData(
					$id_currency_from,
					$id_currency,
					$period,
					$date_start,
					date('Y-m-d H:i:s'),
					$combination
				);
				self::saveIndex($id_currency_from, $id_currency, $period, $combination, $data);
			}
		}
	}

	/**
	 * перебор всех комбинация
	 *
	 * @param $services
	 * @param $start
	 * @param array $last
	 * @return array
	 */
	public static function getComb($services, $start = -1, $last = array())
	{
		// комбинации убрали, считаем только для всех сервисов
		return array($services);

		$comb = array();
		for ($i = $start + 1; $i < count($services); $i++) {
			$comb[] = array_merge($last, array($services[$i]));
			$last = array_merge($last, array($services[$i]));
			$ret = self::getComb($services, $i, $last);
			$comb = array_merge($comb, $ret);
			$last = array();
		}
		return $comb;
	}

	/**
	 * получает от сервиса данные и сохраняет в db
	 */
	public static function parseAllService($id_pair=false)
	{
		$exchange = Yii::app()->exchange;
		$services = self::getPairServices($id_pair, true);
		foreach ($services as $values) {
			foreach ($values['services'] as $service) {
				$exchange->setService($service->name);
				$results = $exchange->getTicker($values['currency_from']->name, $values['currency']->name);
				if ($results!==false) {
					// считаем изменение в курсе
					$change = self::getChangePercent($results['last'], $values['currency_from']->id, $values['currency']->id, $service->id);

					$model = new Course;
					$model->attributes=$results;
					$model->id_service = $service->id;
					$model->id_currency = $values['id_currency'];
					$model->id_currency_from = $values['id_currency_from'];
					$model->change_state = $change[0];
					$model->change_percent = $change[1];
					$model->save();
				}
			}
		}
	}

	/**
	 * вернет на сколько % изменился цена и в какую сторону
	 *
	 * @param $course
	 * @param $id_currency_from
	 * @param $id_currency
	 * @param $id_service
	 * @return array
	 */
	public static function getChangePercent($course, $id_currency_from, $id_currency, $id_service)
	{
		$sql = "
			SELECT `last`
			FROM `". Course::model()->tableName() ."`
			WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND `id_service` = '". $id_service ."'
			ORDER BY id DESC
			LIMIT 1
		";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		if (!isset($data['last']))
			return array(RateIndex::CHANGE_NULL, 0);

		$first = $course;
		$last = $data['last'];

		if ($first<$last) {
			$percent = (($last - $first) * 100) / $first;
			$change = RateIndex::CHANGE_UP;
		} elseif ($last<$first) {
			$percent = (($first - $last) * 100) / $last;
			$change = RateIndex::CHANGE_DOWN;
		} else {
			$percent = 0;
			$change = RateIndex::CHANGE_NULL;
		}

		$round = 1;
		if ($percent < 1) {
			$round = 2;
		}

		return array($change, round($percent, $round));
	}
}