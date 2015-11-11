<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use backend\models\Categorias;

/* @var $this yii\web\View */
/* @var $model backend\models\Producto */

$this->title = Yii::t('app', 'Update picture of {modelClass}: ', [
    'modelClass' => 'product',
]) . ' ' . $model->Nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="producto-update">

    <h1><?= Html::encode($this->title) ?></h1>
	</br>
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Nombre',
            ['attribute'=>'idcategoria',
            'value' => Categorias::findOne($model->idcategoria)->nombre,
                ],            
        ],
    ]) ?>

    <div class="producto-form">

	    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

	    <?= $form->field($model, 'Nombre')->hiddenInput()->label(false)?>

	    <?= $form->field($model, 'idcategoria')->hiddenInput()->label(false)?>

	    <?=$form->field($img_model, 'imageFile')->fileInput(['multiple' => false, 'accept' => 'image/*'])?>

	    <div class="form-group">
	        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' =>'btn btn-primary']) ?>
	    </div>

	    <?php ActiveForm::end(); ?>

	</div>

</div>