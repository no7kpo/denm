<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\categorias */

$this->title = Yii::t('app', 'Create categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categorias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
