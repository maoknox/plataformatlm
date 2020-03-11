<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/images/themes/default/style.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/plugins/jstree.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/plugins/jquery.dataTables.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/Services/WaterManagment/InfoMeter.js", CClientScript::POS_END);
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::app()->baseUrl ?>/index.php">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Medidores</li>
    </ol>
</nav>
<div class="row" id="showMeters">
    <div class="col-sm-2 overflow-auto">
        <div class="card">
            <div class="card-header card-header-text card-header-warning">
                <div class="card-text">
                    <h4 class="card-title">Grupos y subgrupos</h4>
                    <p class="card-category">Puede mover grupos a otros grupos</p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                      <label for="deliverable_search" class="bmd-label-floating">Buscar ítems</label>
                      <input type="text" class="form-control" id="deliverable_search">
                </div>                
                <div id="treemeters" class="demo"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-10">
        <div class="card">        
            <div class="card-body">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">DataTables.net</h4>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="material-datatables">
<!--                        <table id="datatables" class="display" style="width:100%">
        <thead>
            <tr>
                <th>a</th>
                <th>b</th>
                <th>c</th>
                <th>d.</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>a</th>
                <th>b</th>
                <th>c</th>
                <th>d.</th>
            </tr>
        </tfoot>
    </table>-->
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Medidor No.</th>
                                    <th>Id. Suscriptor</th>
                                    <th>Última lectura</th>
                                    <th>Fecha última lectura</th>
                                    <th>Consumo último mes</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Medidor No.</th>
                                    <th>Id. Suscriptor</th>
                                    <th>Última lectura</th>
                                    <th>Fecha última lectura</th>
                                    <th>Consumo último mes</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
