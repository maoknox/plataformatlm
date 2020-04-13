<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/images/themes/default/style.min.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/plugins/jstree.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/plugins/jquery.dataTables.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/Services/WaterManagment/InfoMeter.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/plugins/bootstrap-selectpicker.js", CClientScript::POS_END);
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo Yii::app()->baseUrl ?>/index.php">Inicio</a></li>
        <li class="breadcrumb-item active" aria-current="page">Medidores</li>
    </ol>
</nav>
 <span class="spinner-border"></span>
<div class="row" id="showMeters">
    <div class="col-sm-3">
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
                <div id="treemeters" class="demo scrollbar scrollbar-primary force-overflow" style="height: 400px;overflow-y: auto"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="card">        
            <div class="card-body">
                <div class="card-header card-header-primary card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">assignment</i>
                    </div>
                    <h4 class="card-title">Últimas mediciones</h4>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="material-datatables">
                        <select class="selectpicker" data-size="7" data-style="btn btn-primary btn-round" multiple title="Mostrar/Ocultar columnas" id="selcol">                            
                            <option value="0">Medidor No.</option>
                            <option value="1">Id. Suscriptor</option>
                            <option value="2">Unidad de medida</option>
                            <option value="3">Última lectura</option>
                            <option value="4">Fecha última lectura</option>
                            <option value="5">Consumo Actual</option>
                          </select>
                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                    <th title="Medidor No.">Medidor No.</th>
                                    <th>Id. Suscriptor</th>
                                    <th>Unidad de medida</th>
                                    <th>Última lectura</th>
                                    <th>Fecha última lectura</th>
                                    <th>Consumo Actual</th>
                                </tr>
                                 <tr>
                                    <th>Medidor No.</th>
                                    <th>Id. Suscriptor</th>
                                    <th>Unidad de medida</th>
                                    <th>Última lectura</th>
                                    <th>Fecha última lectura</th>
                                    <th>Consumo Actual</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Medidor No.</th>
                                    <th>Id. Suscriptor</th>
                                    <th>Unidad de medida</th>
                                    <th>Última lectura</th>
                                    <th>Fecha última lectura</th>
                                    <th>Consumo Actual</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
