<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Categorias;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'Nombre',
            ['attribute'=>'idcategoria',
             'value' => function($producto){
                    return Categorias::findOne($producto->idcategoria)->nombre;
                }
            ],
            'Imagen',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
