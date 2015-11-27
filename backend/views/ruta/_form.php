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
    	<?= Html::button(Yii::t('app', 'Create'), [ 'class' => 'btn btn-primary', 'onclick' => '
                        $.post( "'.Url::toRoute('/ruta/generarruta').'", { datos: orden, relevador: document.getElementById("rutarelevador-idrelevador").value,dia: document.getElementById("ruta-dia").value } )
                            .done(function( data ) {
                            	
                               	
                               	console.log(data);
                               	
                                }
                        );
                    '   
    ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div id="outputDiv"></div>
</div>
<script>

var rutafinal=[];
var destinos = [];
var comercios= [];
var orden=[];
var geocoder;
var directionsDisplay;
var directionsService;	

function initialize() {
	sessionStorage.clear();
	geocoder = new google.maps.Geocoder();
	directionsService = new google.maps.DirectionsService();
	
    var mapCanvas = document.getElementById('map-canvas');
    var mapOptions = {
      center: new google.maps.LatLng(-34.8977714, -56.165),
      zoom: 13,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    var map = new google.maps.Map(mapCanvas,mapOptions);
   
    

        
    	
     
}

function calculateDistances(origen,dest) {
  var service = new google.maps.DistanceMatrixService();

  service.getDistanceMatrix({
	  origins:[origen], //Dado que es una matriz se pueden especificar varios origenes y destinos
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
//	rutafinal[0]=origins[0];
//	console.log(origins);



//	for (var i = 0; i < origins.length; i++) {
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

	  }
	var indexofcerca= destinations.indexOf(mascerca);
	  
	  
	//  results.splice(indexofcerca,1);
	  orden.push(comercios[indexofcerca]);
	  comercios.splice(indexofcerca,1);
	  var nuevoorigen=destinos[indexofcerca];
	  rutafinal.push(nuevoorigen);
	  destinos.splice(indexofcerca,1);

	//}
	if(destinos.length>0){
		calculateDistances(nuevoorigen,destinos);
	}else{
		calcular_ruta();
	}
	

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
    directionsDisplay = new google.maps.DirectionsRenderer({map: map,draggable: true});
	var markers = [];
	var comer=JSON.parse(sessionStorage.comercios);
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
	rutafinal.push(mark);

	for(var x in comer){
	  comercios.push(comer[x]);
	}
	calculateDistances(mark,destinos);
	
	/*while(destinos.length>3){
		calculateDistances(destinos[0],destinos);
	}*/
	
	
}
   

google.maps.event.addDomListener(window, 'load', initialize);

function calcular_ruta() {
		  		  
		  // Retrieve the start and end locations and create a DirectionsRequest using DRIVING, BICYCLE OR WALKING directions.		  

			var origen  = rutafinal[0];
			var destino = rutafinal[rutafinal.length-1];
			var puntosmedios=[];
			puntosmedios=rutafinal;
			puntosmedios.pop();
			puntosmedios.shift();
			console.log(orden);
			var wypt=[];
			for (var i = 0; i < puntosmedios.length; i++) {
    			if (puntosmedios[i]) {
      				wypt.push({
        				location: puntosmedios[i],
        				stopover: true
      				});
    			}
  			}
			var modo_viaje = 'DRIVING';
						
			//var estadio = new google.maps.LatLng(-34.894300, -56.152912);		

			var request = {
				 origin: origen, 
				 destination: destino,
				 travelMode: google.maps.DirectionsTravelMode[modo_viaje],
				 waypoints: wypt,
				 optimizeWaypoints: true,
				 unitSystem: google.maps.UnitSystem.METRIC,
				 provideRouteAlternatives: true		
			};		  		  

			// Route the directions and pass the response to a function to create markers for each step.
			directionsService.route(request, function(response, status) {
				if (status == google.maps.DirectionsStatus.OK){			
					directionsDisplay.setPanel();
					directionsDisplay.setDirections(response);					
				}
				else{
					alert("No existen rutas entre ambos puntos");
				}
			});  
						
	    }

</script>