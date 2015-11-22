<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Categorias;

/* @var $this yii\web\View */
/* @var $model backend\models\Producto */

$this->title = $model->Nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Change Picture'), ['update_picture', 'id' => $model->id] , ['class' => 'btn btn-success']) ?>
        <!--<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>-->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'Nombre',
            ['attribute'=>'idcategoria',
            'value' => Categorias::findOne($model->idcategoria)->nombre,
                ],            
        ],
    ]) ?>
    <div class='row'>
        <div class='col-md-offset-2 col-md-8 col-sm-12'>
                <center><?=Html::img(Yii::getAlias('@product_pictures'). '/' .$model->Imagen,
                    ['alt' => Yii::t('app','Product picture'), 'style' => 'max-width:100%; max-height:25%']);?>
                </center>
        </div>
    </div>
</div>
