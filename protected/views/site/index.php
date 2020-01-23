<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<!--Render partial a información general-->
<div class="row">    
    <?php $this->renderPartial("principal_info",array("userRole"=>$userRole));?>                         
</div>

<!--Render partial a Menú de servicio-->
<div class="row">
    <?php $this->renderPartial("principal_menu",array("userRole"=>$userRole,"entityUser"=>$entityUser));?>
</div>
