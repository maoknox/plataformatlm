<?php

class WaterController extends Controller{
     /**
    * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
    * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
    */
    public function filterEnforcelogin($filterChain){
        if(Yii::app()->user->isGuest){
            if(isset($_POST) && !empty($_POST)){
                if(Yii::app()->request->isAjaxRequest){
                    $response["status"]="nosession";
                    echo CJSON::encode($response);
                    exit();
                }
                else{
                    Yii::app()->user->returnUrl = array("site/login");                                                          
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            else{
                Yii::app()->user->returnUrl = array("site/login");                                                          
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        else{
            if(!isset($_POST)){
                Yii::app()->user->returnUrl = array("site/index");          
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $filterChain->run();
    }
    /**
     * @return array action filters
     */
    public function filters(){
        return array(
                'enforcelogin',                      
        );
    }
    public function actionIndex(){
        $entitServiceId=Yii::app()->request->getPost("entit_service_id");
        $modelObject= Object::searchObjectsByEntityService($entitServiceId);
        $this->render('index',array('entitServiceId'=>$entitServiceId));
    }
        
    public function actionGetTree(){
        $response=array();
        $response["status"]="success";
        $modelService= Service::model()->findByAttributes(array("service_name"=>'gestion_hidrica'));
        $idEntity= EntityUser::getEntity();
        $modelServiceEntity= ServiceEntity::model()->findByAttributes(array("entity_id"=>$idEntity,"service_id"=>$modelService->service_id));
        $conn=Yii::app()->db;
        $serviceEntityId=$modelServiceEntity->service_entity_id;
        $searchGroupSb="select * from sub_group sb left join group_set gs on gs.group_id=sb.group_id where gs.service_entity_id=:seid order by sb.group_id desc";
        $query=$conn->createCommand($searchGroupSb);
        $query->bindParam(":seid", $serviceEntityId);
        $read=$query->query();
        $resGroupsSg=$read->readAll();
        $read->close();
        $tree=array();
        if(!empty($resGroupsSg)){
            $new = array();
            foreach ($resGroupsSg as $pk=>$pGroup){            
                $new[$pGroup['group_id']][] = $pGroup;
            }
            ksort($new);
            $firstKey = key($new);
            $tree = GroupSet::createTree($new, $new[1],$modelService->service_id); // changed
            foreach($tree as $pk=>$tr){
//                $tree[$pk]["type"]="root";
            }
        }        
        $tree= GroupObject::getObjectsWithoutGroup($tree,$modelService->service_id);
        $response["tree"]=$tree;
        echo CJSON::encode($response);
    }
    public function actionSearchInfoDTables(){
        $conn=Yii::app()->db;
        $modelServiceEnity= ServiceEntity::getServiceEntityGH();       
        $serviceEntity=$modelServiceEnity->service_entity_id;
        $sqlSearchObjects="select * from object obj 
        left join object_suscriptor objs on objs.object_id=obj.object_id 
        left join entity_suscriptor es on es.company_suscriptor_id=objs.company_suscriptor_id
        left join entity et on et.entity_id=es.suscriptor_id 
        left join measure ms on ms.object_id=obj.object_id
        where obj.service_entity_id=:seId order by measure_date desc limit 1;";
         $querySobj=$conn->createCommand($sqlSearchObjects);
        $querySobj->bindParam(":seId",$serviceEntity);
        $readSObj=$querySobj->query();
        $resSObj=$readSObj->readAll();
        $readSObj->close();
        $dataRes=array();
        if(!empty($resSObj)){
            foreach($resSObj as $pk=>$res){
                $unity="";
                $dataAux=array();
                $dataAux[]=$res["object_number"];
                $dataAux[]=$res["entity_number_id"];
                $measDatas= json_decode($res["measure_data"],true);
                $modelMagnitude= Magnitude::model()->findByAttributes(array("magnitude_key"=>$measDatas[0]["magnitude_key"]));
                if($modelMagnitude){
                    $unity=$modelMagnitude->magnitude_unity;
                }
                $dataAux[]=$measDatas[0]["measure"]." ".$unity;
                $dataAux[]=$res["measure_date"];
                $date=New DateTime($res["measure_date"]);
                $date->sub(new DateInterval('P1M'));
                $firstDay=$date->modify("first day of this month")->format("Y-m-d 00:00:00");
                $lastDay=$date->modify("last day of this month")->format("Y-m-d 23:59:59");
                $consLastMonth= Measure::searchLastRead($firstDay,$lastDay,$res["object_id"]);
                $consumption=0;
                if(!empty($consLastMonth)){
                    $oldLecture= json_decode($consLastMonth["oldlecture"],true);
                    $newLecture= json_decode($consLastMonth["newlecture"],true);
                    $consumption=(float)$newLecture[0]["measure"]-(float)$oldLecture[0]["measure"];
                }
                $dataAux[]=$consumption." ".$unity;
                $dataRes[]=$dataAux;
            }
        } 
        $lectura["data"]=$dataRes;
        echo CJSON::encode($lectura);
    }
    public function actionChangeNode(){
        $childrenId= Yii::app()->request->getPost("children_id");
        $parentId= Yii::app()->request->getPost("parent_id");
        $modelServiceEnity= ServiceEntity::getServiceEntityGH();
        if(strstr($parentId,"obj_")){
            $msg="Un objeto no puede tener hijos";
        }
        else{
            $ch=$childrenId;
            if(count(explode("obj_",$childrenId)) ===2){
                $ch=explode("obj_",$childrenId)[1];
                //cambia padre de objeto
                $msg= GroupObject::changeParentsObject($ch,$parentId,$modelServiceEnity->service_entity_id);
            }
            else{
                //cambia padre de hijo
                $msg= GroupSet::changeParentsChild($ch,$parentId,$modelServiceEnity->service_entity_id);
            }
        }

        echo json_encode($msg);
    }
    public function actionCreateGroup(){
        $result=array();
        $result["status"]="success";
        $childName= Yii::app()->request->getPost("childName");
        $parentId= Yii::app()->request->getPost("parentId");
        $modelServiceEnity= ServiceEntity::getServiceEntityGH();
        $modelGroupSet=new GroupSet();
        $modelGroupSet->group_name=$childName;
        $modelGroupSet->group_label=$childName;
        $modelGroupSet->service_entity_id=$modelServiceEnity->service_entity_id;
        if($modelGroupSet->save()){
            $result["groupid"]=$modelGroupSet->group_id;
            $modelSubGroup= new SubGroup();
            $modelSubGroup->sub_group_id=$modelGroupSet->group_id;
            $modelSubGroup->group_id=$parentId;
            if(!$modelSubGroup->save()){
                $result["status"]="danger";
            }
        }
        else{
            $result["status"]="danger";
        }
        echo CJSON::encode($result);
//        echo CHtml::jsonjson_encode($result);
    }
    
    public function actionRenameGroup(){
        $result=array();
        $result["status"]="success";
        $groupId= Yii::app()->request->getPost("groupId");
        $groupName= Yii::app()->request->getPost("groupName");
        $modelGroupSet= GroupSet::model()->findByPk($groupId);
        $modelGroupSet->group_name=$groupName;
        $modelGroupSet->group_label=$groupName;
        if(!$modelGroupSet->save()){
            $result["status"]="error";
        }
        echo json_encode($result);
    }
}