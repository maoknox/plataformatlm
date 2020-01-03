<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property integer $person_id
 * @property integer $company_id
 * @property integer $type_document_id
 * @property integer $city_id
 * @property string $person_number_id
 * @property string $person_name
 * @property string $person_lastname
 * @property string $username
 * @property string $password
 *
 * The followings are the available model relations:
 * @property CompanySuscriptor[] $companySuscriptors
 * @property Role[] $roles
 * @property Authitem[] $authitems
 * @property City $city
 * @property Company $company
 * @property TypeDocument $typeDocument
 */
class Person extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person_number_id', 'required'),
			array('company_id, type_document_id, city_id', 'numerical', 'integerOnly'=>true),
			array('person_number_id, person_name, person_lastname', 'length', 'max'=>50),
			array('username', 'length', 'max'=>25),
			array('password', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('person_id, company_id, type_document_id, city_id, person_number_id, person_name, person_lastname, username, password', 'safe', 'on'=>'search'),
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
			'companySuscriptors' => array(self::HAS_MANY, 'CompanySuscriptor', 'person_id'),
			'roles' => array(self::MANY_MANY, 'Role', 'person_role(person_id, role_id)'),
			'authitems' => array(self::MANY_MANY, 'Authitem', 'authassignment(userid, itemname)'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'typeDocument' => array(self::BELONGS_TO, 'TypeDocument', 'type_document_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'person_id' => 'Person',
			'company_id' => 'Company',
			'type_document_id' => 'Type Document',
			'city_id' => 'City',
			'person_number_id' => 'Person Number',
			'person_name' => 'Person Name',
			'person_lastname' => 'Person Lastname',
			'username' => 'Nombre de usuario',
			'password' => 'Password',
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

		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('type_document_id',$this->type_document_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('person_number_id',$this->person_number_id,true);
		$criteria->compare('person_name',$this->person_name,true);
		$criteria->compare('person_lastname',$this->person_lastname,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        public static function validateAccess(){
            
            Yii::app()->user->checkAccess("AdministradorUsuarios");
            return $result;
        }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Person the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getRole(){
            $idPerson=Yii::app()->user->getId(); 
            $personRole;
        }
}
