<?php

/**
 * This is the model class for table "entity_suscriptor".
 *
 * The followings are the available columns in table 'entity_suscriptor':
 * @property integer $entity_suscriptor_id
 * @property integer $entity_id
 * @property integer $suscriptor_id
 *
 * The followings are the available model relations:
 * @property Object[] $objects
 * @property Entity $entity
 * @property Suscriptor $suscriptor
 */
class EntitySuscriptor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'entity_suscriptor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id, suscriptor_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('entity_suscriptor_id, entity_id, suscriptor_id', 'safe', 'on'=>'search'),
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
			'objects' => array(self::MANY_MANY, 'Object', 'object_suscriptor(entity_suscriptor_id, object_id)'),
			'entity' => array(self::BELONGS_TO, 'Entity', 'entity_id'),
			'suscriptor' => array(self::BELONGS_TO, 'Suscriptor', 'suscriptor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'entity_suscriptor_id' => 'Entity Suscriptor',
			'entity_id' => 'Entity',
			'suscriptor_id' => 'Suscriptor',
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
		$criteria->compare('entity_id',$this->entity_id);
		$criteria->compare('suscriptor_id',$this->suscriptor_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return EntitySuscriptor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
