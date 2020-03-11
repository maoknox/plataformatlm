<?php

/**
 * This is the model class for table "group_object".
 *
 * The followings are the available columns in table 'group_object':
 * @property integer $object_id
 * @property integer $group_id
 */
class GroupObject extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group_object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('object_id, group_id', 'required'),
			array('object_id, group_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('object_id, group_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'object_id' => 'Object',
			'group_id' => 'Group',
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

		$criteria->compare('object_id',$this->object_id);
		$criteria->compare('group_id',$this->group_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GroupObject the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
    public static function getObjectsWithoutGroup($tree,$erviceEntityId){
        $conn=Yii::app()->db;
        $sqlObjWtGr="select obj.* from object obj left join group_object gob on obj.object_id=gob.object_id where group_id is null and service_entity_id=:seid";
        $query=$conn->createCommand($sqlObjWtGr);
        $query->bindParam(":seid",$erviceEntityId);
        $read=$query->query();
        $resObjWtGr=$read->readAll();
        $read->close();
        if(!empty($resObjWtGr)){        
            foreach($resObjWtGr as $object){
                $tree[]=array("text"=>$object["object_number"],"id"=>"obj_".$object["object_id"],"type"=>"file");
            }
        }
        return $tree;
    }
    public static function changeParentsObject($ch,$parentId,$serviceEntityId){        
        $msg="success";
        $modelGroupObject= GroupObject::model()->findByAttributes(array("object_id"=>$ch));
        if($parentId==='#'){
            if($modelGroupObject){
                if(!$modelGroupObject->delete()){
                    $msg="error";
                }
            }
        }
        else{
            if(!$modelGroupObject){
                $modelGroupObject=new GroupObject();
                $modelGroupObject->object_id=$ch;
                $modelGroupObject->group_id=$parentId;
                if(!$modelGroupObject->save()){
                    $msg="error";
                }

            }
            else{
                $modelGroupObject->group_id=$parentId;
                if(!$modelGroupObject->save()){
                    $msg="error";
                }
            }
        }
        return $msg;
    }
}
