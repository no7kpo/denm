<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Ruta */

$this->title = Yii::t('app', 'Create Ruta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
