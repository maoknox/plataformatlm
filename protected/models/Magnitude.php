<?php

/**
 * This is the model class for table "magnitude".
 *
 * The followings are the available columns in table 'magnitude':
 * @property integer $magnitude_id
 * @property integer $measure_system_id
 * @property string $magnitude_name
 * @property string $magnitude_label
 * @property string $magnitude_key
 * @property string $magnitude_unity
 *
 * The followings are the available model relations:
 * @property MeasureSystem $measureSystem
 * @property Object[] $objects
 */
class Magnitude extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'magnitude';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('magnitude_name, magnitude_label', 'required'),
			array('measure_system_id', 'numerical', 'integerOnly'=>true),
			array('magnitude_name, magnitude_label', 'length', 'max'=>25),
			array('magnitude_key, magnitude_unity', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('magnitude_id, measure_system_id, magnitude_name, magnitude_label, magnitude_key, magnitude_unity', 'safe', 'on'=>'search'),
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
			'measureSystem' => array(self::BELONGS_TO, 'MeasureSystem', 'measure_system_id'),
			'objects' => array(self::MANY_MANY, 'Object', 'magnitude_object(magnitude_id, object_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'magnitude_id' => 'Magnitude',
			'measure_system_id' => 'Measure System',
			'magnitude_name' => 'Magnitude Name',
			'magnitude_label' => 'Magnitude Label',
			'magnitude_key' => 'Magnitude Key',
			'magnitude_unity' => 'Magnitude Unity',
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

		$criteria->compare('magnitude_id',$this->magnitude_id);
		$criteria->compare('measure_system_id',$this->measure_system_id);
		$criteria->compare('magnitude_name',$this->magnitude_name,true);
		$criteria->compare('magnitude_label',$this->magnitude_label,true);
		$criteria->compare('magnitude_key',$this->magnitude_key,true);
		$criteria->compare('magnitude_unity',$this->magnitude_unity,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Magnitude the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}
