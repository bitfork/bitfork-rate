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
 * @property integer $change_state
 * @property double $change_percent
 * @property string $data
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class ApiRateIndex extends RateIndex
{
	public function behaviors()
	{
		return CMap::mergeArray(parent::behaviors(), array(
			'renderModel' => array('class' => '\rest\model\Behavior')
		));
	}

	public function rules()
	{
		return CMap::mergeArray(parent::rules(), array(
			array('id,index', 'safe', 'on' => 'render'),
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