<?php

/**
 * This is the model class for table "euser".
 *
 * The followings are the available columns in table 'euser':
 * @property integer $euser_id
 * @property string $username
 * @property string $password
 * @property string $euser_name
 * @property string $euser_lastname
 * @property string $euser_phone
 * @property string $euser_celphone
 *
 * The followings are the available model relations:
 * @property Authitem[] $authitems
 * @property Entity[] $entities
 * @property Role[] $roles
 */
class Euser extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'euser';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password', 'required'),
			array('username', 'length', 'max'=>25),
			array('euser_name, euser_lastname, euser_phone, euser_celphone', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('euser_id, username, password, euser_name, euser_lastname, euser_phone, euser_celphone', 'safe', 'on'=>'search'),
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
			'authitems' => array(self::MANY_MANY, 'Authitem', 'authassignment(userid, itemname)'),
			'entities' => array(self::MANY_MANY, 'Entity', 'entity_user(euser_id, entity_id)'),
			'roles' => array(self::MANY_MANY, 'Role', 'user_role(euser_id, role_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'euser_id' => 'Euser',
			'username' => 'Username',
			'password' => 'Password',
			'euser_name' => 'Euser Name',
			'euser_lastname' => 'Euser Lastname',
			'euser_phone' => 'Euser Phone',
			'euser_celphone' => 'Euser Celphone',
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

		$criteria->compare('euser_id',$this->euser_id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('euser_name',$this->euser_name,true);
		$criteria->compare('euser_lastname',$this->euser_lastname,true);
		$criteria->compare('euser_phone',$this->euser_phone,true);
		$criteria->compare('euser_celphone',$this->euser_celphone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Euser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
	 * Returns the user's role.
	 * @return Role
	 */
        public static function getRole(){
            $userId=Yii::app()->user->getId();
            $userRole= UserRole::model()->findByAttributes(array("euser_id"=>$userId));
            $role= Role::model()->findByPk($userRole->role_id);
            return $role;
        }
        
}
