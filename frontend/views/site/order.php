<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Order';
$id = $_GET['id'];

//Datos de ejemplo - Informacion del comercio
$local_name = 'Devoto San Martin';
$local_dir = 'San Martin 1243';
$local_hour = '09:00 - 21:00';

//Data de ejemplo - Lista de productos del pedido $id
$data = array();
$data[] = array(
    'id' => 385,
    'name' => 'Shampoo de perro',
    'amount' => 50,
    'image' => 'http://www.caloxvetcentroamerica.com/wp-content/uploads/2012/05/Champu_Antialergico.png'
);
$data[] = array(
    'id' => 101,
    'name' => 'Pasta de dientes Colgate',
    'amount' => 100,
    'image' => 'https://www.perfumeriasif.com/1419-22008-medium/colgate-pasta-proteccion-caries-75-ml.jpg'
);
$data[] = array(
    'id' => 95,
    'name' => 'Espuma de afeitar Gillette',
    'amount' => 20,
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
            	<p> It looks like the order doesnt exist.</p>
            
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
	                <h3>Best route from your location</h3>
	                <img class="img-responsive map-center" src="http://i.imgur.com/us91yIY.png">
            	</div>
            	<br>
            </div>

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-7">
        	<div class="row">
	            <form role="form">        
	                <h2>Delivery Items</h2>

	                <div class="table-responsive">
	                    <table class="table table-hover" id="delivery-table">
	                        <tr>
	                        	<th>Id</th>
	                            <th>Name</th>
	                            <th class="text-center">Amount</th>
	                            <th class="text-center">Image</th>
	                            <th class="text-center">Stock</th>
	                        </tr>

	                        <?php foreach($data as $item){ ?>
	                        <tr>
	                        	<td><?php echo $item['id']; ?></td>
	                            <td><?php echo $item['name']; ?></td>
	                            <td class="text-center"><?php echo $item['amount']; ?></td>
	                            <td class="text-center"><span><img class="item img-responsive" src=<?php if($item['image'] == ''){ echo "/assets/images/wrong.png"; } else{ echo $item['image']; } ?>></span></td>
	                           	<td class="text-center">NUMBER INPUT</td>
	                        </tr>
	                        <?php } ?>
	                    </table>
	                </div>

	                <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="big-btn" onclick=<?php echo '"deliveryDone('.$id.')"';?>>Delivery done!</a></p>
		        </form>
		    </div>
        </div>
    
    <?php }else{ ?>
    	<div class="col-md-12">
        	<div class="row text-center">
        		<h2><a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/index'?>>Please go back</a></h2>
        		<h3>Theres no data to show.</h3>
        	</div>
        </div>
    <?php } ?>
    </div>

</div>

<?php } else{ ?>

<div class="site-order">

    <div class="row" id="indx-welcome">
        <div class="col-md-4">
            <div>
                <h2><p>Welcome back .. guest?</p></h2>
                <p> - It's nice see you!</p>
            </div>
        </div>

        <div class="col-md-8 right">
            <img class="img-responsive right" src="http://gamers-on.com/wp-content/uploads/2015/02/google-maps_infografia.jpg">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <br><br>
            <h1>Please <a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/login'?>> login</a> or <a href=<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/signup'?>>signup</a>.</h1>
        </div>
    </div>

</div>

<?php } ?>