<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $service_id
 * @property string $service_name
 * @property string $service_label
 * @property string $service_icon
 *
 * The followings are the available model relations:
 * @property ServiceEntity[] $serviceEntities
 * @property Summary[] $summaries
 * @property Menu[] $menus
 */
class Service extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_name, service_label', 'required'),
			array('service_name, service_label', 'length', 'max'=>50),
			array('service_icon', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('service_id, service_name, service_label, service_icon', 'safe', 'on'=>'search'),
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
			'serviceEntities' => array(self::HAS_MANY, 'ServiceEntity', 'service_id'),
			'summaries' => array(self::HAS_MANY, 'Summary', 'service_id'),
			'menus' => array(self::HAS_MANY, 'Menu', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'service_id' => 'Service',
			'service_name' => 'Service Name',
			'service_label' => 'Service Label',
			'service_icon' => 'Service Icon',
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

		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('service_name',$this->service_name,true);
		$criteria->compare('service_label',$this->service_label,true);
		$criteria->compare('service_icon',$this->service_icon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Service the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
