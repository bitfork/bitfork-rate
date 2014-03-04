<?php

/**
 * This is the model class for table "users_wallets".
 *
 * The followings are the available columns in table 'users_wallets':
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_type
 * @property string $name
 * @property string $adress
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class UsersWallets extends MyActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersWallets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users_wallets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_user, id_type, name, adress', 'required'),
			array('id_user, id_type, is_active', 'numerical', 'integerOnly'=>true),
			array('name, adress', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, id_type, name, adress, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'id' => UserModule::t('ID'),
			'id_user' => UserModule::t('Id пользователя'),
			'id_type' => UserModule::t('Id типа'),
			'name' => UserModule::t('Название'),
			'adress' => UserModule::t('Адрес'),
			'is_active' => UserModule::t('Is Active'),
			'create_date' => UserModule::t('Create Date'),
			'mod_date' => UserModule::t('Mod Date'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_type',$this->id_type);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('adress',$this->adress,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('mod_date',$this->mod_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * вернет тип кошелька
	 *
	 * @return string
	 */
	public function getType()
	{
		$list = array(1=>'BTC',2=>'Qiwi',3=>'Webmoney',4=>'Яндекс.деньги');
		return isset($list[$this->id_type]) ? $list[$this->id_type] : '';
	}

	/**
	 * список типов кошельков
	 *
	 * @param array $not
	 * @return array
	 */
	public static function getTypes($not = array())
	{
		$list = array(1=>'BTC',2=>'Qiwi',3=>'Webmoney',4=>'Яндекс.деньги');
		foreach ($not as $id) {
			unset($list[$id]);
		}
		return $list;
	}
}