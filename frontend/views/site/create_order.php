<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Order');

//Datos de ejemplo - Informacion del comercio
$local_name = 'Devoto San Martin';
$local_dir = 'San Martin 1243';
$local_hour = '09:00 - 21:00';

//Data de ejemplo - Informacion de productos asociados al comercio de id $id
$data = array();
$data[] = array(
    'id' => 385,
    'name' => 'Shampoo de perro',
    'stock' => 50, //stock available in our store?
    'image' => 'http://www.caloxvetcentroamerica.com/wp-content/uploads/2012/05/Champu_Antialergico.png'
);

if(!Yii::$app->user->getIsGuest()){

?>

<div class="site-createorder">

        <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Html::encode($this->title)?> for: <?php echo $local_name;?></p></h2>
                <p> <?php echo $local_dir.' | '.$local_hour; ?></p>
            </div>
        </div>

        <div class="col-md-2">
            <img class="img-responsive map-center" id="map_logo" src="/assets/images/items.png">
        </div>
    </div>

    <br>
    <div class="body-content">
    
    <?php if(count($data) > 0){ ?>
        <div class="col-md-4">

            <div class="row text-center">
                <div>
                    <h3><?= Yii::t('app','Select delivery day');?></h3>
                    DATEPICKER
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
                                <th>Id</th>
                                <th><?= Yii::t('app','Name');?></th>
                                <th class="text-center"><?= Yii::t('app','Our stock');?></th>
                                <th class="text-center"><?= Yii::t('app','Image');?></th>
                                <th class="text-center"><?= Yii::t('app','Amount');?></th>
                            </tr>

                            <?php foreach($data as $item){ ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td class="text-center"><?php echo $item['stock']; ?></td>
                                <td class="text-center"><span><img class="item img-responsive" src=<?php if($item['image'] == ''){ echo "/assets/images/wrong.png"; } else{ echo $item['image']; } ?>></span></td>
                                <td class="text-center">NUMBER INPUT</td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>

                    <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>><?= Yii::t('app','Cancel');?></a></p>
                    <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" id="" href=<?php echo '';?>><?= Yii::t('app','Create');?></a></p>
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


<?php } else{ ?>

<div class="site-createorder">

    <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Yii::t('app','Welcome back .. guest?');?></p></h2>
                <p> - <?= Yii::t('app',"It's nice see you!");?></p>
            </div>
        </div>

        <div class="col-md-2 right">
            <img class="img-responsive right" src="/assets/images/items.png">
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