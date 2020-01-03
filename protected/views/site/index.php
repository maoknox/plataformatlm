<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="row">
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                              <div class="card-header card-header-warning card-header-icon">
                                <div class="card-icon">
                                  <i class="material-icons">weekend</i>
                                </div>
                                <p class="card-category">Bookings</p>
                                <h3 class="card-title">184</h3>
                              </div>
                              <div class="card-footer">
                                <div class="stats">
                                  <i class="material-icons text-danger">warning</i>
                                  <a href="#pablo">Get More Space...</a>
                                </div>
                              </div>
                            </div>
                          </div>
</div>
<div class="row">
    <?php $this->renderPartial("pruebarp",array("param1"=>"param"));?>
</div>
<?php if (Yii::app()->user->checkAccess("administrar_usuarios")): ?>
Opciones <br>
    <?php if (Yii::app()->user->checkAccess("crear_usuarios")): ?>
    Crear usuario <br>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess("editar_datos_usuario")): ?>
    Editar usuario <br>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess("reestablecer_clave_acceso_usuario")): ?>
    Reestablecer usuario<br>
    <?php endif; ?>
    <?php if (Yii::app()->user->checkAccess("eliminar_usuario")): ?>
        Eliminar usuario
    <?php endif; ?>
<?php endif; ?>
