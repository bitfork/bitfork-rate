<?php

/**
 * This is the model class for table "rate_index".
 *
 * The followings are the available columns in table 'rate_index':
 * @property integer $id
 * @property integer $period
 * @property string $servises
 * @property string $services_hash
 * @property double $index
 * @property integer $id_currency
 * @property integer $id_currency_from
 * @property integer $change_state
 * @property double $change_percent
 * @property string $data
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class RateIndex extends MyActiveRecord
{
	const CHANGE_NULL 	= 0;
	const CHANGE_UP 	= 2;
	const CHANGE_DOWN 	= 3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rate_index';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('period, servises, services_hash, index, id_currency, id_currency_from, data, create_date, mod_date', 'required'),
			array('period, id_currency, id_currency_from, change_state, is_active', 'numerical', 'integerOnly'=>true),
			array('index, change_percent', 'numerical'),
			array('services_hash', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, period, servises, services_hash, index, id_currency, id_currency_from, change_state, change_percent, data, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'period' => 'Period',
			'servises' => 'Servises',
			'services_hash' => 'Services Hash',
			'index' => 'Index',
			'id_currency' => 'Id Currency',
			'id_currency_from' => 'Id Currency From',
			'change_state' => 'Change State',
			'change_percent' => 'Change Percent',
			'data' => 'Data',
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
		$criteria->compare('period',$this->period);
		$criteria->compare('servises',$this->servises,true);
		$criteria->compare('services_hash',$this->services_hash,true);
		$criteria->compare('index',$this->index);
		$criteria->compare('id_currency',$this->id_currency);
		$criteria->compare('id_currency_from',$this->id_currency_from);
		$criteria->compare('change_state',$this->change_state);
		$criteria->compare('change_percent',$this->change_percent);
		$criteria->compare('data',$this->data,true);
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
	 * @return RateIndex the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function afterSave()
	{
		parent::afterSave();
		if ($this->isNewRecord) {
			$this->sendUser();
		}
	}

	/**
	 * вернет последний индекс
	 *
	 * @param $period
	 * @param $id_services
	 * @return array
	 */
	public static function _getLastIndex($period, $id_services)
	{
		$sql = "
			SELECT `index`, `data`
			FROM `". RateIndex::model()->tableName() ."`
			WHERE `period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."'
			ORDER BY `id` DESC
			LIMIT 1
		";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		return array($data['index'], json_decode($data['data'], true));
	}

	/**
	 * вернет индекс за время
	 *
	 * @param $id_currency_from
	 * @param $id_currency
	 * @param $period
	 * @param null $id_services
	 * @param null $date_start
	 * @param null $date_finish
	 * @return array
	 */
	public static function getDateIndex($id_currency_from, $id_currency, $period, $id_services = null, $date_start = null, $date_finish = null)
	{
		if ($id_services===null) {
			$id_services = array();
			$pair = Pair::model()->find('id_currency_from=:id_currency_from and id_currency=:id_currency', array(':id_currency_from'=>$id_currency_from,':id_currency'=>$id_currency));
			$servicesAll = ServicePair::model()->findAll('id_pair=:id_pair', array(':id_pair'=>$pair->id));
			foreach ($servicesAll as $service) {
				$id_services[] = $service->id_service;
			}
		}
		if ($date_start===true) {
			$date_start = new DateTime();
			$date_start->modify('-'. $period .' hour');
			$date_start = $date_start->format('Y-m-d H:i:s');
		}
		if ($date_finish===true) {
			$date_finish = date('Y-m-d H:i:s');
		}
		$where_date = '';
		if ($date_start!==null and $date_finish!==null) {
			$where_date = "AND `create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'";
		}
		$sql = "
			SELECT `index`, `id_currency_from`, `id_currency`, `change_state`, `change_percent`, `data`, `create_date`
			FROM `". RateIndex::model()->tableName() ."`
			WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND
				`period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' ". $where_date ."
			ORDER BY `id` DESC
			LIMIT 1
		";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		$services = array();
		if (isset($data['data'])) {
			$services = json_decode($data['data'], true);
			unset($data['data']);
		}

		return (isset($data['index'])) ?
			array('index'=>$data, 'services'=>$services) :
			array('index'=>array('index' => 0, 'change_state' => RateIndex::CHANGE_NULL, 'change_percent' => 0, 'id_currency'=>$id_currency, 'id_currency_from'=>$id_currency_from, 'create_date'=>''), 'services'=>$services);
	}

	/**
	 * вернет максимальное и минимальное значение за период
	 *
	 * @param $id_currency_from
	 * @param $id_currency
	 * @param $period
	 * @param $id_services
	 * @param null $date_start
	 * @param null $date_finish
	 * @return bool
	 */
	public static function getRangeIndex($id_currency_from, $id_currency, $period, $id_services, $date_start = null, $date_finish = null)
	{
		if ($date_start===null) {
			$date_start = new DateTime();
			$date_start->modify('-'. $period .' hour');
			$date_start = $date_start->format('Y-m-d H:i:s');
		}
		if ($date_finish===null) {
			$date_finish = date('Y-m-d H:i:s');
		}
		$sql = "
			SELECT MIN(`index`) as `min`, MAX(`index`) as `max`
			FROM `". RateIndex::model()->tableName() ."`
			WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND
				`period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
				`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
		";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		return (isset($data['min'])) ? $data : false;
	}

	/**
	 * вернет на сколько % изменился индекс и в какую сторону
	 *
	 * @param $id_currency_from
	 * @param $id_currency
	 * @param $period
	 * @param $id_services
	 * @param null $date_start
	 * @param null $date_finish
	 * @return array
	 */
	public static function getChangePercent($id_currency_from, $id_currency, $period, $id_services, $date_start = null, $date_finish = null)
	{
		if ($date_start===null) {
			$date_start = new DateTime();
			$date_start->modify('-'. $period .' hour');
			$date_start = $date_start->format('Y-m-d H:i:s');
		}
		if ($date_finish===null) {
			$date_finish = date('Y-m-d H:i:s');
		}
		$sql = "
			SELECT `first`.*
			FROM (
				SELECT `index`
				FROM `". RateIndex::model()->tableName() ."`
				WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND
					`period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
					`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
				ORDER BY id ASC
				LIMIT 1
			) as `first`
			UNION
			SELECT `last`.*
			FROM (
				SELECT `index`
				FROM `". RateIndex::model()->tableName() ."`
				WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND
					`period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
					`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
				ORDER BY id DESC
				LIMIT 1
			) as `last`
		";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryAll();

		if (!isset($data[0]) or !isset($data[1]))
			return array(self::CHANGE_NULL, 0);

		$first = $data[0]['index'];
		$last = $data[1]['index'];

		if ($first<$last) {
			$percent = (($last - $first) * 100) / $first;
			$change = self::CHANGE_UP;
		} elseif ($last<$first) {
			$percent = (($first - $last) * 100) / $last;
			$change = self::CHANGE_DOWN;
		} else {
			$percent = 0;
			$change = self::CHANGE_NULL;
		}

		$round = 1;
		if ($percent < 1) {
			$round = 2;
		}

		return array($change, round($percent, $round));
	}

	/**
	 * вернет строковое представление изменения индекса
	 *
	 * @param $id
	 * @return string
	 */
	public static function getStrChangeId($id)
	{
		if ($id === self::CHANGE_DOWN)
			return '-';
		if ($id === self::CHANGE_UP)
			return '+';
		return '';
	}

	/**
	 * разослать новые данные пользователям
	 */
	public function sendUser()
	{
		$pair = Pair::model()->find('id_currency=:id_currency and id_currency_from=:id_currency_from',
			array(
				':id_currency'=>$this->id_currency,
				':id_currency_from'=>$this->id_currency_from,
			)
		);
		$index = self::getDateIndex($this->id_currency_from, $this->id_currency, 0, explode(',', $this->servises));
		$symbol = Currency::getSymbol($this->id_currency);
		$round = Currency::getCountRound($this->id_currency);
		$services = $index['services'];
		$data = array();
		foreach ($services as $service) {
			$data[] = array(
				'id'=>$service['id_service'],
				'price'=>ViewPrice::GetResult($service['avg_price'], $symbol, $round),
			);
		}
		Yii::app()->websocket->send(array(
			'pair'=>$pair->id,
			'index'=>ViewPrice::GetResult($index['index']['index'], $symbol, $round),
			'services'=>$data,
			'date'=>date('D, d.m.y\, H:i', strtotime($index['index']['create_date'])),
		));
	}
}