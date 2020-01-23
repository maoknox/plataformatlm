<?php

/**
 * This is the model class for table "entity".
 *
 * The followings are the available columns in table 'entity':
 * @property integer $entity_id
 * @property integer $city_id
 * @property integer $type_document_id
 * @property integer $type_entity_id
 * @property string $entity_number_id
 * @property string $entity_name
 * @property string $entity_address
 * @property string $entity_phone
 * @property string $entity_celphone
 *
 * The followings are the available model relations:
 * @property Euser[] $eusers
 * @property EntitySuscriptor[] $entitySuscriptors
 * @property EntitySuscriptor[] $entitySuscriptors1
 * @property City $city
 * @property TypeDocument $typeDocument
 * @property TypeEntity $typeEntity
 * @property ServiceEntity[] $serviceEntities
 */
class Entity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_number_id', 'required'),
			array('city_id, type_document_id, type_entity_id', 'numerical', 'integerOnly'=>true),
			array('entity_number_id, entity_phone, entity_celphone', 'length', 'max'=>50),
			array('entity_name, entity_address', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('entity_id, city_id, type_document_id, type_entity_id, entity_number_id, entity_name, entity_address, entity_phone, entity_celphone', 'safe', 'on'=>'search'),
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
			'eusers' => array(self::MANY_MANY, 'Euser', 'entity_user(entity_id, euser_id)'),
			'entitySuscriptors' => array(self::HAS_MANY, 'EntitySuscriptor', 'entity_id'),
			'entitySuscriptors1' => array(self::HAS_MANY, 'EntitySuscriptor', 'suscriptor_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'typeDocument' => array(self::BELONGS_TO, 'TypeDocument', 'type_document_id'),
			'typeEntity' => array(self::BELONGS_TO, 'TypeEntity', 'type_entity_id'),
			'serviceEntities' => array(self::HAS_MANY, 'ServiceEntity', 'entity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'entity_id' => 'Entity',
			'city_id' => 'City',
			'type_document_id' => 'Type Document',
			'type_entity_id' => 'Type Entity',
			'entity_number_id' => 'Entity Number',
			'entity_name' => 'Entity Name',
			'entity_address' => 'Entity Address',
			'entity_phone' => 'Entity Phone',
			'entity_celphone' => 'Entity Celphone',
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

		$criteria->compare('entity_id',$this->entity_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('type_document_id',$this->type_document_id);
		$criteria->compare('type_entity_id',$this->type_entity_id);
		$criteria->compare('entity_number_id',$this->entity_number_id,true);
		$criteria->compare('entity_name',$this->entity_name,true);
		$criteria->compare('entity_address',$this->entity_address,true);
		$criteria->compare('entity_phone',$this->entity_phone,true);
		$criteria->compare('entity_celphone',$this->entity_celphone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Entity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
