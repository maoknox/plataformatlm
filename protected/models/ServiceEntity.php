<?php

/**
 * This is the model class for table "service_entity".
 *
 * The followings are the available columns in table 'service_entity':
 * @property integer $service_company_id
 * @property integer $service_id
 * @property integer $entity_id
 *
 * The followings are the available model relations:
 * @property Indicator[] $indicators
 * @property Object[] $objects
 * @property Entity $entity
 * @property Service $service
 */
class ServiceEntity extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service_entity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, entity_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('service_company_id, service_id, entity_id', 'safe', 'on'=>'search'),
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
			'indicators' => array(self::MANY_MANY, 'Indicator', 'indicator_service_entity(service_company_id, indicador_id)'),
			'objects' => array(self::HAS_MANY, 'Object', 'service_company_id'),
			'entity' => array(self::BELONGS_TO, 'Entity', 'entity_id'),
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'service_company_id' => 'Service Company',
			'service_id' => 'Service',
			'entity_id' => 'Entity',
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

		$criteria->compare('service_company_id',$this->service_company_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('entity_id',$this->entity_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceEntity the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
