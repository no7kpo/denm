<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'New Order';
$shopId = ''; //actualizar variable segun id de dropdown - jquery?

//Data de ejemplo - Lista de Ids, Nombres de Comercios
$data = array();
$data[] = array(
    'id' => 1,
    'name' => 'Devoto San Martin',
);
$data[] = array(
    'id' => 2,
    'name' => 'Tienda Inglesa Propios',
);
$data[] = array(
    'id' => 3,
    'name' => 'Cobadonga Hogar',
);
$data[] = array(
    'id' => 4,
    'name' => 'Cobadonga Hogar 2',
);

if(!Yii::$app->user->getIsGuest()){

?>

<div class="site-neworder">
    <br>
    <div class="body-content">
    	
    	<div class="col-md-12">
    		<div class="text-center" id="new-order-sel">
                <h1 class="text-center">New Order</h1>

                <?php if(count($data) > 0){ ?>
                
                <div class="dropdown datepicker-inline">
                    <select class="btn btn-sm dropdown-toggle" id="shop-dropdown">
                    
                    <?php foreach($data as $shop){ ?>
                      <option value=<?php echo $shop['id'];?> onclick="<?php echo "setShopId('".$shop['id']."')";?>"><?php echo $shop['name'];?></option>
                    <?php } ?>
                    
                    </select>
                </div>

                <br><br>
                <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="med-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/createorder?id='.$shopId.'"';?>>Select Shop</a></p>

                <?php } else{ ?>

                	<h4>Oh, oh! No shops are available.</h4>
                	<br><br>
                <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="med-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>>Go back</a></p>

                <?php } ?>
            </div>
    	</div>
    	
    </div>
</div>


<?php } else{ ?>

<div class="site-neworder">

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