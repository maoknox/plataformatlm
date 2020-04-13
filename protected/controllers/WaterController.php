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
        $params=$_REQUEST;
        $columns=array(
            0=>array("column_name"=>"object_number","type"=>"string"),
            1=>array("column_name"=>"suscriptor_name","type"=>"string"),
            2=>array("column_name"=>"magnitude_key","type"=>"string"),
            3=>array("column_name"=>"measure_reading","type"=>"float"),
            4=>array("column_name"=>"measure_date","type"=>"date"),
            5=>array("column_name"=>"sum_consumption","type"=>"float"),
            
        );
        $where="";
        $where .=" AND (";
        $count=0;
        $condition="";
        foreach($columns as $pk=>$column){
            if(!empty($params['columns'][$pk]["search"]['value'])){
                if($column["type"]=="float"){
                    preg_match('/[^\d]+/', pg_escape_string($params['columns'][$pk]['search']['value']), $textMatch);
                    preg_match('/\d+/', pg_escape_string($params['columns'][$pk]['search']['value']), $numMatch);                    
                    if(!$textMatch){
                        $textMatch=" =";
                    }elseif(is_array($textMatch)){
                        if(!in_array(str_replace(" ", "", $textMatch[0]),array("<",">",">=","<=","="))){
                            $textMatch="=";
                        }
                        else{
                            $textMatch= str_replace(" ", "", $textMatch[0]);
                        }
                    }                    
                    if(!$numMatch){
                        $numMatch=0;
                    }
                    else{
                        $numMatch=$numMatch[0];
                    }
                    $condition=$column["column_name"]." ".$textMatch." ".$numMatch;
                    
                }elseif($column["type"]=="date"){
                    preg_match('/\\d{4}\\-\\d{2}\\-\\d{2}\\ \\d{2}\\:\\d{2}\\:\\d{2}/',$params['columns'][$pk]['search']['value'],$date);
                    if($date){
                        $compArr=explode($date[0], $params['columns'][$pk]['search']['value']);
                        if(!in_array(str_replace(" ", "", $compArr[0]),array("<",">",">=","<=","="))){
                            $comp="=";
                        }
                        else{
                            $comp= str_replace(" ", "", $compArr[0]);
                        }
                        $d =DateTime::createFromFormat("Y-m-d H:i:s", $date[0]);                        
                        if($d && $d->format("Y-m-d H:i:s")==$date[0]){
                            $condition="ms.".$column["column_name"]."  ".$comp." '".$date[0]."'";
                        }
                    }
                }
                elseif($column["type"]=="string"){
                    $condition=$column["column_name"]." ILIKE '%".pg_escape_string($params['columns'][$pk]['search']['value'])."%'";                    
                }
                if($count==0){
                    $where .=" ".$condition." ";
                }
                else{
                    $where .=" OR ".$condition." ";
                }
                $count++;
            }
        }
        $where .=")";
        if(empty($condition)){
            $where="";
        }  
        $serviceEntity=$modelServiceEnity->service_entity_id;
        $date=New DateTime(date("Y-m-d H:i:s"));
        $date->sub(new DateInterval('P2M'));
        $firstDay=$date->modify("first day of this month")->format("Y-m-d 00:00:00");
        $now=New DateTime();
        $lastDay=date("Y-m-d H:i:s");
        $sqlSearchObjects="  select COUNT(*) OVER() as count,obj.object_id,obj.object_number,et.suscriptor_name,mn.magnitude_key,ms.measure_reading,rd.reading_date,wd.sum_consumption
            from object obj
            left join object_suscriptor objs on objs.object_id=obj.object_id 
            left join entity_suscriptor es on es.entity_suscriptor_id=objs.entity_suscriptor_id
            left join suscriptor et on et.suscriptor_id=es.suscriptor_id
            left join (select object_id,max(reading_id) reading_id,max(reading_date) reading_date from reading group by object_id) rd on rd.object_id=obj.object_id
            left join measure ms on ms.reading_id=rd.reading_id 
            left join reading rdii on rdii.reading_id=(select reading_id from reading where reading_date<rd.reading_date and object_id=rd.object_id order by reading_date desc limit 1)
            left join magnitude mn on mn.magnitude_id=ms.magnitude_id
            left join water_data wd on wd.reading_id=rdii.reading_id
            where obj.service_entity_id=:seId and rd.reading_id is not null ";
        $sqlSearchObjects.=$where;
        
            $sqlSearchObjects .=  " ORDER BY ".$columns[$params['order'][0]['column']]["column_name"]."   ".$params['order'][0]['dir']."  OFFSET ".$params['start']." LIMIT ".$params['length']." "; 
                         
        $querySobj=$conn->createCommand($sqlSearchObjects);
        $querySobj->bindParam(":seId",$serviceEntity);
        $readSObj=$querySobj->query();
        $resSObj=$readSObj->readAll();
        $readSObj->close();
        //total
         $sqlTot="select count(*) cn
            from object obj
            left join object_suscriptor objs on objs.object_id=obj.object_id 
            left join entity_suscriptor es on es.entity_suscriptor_id=objs.entity_suscriptor_id
            left join suscriptor et on et.suscriptor_id=es.suscriptor_id
            left join (select object_id,max(reading_id) reading_id,max(reading_date) reading_date from reading group by object_id) rd on rd.object_id=obj.object_id
            left join measure ms on ms.reading_id=rd.reading_id 
            left join reading rdii on rdii.reading_id=(select reading_id from reading where reading_date<rd.reading_date and object_id=rd.object_id limit 1)
            left join magnitude mn on mn.magnitude_id=ms.magnitude_id
            left join water_data wd on wd.reading_id=rdii.reading_id
            where obj.service_entity_id=:seId and rd.reading_id is not null ";
         $queryTot=$conn->createCommand($sqlTot);
        $queryTot->bindParam(":seId",$serviceEntity);
        $readTot=$queryTot->query();       
        $resTot=$readTot->read();
        $readTot->close();
        //
        $rs=0;
        $dataRes=array();
        if(!empty($resSObj)){
            foreach($resSObj as $pk=>$res){
                $unity="";
                $dataAux=array();
                $dataAux[]=CHtml::link($res["object_number"], 
                    array(
                        'viewMeterData',
                        'meterId'=>$res["object_id"],'meterNumber'=>$res["object_number"]
                    )
                );               
                $dataAux[]=$res["suscriptor_name"];
                $dataAux[]=$res["magnitude_key"];
                $dataAux[]=$res["measure_reading"];
                $dataAux[]=$res["reading_date"];
                $dataAux[]=$res["sum_consumption"];
                $dataRes[]=$dataAux;
                $rs=$res["count"];
            }
        } 
        $json_data = array(
                "draw"            => intval( $params['draw'] ),   
                "recordsTotal"    => intval($resTot["cn"] ),  
                "recordsFiltered" => intval($rs),
                "data"            => $dataRes,
//                "columns"=>$columnsi// total data array
            );
        $lectura["data"]=$dataRes;
        echo CJSON::encode($json_data);
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
    
    public function actionViewMeterData(){
//        print_r($_GET);exit();
        $meterId=Yii::app()->request->getParam('meterId');
        $modelObject= Object::model()->findByPk($meterId);
        $modelObjectSuscriptor= ObjectSuscriptor::model()->findByAttributes(array("object_id"=>$meterId));
        $modelEntitySuscriptor=false;
        $modelSuscriptor=false;
        if($modelObjectSuscriptor){
            $modelEntitySuscriptor= EntitySuscriptor::model()->findByPk($modelObjectSuscriptor->entity_suscriptor_id);
            $modelSuscriptor= Suscriptor::model()->findByPk($modelEntitySuscriptor->suscriptor_id);        
        }
        $modelReading= Reading::model()->findBySql("select reading_id from reading where object_id=:objectId order by reading_id desc limit 1",array(":objectId"=>$modelObject->object_id));
        $modelMeasure= Measure::model()->findByAttributes(array("reading_id"=>$modelReading->reading_id));
        $this->render('view_meter_data',
            array(
                "modelObject"=>$modelObject,
                "modelObjectSuscriptor"=>$modelObjectSuscriptor,
                "modelEntitySuscriptor"=>$modelEntitySuscriptor,
                "modelSuscriptor"=>$modelSuscriptor,
                "modelReading"=>$modelReading,
                "modelMeasure"=>$modelMeasure,
            )
        );
    }
}