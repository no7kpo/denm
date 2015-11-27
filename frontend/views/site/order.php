<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

//Defino datos del comercio
$local_name = $comercio['nombre'];
$horaIni = explode(':', $comercio['hora_apertura']);
$horaFin = explode(':', $comercio['hora_cierre']);
$local_hour = $horaIni[0].':'.$horaIni[1].' - '.$horaFin[0].':'.$horaFin[1];
$latitud = $comercio['latitud'];
$longitud = $comercio['longitud'];


$this->title = Yii::t('app', 'Stock for Shop');

if(!Yii::$app->user->getIsGuest()){
?>

<div class="site-order site-page">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
            <?php if(count($productos) > 0){ ?>

                <h2><p><?= Html::encode($this->title)?> Nº <?php echo $shopId.' - '.$local_name;?></p></h2>
                <p> <?php echo $local_hour; ?></p>
            
            <?php } else{ ?>

            	<h2><p><?= Html::encode($this->title)?> Nº <?php echo $shopId; ?>?</p></h2>
            	<p> <?= Yii::t('app','It looks like the order doesnt exist');?>.</p>
            
            <?php } ?>
            </div>
        </div>

        <div class="col-md-2 logo_banner">
            <img class="img-responsive map-center" id="map_logo" src="/assets/images/carrito.png">
        </div>
    </div>

    <br>
    <div class="body-content">
    
    <?php if(count($productos) > 0){ ?>
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

	                        <?php foreach($productos as $item){ ?>
	                        <tr>
	                            <td><?php echo $item['nombre']; ?></td>
	                            <td class="text-center"><?php if($item['imagen'] == ''){ echo '<span class="not-delivered glyphicon glyphicon-remove"></span>'; } else{ ?><span><img class="item img-responsive" src="<?=Yii::getAlias('@product_pictures')?><?php echo DIRECTORY_SEPARATOR.$item['imagen'];?>"></span><?php } ?></td>
	                           	<td class="text-center">
	                           		<input class="input-stock" onblur="saveThisItem(<?php echo $item['idproducto'];?>,this.value)" type="number" id="stock_<?php echo $item['idproducto'];?>" value="0" min="0" max="1000">
	                           	</td>
	                        </tr>
	                        <?php } ?>
	                    </table>
	                </div>
                    
                    <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>><?= Yii::t('app','Cancel');?></a></p>
                    <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" onclick=<?php echo '"deliveryDone('.$shopId.')"';?>><?= Yii::t('app','Done');?>!</a></p>
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


<script type="text/javascript">

    //Actualiza valor del stock
    function saveThisItem(itemId,value) {

        var url = "<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/savethisitem'; ?>";

        $.ajax({
            type: "POST",
            url: url,
            data: { "shopId" :  <?php echo $shopId; ?>, "fecha" : "<?php echo $fecha; ?>", "itemId" : itemId, "stock" : value },
            success: function(response){
                console.log(response);
            }
        });
    }

    //Asigna como finalizada la orden
    function deliveryDone(shopId) {
        
        var url = "<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/deliverydone'; ?>";

        $.ajax({
            type: "POST",
            url: url,
            data: { "shopId" :  shopId, "fecha" : "<?php echo $fecha; ?>" },
            success: function(response){
                console.log(response);
                window.location.href = "<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>";
            }
        });
    }

</script>

<script>
    function initialize() {
        var latitud=<?php echo $latitud; ?>;
        var longitud=<?php echo $longitud; ?>;
        var mapCanvas = document.getElementById('map-canvas');
        
        var mapOptions = {
            center: new google.maps.LatLng(latitud,longitud),
            zoom: 13,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        
        var map = new google.maps.Map(mapCanvas,mapOptions);
        
        google.maps.event.addListener(map, 'click', function( event ){
            document.getElementById('productos-ubicacion').value="Latitud: "+event.latLng.lat()+" "+", Longitud: "+event.latLng.lng();
        });

        var markers = [];
        
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