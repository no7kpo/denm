<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Stock for order');
$shopId = $_GET['id'];

//Datos de ejemplo - Informacion del comercio
$local_name = 'Devoto San Martin';
$local_dir = 'San Martin 1243';
$local_hour = '09:00 - 21:00';

//Data de ejemplo - Lista de productos del pedido $id
$data = array();
$data[] = array(
    'id' => 385,
    'name' => 'Shampoo de perro',
    'image' => 'http://www.caloxvetcentroamerica.com/wp-content/uploads/2012/05/Champu_Antialergico.png'
);
$data[] = array(
    'id' => 101,
    'name' => 'Pasta de dientes Colgate',
    'image' => 'https://www.perfumeriasif.com/1419-22008-medium/colgate-pasta-proteccion-caries-75-ml.jpg'
);
$data[] = array(
    'id' => 95,
    'name' => 'Espuma de afeitar Gillette',
    'image' => 'https://www.gillette.com/WebHandlers/JSCSSCompressHandler.ashx?filetype=image&sourcefilename=/Content/es-AR/Images/Nav_preview/Espuma-para-Afeitar-Foamy.png'
);


if(!Yii::$app->user->getIsGuest()){
?>

<div class="site-order">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
            <?php if(count($data) > 0){ ?>

                <h2><p><?= Html::encode($this->title)?> Nº <?php echo $id.' - '.$local_name;?></p></h2>
                <p> <?php echo $local_dir.' | '.$local_hour; ?></p>
            
            <?php } else{ ?>

            	<h2><p><?= Html::encode($this->title)?> Nº <?php echo $id; ?>?</p></h2>
            	<p> <?= Yii::t('app','It looks like the order doesnt exist');?>.</p>
            
            <?php } ?>
            </div>
        </div>

        <div class="col-md-2">
            <img class="img-responsive map-center" id="map_logo" src="/assets/images/carrito.png">
        </div>
    </div>

    <br>
    <div class="body-content">
    
    <?php if(count($data) > 0){ ?>
    	<div class="col-md-4">

        	<div class="row text-center">
        		<div>
	                <h3><?= Yii::t('app','Best route from your location');?></h3>
	                <div id="map-canvas" class="img-responsive map-center google-map"></div>
            	</div>
            	<br>
            </div>

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-7">
        	<div class="row">
	            <form role="form">        
	                <h2><?= Yii::t('app','Delivery Items');?></h2>

	                <div class="table-responsive">
	                    <table class="table table-hover" id="delivery-table">
	                        <tr>
	                            <th>Name</th>
	                            <th class="text-center"><?= Yii::t('app','Image');?></th>
	                            <th class="text-center"><?= Yii::t('app','Stock');?></th>
	                        </tr>

	                        <?php foreach($data as $item){ ?>
	                        <tr>
	                            <td><?php echo $item['name']; ?></td>
	                            <td class="text-center"><span><img class="item img-responsive" src=<?php if($item['image'] == ''){ echo "/assets/images/wrong.png"; } else{ echo $item['image']; } ?>></span></td>
	                           	<td class="text-center">
	                           		<input class="input-stock" onblur="saveThisItem(<?php echo $shopId;?>,<?php echo $item['id'];?>,this.value)" type="number" id="stock_<?php echo $item['id'];?>" value="0" min="0" max="1000">
	                           	</td>
	                        </tr>
	                        <?php } ?>
	                    </table>
	                </div>
                    <script type="text/javascript">
                        function saveThisItem(shop,item,value) {

                            console.log(shop,item,value);
                        }
                    </script>
                    <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>><?= Yii::t('app','Cancel');?></a></p>
                    <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" onclick=<?php echo '"deliveryDone('.$id.')"';?>><?= Yii::t('app','Done');?>!</a></p>
                </form>
		    </div>
        </div>
    
    <?php }else{ ?>
    	<div class="col-md-12">
        	<div class="row text-center">
        		<h2><a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/index'?>><?= Yii::t('app','Please go back');?></a></h2>
        		<h3><?= Yii::t('app','Theres no data to show');?>.</h3>
        	</div>
        </div>
    <?php } ?>
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

<div class="site-order">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Yii::t('app','Welcome back .. guest?');?></p></h2>
                <p> - <?= Yii::t('app',"It's nice see you!");?></p>
            </div>
        </div>

        <div class="col-md-2 right">
            <img class="img-responsive right" src="/assets/images/carrito.png">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <br><br>
            <h1><?= Yii::t('app','Please');?> <a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/login'?>> <?= Yii::t('app','login');?></a> <?= Yii::t('app','or');?> <a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/signup'?>><?= Yii::t('app','signup');?></a>.</h1>
        </div>
    </div>

</div>

<?php } ?>