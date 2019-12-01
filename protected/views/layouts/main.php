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
  <title>Hello, world!</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/material-dashboard.css?v=2.1.0" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/demo/demo.css" rel="stylesheet" />
</head>

<body>
  <div class="wrapper ">
  	<?php if(!Yii::app()->user->isGuest):?>
	    <div class="sidebar" data-color="azure" data-background-color="white">
	      <!--
	      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

	      Tip 2: you can also add an image using data-image tag
	  -->
	      <div class="logo">
	        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
	          CT
	        </a>
	        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
	          Creative Tim
	        </a>
	      </div>
	      <div class="sidebar-wrapper">
	      	<div class="user">
	          <div class="photo">
	            <img src="../assets/img/faces/avatar.jpg" />
	          </div>
	          <div class="user-info">
	            <a data-toggle="collapse" href="#collapseExample" class="username">
	              <span>
	                Tania Andrew
	                <b class="caret"></b>
	              </span>
	            </a>
	            <div class="collapse" id="collapseExample">
	              <ul class="nav">
	                <li class="nav-item">
	                  <a class="nav-link" href="#">
	                    <span class="sidebar-mini"> MP </span>
	                    <span class="sidebar-normal"> My Profile </span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a class="nav-link" href="#">
	                    <span class="sidebar-mini"> EP </span>
	                    <span class="sidebar-normal"> Edit Profile </span>
	                  </a>
	                </li>
	                <li class="nav-item">
	                  <a class="nav-link" href="#">
	                    <span class="sidebar-mini"> S </span>
	                    <span class="sidebar-normal"> Settings </span>
	                  </a>
	                </li>
	              </ul>
	            </div>
	          </div>
	        </div>
	        <ul class="nav">
	          <li class="nav-item active  ">
	            <a class="nav-link" href="#0">
	              <i class="material-icons">dashboard</i>
	              <p>Dashboard</p>
	            </a>
	          </li>
	          <!-- your sidebar here -->
	        </ul>
	      </div>
	    </div>
	<?php endif?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
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
              <li class="nav-item">
                <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/index">
                  <i class="material-icons">home</i> Home
                </a>
              </li>
       		<li class="nav-item">
                <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/page?view=about">
                  <i class="material-icons">about</i> About
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/contact">
                  <i class="material-icons">contact</i> Contact
                </a>
              </li>
              <?php if(Yii::app()->user->isGuest):?>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/login">
                  <i class="material-icons">contact</i> Login
                </a>
              </li>
              <?php else:?>
				<li class="nav-item">
                <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/logout">
                  <i class="material-icons">contact</i> Logout
                </a>
              </li>
              <?php
				if (Yii::app()->user->checkAccess("AdministradorUsuarios")):?>
					<li class="nav-item">
	                <a class="nav-link" href="<?php echo Yii::app()->request->baseUrl; ?>/index.php/site/logout">
	                  <i class="material-icons">contact</i> Administrar usuarios
	                </a>
	              </li>
				
				<?php endif;?>
              <?php echo Yii::app()->user->id."-------------";endif;?>
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
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/jquery.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/popper.min.js"></script>
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/core/bootstrap-material-design.min.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/material-dashboard.js?v=2.1.0" type="text/javascript"></script>
</body>

</html>
