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
		if ($date_start===true) {
			$date_start = new DateTime();
			$date_start->modify('-'. $period .' minutes');
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
				`period` = ". $period ." ". $where_date ."
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
			$date_start->modify('-'. $period .' minutes');
			$date_start = $date_start->format('Y-m-d H:i:s');
		}
		if ($date_finish===null) {
			$date_finish = date('Y-m-d H:i:s');
		}
		$sql = "
			SELECT MIN(`index`) as `min`, MAX(`index`) as `max`
			FROM `". RateIndex::model()->tableName() ."`
			WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND
				`period` = ". $period ." AND `create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
		";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		return (isset($data['min'])) ? $data : false;
	}

	/**
	 * вернет на сколько % изменился индекс и в какую сторону
	 *
	 * @param $index
	 * @param $id_currency_from
	 * @param $id_currency
	 * @param $period
	 * @return array
	 */
	public static function getChangePercent($index, $id_currency_from, $id_currency, $period)
	{
		$sql = "
			SELECT `index`
			FROM `". RateIndex::model()->tableName() ."`
			WHERE `id_currency_from` = ". $id_currency_from ." AND `id_currency` = ". $id_currency ." AND `period` = ". $period ."
			ORDER BY id DESC
			LIMIT 1
		";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		if (!isset($data['index']))
			return array(self::CHANGE_NULL, 0);

		$first = $data['index'];
		$last = $index;

		if ($first<$last) {
			if ($first>0) $percent = (($last - $first) * 100) / $first;
			else $percent = $last * 100;
			$change = self::CHANGE_UP;
		} elseif ($last<$first) {
			if ($last>0) $percent = (($first - $last) * 100) / $last;
			else $percent = $first * 100;
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
		if ($this->period != 0) {
			return;
		}
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
			$percent = (float)$service['percent_for_index'] * 100;
			$percent = ($percent>0) ? (($percent >= 0.1) ? round($percent, 2) .'%' : '< 0.1 %') : 'loss';
			$price = (($service['avg_price']>0) ? ViewPrice::GetResult($service['avg_price'], $symbol, $round) : 'loss');
			if (!empty($pair->id_currency_intermed)) {
				$price_intermed = (($service['price_intermed_2']>0) ? ViewPrice::GetResult($service['price_intermed_2'], $pair->currency_intermed->symbol, $pair->currency_intermed->round) : 'loss');
			} else {
				$price_intermed = $price;
			}
			$data[] = array(
				'id'=>$service['id_service'],
				'price_intermed'=>$price_intermed,
				'price'=>$price,
				'volume'=>$percent,
			);
		}
		Yii::app()->websocket->send(array(
			'pair'=>$pair->id,
			'index_num'=>round($index['index']['index'], $round),
			'index'=>ViewPrice::GetResult($index['index']['index'], $symbol, $round),
			'services'=>$data,
			'date'=>date('D\, d.m.y\, H:i:s', strtotime($index['index']['create_date'])),
			'timestamp'=>strtotime($index['index']['create_date']) * 1000,
		));
	}

	/**
	 * архивирование данных
	 */
	public static function partition()
	{
		//найти id записи до которой нужно удалить
		$date_start = new DateTime();
		$date_start->modify('-7 day');
		$date_limit = $date_start->getTimestamp();

		$sql = "
			SELECT `id`
			FROM `rate_index`
			WHERE UNIX_TIMESTAMP(`create_date`) > '". $date_limit ."'
			ORDER BY id
			LIMIT 1
		";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		if (isset($data['id'])) {
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$sql = "
					INSERT INTO `rate_index_archive` (
						`id`,`period`,`servises`,`services_hash`,`index`,`id_currency`,`id_currency_from`,`change_state`,`change_percent`,`data`,`is_active`,`create_date`,`mod_date`
					)
					SELECT * FROM `rate_index` WHERE id < ". $data['id'] ."
				";
				$command=$connection->createCommand($sql);
				$command->execute();
				$sql = "DELETE FROM `rate_index` WHERE id < ". $data['id'] ."";
				$command=$connection->createCommand($sql);
				$command->execute();

				$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollback();
			}
		}
	}
}