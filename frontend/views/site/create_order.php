<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = Yii::t('app', 'Create Order');

//Defino datos del comercio
$local_name = $comercio['nombre'];
$horaIni = explode(':', $comercio['hora_apertura']);
$horaFin = explode(':', $comercio['hora_cierre']);
$local_hour = $horaIni[0].':'.$horaIni[1].' - '.$horaFin[0].':'.$horaFin[1];


$userId = Yii::$app->user->getId();

if(!Yii::$app->user->getIsGuest()){

?>


<div class="site-createorder site-page">

        <div class="row" id="indx-welcome">
        <div class="col-md-10">
            <div>
                <h2><p><?= Html::encode($this->title)?> for: <?php echo $local_name;?></p></h2>
                <p> <?php echo $local_hour; ?></p>
            </div>
        </div>

        <div class="col-md-2">
            <img class="img-responsive map-center logo_banner" id="map_logo" src="/assets/images/items.png">
        </div>
    </div>

    <br>
    <div class="body-content">
    
    <?php if(count($items) > 0){ ?>

            <div class="col-md-4">

                <div class="row text-left">
                    <div class="text-center create-order-date">
                        <h2><?= Yii::t('app','Order day');?></h2>
                        <input class="input-date" type="text" value="<?php echo $fecha; ?>" disabled>
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
                                    <th class="text-center"><?= Yii::t('app','Image');?></th>
                                    <th class="text-center"><?= Yii::t('app','Stock to deliver');?></th>
                                </tr>

                                <?php foreach($items as $item){ ?>
                                <tr>
                                    <td><?php echo $item['nombre']; ?></td>
                                    <td class="text-center"><?php if($item['Imagen'] == ''){ echo '<span class="not-delivered glyphicon glyphicon-remove"></span>'; } else{ ?><span><img class="item img-responsive" src="<?=Yii::getAlias('@product_pictures')?><?php echo DIRECTORY_SEPARATOR.$item['Imagen'];?>"></span><?php } ?></td>
                                    <td class="text-center">
                                        <input class="input-stock" type="number" id="<?php echo $item['id'];?>" value="0" min="0" max="1000">
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>

                        <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>><?= Yii::t('app','Cancel');?></a></p>
                        <p class="text-center inline"><a class="btn btn-default btn-primary btn-sm big-btn" onclick="createNewOrder()"><?= Yii::t('app','Create');?></a></p>
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
    function createNewOrder() {
        var arrayItems = [];
        var count = 0;

        $(".input-stock").each(function() {
            arrayItems[count] = $(this).attr("id")+':'+$(this).val();
            count++;
        });

        var url = "<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/site/createneworder'; ?>";

        $.ajax({
            type: "POST",
            url: url,
            data: { "shopId" : "<?php echo $shopId;?>", "fecha" :  "<?php echo $fecha; ?>", "arrayItems" : arrayItems },
            success: function(response){
                console.log(response);
                window.location.href = "<?php echo 'http://'.$_SERVER['HTTP_HOST']; ?>";
            }
        });
    }
</script>

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