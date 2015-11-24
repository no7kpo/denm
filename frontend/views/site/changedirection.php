<?php use yii\widgets\ActiveForm; ?>
<style>
      #map-canvas {
        width: 500px;
        height: 400px;
      }
    </style>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<div class="site-index">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Yii::t('app','Change address');?> </p></h2>
            </div>
        </div>

        <div class="col-md-2">
            <img class="img-responsive map-center" id="map_logo" src="/assets/images/map.jpg">
        </div>
    </div>
    
    <br>
    <div class="body-content">

        <div class="col-md-4">


                <div id="map-canvas"></div>

    <form action="updateaddress" method="post">
        <input type="hidden" id="longitud" name="longitud" value="">
        <input type="hidden" id="latitud" name="latitud" value="">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>"/>
        <input type="submit" value=<?=Yii::t('app', 'Update') ?>>
    </form> 
        </div>

    </div>
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

            document.getElementById('latitud').value=event.latLng.lat();
            document.getElementById('longitud').value=event.latLng.lng();
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
            }
            else{
                markers[0].setMap(null);
                markers.splice(0,1);
                marker.setMap(map);    
            }
           
        });    
    }
    google.maps.event.addDomListener(window, 'load', initialize);

</script>