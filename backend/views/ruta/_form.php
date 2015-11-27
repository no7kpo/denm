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
    ->dropDownList($user,[
    	'onchange'=>'
                        $.post( "'.Url::toRoute('/comercios/relevador').'", { id: $(this).val() } )
                            .done(function( data ) {
                            	
                               	sessionStorage.setItem("relevador",data);
                               	loadMap();
                                }
                        );
                    '   
                    ]) ?>

    <?=   $form->field($model, 'dia')->dropDownList( ['0' => Yii::t('app','Monday'), '1' => Yii::t('app','Tuesday'), '2' => Yii::t('app','Wednesday'), '3' => Yii::t('app','Thursday'), '4'=> Yii::t('app','Friday'), '5' => Yii::t('app','Saturday')],[
    	'onchange'=>'
                        $.post( "'.Url::toRoute('/comercios/pordia').'", { id: $(this).val() } )
                            .done(function( data ) {
                            	
                               	sessionStorage.setItem("comercios",data);
                               	console.log(data);
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
    <div id="outputDiv"></div>
</div>
<script>

var rutafinal=[];
var destinos = [];
var comercios= [];

function initialize() {
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(-34.8977714, -56.165),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas,mapOptions);
    sessionStorage.clear();

        
    	
     
}

function calculateDistances(origen,dest) {
		  var service = new google.maps.DistanceMatrixService();
		  service.getDistanceMatrix({
			  origins: [origen], //Dado que es una matriz se pueden especificar varios origenes y destinos
			  destinations: dest, 
			  travelMode: google.maps.TravelMode.DRIVING,
			  unitSystem: google.maps.UnitSystem.METRIC,
			  
			  //avoidHighways: false,
			  //avoidTolls: false
		  }, callbackMostrarDistancias);
		}

		//Muestra el resultado de la solicitud
		function callbackMostrarDistancias(response, status) {
		  if (status != google.maps.DistanceMatrixStatus.OK) {
			alert('Error was: ' + status);
		  } 
		  else 
		  {
			var origins = response.originAddresses;
			var destinations = response.destinationAddresses;
			var outputDiv = document.getElementById('outputDiv');
			outputDiv.innerHTML = '';
		//	deleteOverlays();

			
			  var results = response.rows[0].elements;
			//  addMarker(origins[i], false);
			  var distanciachica=0;
			  var mascerca;
			  //Muestra el resultado con el detalle de las distancias a cada punto, en kilometros y en metros
			  for (var j = 0; j < results.length; j++) {
				//addMarker(destinations[j], true);
				var dist=results[j].distance.value;
				if(distanciachica==0 || dist<distanciachica){
					distanciachica=dist;
					mascerca=destinations[j];
				}

			/*	outputDiv.innerHTML += '<i>' + origins[i] + '</i> a <i>' + destinations[j] + '</i>'
					+ ': <b>' + results[j].distance.text  
					+ ' ( ' + results[j].distance.value + ' mts )</b> en '
					+ results[j].duration.text + '<br>';*/
			  }
			
			rutafinal.push(mascerca);
			var indexofcerca= destinations.indexOf(mascerca);
			comercios.splice(indexofcerca,1);
			destinos.splice(indexofcerca,1);
			console.log(destinos.length  + 'en calculate');
			console.log(destinos);
			console.log(comercios);
			console.log(rutafinal);
		  }
		}

function loadMap(){
	var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(-34.8977714, -56.165),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
   // var image = {url:"<?= Yii::getAlias('@map_icon'). '/store.png'?>",scaledSize: new google.maps.Size('50','50'),origin: new google.maps.Point(0,0),anchor:new google.maps.Point(0,0)};
    var hogar = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';
    var map = new google.maps.Map(mapCanvas,mapOptions);
	var markers = [];
	var comer=JSON.parse(sessionStorage.comercios);
	var geocoder;
		var bounds = new google.maps.LatLngBounds();
	var relevador=JSON.parse(sessionStorage.relevador);
	var mark=new google.maps.LatLng(relevador.latitud,relevador.longitud);
	var marca = new google.maps.Marker({
		position: mark,
		animation:google.maps.Animation.DROP,
		map:map,
		icon:hogar
	})
	markers.push(marca);
	
	for(comercio in comer){
		var com=comer[comercio];
		var marcador = new google.maps.LatLng(com.latitud,com.longitud);
		destinos.push(marcador);
		var marker = new google.maps.Marker({
      		position: marcador,
      		draggable:true,
      		animation: google.maps.Animation.DROP,
      		map: map,
      //		icon:image
      
  		});
   markers.push(marker);
  var iw = new google.maps.InfoWindow({
       content: com.nombre
     });
     google.maps.event.addListener(marker, "click", function (e) { iw.open(map, this); });
	}
	rutafinal.push(JSON.parse(sessionStorage.relevador));

for(var x in comer){
  comercios.push(comer[x]);
}
	calculateDistances(mark,destinos);
	console.log(destinos.length + 'áfter calculate');
	/*while(destinos.length>3){
		calculateDistances(destinos[0],destinos);
	}*/
	
	
}
   

google.maps.event.addDomListener(window, 'load', initialize);

</script>