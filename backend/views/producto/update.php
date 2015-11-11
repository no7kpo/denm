<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Producto */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'product',
]) . ' ' . $model->Nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="producto-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
