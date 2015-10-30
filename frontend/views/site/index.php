<?php

/* @var $this yii\web\View */

$this->title = 'Relevadores';
$count = 1;

//Data de ejemplo
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

if(!Yii::$app->user->getIsGuest()){
?>

<div class="site-index">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p>Welcome back <?php print_r(Yii::$app->user->identity->username); ?>!</p></h2>
                <p> - It's nice see you again</p>
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
                    <h3>Your best route for today</h3>
                    <img class="img-responsive map-center" src="http://i.imgur.com/us91yIY.png">
                </div>
                <br>
                <div class="text-center" id="new-order">
                    <h3 class="text-center">Take new orders!</h3>
                    <p class="text-center"><a class="btn btn-default btn-primary btn-sm" id="med-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/createorder"';?>>New order</a></p>
                </div>
            </div>

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-7">

            <div class="row">
                <div class="dropdown datepicker-inline">
                    <h2>Deliveries</h2>
                    <select class="btn btn-sm dropdown-toggle" id="datepicker-btn">
                      <option value="today" selected onclick="getReport('today')">Today</option>
                      <option value="tomorrow" onclick="getReport('tomorrow')">Tomorrow</option>
                      <option value="t_week" onclick="getReport('t_week')">This week</option>
                      <option value="n_week" onclick="getReport('n_week')">Next week</option>
                    </select>
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-hover" id="delivery-table">
                        <tr>
                            <th>#</th>
                            <th>Shop</th>
                            <th class="text-center">Day</th>
                            <th class="text-center">Hours</th>
                            <th class="text-center">Delivered</th>
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

    </div>
</div>

<?php } else{ ?>

<div class="site-index">

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