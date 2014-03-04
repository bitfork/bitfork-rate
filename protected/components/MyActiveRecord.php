<?php
class MyActiveRecord extends CActiveRecord
{
	public function behaviors()
	{
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'application.components.behavior.AutoTimestampBehavior',
			)
		);
	}

	public function defaultScope()
	{
		return array(
			'condition' => $this->getTableAlias(false, false) . ".is_active=1",
		);
	}
}