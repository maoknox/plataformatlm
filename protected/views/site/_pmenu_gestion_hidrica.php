<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/Services/WaterManagment/Meter.js",CClientScript::POS_END);
//    print_r($services);
?>
<?php if($userRole->role_name=="usuario_cliente"):?>
    <?php 
        $entityService= ServiceEntity::model()->findByAttributes(array("entity_id"=>$entityUser->entity_id));
        $service=Service::model()->findAllByAttributes(array("service_id"=>$entityService->service_id));
    ?>
    <div class="col-md-12" id="divMeter">
        <div class="card ">
          <div class="card-header ">
            <h4 class="card-title">Menú
                <small class="description"><?php echo $serviceEntity->service->service_label?></small>
            </h4>
          </div>
          <div class="card-body ">
            <ul class="nav nav-pills nav-pills-warning" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#medidores" role="tablist">
                  Medidores
                </a>
              </li>
            </ul>
            <div class="tab-content tab-space">
              <div class="tab-pane active" id="medidores">
                  <div class="col-md-6 ml-auto mr-auto">

  <!--Grid column-->
                    <div>
                        <?php
                        echo CHtml::link("Ver medidores", Yii::app()->baseUrl."/index.php/water/", 
                            array(
                                'submit' =>  Yii::app()->baseUrl."/index.php/water/",
                                'params' => array("entit_service_id" =>$entityService->service_id),
                                'class'=>'btn btn-primary'
                            )
                        );
                        ?>               
                    </div>
                    
                    <!--Grid column-->

                  </div>
              </div>
              <div class="tab-pane" id="link2">
                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                <br />
                <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
              </div>
              <div class="tab-pane" id="link3">
                Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                <br />
                <br />Dynamically innovate resource-leveling customer service for state of the art customer service.
              </div>
            </div>
          </div>
        </div>
    </div>
<?php elseif($userRole->role_name=="super_usuario"): ?>
    <div class="col-md-4">
        <div class="card ">
          <div class="card-header ">
            <h4 class="card-title">Navigation Pills -
              <small class="description">Horizontal Tabs</small>
            </h4>
          </div>
          <div class="card-body ">
            <ul class="nav nav-pills nav-pills-warning" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#link1" role="tablist">
                  Profile
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#link2" role="tablist">
                  Settings
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#link3" role="tablist">
                  Options
                </a>
              </li>
            </ul>
            <div class="tab-content tab-space">
              <div class="tab-pane active" id="link1">
                Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                <br />
                <br /> Dramatically visualize customer directed convergence without revolutionary ROI. Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                <br/>
                <br/> This is very nice.
              </div>
              <div class="tab-pane" id="link2">
                Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                <br />
                <br />Dramatically maintain clicks-and-mortar solutions without functional solutions.
              </div>
              <div class="tab-pane" id="link3">
                Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                <br />
                <br />Dynamically innovate resource-leveling customer service for state of the art customer service.
              </div>
            </div>
          </div>
        </div>
    </div>
<?php endif;?>
<?php
//    Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_END);
//    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/Services/WaterManagment/ChartsWater.js", CClientScript::POS_END);
?>
<?php
    $anchorageElements= Anchorage::model()->findAllByAttributes(array("service_entity_id"=>$serviceEntity->service_entity_id));
?>
<?php if($anchorageElements):?>
<div class="container">
    <div class="row">
    <?php foreach($anchorageElements as $element):?>
        <?php 
            $serviceEntityId=ServiceEntity::getServiceEntityByName("gestion_hidrica")->service_entity_id;
            $params= json_decode($element->anchorage_params,true);
            $params["anchorage"]=false;
            $params["serviceEntityId"]=$serviceEntityId;
        ?>
        <div class="col-sm-3 " id="sm-<?php echo $params["index"]?>">
            <div class="card">           
                    <?php
                        
                        $this->renderPartial("//".$element->anchorage_controller."/".$element->anchorage_view,$params)                 
                    ?>
            </div>
        </div>     
    <?php  endforeach;?>
    </div>
</div>
<?php endif;?>

