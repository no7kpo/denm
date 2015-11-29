<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\user;

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'id',
                'dia',
                ['attribute'=>'idrelevador',
                    'value' => User::findOne($dataProvider->getModels()->idrelevador)->nombre,
                ],    
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
