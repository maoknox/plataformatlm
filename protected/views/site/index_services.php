<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<!--Render partial a información general-->



<?php 

if($servicesEntity):?>

          <div class="row">
            <div class="col-md-12 ml-auto mr-auto">
              <div class="page-categories">                
                <ul class="nav nav-pills nav-pills-warning nav-pills-icons justify-content-center" role="tablist">
                    <?php foreach($servicesEntity as $serviceEntity):?>
                    <li class="nav-item">
                        <a class="nav-link active"  data-toggle="tab" href="#<?php echo $serviceEntity->service->service_name?>" role="tablist">
                          <i class="material-icons"><?php echo $serviceEntity->service->service_icon?></i> Gestión hídrica
                        </a>
                    </li>
                  <?php endforeach;?>                 
                </ul>
                <!--Fin listar servicios-->
                <!--Mostrar contenido de servicios-->
                <div class="tab-content tab-space tab-subcategories">
                    <?php foreach($servicesEntity as $serviceEntity):?>
                    <!--Mostrar contenido de un servicio-->
                    <div class="tab-pane active" id="<?php $serviceEntity->service->service_name?>">
                            <div class="row">    
                                <?php $this->renderPartial("principal_info",array("userRole"=>$userRole,"entityUser"=>$entityUser,"serviceEntity"=>$serviceEntity));?>                         
                            </div>

                            <!--Render partial a Menú de servicio-->
                            <div class="row">
                                <?php $this->renderPartial("principal_menu",array("userRole"=>$userRole,"entityUser"=>$entityUser,"serviceEntity"=>$serviceEntity));?>
                            </div>
                    </div>
                    <?php endforeach;?>
                    <!--Fin Mostrar contenido de un servicio-->                                    
                </div>
                <!--Fin Mostrar contenido de servicios-->
              </div>
            </div>
          </div>
<?php

else:
    echo "La entidad no tiene asociado algún servicio";
endif;