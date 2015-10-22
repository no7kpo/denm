<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Comercios */

$this->title = Yii::t('app', 'Create Comercios');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comercios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercios-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
