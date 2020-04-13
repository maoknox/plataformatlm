<?php

/**
 * This is the model class for table "water_data".
 *
 * The followings are the available columns in table 'water_data':
 * @property integer $water_data_id
 * @property integer $object_id
 * @property string $consumption
 * @property integer $critic
 * @property string $manual
 * @property string $micromedition
 * @property string $water_data_date
 *
 * The followings are the available model relations:
 * @property Object $object
 */
class WaterData extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'water_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('consumption', 'required'),
			array('object_id, critic', 'numerical', 'integerOnly'=>true),
			array('water_data_date', 'length', 'max'=>4),
			array('manual, micromedition', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('water_data_id, object_id, consumption, critic, manual, micromedition, water_data_date', 'safe', 'on'=>'search'),
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
			'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'water_data_id' => 'Water Data',
			'object_id' => 'Object',
			'consumption' => 'Consumption',
			'critic' => 'Critic',
			'manual' => 'Manual',
			'micromedition' => 'Micromedition',
			'water_data_date' => 'Water Data Date',
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

		$criteria->compare('water_data_id',$this->water_data_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('consumption',$this->consumption,true);
		$criteria->compare('critic',$this->critic);
		$criteria->compare('manual',$this->manual,true);
		$criteria->compare('micromedition',$this->micromedition,true);
		$criteria->compare('water_data_date',$this->water_data_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WaterData the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
