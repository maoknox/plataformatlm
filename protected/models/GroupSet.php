<?php

/**
 * This is the model class for table "group_set".
 *
 * The followings are the available columns in table 'group_set':
 * @property integer $group_id
 * @property integer $service_entity_id
 * @property string $group_name
 * @property string $group_label
 * @property string $group_geozone
 *
 * The followings are the available model relations:
 * @property Object[] $objects
 * @property SubGroup[] $subGroups
 * @property SubGroup[] $subGroups1
 * @property ServiceEntity $serviceEntity
 */
class GroupSet extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'group_set';
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
                    array('group_name, group_label, group_geozone', 'length', 'max'=>50),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('group_id, service_entity_id, group_name, group_label, group_geozone', 'safe', 'on'=>'search'),
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
                    'objects' => array(self::MANY_MANY, 'Object', 'group_object(group_id, object_id)'),
                    'subGroups' => array(self::HAS_MANY, 'SubGroup', 'group_id'),
                    'subGroups1' => array(self::HAS_MANY, 'SubGroup', 'sub_group_id'),
                    'serviceEntity' => array(self::BELONGS_TO, 'ServiceEntity', 'service_entity_id'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'group_id' => 'Group',
                    'service_entity_id' => 'Service Entity',
                    'group_name' => 'Group Name',
                    'group_label' => 'Group Label',
                    'group_geozone' => 'Group Geozone',
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

            $criteria->compare('group_id',$this->group_id);
            $criteria->compare('service_entity_id',$this->service_entity_id);
            $criteria->compare('group_name',$this->group_name,true);
            $criteria->compare('group_label',$this->group_label,true);
            $criteria->compare('group_geozone',$this->group_geozone,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GroupSet the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    public static function createTree(&$list, $parent,$serviceId){
         $tree = array();
        $node=array();
        foreach ($parent as $k=>$l){
            $child=self::searchNameChild($l['sub_group_id']);
            $node['text']=$child["group_label"];
            $node['id']=$child["group_id"];
            if(isset($list[$l['sub_group_id']])){
                $node['children'] = GroupSet::createTree($list, $list[$l['sub_group_id']],$serviceId);
                $node=self::createObjectInGroup($node,$l['sub_group_id'],false);                                
            }
            else{
                // echo $l['child_id']."<br>";
                unset($node['children']);                 
                $node=self::createObjectInGroup($node,$l['sub_group_id'],true);                    
            }
            $tree[] = $node;                
        } 

        return $tree;
    }
    public function searchNameChild($groupId){
        $conn=Yii::app()->db;
        $searchGroup="select group_label, group_id from group_set where group_id=:groupId";
        $query=$conn->createCommand($searchGroup);
        $query->bindParam(":groupId", $groupId);
        $read=$query->query();
        $resGroups=$read->read();
        $read->close();
        return $resGroups;
    }
    
    public function createObjectInGroup($node,$groupId,$createNode){    
        $resObjs=self::searchObjectInGroup($groupId);
        if(!empty($resObjs)){
            if($createNode){
                $node["children"]=array();
            }
            foreach($resObjs as $resObj){
                $node["children"][]=array("text"=>$resObj["object_number"],"id"=>"obj_".$resObj["object_id"],"type"=>"file");
            }
        }
        return $node;
    }
    public function searchObjectInGroup($parentGroup){
        $conn=Yii::app()->db;
        $searchGroup="select obj.object_number,obj.object_id from object obj left join group_object gobj on obj.object_id=gobj.object_id where gobj.group_id=:gId";
        $query=$conn->createCommand($searchGroup);
        $query->bindParam(":gId", $parentGroup);
        $read=$query->query();
        $resGroups=$read->readAll();
        $read->close();
        return $resGroups;
    }
    public function changeParentsChild($ch,$parentId,$serviceEntityId){
         //Averigua si tiene padre
        //Si no hace insert en tabla
        if($parentId==='#'){
            $resParentId=GroupSet::searchRootId($serviceEntityId);
            $parentId=$resParentId["group_id"];
        }
        $msg="success";
        $modelSubGroup= SubGroup::model()->findByAttributes(array("sub_group_id"=>$ch));
        if(!$modelSubGroup){
            $modelSubGroup=new SubGroup();
            $modelSubGroup->sub_group_id=$ch;
            $modelSubGroup->group_id=$parentId;
        }
        else{
            $modelSubGroup->group_id=$parentId;
        }
        if(!$modelSubGroup->save()){
            $msg="error";
        }
        return $msg;
    }
    public function searchRootId($serviceEntityId){
        $conn= Yii::app()->db;
        $insObj="select group_id from group_set where group_id not in (select sub_group_id from sub_group) and service_entity_id=:seId;";
        $queryRootId=$conn->createCommand($insObj);
        $queryRootId->bindParam(":seId",$serviceEntityId);
        $readRootId=$queryRootId->query();
        $resRootId=$readRootId->read();
        $readRootId->close();
        return $resRootId;
    }
    
}
