<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rutas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ruta'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
      
          <?php  $form = ActiveForm::begin(); ?>
          <div class="form-group">
        <?=    $form->field($valor, 'valor')->textInput(['maxlength' => true]) ?>
            
                <?= Html::submitButton($valor->isNewRecord ? Yii::t('app', 'Create') : 
                    Yii::t('app', 'Update'), ['class' => $valor->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <div id="result"></div>
            </div>
        <?php    ActiveForm::end(); ?>
       
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'id',
                'dia',
                'relevador',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
