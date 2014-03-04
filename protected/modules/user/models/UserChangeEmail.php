<?php
/**
 * UserChangeemail class.
 * UserChangeemail is the data structure for keeping
 * user change email form data. It is used by the 'changeemail' action of 'UserController'.
 */
class UserChangeEmail extends CFormModel {

	public $email;

	public function rules() {
		return array(
			array('email', 'required'),
			array('email', 'email'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>UserModule::t("email"),
		);
	}
}