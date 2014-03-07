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
			array('period, servises, services_hash, index, data, create_date, mod_date', 'required'),
			array('period, is_active', 'numerical', 'integerOnly'=>true),
			array('index', 'numerical'),
			array('services_hash', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, period, servises, services_hash, index, data, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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

	/**
	 * вернет последний индекс
	 *
	 * @param $period
	 * @param $id_services
	 * @return array
	 */
	public static function getLastIndex($period, $id_services)
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
	 * @param $period
	 * @param $id_services
	 * @param null $date_start
	 * @param null $date_finish
	 * @return array|bool
	 */
	public static function getDateIndex($period, $id_services, $date_start = null, $date_finish = null)
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
			SELECT `index`, `data`
			FROM `". RateIndex::model()->tableName() ."`
			WHERE `period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
				`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
			ORDER BY `id` DESC
			LIMIT 1
		";
		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryRow();

		return (isset($data['index'])) ? array($data['index'], json_decode($data['data'], true)) : array(0, array());
	}

	/**
	 * вернет максимальное и минимальное значение за период
	 *
	 * @param $period
	 * @param $id_services
	 * @param null $date_start
	 * @param null $date_finish
	 * @return bool
	 */
	public static function getRangeIndex($period, $id_services, $date_start = null, $date_finish = null)
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
			WHERE `period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
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
	 * @param $period
	 * @param $id_services
	 * @param null $date_start
	 * @param null $date_finish
	 * @return array|bool
	 */
	public static function getChangePercent($period, $id_services, $date_start = null, $date_finish = null)
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
				WHERE `period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
					`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
				ORDER BY id ASC
				LIMIT 1
			) as `first`
			UNION
			SELECT `last`.*
			FROM (
				SELECT `index`
				FROM `". RateIndex::model()->tableName() ."`
				WHERE `period` = ". $period ." AND `services_hash` = '". md5(implode(',', $id_services)) ."' AND
					`create_date` BETWEEN '". $date_start ."' AND '". $date_finish ."'
				ORDER BY id DESC
				LIMIT 1
			) as `last`
		";

		$connection=Yii::app()->db;
		$command=$connection->createCommand($sql);
		$data = $command->queryAll();

		if (!isset($data[0]))
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
}
