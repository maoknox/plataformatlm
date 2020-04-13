<?php

/**
 * This is the model class for table "reading".
 *
 * The followings are the available columns in table 'reading':
 * @property integer $reading_id
 * @property integer $object_id
 * @property string $reading_date
 * @property string $reading_register_date
 *
 * The followings are the available model relations:
 * @property Object $object
 * @property Measure[] $measures
 */
class Reading extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reading';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('reading_date, reading_register_date', 'required'),
			array('object_id', 'numerical', 'integerOnly'=>true),
			array('reading_date, reading_register_date', 'length', 'max'=>4),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('reading_id, object_id, reading_date, reading_register_date', 'safe', 'on'=>'search'),
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
			'measures' => array(self::HAS_MANY, 'Measure', 'reading_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'reading_id' => 'Reading',
			'object_id' => 'Object',
			'reading_date' => 'Reading Date',
			'reading_register_date' => 'Reading Register Date',
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

		$criteria->compare('reading_id',$this->reading_id);
		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('reading_date',$this->reading_date,true);
		$criteria->compare('reading_register_date',$this->reading_register_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reading the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public static function getLastLecture($objectId){
            $conn=Yii::app()->db;
            $sql="select reading_date,reading_id from reading where object_id=:objid order by reading_date desc limit 1 ";
            $query=$conn->createCommand($sql);
            $query->bindParam(":objid",$objectId);
            $read=$query->query();
            $res=$read->read();
            $read->close();
            return $res;
        }
        
        public static function validateFrecuency($date,$objectId){
            $conn=Yii::app()->db;
            $sql="select count(*) cn from reading where reading_date between (:date::timestamp - INTERVAL '1 weeks') and :datei and object_id=:objectid ";
            $query=$conn->createCommand($sql);
            $query->bindParam(":date",$date);
            $query->bindParam(":datei",$date);
            $query->bindParam(":objectid",$objectId);
            $read=$query->query();
            $res=$read->read();
            $read->close();
            return $res;
        }
        
        public static function getLectures($date,$objectId,$priods){
            $conn=Yii::app()->db;
            $sql="select reading_date,measure_reading,sum_consumption  from reading rd 
                left join measure ms on ms.reading_id=rd.reading_id
                left join water_data wd on wd.reading_id=rd.reading_id
                where reading_date < (:date::timestamp - INTERVAL '1 weeks') 
                and object_id=:objectId
                order by rd.reading_id desc limit :periods";
            $query=$conn->createCommand($sql);
            $query->bindParam(":date",$date);
            $query->bindParam(":objectId",$objectId);
            $query->bindParam(":periods",$priods);
            $read=$query->query();
            $res=$read->readAll();
            $read->close();
            usort($res, function($a, $b) {
                return $a['reading_date'] <=> $b['reading_date'];
            });
            return $res;
            
        }
}
