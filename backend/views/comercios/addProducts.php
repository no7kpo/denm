<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Categorias;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Comercios */

$this->title = Yii::t('app','Add products to ').$model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shop'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercios-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class='row'> 
    <article class='col-sm-6'>
     <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
     <?=   $form->field(new Categorias, 'nombre')->dropDownList( [
      ArrayHelper::map(Categorias::find()->All(), 'id', 'nombre')],
      [ 'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl(["Categorias/getProductos"]).'",function(data){
        console.log("asa");
                    $("#list_products").html( "Se ejecuta javascript" );
                    })'
     ]); ?>

     <?php ActiveForm::end(); ?>
     <div class='list_products' ></div>
      </article>
      <article class='col-sm-6'>
        
      </article>
    </div>



</div>

