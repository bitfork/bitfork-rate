<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $id
 * @property string $name
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class ApiService extends Service
{
	public function behaviors()
	{
		return CMap::mergeArray(parent::behaviors(), array(
			'renderModel' => array('class' => '\rest\model\Behavior')
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
}
