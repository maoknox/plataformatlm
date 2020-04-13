<?php

/**
 * This is the model class for table "object_suscriptor".
 *
 * The followings are the available columns in table 'object_suscriptor':
 * @property integer $entity_suscriptor_id
 * @property integer $object_id
 * @property string $address_object
 */
class ObjectSuscriptor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'object_suscriptor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_suscriptor_id, object_id', 'required'),
			array('entity_suscriptor_id, object_id', 'numerical', 'integerOnly'=>true),
			array('address_object', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('entity_suscriptor_id, object_id, address_object', 'safe', 'on'=>'search'),
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
			'entity_suscriptor_id' => 'Entity Suscriptor',
			'object_id' => 'Object',
			'address_object' => 'Address Object',
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

		$criteria->compare('entity_suscriptor_id',$this->entity_suscriptor_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('address_object',$this->address_object,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ObjectSuscriptor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
