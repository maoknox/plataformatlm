<?php
Yii::app()->clientScript->registerScriptFile("https://code.highcharts.com/highcharts.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/Services/WaterManagment/ChartsWater.js", CClientScript::POS_END);

$viewName=explode(".",basename(__FILE__))[0];
$controllerName=$this->id;
$data=array();
$modelBPSE= BillingPeriodServiceEntity::model()->findByAttributes(array("service_entity_id"=>$serviceEntityId));
$modelBP=BillingPeriod::model()->findByPk($modelBPSE->billing_period_id);
$modelObject= Object::model()->findByAttributes(array("object_number"=>$index));
//Obtener última lectura select extract(days from (now()-'2020-01-14 02:08:00'::timestamp))
$lastLecture= Reading::getLastLecture($modelObject->object_id);
$lastConsum= WaterData::model()->findByAttributes(array("reading_id"=>$lastLecture["reading_id"]));
$lastMeasure= Measure::model()->findByAttributes(array("reading_id"=>$lastLecture["reading_id"]));
$getMagnitude= Magnitude::model()->findByPk($lastMeasure->magnitude_id);
$date = new DateTime($lastLecture["reading_date"]);
$lastDate=strtotime($date->format("Y-m-d H:i:s"))*1000;
$data[0]["name"]="Lectura";
$ldataRead=array($lastDate,(double)$lastMeasure->measure_reading);
$data[1]["name"]="Consumo";
$ldataCons=array($lastDate,(double)$lastConsum->sum_consumption);
$validateFrecuency=Reading::validateFrecuency($lastLecture["reading_date"], $modelObject->object_id);
$totCons=0;
$promCons=0;
$critic=0;
if($validateFrecuency["cn"]>1){
    
}
else{
    $lectures=Reading::getLectures($lastLecture["reading_date"],$modelObject->object_id,$modelBP->periods_for_critic);
    if(!empty($lectures)){
        foreach($lectures as $lecture){
            $totCons=$totCons+(double)$lecture["sum_consumption"];
            $date = new DateTime($lecture["reading_date"]);
            $dateUnix=strtotime($date->format("Y-m-d H:i:s"))*1000;
            $data[0]["data"][]=array($dateUnix,(double)$lecture["measure_reading"]);
            $data[1]["data"][]=array($dateUnix,(double)$lecture["sum_consumption"]);
        }
        $promCons=round($totCons/$modelBP->periods_for_critic,2);
        if($promCons>0){
            $critic=round((double)$lastConsum->sum_consumption*100/$promCons,2)-100;
        }
    }
}

$data[0]["data"][]=$ldataRead;
$data[1]["data"][]=$ldataCons;
$jsonData=json_encode($data);
//$data[0]["data"][0]=;
//Obtener lecturas ultimos 6 periodos
//Obtener consumos de los últimos 6 periodos
//Obtener último consumo
//Obtener promedio de consumo de los últimos 6 periodos
//
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * $date = new DateTime('now');
$date->modify('last day of this month');
echo $date->format('Y-m-d');
 * select count(*) from reading where reading_date between ('2020-01-14 02:08:00'::timestamp - INTERVAL '1 weeks') and '2020-01-14 02:08:00' and object_id=2

 */
?>
<script>
    $(document).ready(function () {
        if (typeof ChartsWater !== 'object') {
             window.ChartsWater=new ChartsWater();
        }
        ChartsWater.drawChart('<?php echo $index; ?>',<?php echo $jsonData; ?>);
        
    });</script>

<div id="<?php echo $index; ?>">
    <div class="card-header d-flex flex-row justify-content-between pmd-card-border" >
        <div class="card-text">
            <h4 class="card-title">Código del medidor: <b><?php echo $index; ?></b></h4>
            <p class="card-category">Consumo último periodo: <?php echo $lastConsum->sum_consumption." ".$getMagnitude->magnitude_unity?></p>
            <p class="card-category">última lectura: <?php echo $lastMeasure->measure_reading." ".$getMagnitude->magnitude_unity?></p>
            <p class="card-category">Consumo promedio <?php echo $modelBP->periods_for_critic?> periodos: <?php echo $promCons." ".$getMagnitude->magnitude_unity?></p>        
            <p class="card-category">Crítica: <?php echo $critic?>%</p>
        </div>
        <div>
            <?php if($anchorage):?>
                 <button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" data-toggle="tooltip" data-placement="top" title="Anclar al inicio" type="button" onclick="Telemed.anchorAtStart('<?php echo $index?>','<?php echo $controllerName ?>','<?php echo $viewName?>','anchor_chart_1_<?php echo $index?>','<?php echo $serviceEntityId?>');"><i class="material-icons pmd-sm">attachment</i></button>   
            <?php else:?>        
                <button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" data-toggle="tooltip" data-placement="top" title="Remover del inicio" type="button" onclick="Telemed.removeDiv('<?php echo $index ?>','anchor_chart_1_<?php echo $index?>');"><i class="material-icons pmd-sm">close</i></button>
                <button class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect btn-primary" data-toggle="collapse" data-target="#chartReadingConsum<?php echo $index; ?>">+ -</button>
                    <?php endif;?>

        </div>
    </div>
    <div class="card-body">   
        <div id="chartReadingConsum<?php echo $index; ?>" class="collapse"></div>
        <input type="hidden" value="<?php echo $getMagnitude->magnitude_unity; ?>" id="magnitude">
    </div>
</div>