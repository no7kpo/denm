<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = Yii::t('app', 'New Order');
$comercioId = ''; //actualizar variable segun id de dropdown - jquery?


if(!Yii::$app->user->getIsGuest()){

?>

<div class="site-neworder">
    <br>
    <div class="body-content">
    	
    	<div class="col-md-12">
    		<div class="text-center" id="new-order-sel">
                <h1 class="text-center"><?= Html::encode($this->title)?></h1>

                <?php if(count($comercios) > 0){ ?>
                
                <div id="shop_select" class="dropdown datepicker-inline">
                    <select class="btn btn-sm dropdown-toggle" id="shop-dropdown">
                    
                    <?php foreach($comercios as $comercio){ ?>
                      <option value=<?php echo $comercio['id'];?>><?php echo $comercio['nombre'];?></option>
                    <?php } ?>
                    
                    </select>
                </div>

                <br><br>
                <p class="text-center"><a class="btn btn-default btn-primary btn-sm med-btn" onclick="newOrder()"><?= Yii::t('app','Select Shop');?></a></p>

                <?php } else{ ?>

                	<h4><?= Yii::t('app','Oh, oh! No shops are available');?>.</h4>
                	<br><br>
                <p class="text-center"><a id="newOrderBtn" class="btn btn-default btn-primary btn-sm med-btn" href=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/site/index"';?>><?= Yii::t('app','Go back');?></a></p>

                <?php } ?>
            </div>
    	</div>
    	
    </div>
</div>

<script>
    function newOrder(){
        var id = $("#shop_select option:selected").val();
        url = "http://"+document.domain+"/site/createorder?id="+id;
        window.location = url;
    }
</script>

<?php } else{ ?>

<div class="site-neworder">

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