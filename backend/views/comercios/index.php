<?php

use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Store');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercios-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Register store'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'nombre',
            'prioridad',
            // 'hora_apertura',
            // 'hora_cierre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
