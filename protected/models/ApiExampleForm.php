<?php

class ApiExampleForm extends CFormModel
{
	public $api_example;

	public function rules()
	{
		return array(
			array('api_example', 'required'),
			array('api_example', 'url'),
		);
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
