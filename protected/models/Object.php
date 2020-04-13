<?php

/**
 * This is the model class for table "object".
 *
 * The followings are the available columns in table 'object':
 * @property integer $object_id
 * @property integer $service_entity_id
 * @property integer $type_object_id
 * @property string $object_number
 * @property string $object_min_warn
 * @property string $object_max_warn
 * @property string $object_address
 * @property string $object_latitude
 * @property string $object_longitude
 * @property integer $object_status_id
 * @property integer $city_id
 *
 * The followings are the available model relations:
 * @property Measure[] $measures
 * @property AlarmObject[] $alarmObjects
 * @property ExtraData[] $extraDatas
 * @property Magnitude[] $magnitudes
 * @property MasterObject[] $masterObjects
 * @property MasterObject[] $masterObjects1
 * @property EntitySuscriptor[] $entitySuscriptors
 * @property ReadedAlarm[] $readedAlarms
 * @property TypeObject $typeObject
 * @property ServiceEntity $serviceEntity
 * @property ObjectStatus $objectStatus
 * @property City $city
 * @property Route[] $routes
 * @property GroupSet[] $groupSets
 * @property Caracteristic[] $caracteristics
 * @property Reading[] $readings
 */
class Object extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_number', 'required'),
			array('service_entity_id, type_object_id, object_status_id, city_id', 'numerical', 'integerOnly'=>true),
			array('object_number', 'length', 'max'=>100),
			array('object_latitude, object_longitude', 'length', 'max'=>1000),
			array('object_min_warn, object_max_warn, object_address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('object_id, service_entity_id, type_object_id, object_number, object_min_warn, object_max_warn, object_address, object_latitude, object_longitude, object_status_id, city_id', 'safe', 'on'=>'search'),
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
			'measures' => array(self::HAS_MANY, 'Measure', 'object_id'),
			'alarmObjects' => array(self::HAS_MANY, 'AlarmObject', 'object_id'),
			'extraDatas' => array(self::HAS_MANY, 'ExtraData', 'object_id'),
			'magnitudes' => array(self::MANY_MANY, 'Magnitude', 'magnitude_object(object_id, magnitude_id)'),
			'masterObjects' => array(self::HAS_MANY, 'MasterObject', 'object_parent_id'),
			'masterObjects1' => array(self::HAS_MANY, 'MasterObject', 'object_child_id'),
			'entitySuscriptors' => array(self::MANY_MANY, 'EntitySuscriptor', 'object_suscriptor(object_id, entity_suscriptor_id)'),
			'readedAlarms' => array(self::HAS_MANY, 'ReadedAlarm', 'object_id'),
			'typeObject' => array(self::BELONGS_TO, 'TypeObject', 'type_object_id'),
			'serviceEntity' => array(self::BELONGS_TO, 'ServiceEntity', 'service_entity_id'),
			'objectStatus' => array(self::BELONGS_TO, 'ObjectStatus', 'object_status_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'routes' => array(self::MANY_MANY, 'Route', 'route_object(object_id, route_id)'),
			'groupSets' => array(self::MANY_MANY, 'GroupSet', 'group_object(object_id, group_id)'),
			'caracteristics' => array(self::MANY_MANY, 'Caracteristic', 'object_caracteristic(object_id, caracteristic_id)'),
			'readings' => array(self::HAS_MANY, 'Reading', 'object_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'object_id' => 'Object',
			'service_entity_id' => 'Service Entity',
			'type_object_id' => 'Type Object',
			'object_number' => 'Object Number',
			'object_min_warn' => 'Object Min Warn',
			'object_max_warn' => 'Object Max Warn',
			'object_address' => 'Object Address',
			'object_latitude' => 'Object Latitude',
			'object_longitude' => 'Object Longitude',
			'object_status_id' => 'Object Status',
			'city_id' => 'City',
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

		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('service_entity_id',$this->service_entity_id);
		$criteria->compare('type_object_id',$this->type_object_id);
		$criteria->compare('object_number',$this->object_number,true);
		$criteria->compare('object_min_warn',$this->object_min_warn,true);
		$criteria->compare('object_max_warn',$this->object_max_warn,true);
		$criteria->compare('object_address',$this->object_address,true);
		$criteria->compare('object_latitude',$this->object_latitude,true);
		$criteria->compare('object_longitude',$this->object_longitude,true);
		$criteria->compare('object_status_id',$this->object_status_id);
		$criteria->compare('city_id',$this->city_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Object the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        /**
     * Returns objects by service entity.
     * @param int $serviceEntity.
     * @return array $resObject
     */
    public static function searchObjectsByEntityService($serviceEntity){
        $conn=Yii::app()->db;
        $sqlSObj="select * from object where service_entity_id=:seId";
        $querySobj=$conn->createCommand($sqlSObj);
        $querySobj->bindParam(":seId",$serviceEntity);
        $readSObj=$querySobj->query();
        $resSObj=$readSObj->readAll();
        $readSObj->close();
        return $resSObj;
    }
}
