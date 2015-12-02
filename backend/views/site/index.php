<?php
   use miloschuman\highcharts\Highcharts;
   use yii\jui\DatePicker;
/* @var $this yii\web\View */

$this->title = 'Welcome to Relevadores APP';
?>
<div class="site-index">
<br>
<h4> RELAYS PERCENTAGE OF EFFECTIVENESS REPORT</h4><br>
<?php

echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Effectiveness Relays'],
      'xAxis' => [
         'categories' => $users
      ],
      'yAxis' => [
         'title' => ['text' => 'Percentage']
      ],
      'series' => [
        ['type' => 'column', 'name' => 'Efficiency', 'data' => $percent,
                'dataLabels' => [
                'enabled'=> true,
                'rotation'=> -90,
                'color'=> '#FFFFFF',
                'align'=> 'right',
                'y'=> 10, 
                ],
                'color' => 'orange',
        ],
      ]
   ]
]);

?>
<br><br>
<h4> SHOPS REPORT ORDER IN TIME</h4><br>
<form action="" method="GET">
    <table>
           <tr>
              <td>
                    <?= yii\jui\DatePicker::widget(['name' => 'startDate', 'language' => 'es-UY' , 'dateFormat' => 'dd-MM-yyyy','options' => ['placeholder' => 'Start Date ...']]) ?>

              </td>
              <td> &nbsp;&nbsp;&nbsp; </td>
              <td>
                    <?= yii\jui\DatePicker::widget(['name' => 'endDate', 'language' => 'es-UY' , 'dateFormat' => 'dd-MM-yyyy','options' => ['placeholder' => 'End Date ...']]) ?>
                
              </td>
              <td> &nbsp;&nbsp;&nbsp; </td>
              <td>
                    <select id="store-picker" name="storePicker" class="btn btn-sm dropdown-toggle">
                      <option value="0" selected>Choose Store...</option>
                      <?php echo $stores ?>
                    </select>
                </td>
                <td> &nbsp;&nbsp;&nbsp; </td>
                <td>
                    <input class="btn btn-default btn-primary btn-sm" type='submit' value='Generate'/>
                </td>

        </tr>
    </table>
    <br>
 <?php


$comercio=$nomstor;
/*$desde='2015-11-24';
$hasta='2015-11-26';*/
echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Products ordered by the shop ' . $comercio . ' from: '. $datei . ' to: ' . $datef],
      'xAxis' => [
         'categories' => $prods
      ],
      'yAxis' => [
         'title' => ['text' => 'Order amount']
      ],
      'series' => [
         ['type' => 'column', 'name' => 'Amount', 'data' => $pedi,
                'dataLabels' => [
                'enabled'=> true,
                'rotation'=> -90,
                'color'=> '#FFFFFF',
                'align'=> 'right',
                'y'=> 10, 
                ],
                  'color' => 'green',
        ],
      ]
   ]
]);

?>
</form>
</div>
