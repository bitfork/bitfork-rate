<?php

/**
 * This is the model class for table "integration".
 *
 * The followings are the available columns in table 'integration':
 * @property integer $id
 * @property string $email
 * @property string $site
 * @property string $comment
 * @property integer $is_active
 * @property string $create_date
 * @property string $mod_date
 */
class Integration extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'integration';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, site, create_date, mod_date', 'required'),
			array('is_active', 'numerical', 'integerOnly'=>true),
			array('email, site', 'length', 'max'=>1024),
			array('email', 'email'),
			array('comment', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, site, comment, is_active, create_date, mod_date', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'email' => 'Email',
			'site' => 'Site',
			'comment' => 'Comment',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('comment',$this->comment,true);
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
	 * @return Integration the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	protected function afterSave()
	{
		parent::afterSave();
		if ($this->isNewRecord) {
			$this->sendMail();
		}
	}

	public function sendMail()
	{
		$_admin_from = 'robot';
		$_admin_email = 'robot@bitfork-rate.com';
		$subject = 'Bitfork-rate CREATE INTEGRATION';
		$email = 'ens.rationis@bono-idea.com';
		$message = 'email: '. $this->email ."<br />".
			'site: '. $this->site ."<br />".
			'comment: '. $this->comment;
		$headers = "MIME-Version: 1.0\r\nFrom: $_admin_from\r\nReply-To: $_admin_email\r\nContent-Type: text/html; charset=utf-8";
		$message = wordwrap($message, 70);
		$message = str_replace("\n.", "\n..", $message);
		return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
}
