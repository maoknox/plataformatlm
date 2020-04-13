<?php

/**
 * This is the model class for table "anchorage".
 *
 * The followings are the available columns in table 'anchorage':
 * @property integer $anchorage_id
 * @property integer $service_entity_id
 * @property string $anchorage_controller
 * @property string $anchorage_view
 * @property string $anchorage_params
 * @property string $anchorage_name
 *
 * The followings are the available model relations:
 * @property ServiceEntity $serviceEntity
 */
class Anchorage extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'anchorage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_entity_id', 'numerical', 'integerOnly'=>true),
			array('anchorage_controller, anchorage_view, anchorage_name', 'length', 'max'=>50),
			array('anchorage_params', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('anchorage_id, service_entity_id, anchorage_controller, anchorage_view, anchorage_params, anchorage_name', 'safe', 'on'=>'search'),
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
			'serviceEntity' => array(self::BELONGS_TO, 'ServiceEntity', 'service_entity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'anchorage_id' => 'Anchorage',
			'service_entity_id' => 'Service Entity',
			'anchorage_controller' => 'Anchorage Controller',
			'anchorage_view' => 'Anchorage View',
			'anchorage_params' => 'Anchorage Params',
			'anchorage_name' => 'Anchorage Name',
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

		$criteria->compare('anchorage_id',$this->anchorage_id);
		$criteria->compare('service_entity_id',$this->service_entity_id);
		$criteria->compare('anchorage_controller',$this->anchorage_controller,true);
		$criteria->compare('anchorage_view',$this->anchorage_view,true);
		$criteria->compare('anchorage_params',$this->anchorage_params,true);
		$criteria->compare('anchorage_name',$this->anchorage_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Anchorage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
