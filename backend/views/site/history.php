<?php

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Deliveries Records');

use yii\helpers\Url;
?>


<div class="site-history">
	<div class="row">
        <div class="col-md-12">
        	<div class="table-responsive">
                <table class="table table-hover" id="delivery-table">
                    <tr>
                        <th class="text-center"><?= Yii::t('app',"Date");?></th>
                        <th class="text-center"><?= Yii::t('app',"Shop");?></th>
                        <th class="text-center"><?= Yii::t('app',"Route id");?></th>
                        <th class="text-center"><?= Yii::t('app',"User id");?></th>
                    </tr>
                    <tr>
                    <?php if(count($relevamientos) > 0){ 

                        foreach($relevamientos as $relevamiento){ ?>

                        <td class="text-center"><?php echo $relevamiento['fecha']; ?></td>
                        <td class="text-center"><?php echo $relevamiento['nombreComercio']; ?></td>
                        <td class="text-center"><?php echo $relevamiento['rutaId']; ?></td>
                        <td class="text-center"><?php echo $relevamiento['relevadorId'];; ?></td>

                    <?php }} ?>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>