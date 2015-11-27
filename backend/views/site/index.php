<?php
   use miloschuman\highcharts\Highcharts;
   use yii\jui\DatePicker;
/* @var $this yii\web\View */

$this->title = 'Bienvenido a Relevadores APP';
?>
<div class="site-index">
<br>
<h4> REPORTE DE PORCENTAJE DE EFECTIVIDAD EN RELEVADORES</h4><br>
<?php

echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Efectividad de Relevadores'],
      'xAxis' => [
         'categories' => $users
      ],
      'yAxis' => [
         'title' => ['text' => 'Porcentaje']
      ],
      'series' => [
        ['type' => 'column', 'name' => 'Eficiencia', 'data' => $percent,
                'dataLabels' => [
                'enabled'=> true,
                'rotation'=> -90,
                'color'=> '#FFFFFF',
                'align'=> 'right',
                'y'=> 10, 
                ],
        ],
      ]
   ]
]);

?>
<br><br>
<h4> REPORTE DE PEDIDOS DE COMERCIO EN EL TIEMPO</h4><br>
<form>
    <table>
           <tr>
              <td>
                <fieldset>
                    <legend>Desde:</legend>
                    <?= yii\jui\DatePicker::widget(['name' => 'startDate', 'language' => 'es-UY' , 'dateFormat' => 'dd-MM-yyyy']) ?>
                </fieldset>
              </td>
              <td> &nbsp;&nbsp;&nbsp; </td>
              <td>
                <fieldset>
                    <legend>Hasta:</legend>
                    <?= yii\jui\DatePicker::widget(['name' => 'endDate', 'language' => 'es-UY' , 'dateFormat' => 'dd-MM-yyyy']) ?>
                </fieldset>
              </td>
              <td> &nbsp;&nbsp;&nbsp; </td>
              <td> 
                    <select id="store-picker">
                      <option value="0" selected>Seleccione un comercio</option>
                      <?php echo $stores ?>
                    </select>

                </td>
                <td> &nbsp;&nbsp;&nbsp; </td>
                <td> 
                    <input type="button" value='Generar Gr&aacute;fica'/>

                </td>

        </tr>
    </table>
    <br>
 <?php


$comercio='Frutas Zarlanga';
/*$desde='2015-11-24';
$hasta='2015-11-26';*/
echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Productos pedidos por el comercio ' . $comercio . ' desde: '. $datei . ' hasta: ' . $datef],
      'xAxis' => [
         'categories' => $prods
      ],
      'yAxis' => [
         'title' => ['text' => 'Cantidad pedida']
      ],
      'series' => [
         ['type' => 'column', 'name' => 'Cantidad', 'data' => $pedi,
                'dataLabels' => [
                'enabled'=> true,
                'rotation'=> -90,
                'color'=> '#FFFFFF',
                'align'=> 'right',
                'y'=> 10, 
                ],
        ],
      ]
   ]
]);

?>
</form>
</div>
