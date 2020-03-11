<?php

/**
 * This is the model class for table "measure".
 *
 * The followings are the available columns in table 'measure':
 * @property integer $measure_id
 * @property integer $object_id
 * @property string $measure_data
 * @property string $measure_date
 *
 * The followings are the available model relations:
 * @property WaterData[] $waterDatas
 * @property Object $object
 */
class Measure extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'measure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id', 'numerical', 'integerOnly'=>true),
			array('measure_data, measure_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('measure_id, object_id, measure_data, measure_date', 'safe', 'on'=>'search'),
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
			'waterDatas' => array(self::HAS_MANY, 'WaterData', 'measure_id'),
			'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'measure_id' => 'Measure',
			'object_id' => 'Object',
			'measure_data' => 'Measure Data',
			'measure_date' => 'Measure Date',
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

		$criteria->compare('measure_id',$this->measure_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('measure_data',$this->measure_data,true);
		$criteria->compare('measure_date',$this->measure_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Measure the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function searchLastRead($firstDay,$lastDay,$objectId){
            $conn=Yii::app()->db;
            $sqlFLLect="select 
                (select measure_data from measure where measure_date between :firstDate and :lastDate and object_id=:objId order by measure_id asc limit 1) oldLecture,
                (select measure_data from measure where measure_date between :firstDate and :lastDate and object_id=:objId order by measure_id desc limit 1) newLecture;";
            $queryFLLect=$conn->createCommand($sqlFLLect);
            $queryFLLect->bindParam(":firstDate",$firstDay);
            $queryFLLect->bindParam(":lastDate",$lastDay);
            $queryFLLect->bindParam(":objId",$objectId);
            $readFLLect=$queryFLLect->query();
            $res=$readFLLect->read();
            $readFLLect->close();
            return $res;
            
            
            
            
        }
}
