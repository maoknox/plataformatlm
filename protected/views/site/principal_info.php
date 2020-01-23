<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--Si es usuario_cliente muestra cuadros distintos a superusuario-->
<?php if($userRole->role_name=="usuario_cliente"):?>

<div class = "col-lg-3 col-md-6 col-sm-6">
    <div class = "card card-stats">
        <div class = "card-header card-header-warning card-header-icon">
            <div class = "card-icon">
                <i class = "material-icons">weekend</i>
            </div>
            <p class = "card-category">Bookings</p>
            <h3 class = "card-title">184</h3>
        </div>
        <div class = "card-footer">
            <div class = "stats">
                <i class = "material-icons text-danger">warning</i>
                <a href = "#pablo">Get More Space...</a>
            </div>
        </div>
    </div>
</div>
<div class = "col-lg-3 col-md-6 col-sm-6">
    <div class = "card card-stats">
        <div class = "card-header card-header-warning card-header-icon">
            <div class = "card-icon">
                <i class = "material-icons">weekend</i>
            </div>
            <p class = "card-category">Bookings</p>
            <h3 class = "card-title">184</h3>
        </div>
        <div class = "card-footer">
            <div class = "stats">
                <i class = "material-icons text-danger">warning</i>
                <a href = "#pablo">Get More Space...</a>
            </div>
        </div>
    </div> 
</div>
<?php endif;?>
<?php if($userRole->role_name=="super_usuario"):?>
<div class = "col-lg-3 col-md-6 col-sm-6">
    <div class = "card card-stats">
        <div class = "card-header card-header-warning card-header-icon">
            <div class = "card-icon">
                <i class = "material-icons">weekend</i>
            </div>
            <p class = "card-category">Bookings</p>
            <h3 class = "card-title">184</h3>
        </div>
        <div class = "card-footer">
            <div class = "stats">
                <i class = "material-icons text-danger">warning</i>
                <a href = "#pablo">Get More Space...</a>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
