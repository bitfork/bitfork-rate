<?php

class TopForm extends CFormModel
{
	public $id_service_1;
	public $id_service_2;
	public $volume;
	public $is_buy;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('id_service_1, id_service_2, volume', 'required'),
			array('is_buy', 'safe'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'id_service_1'=>'Валюта 1',
			'id_service_2'=>'Валюта 2',
			'volume'=>'Объем',
			'is_buy'=>'Что делаем?',
		);
	}
}