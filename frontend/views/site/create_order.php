<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

$this->title = Yii::t('app', 'Create Order');

//Defino datos del comercio
$local_name = $comercio['nombre'];
$local_dir = 'San Martin 1243';
$horaIni = explode(':', $comercio['hora_apertura']);
$horaFin = explode(':', $comercio['hora_cierre']);
$local_hour = $horaIni[0].':'.$horaIni[1].' - '.$horaFin[0].':'.$horaFin[1];

$stock = 50; //TRAER DE BASE!!!!!

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
    
    <?php if(count($items) > 0){ ?>

        <?php $form = ActiveForm::begin(['id' => 'form-createorder']); ?>
            <div class="col-md-4">

                <div class="row text-left">
                    <div class="text-center create-order-date">
                        <h2><?= Yii::t('app','Delivery day');?></h2>

                        <?php echo DatePicker::widget([
                            'id' => 'delivery_day',
                            'clientOptions' => [
                                'model' => $model,
                                'attribute' => 'deliveryDate',
                                //'dateFormat' => 'dd-MM-yyyy',
                            ],
                            'options' => ['class' => 'form-control', 'style' => 'max-width: 260px;']
                        ]); ?>
                        
                        <br>
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
                                    <th><?= Yii::t('app','Name');?></th>
                                    <th class="text-center"><?= Yii::t('app','Available stock');?></th>
                                    <th class="text-center"><?= Yii::t('app','Image');?></th>
                                    <th class="text-center"><?= Yii::t('app','New delivery stock');?></th>
                                </tr>

                                <?php foreach($items as $item){ ?>
                                <tr>
                                    <td><?php echo $item['nombre']; ?></td>
                                    <td class="text-center"><?php echo $stock; ?></td>
                                    <td class="text-center"><?php if($item['Imagen'] == ''){ echo '<span class="not-delivered glyphicon glyphicon-remove"></span>'; } else{ echo '<span><img class="item img-responsive" src="../../backend/imagenes/productos/'.$item["Imagen"].'"></span>'; } ?></td>
                                    <td class="text-center">
                                        <input class="input-stock" type="number" id="stock_<?php echo $item['id'];?>" value="0" min="0" max="<?php echo $stock;?>">
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>

                        <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>><?= Yii::t('app','Cancel');?></a></p>
                        <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" id="" href=<?php echo '';?>><?= Yii::t('app','Create');?></a></p>
                    </form>
                </div>
            </div>

        <?php ActiveForm::end(); ?>

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