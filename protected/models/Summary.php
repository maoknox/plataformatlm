<?php

/**
 * This is the model class for table "summary".
 *
 * The followings are the available columns in table 'summary':
 * @property integer $summary_id
 * @property integer $service_id
 * @property string $summary_name
 * @property string $summary_label
 * @property string $summary_sql
 * @property string $summary_icon
 * @property string $summary_url
 * @property string $summary_url_name
 *
 * The followings are the available model relations:
 * @property Service $service
 */
class Summary extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'summary';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('summary_name, summary_label, summary_sql', 'required'),
			array('service_id', 'numerical', 'integerOnly'=>true),
			array('summary_name, summary_label, summary_icon', 'length', 'max'=>50),
			array('summary_url_name', 'length', 'max'=>20),
			array('summary_url', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('summary_id, service_id, summary_name, summary_label, summary_sql, summary_icon, summary_url, summary_url_name', 'safe', 'on'=>'search'),
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
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'summary_id' => 'Summary',
			'service_id' => 'Service',
			'summary_name' => 'Summary Name',
			'summary_label' => 'Summary Label',
			'summary_sql' => 'Summary Sql',
			'summary_icon' => 'Summary Icon',
			'summary_url' => 'Summary Url',
			'summary_url_name' => 'Summary Url Name',
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

		$criteria->compare('summary_id',$this->summary_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('summary_name',$this->summary_name,true);
		$criteria->compare('summary_label',$this->summary_label,true);
		$criteria->compare('summary_sql',$this->summary_sql,true);
		$criteria->compare('summary_icon',$this->summary_icon,true);
		$criteria->compare('summary_url',$this->summary_url,true);
		$criteria->compare('summary_url_name',$this->summary_url_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Summary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
