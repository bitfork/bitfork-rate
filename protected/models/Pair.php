<?php

/**
 * This is the model class for table "pair".
 *
 * The followings are the available columns in table 'pair':
 * @property integer $id
 * @property integer $id_currency
 * @property integer $id_currency_from
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
			array('id_currency, id_currency_from, is_active', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_currency, id_currency_from, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
}
