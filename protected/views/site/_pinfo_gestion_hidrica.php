<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!--Si es usuario_cliente muestra cuadros distintos a superusuario-->
<?php if($userRole->role_name=="usuario_cliente"):?>
<?php
        if(($serviceEntity->service->summaries)):
            foreach($serviceEntity->service->summaries as $summary):
                $sqlSummary= str_replace('{entity_number_id}', "'".$entityUser->entity->entity_number_id."'", $summary->summary_sql);
                $connect=Yii::app()->db;
                $query=$connect->createCommand($sqlSummary);
                $read=$query->query();
                $res=$read->read();
                $read->close();
            ?>
                <div class = "col-lg-3 col-md-6 col-sm-6">
                    <div class = "card card-stats">
                        <div class = "card-header card-header-warning card-header-icon">
                            <div class = "card-icon">
                                <i class = "material-icons"><?php echo $summary->summary_icon;?></i>
                            </div>
                            <p class = "card-category"><?php echo $summary->summary_label;?></p>
                            <h3 class = "card-title"><?php echo $res["count"];?></h3>
                        </div>
                        <div class = "card-footer">
                            <div class = "stats">
<?php 
echo CHtml::link($summary->summary_url_name, Yii::app()->baseUrl.$summary->summary_url, 
                            array(
                                'submit' =>  Yii::app()->baseUrl.$summary->summary_url,
                                'params' => array("entit_service_id" =>$serviceEntity->service_id)
                            )
                        );
?>
                                
                            </div>
                        </div>
                    </div>
                </div>
<?php       endforeach; 
        endif;?>
<?php endif;?>
