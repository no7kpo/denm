<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model backend\models\Ruta */

$this->title = Yii::t('app', 'Create Ruta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rutas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ruta-create">

      <?= $this->render('_form', [
        'model' => $model, 'user' => $users,'rutarel' =>$rutarel
        
    ]) ?>



</div>
