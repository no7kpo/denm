<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Home');
$count = 1;

$user=Yii::$app->user->identity;

//Data de ejemplo - Lista de pedidos y nombre de comercio
$data = array();
$data[] = array(
    'id' => 1,
    'name' => 'Devoto San Martin',
    'date' => '10-11-2015',
    'hours' => '09:00 - 21:00',
    'delivered' => true
);
$data[] = array(
    'id' => 2,
    'name' => 'Tienda Inglesa Propios',
    'date' => '10-11-2015',
    'hours' => '09:00 - 22:00',
    'delivered' => true
);
$data[] = array(
    'id' => 3,
    'name' => 'Cobadonga Hogar',
    'date' => '10-11-2015',
    'hours' => '10:00 - 17:00',
    'delivered' => false
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
    'date' => '10-11-2015',
    'hours' => '11:00 - 16:00',
    'delivered' => false
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
    'date' => '10-11-2015',
    'hours' => '11:00 - 16:00',
    'delivered' => false
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
    'date' => '10-11-2015',
    'hours' => '11:00 - 16:00',
    'delivered' => false
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
    'date' => '10-11-2015',
    'hours' => '11:00 - 16:00',
    'delivered' => false
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
    'date' => '10-11-2015',
    'hours' => '11:00 - 16:00',
    'delivered' => false
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
    'date' => '10-11-2015',
    'hours' => '11:00 - 16:00',
    'delivered' => false
);

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
                      <option value="tomorrow"><?= Yii::t('app',"Tomorrow");?></option>
                      <option value="t_week"><?= Yii::t('app',"This week");?></option>
                      <option value="n_week"><?= Yii::t('app',"Next week");?></option>
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

                        <?php if(count($data) > 0){ foreach($data as $order){ ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td title="Delivery info"><a class="btn-default" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/order?id='.$order['id'].'">'; echo '<span class="info glyphicon glyphicon-info-sign"></span> '.$order['name']; ?></a></td>
                            <td class="text-center"><?php echo $order['date']; ?></td>
                            <td class="text-center"><?php echo $order['hours']; ?></td>
                            <td class="text-center"><?php if($order['delivered'] == true){ echo '<span class="delivered glyphicon glyphicon-ok"></span>'; } else{ echo '<span class="not-delivered glyphicon glyphicon-remove"></span>'; } ?></td>
                        </tr>
                        <?php $count++; }}?>
                    </table>
                </div>
            </div>

        </div>
                <div class="text-center">
                    <h3 class="text-center"><?= Yii::t('app',"Change personal address!");?></h3>
                    <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="med-btn" href=<?php echo '"site/changedirection"';?>><?= Yii::t('app',"Update");?></a></p>
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

