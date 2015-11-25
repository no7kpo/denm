<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Ruta */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<div class="ruta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($rutarel, 'idrelevador')
    ->dropDownList($user) ?>

    <?=   $form->field($model, 'fecha')->dropDownList( ['0' => Yii::t('app','Monday'), '1' => Yii::t('app','Tuesday'), '2' => Yii::t('app','Wednesday'), '3' => Yii::t('app','Thursday'), '4'=> Yii::t('app','Friday'), '5' => Yii::t('app','Saturday')],[
    	'onchange'=>'
                        $.post( "'.Url::toRoute('/comercios/pordia').'", { id: $(this).val() } )
                            .done(function( data ) {
                            	
                               	sessionStorage.setItem("comercios",data);
                               	loadMap();
                                }
                        );
                    '   
    ]) ?>
    <div id="map-canvas"></div>
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
        
    });
     
}

function loadMap(){
	var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(-34.8977714, -56.165),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas,mapOptions);
	var comercios=sessionStorage.comercios;
	var markers = [];
	var comer=JSON.parse(comercios);
	for(comercio in comer){
		var com=comer[comercio];
		var marcador = new google.maps.LatLng(com.latitud,com.longitud);
		var marker = new google.maps.Marker({
      position: marcador,
      draggable:true,
      animation: google.maps.Animation.DROP,
      map: map,
      title: '',
      
  });
  markers.push(marker);
  var iw = new google.maps.InfoWindow({
       content: com.nombre
     });
     google.maps.event.addListener(marker, "click", function (e) { iw.open(map, this); });
	}
	
}
   

google.maps.event.addDomListener(window, 'load', initialize);

</script>