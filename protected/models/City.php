<?php

/**
 * This is the model class for table "city".
 *
 * The followings are the available columns in table 'city':
 * @property integer $city_id
 * @property integer $state_id
 * @property string $city_name
 * @property string $city_label
 * @property string $city_code
 *
 * The followings are the available model relations:
 * @property State $state
 * @property Object[] $objects
 * @property Entity[] $entities
 */
class City extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'city';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('city_name', 'required'),
			array('state_id', 'numerical', 'integerOnly'=>true),
			array('city_name, city_label, city_code', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('city_id, state_id, city_name, city_label, city_code', 'safe', 'on'=>'search'),
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
			'state' => array(self::BELONGS_TO, 'State', 'state_id'),
			'objects' => array(self::HAS_MANY, 'Object', 'city_id'),
			'entities' => array(self::HAS_MANY, 'Entity', 'city_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'city_id' => 'City',
			'state_id' => 'State',
			'city_name' => 'City Name',
			'city_label' => 'City Label',
			'city_code' => 'City Code',
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

		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('city_name',$this->city_name,true);
		$criteria->compare('city_label',$this->city_label,true);
		$criteria->compare('city_code',$this->city_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return City the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
