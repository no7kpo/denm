<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Categorias;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Comercios */

$this->title = Yii::t('app','Add products to ').$model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shop'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$nombreColumna = function ($data){ return Categorias::findOne($data->idcategoria)->nombre; }
?>
<div class="comercios-view">
    <h1><?= Html::encode($this->title) ?></h1>
    </br>
    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'nombre')->dropDownList($categorias,[
      'onchange'=>'
                        $.post( "'.Url::toRoute('/comercios/getproductos').'", { id: $(this).val(),idcomercio:'.$model->id.' } )
                            .done(function( data ) {
                                
                                sessionStorage.setItem("productos",data);
                                loadElements();
                                }
                        );
                    '   
                    ]);

    ActiveForm::end();
 ?>
    <div class='row'> 
      <div class='col-md-6'>
        <div class='panel panel-default'>
          <div class='panel-heading'>
            <center><h2><?=Yii::t('app', 'Products in store')?></h2></center>
            <center class="help-block"><?=Yii::t('app','Choose from the list to remove a product')?></center>
          </div>
          <div class="assign-products panel-body">
            <?php
              foreach ($productos->allModels as $key => $value) { ?>
                <div class='row'>
                  <div id="<?=$value['id']?>" class="btn removeProduct" data-toggle="tooltip" 
                    title="<?=Yii::t('app','Click to remove')?>" style="width:100%">
                    <?=$nombreColumna($value)?> - <?=$value['Nombre']?>
                  </div>
                </div>
            <?php
              } ?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <center><h2><?=Yii::t('app', 'Unassign products')?></h2></center>
            <center class="help-block"><?=Yii::t('app','Choose from the list to add a product')?></center>
          </div>
          <div class="unassign-products panel-body">
            <?php
              foreach ($resto->allModels as $key => $value) { ?>
              <div class="row">
                <div id="<?=$value['id']?>" class="btn addProduct" data-toggle="tooltip" 
                    title="<?=Yii::t('app','Click to add')?>" style="width:100%">
                  <?=$nombreColumna($value)?> - <?=$value['Nombre']?>
                </div>
              </div>
              <?php
              }
            ?>
          </div>
        </div>
      </div>
    </div>
</div>
<div>
  <input type="hidden" name="model-id" value="<?=$model->id?>" />
</div>

<?php
  $this->registerJsFile(Yii::getAlias('@user_js') . '/product-store.js', ['depends' => [yii\web\JqueryAsset::className()]]);
?>

