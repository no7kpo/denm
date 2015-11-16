<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Categorias;

/* @var $this yii\web\View */
/* @var $model backend\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'Nombre')->textInput(['maxlength' => true]) ?>

    <?=   $form->field($model, 'idcategoria')->dropDownList( ArrayHelper::map(Categorias::find()->All(), 'id', 'nombre')) ?>

    <?php if (Yii::$app->controller->action->id === 'create'){ ?>
    	<?=$form->field($img_model, 'imageFile')->fileInput(['multiple' => false, 'accept' => 'image/*']) ?>
    <?php
    } 
    
     ?> 


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : 
        Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
