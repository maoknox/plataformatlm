<!--
 =========================================================
 Material Dashboard PRO - v2.1.0
 =========================================================

 Product Page: https://www.creative-tim.com/product/material-dashboard-pro
 Copyright 2019 Creative Tim (https://www.creative-tim.com)

 Coded by Creative Tim

 =========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>TeleMed</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <!--Confirm css-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins/jquery-confirm.min.css" />
        <!--     Fonts and icons     -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
        <!-- Material Kit CSS -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/material-dashboard.css?v=2.1.0" />

    </head>
    <?php if (!Yii::app()->user->isGuest): ?>
        <body>  
            <div class="wrapper">
                <div class="sidebar" data-color="wite" data-background-color="black" data-image="<?php echo Yii::app()->request->baseUrl; ?>/images/sidebar-1.jpg">
                    <!--
                    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"
      
                    Tip 2: you can also add an image using data-image tag
                    -->
                    <div class="logo">
                        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
                            
                        </a>
                        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
                            <?php
                                $entityUser= EntityUser::model()->findByAttributes(array("euser_id"=>Yii::app()->user->getId()));
                                echo $entityUser->entity->entity_name;
                            ?>
                        </a>
                    </div>
                    <div class="sidebar-wrapper">
                        <div class="user">
                            <div class="photo">
                                
                            </div>
                            <div class="user-info">
                                <a data-toggle="collapse" href="#collapseExample" class="username">
                                    <span>
                                        <?=$entityUser->euser->euser_name." ".$entityUser->euser->euser_lastname?>                                        
                                    </span>
                                </a>
                            </div>
                        </div>                    
                    </div>
                </div>
                <div class="main-panel">
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
                        <div class="container-fluid">
                            <div class="navbar-wrapper">
                                <div class="navbar-minimize">
                                    <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                                        <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                                        <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                                    </button>
                                </div>
                                <a class="navbar-brand" href="#pablo">Dashboard</a>
                            </div>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="navbar-toggler-icon icon-bar"></span>
                                <span class="navbar-toggler-icon icon-bar"></span>
                                <span class="navbar-toggler-icon icon-bar"></span>
                            </button>
                            <div class="collapse navbar-collapse justify-content-end">
                                
                                <ul class="navbar-nav">                                                                       
                                    <li class="nav-item dropdown">
                                        <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons">person</i>
                                            <p class="d-lg-none d-md-block">
                                                Account
                                            </p>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">                                            
                                            <a class="dropdown-item" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/logout">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <!-- End Navbar -->
                    <div class="content">
                        <div class="container-fluid">
                            <?php echo $content; ?>
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="container-fluid">
                            <nav class="float-left">
                                <ul>
                                    <li>
                                        <a href="https://www.creative-tim.com">
                                            Creative Tim
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <div class="copyright float-right">
                                &copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script>, made with <i class="material-icons">favorite</i> by
                                <a href="https://www.creative-tim.com" target="_blank">Creative Tim</a> for a better web.
                            </div>
                            <!-- your footer here -->
                        </div>
                    </footer>
                </div>
            </div>

            <!--   Core JS Files   -->
            <?php
            Yii::app()->clientScript->registerCoreScript('jquery.ui');
            ?>            
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/jquery-confirm.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/popper.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/bootstrap-material-design.min.js"></script>
            <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>               
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/bootstrap-notify.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/moment.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/loadingoverlay.min.js"></script>
            <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/Telemed.js"></script>
        </body>
    <?php else: ?>
        <?php echo $content; ?>
    <?php
    endif;
    ?>
</html>
