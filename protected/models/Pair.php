<?php

/**
 * This is the model class for table "pair".
 *
 * The followings are the available columns in table 'pair':
 * @property integer $id
 * @property integer $id_currency
 * @property integer $id_currency_from
 * @property integer $id_currency_intermed
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class Pair extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pair';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_currency, id_currency_from, create_date, mod_date', 'required'),
			array('id_currency, id_currency_from, id_currency_intermed, is_active', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_currency, id_currency_from, id_currency_intermed, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'currency_intermed' => array(self::BELONGS_TO, 'Currency', 'id_currency_intermed'),
			'service_pair' => array(self::HAS_MANY, 'ServicePair', 'id_pair'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_currency' => 'Id Currency',
			'id_currency_from' => 'Id Currency From',
			'id_currency_intermed' => 'Id Currency Intermed',
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
		$criteria->compare('id_currency',$this->id_currency);
		$criteria->compare('id_currency_from',$this->id_currency_from);
		$criteria->compare('id_currency_intermed',$this->id_currency_intermed);
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
	 * @return Pair the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public static function getPairServices($id_pair=false)
	{
		$services = array();
		if ($id_pair===false)
			$pairs = Pair::model()->findAll();
		else
			$pairs = Pair::model()->findAll('id=:id', array(':id'=>$id_pair));
		foreach ($pairs as $pair) {
			$services[$pair->id]['currency'] = $pair->currency;
			$services[$pair->id]['currency_from'] = $pair->currency_from;
			$services[$pair->id]['services'] = array();
			foreach ($pair->service_pair as $service_pair) {
				$services[$pair->id]['services'][] = $service_pair->service;
			}
		}
		return $services;
	}

	public static function parseAllService($volume, $id_currency_2, $id_currency_1, $is_buy = true)
	{
		$pair = Pair::model()->findByAttributes(array('id_currency'=>$id_currency_1, 'id_currency_from'=>$id_currency_2));
		if ($pair===null) {
			return false;
		}
		$id_pair = $pair->id;
		$exchange = Yii::app()->exchange;
		// получаем сервисы для пары
		$services = self::getPairServices($id_pair);
		foreach ($services as $values) {
			$parse_data = array();
			foreach ($values['services'] as $service) {
				// для каждого сервиса получаем стаканы
				$exchange->setService($service->name);
				$results = $exchange->getDepth($values['currency_from']->name, $values['currency']->name);
				if ($results!==false) {
					$parse_data[$service->id]['service'] = $service->name;
					$parse_data[$service->id]['service_url'] = $exchange->getBaseUrl();
					$parse_data[$service->id]['data'] = $results;
				}/* else {
					echo "<pre>";
					print_r($service->name);
					echo "</pre>";
				}*/
			}
		}
		if (count($parse_data)>0) {
			foreach ($parse_data as $id_service => $data) {
				// для каждого сервиса теперь ищем подходящие лоты
				$list = self::getTop($data['data'], $volume, $is_buy);
				if (count($list['list'])>0) {
					$top[$id_service]['service'] = $data['service'];
					$top[$id_service]['service_url'] = $data['service_url'];
					$top[$id_service]['data'] = $list;
				}
			}
		}
		if (!isset($top) or count($top)<=0) {
			return false;
		}

		$id_service = ($is_buy==1) ? self::getTopBuy($top) : self::getTopSell($top);

		return array($id_service, $top);
	}

	public static function getTopBuy($top)
	{
		$min = null;
		$id_service_search = null;
		foreach ($top as $id_service => $item) {
			if ($min===null or $item['data']['summa'] < $min) {
				$min = $item['data']['summa'];
				$id_service_search = $id_service;
			}
		}
		return $id_service_search;
	}

	public static function getTopSell($top)
	{
		$max = null;
		$id_service_search = null;
		foreach ($top as $id_service => $item) {
			if ($max===null or $item['data']['summa'] > $max) {
				$max = $item['data']['summa'];
				$id_service_search = $id_service;
			}
		}
		return $id_service_search;
	}

	public static function getTop($data, $volume, $is_buy)
	{
		if ($is_buy==1) {
			// нам нужно купить, по этому смотрим лоты на продажу
			$data = $data['asks'];
		} else {
			$data = $data['bids'];
		}

		$tmp_volume = 0;
		$summa = 0;
		$list = array();

		foreach ($data as $item) {
			if ($tmp_volume < $volume and ($tmp_volume + $item[1]) < $volume) {
				$tmp_volume += $item[1];
				$summa += $item[0] * $item[1];
				$list[] = $item;
			}
		}

		return array('summa'=>$summa,'volume'=>$tmp_volume,'list'=>$list);
	}
}
