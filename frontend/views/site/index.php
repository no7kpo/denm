<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Home');
$count = 1;
use yii\helpers\Url;
?>

<div class="site-index site-page">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Yii::t('app','Welcome back');?> <?php print_r(Yii::$app->user->identity->username); ?>!</p></h2>
                <p> - <?= Yii::t('app',"It's nice see you again");?></p>
            </div>
        </div>

        <div class="col-md-2 logo_banner">
            <img class="img-responsive map-center" id="map_logo" src="/assets/images/map.jpg">
        </div>
    </div>
    
    <br>
    <div class="body-content">

        <div class="col-md-4">

            <div class="row text-center">
                <div>
                    <h3><?= Yii::t('app',"Your best route for today");?></h3>
                    <div id="map-canvas" class="img-responsive map-center google-map"></div>
                </div>
                <br>
                <div class="text-center" id="new-order">
                    <h3 class="text-center"><?= Yii::t('app',"Take new orders!");?></h3>
                    <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="med-btn" href=<?= Url::to(Yii::$app->request->BaseUrl.'/site/neworder');?>><?= Yii::t('app',"New order");?></a></p>
                </div>

            </div>

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-7">

            <div class="row">
                <div class="dropdown datepicker-inline">
                    <h2><span class="glyphicon glyphicon-list-alt"></span>
                    <select class="btn btn-sm dropdown-toggle" id="datepicker-btn" onchange="changeDateRange(this.value)"></h2>
                      <option value="today" selected><?= Yii::t('app',"Today");?></option>
                      <option value="yesterday"><?= Yii::t('app',"Yesterday");?></option>
                      <option value="last7"><?= Yii::t('app',"Last 7 days");?></option>
                      <option value="last30"><?= Yii::t('app',"Last 30 days");?></option>
                    </select>
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-hover" id="delivery-table">
                        <tr>
                            <th>#</th>
                            <th><?= Yii::t('app',"Shop");?></th>
                            <th class="text-center"><?= Yii::t('app',"Date");?></th>
                            <th class="text-center"><?= Yii::t('app',"Hours");?></th>
                            <th class="text-center"><?= Yii::t('app',"Delivered");?></th>
                        </tr>

                        <?php if(count($orders) > 0){ 

                            foreach($orders as $order){ 
                              $horaIni = explode(':', $order['horaAper']);
                              $horaFin = explode(':', $order['horaCierr']);
                              $local_hour = $horaIni[0].':'.$horaIni[1].' - '.$horaFin[0].':'.$horaFin[1];
                        ?>
                        <tr class="tr-data">
                            <td><?php echo $count; ?></td>
                            
                            <td title="Delivery info">
                                <?php if($order['relevado'] != 1){ ?>
                                    <a class="btn-default" href=<?= Url::to(Yii::$app->request->BaseUrl.'/site/order?id='.$order['idComercio']);?>><?php echo '<span class="info glyphicon glyphicon-info-sign"></span> ';?>
                                <?php } echo $order['nombre']; if($order['relevado'] != 1){ ?>
                                    </a>
                                <?php } ?>
                            </td>
                            
                            <td class="text-center"><?php if($order['fecha'] == '0000-00-00'){ echo '-'; } else{ echo $order['fecha']; } ?></td>
                            <td class="text-center"><?php echo $local_hour; ?></td>
                            <td class="text-center"><?php if($order['relevado'] == 1){ echo '<span class="delivered glyphicon glyphicon-ok"></span>'; } else{ echo '<span class="not-delivered glyphicon glyphicon-remove"></span>'; } ?></td>
                        </tr>
                        <?php $count++; }}else{


                        }

                        ?>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript">

    //Funcion para el cambio de fechas
    function changeDateRange(value) {

        $(".tr-data").each(function(index, elem) {
            elem.remove();
        });

        console.log(value);

        var url = "<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>";

        $.ajax({
            type: "GET",
            url: url,
            data: { "filter" :  value },
            success: function(response){

                $.each(JSON.parse(response), function(index, value) {
                    console.log(value);
                    $("#delivery-table").append(value);
                });
            }
        });
    }
    
</script>

<script>
var rutafinal=[];
var destinos = [];
var comercios= [];
var orden=[];
var comer=[];
var geocoder;
var directionsDisplay;
var directionsService;
var map;

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
     map = new google.maps.Map(mapCanvas,mapOptions);
        directionsDisplay = new google.maps.DirectionsRenderer({map: map,draggable: false});
        
     loadMap();
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
//    outputDiv.innerHTML = '';
//  deleteOverlays();
//  rutafinal[0]=origins[0];
//  console.log(origins);



//  for (var i = 0; i < origins.length; i++) {
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
    var hogar = 'https://chart.googleapis.com/chart?chst=d_map_pin_letter&chld=O|FFFF00|000000';
    var map = new google.maps.Map(mapCanvas,mapOptions);
    directionsDisplay = new google.maps.DirectionsRenderer({map: map,draggable: false});
    var markers = [];
    var infowindows = [];
     comer=<?=json_encode($orders)?>;
        var bounds = new google.maps.LatLngBounds();
        var relev=<?=json_encode($relevador)?>;
        console.log(relev);
   var mark= new google.maps.LatLng(relev["latitud"],relev["longitud"]);
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
      //        icon:image
      
        });
   markers.push(marker);
  var iw = new google.maps.InfoWindow({
       content: com.nombre
     });
     google.maps.event.addListener(marker, "click", function (e) { iw.open(map, this); });
    }
    infowindows.push(iw);
    rutafinal.push(mark);

    for(var x in comer){
      comercios.push(comer[x]);
    }
    if(comer!=""){
        calculateDistances(mark,destinos);
    }
    
    
    /*while(destinos.length>3){
        calculateDistances(destinos[0],destinos);
    }*/
    
    
}

google.maps.event.addDomListener(window, 'load', initialize);

function calcular_ruta() {
                  
          // Retrieve the start and end locations and create a DirectionsRequest using DRIVING, BICYCLE OR WALKING directions.        

            var origen  = rutafinal[0];
            console.log(origen);
            var destino = rutafinal[rutafinal.length-1];
            console.log(destino);
            var puntosmedios=[];
            puntosmedios=rutafinal;
            puntosmedios.pop();
            puntosmedios.shift();
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
