<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Comercios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'shop'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comercios-view">
<style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'prioridad',
            'hora_apertura',
            'hora_cierre',
        ],
    ]) ?>
    <article>
        <div id="map-canvas"></div>
    </article>

    <input type='hidden' value=  id='latitud'/>
<input type='hidden' value= id='longitud' />

</div>

<script>
function initialize() {
    var latitud=<?= $model->latitud ?>;
    var longitud=<?= $model->longitud ?>;
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(latitud,longitud),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(mapCanvas,mapOptions);
    google.maps.event.addListener(map, 'click', function( event ){
        document.getElementById('productos-ubicacion').value="Latitud: "+event.latLng.lat()+" "+", Longitud: "+event.latLng.lng();
});
    var marcador = new google.maps.LatLng(latitud,longitud);
    var marker = new google.maps.Marker({
      position: marcador,
      dragabble: false,
      map: map,
      title: ''
  });
  marker.setMap(map);
}


google.maps.event.addDomListener(window, 'load', initialize);

</script>
