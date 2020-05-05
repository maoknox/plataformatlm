<body class="off-canvas-sidebar">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
        <div class="container">
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="#pablo">Página de acceso</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>            
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('<?php echo Yii::app()->request->baseUrl; ?>/images/login.jpg'); background-size: cover; background-position: top center;">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
                        <?php
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'login-form',
                            'enableClientValidation' => true,
                            'enableAjaxValidation'=>true,
                            'clientOptions' => array(
                                'validateOnSubmit' => true,
                            ),
                        ));
                        ?>	                        
                        <div class="card card-login card-hidden">
                            <div class="card-header card-header-rose text-center">
                                <h4 class="card-title">Bienvenido a TeleMED</h4>                  
                            </div>
                            <div class="card-body ">                  
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">email</i>
                                            </span>
                                        </div>
                                        <?php echo $form->textField($model, 'username', array('class' => 'form-control', 'placeholder' => 'Nombre de usuario')); ?>                                        
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="material-icons">lock_outline</i>
                                            </span>
                                        </div>
                                        <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Contraseña')); ?>
                                        
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                               
                                            </span>
                                        </div>
                                        <?php echo $form->error($model, 'username',array('class'=>'error')); ?>
                                    </div>
                                </span>
                                <span class="bmd-form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                               
                                            </span>
                                        </div>
                                        <?php echo $form->error($model, 'password',array('class'=>'error')); ?>
                                    </div>
                                </span>
                            </div>
                            <div class="card-footer justify-content-center">
                                <!-- <a href="#pablo" class="btn btn-rose btn-link btn-lg">Lets Go</a> -->
                        <?php echo CHtml::submitButton('Login', array('class' => 'btn btn-rose btn-link btn-lg')); ?>
                                <?php echo CHtml::submitButton('Recuperar contraseña    ', array('class' => 'btn btn-rose btn-link btn-lg')); ?>
                            </div>
                        </div>
<?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">                    
                    <div class="copyright float-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>, creado por 
                        <a href="https://iktronik.com" target="_blank">Ingetronik</a>.
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core JS Files   -->
    <?php
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
    ?>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/popper.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/bootstrap-material-design.min.js"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script> -->
    <!-- Chartist JS -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/chartist.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
    <!-- Material Dashboard DEMO methods, don't include it in your project! -->
    <!-- <script src="../../assets/demo/demo.js"></script> -->
    <script>
        $(document).ready(function () {
            $('.card').removeClass('card-hidden');           
        });
    </script>
</body>