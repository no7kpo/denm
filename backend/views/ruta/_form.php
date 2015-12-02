<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Ruta */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<div class="ruta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($rutarel, 'idrelevador')
    ->dropDownList($user,[
    	'onchange'=>'
                        $.post( "'.Url::toRoute('/comercios/relevador').'", { id: $(this).val() } )
                            .done(function( data ) {
                            	
                               	sessionStorage.setItem("relevador",data);
                               	loadMap();
                                }
                        );
                    '   
                    ]) ?>

    <?=   $form->field($model, 'dia')->dropDownList( ['0' => Yii::t('app','Monday'), '1' => Yii::t('app','Tuesday'), '2' => Yii::t('app','Wednesday'), '3' => Yii::t('app','Thursday'), '4'=> Yii::t('app','Friday'), '5' => Yii::t('app','Saturday')],[
    	'onchange'=>'
                        $.post( "'.Url::toRoute('/comercios/pordia').'", { id: $(this).val() } )
                            .done(function( data ) {
                            	
                               	sessionStorage.setItem("comercios",data);
                               	loadMap();
                                }
                        );
                    '   
    ]) ?>
    
    	<div id="map-canvas"></div>
    	<div class="row">
    	<div class="col-md-6">
    	<div class='panel panel-default'>
          <div class='panel-heading'>
            <center><h2><?=Yii::t('app', 'Stores in route')?></h2></center>
            <center class="help-block"><?=Yii::t('app','Choose from the list to remove a store')?></center>
          </div>
          <div class="assign-store panel-body">
            <?php
            /*  foreach ($productos->allModels as $key => $value) { ?>
                <div class='row'>
                  <div id="<?=$value['id']?>" class="btn removeProduct" data-toggle="tooltip" title="<?=Yii::t('app','Click to remove')?>" style="width:100%">
                    <?=$nombreColumna($value)?> - <?=$value['Nombre']?>
                  </div>
                </div>
            <?php
            /*  }*/ ?>
          </div>
        </div>
        </div>
        <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <center><h2><?=Yii::t('app', 'Unassigned stores')?></h2></center>
            <center class="help-block"><?=Yii::t('app','Choose from the list to add a store')?></center>
          </div>
          <div class="unassign-store panel-body">
            <?php /*
              foreach ($resto->allModels as $key => $value) { ?>
              <div class="row">
                <div id="<?=$value['id']?>" class="btn addProduct" data-toggle="tooltip" title="<?=Yii::t('app','Click to add')?>" style="width:100%">
                  <?=$nombreColumna($value)?> - <?=$value['Nombre']?>
                </div>
              </div>
              <?php
              }*/
            ?>
          </div>
        </div>
        </div>
    </div>
    <div class="form-group">
    	<?= Html::button(Yii::t('app', 'Create'), [ 'class' => 'btn btn-primary', 'onclick' => '
                        $.post( "'.Url::toRoute('/ruta/generarruta').'", { datos: orden, relevador: document.getElementById("rutarelevador-idrelevador").value,dia: document.getElementById("ruta-dia").value } )
                            .done(function( data ) {
                            	
                               	
                               	console.log(data);
                               	
                                }
                        );
                    '   
    ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>
<script>




</script>
<?php
  $this->registerJsFile(Yii::getAlias('@user_js') . '/route-to-store.js', ['depends' => [yii\web\JqueryAsset::className()]]);
?>
