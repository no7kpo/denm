<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Home');
$count = 1;


if(!Yii::$app->user->getIsGuest()){
?>

<div class="site-index">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Yii::t('app','Welcome back');?> <?php print_r(Yii::$app->user->identity->username); ?>!</p></h2>
                <p> - <?= Yii::t('app',"It's nice see you again");?></p>
            </div>
        </div>

        <div class="col-md-2">
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
                    <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="med-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/neworder"';?>><?= Yii::t('app',"New order");?></a></p>
                </div>
            </div>

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-7">

            <div class="row">
                <div class="dropdown datepicker-inline">
                    <h2><?= Yii::t('app',"Deliveries");?></h2>
                    <select class="btn btn-sm dropdown-toggle" id="datepicker-btn" onchange="changeDateRange(this.value)">
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
                            <th class="text-center"><?= Yii::t('app',"Day");?></th>
                            <th class="text-center"><?= Yii::t('app',"Hours");?></th>
                            <th class="text-center"><?= Yii::t('app',"Delivered");?></th>
                        </tr>

                        <?php if(count($orders) > 0){ foreach($orders as $order){ 
                            $horaIni = explode(':', $order['horaAper']);
                            $horaFin = explode(':', $order['horaCierr']);
                            $local_hour = $horaIni[0].':'.$horaIni[1].' - '.$horaFin[0].':'.$horaFin[1];
                        ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td title="Delivery info">
                                <?php if($order['relevado'] != 1){ ?>
                                    <a class="btn-default" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/order?id='.$order['idComercio'].'">'; echo '<span class="info glyphicon glyphicon-info-sign"></span> ';?>
                                <?php } echo $order['nombre']; if($order['relevado'] != 1){ ?>
                                    </a>
                                <?php } ?>
                            </td>
                            <td class="text-center"><?php echo $order['fecha']; ?></td>
                            <td class="text-center"><?php echo $local_hour; ?></td>
                            <td class="text-center"><?php if($order['relevado'] == 1){ echo '<span class="delivered glyphicon glyphicon-ok"></span>'; } else{ echo '<span class="not-delivered glyphicon glyphicon-remove"></span>'; } ?></td>
                        </tr>
                        <?php $count++; }}?>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

<script type="text/javascript">

    //Funcion para el cambio de fechas
    function changeDateRange(value) {
        alert(value);
    }
    
</script>

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

<?php } else{ ?>

<div class="site-index">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Yii::t('app',"Welcome back .. guest?");?></p></h2>
                <p> - <?= Yii::t('app',"It's nice see you!");?></p>
            </div>
        </div>

        <div class="col-md-2 right">
            <img class="img-responsive right" src="/assets/images/map.jpg">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <br><br>
            <h1><?= Yii::t('app',"Please");?> <a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/login'?>> <?= Yii::t('app',"login");?></a> <?= Yii::t('app',"or");?> <a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/signup'?>><?= Yii::t('app',"signup");?></a>.</h1>
        </div>
    </div>

</div>

<?php } ?>