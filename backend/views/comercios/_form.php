<?php

use yii\helpers\Html;
use kartik\time\TimePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Comercios */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<div class="comercios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <div id="map-canvas"></div>
    <?= $form->field($model, 'latitud')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'longitud')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'prioridad')->textInput() ?>

    
    <?= $form->field($model,'hora_apertura')->widget(TimePicker::classname(), []); ?>

    <?= $form->field($model, 'hora_cierre')->widget(TimePicker::classname(), []) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
function initialize() {
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(-34.8977714, -56.165),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas,mapOptions);
    
    var markers = [];
    google.maps.event.addListener(map, 'click', function( event ){
        
        document.getElementById('comercios-latitud').value=event.latLng.lat();
        document.getElementById('comercios-longitud').value=event.latLng.lng();
        var marcador = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng());
        var marker = new google.maps.Marker({
      position: marcador,
      draggable:true,
      animation: google.maps.Animation.DROP,
      map: map,
      title: ''
  });
  markers.push(marker);
  if(markers.length==1){
      markers[0].setMap(map);
  }else{
      markers[0].setMap(null);
      markers.splice(0,1);
      marker.setMap(map);    
  }
  
        
    });
     
}
   

google.maps.event.addDomListener(window, 'load', initialize);

</script>