<?php

class ApiExampleForm extends CFormModel
{
	public $api_example;

	public function rules()
	{
		return array(
			array('api_example', 'required'),
			array('api_example', 'myurl'),
		);
	}

	public function myurl($attribute, $params)
	{
		if (!preg_match('/^(https?:\/\/)?'. $_SERVER['HTTP_HOST'] .'\//iu', $this->$attribute))
			$this->addError($attribute, 'Не верный урл');
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'api_example'=>'URL:',
		);
	}
}
