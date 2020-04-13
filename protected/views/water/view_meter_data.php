<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/leaflet/leaflet.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/leaflet/MarkerCluster.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/leaflet/MarkerCluster.Default.css');
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/css/charts/charts.css');
Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/leaflet/leaflet.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/leaflet/leaflet.markercluster.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("http://maps.googleapis.com/maps/api/js?key=".getenv("TELEMED_GOOGLEAPI")."&callback", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("https://asmaloney.com/wp-content/themes/asmaloney2/maps_cluster/markers.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/Services/WaterManagment/ViewMeterData.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js",CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/Services/WaterManagment/ChartsWater.js", CClientScript::POS_END);


//print_r($modelReading);
//print_r($modelMeasure);
//print_r($modelEntitySuscriptor);
//print_r($modelSuscriptor);
//"modelReading"=>$modelReading,
//                "modelMeasure"=>$modelMeasure,
?>
<script>

$(document).ready(function(){
    window.ChartsWater=new ChartsWater();    
});</script>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::app()->baseUrl ?>/index.php">Inicio</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="<?php echo Yii::app()->baseUrl ?>/index.php/water/">Medidores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Lecturas</li>
    </ol>
</nav>
<div class="content" id="divViewMeterData">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons"></i>
                        </div>
                        <h4 class="card-title">Inormación del medidor, lecturas y consumos</h4>
                    </div>
                    <div class="card-body ">
                        <div class="row">
                            <div class="col-md-3 card-4">
                                <div class="card-body">
                                    <div class="table-responsive table-sales">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Número de medidor</td>
                                                    <td class="text-right">
                                                        <?php echo $modelObject->object_number; ?>
                                                    </td>                                                
                                                </tr>
                                                <tr>                                                
                                                    <td>Ciudad</td>                                                
                                                    <td class="text-right">
                                                        <?php echo $modelObject->city->city_label;?>
                                                    </td>
                                                </tr>
                                                <tr>                                                
                                                    <td>Dirección</td>
                                                    <td class="text-right">
                                                        <?php 
                                                            $toReplaceKr=array("CR","Cr","cR","Kr","KR","kR");
                                                            $replKr=array("carrera");
                                                            $toReplaceCl=array("CLL","CL","Cll","Cl","cLL","cL");
                                                            $replCl=array("calle");
                                                            $address=str_replace($toReplaceKr,$replKr,$modelObject->object_address);
                                                            $address=str_replace($toReplaceCl,$replCl,$address);
                                                            echo $address;
                                                            
                                                        ?>
                                                    </td>                                                
                                                </tr>                                            
                                                <tr>                                                
                                                    <td>Identificación suscriptor</td>
                                                    <td class="text-right">
                                                        <?php echo (empty($modelSuscriptor->suscriptor_code))?"N.R":$modelSuscriptor->suscriptor_code;?>
                                                    </td>                                                
                                                </tr>
                                                <tr>                                                
                                                    <td>Nombre del suscriptor</td>
                                                    <td class="text-right">
                                                        <?php echo (empty($modelSuscriptor->suscriptor_name))?"N.R":$modelSuscriptor->suscriptor_name;?>
                                                    </td>                                                
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 ml-auto mr-auto "> 
                                <?php $serviceEntityId=ServiceEntity::getServiceEntityByName("gestion_hidrica")->service_entity_id;?>
                                <?php $this->renderPartial("_charts",array("index"=>$modelObject->object_number,"serviceEntityId"=>$serviceEntityId,"anchorage"=>true)) ?>
                            </div>
                            <div class="col-md-3 card-4">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <input type="hidden" id="address" value="<?php echo $address;?>">
    <input type="hidden" id="city" value="<?php echo $modelObject->city->city_label;?>">
    <input type="hidden" id="lat" value="<?php echo $modelObject->object_latitude;?>">
    <input type="hidden" id="lng" value="<?php echo $modelObject->object_longitude;?>">
</div>

<?php 