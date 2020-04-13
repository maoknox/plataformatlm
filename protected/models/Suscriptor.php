<?php

/**
 * This is the model class for table "suscriptor".
 *
 * The followings are the available columns in table 'suscriptor':
 * @property integer $suscriptor_id
 * @property string $suscriptor_code
 * @property string $suscriptor_name
 * @property string $suscriptor_address
 * @property string $suscriptor_celphone
 *
 * The followings are the available model relations:
 * @property EntitySuscriptor[] $entitySuscriptors
 */
class Suscriptor extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'suscriptor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('suscriptor_code, suscriptor_celphone', 'length', 'max'=>50),
			array('suscriptor_name', 'length', 'max'=>100),
			array('suscriptor_address', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('suscriptor_id, suscriptor_code, suscriptor_name, suscriptor_address, suscriptor_celphone', 'safe', 'on'=>'search'),
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
			'entitySuscriptors' => array(self::HAS_MANY, 'EntitySuscriptor', 'suscriptor_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'suscriptor_id' => 'Suscriptor',
			'suscriptor_code' => 'Suscriptor Code',
			'suscriptor_name' => 'Suscriptor Name',
			'suscriptor_address' => 'Suscriptor Address',
			'suscriptor_celphone' => 'Suscriptor Celphone',
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

		$criteria->compare('suscriptor_id',$this->suscriptor_id);
		$criteria->compare('suscriptor_code',$this->suscriptor_code,true);
		$criteria->compare('suscriptor_name',$this->suscriptor_name,true);
		$criteria->compare('suscriptor_address',$this->suscriptor_address,true);
		$criteria->compare('suscriptor_celphone',$this->suscriptor_celphone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Suscriptor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
