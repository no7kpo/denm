<?php
   use miloschuman\highcharts\Highcharts;
/* @var $this yii\web\View */

$this->title = 'Bienvenido a Relevadores APP';
?>
<div class="site-index">
<br>
 <?php

echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Productos mas vendidos por comercios'],
      'xAxis' => [
         'categories' => ['Manzanas', 'Bananas', 'Naranja']
      ],
      'yAxis' => [
         'title' => ['text' => 'Cantidad de ventas']
      ],
      'series' => [
         ['name' => 'La tienda de Pepe', 'data' => [1, 0, 4]],
         ['name' => 'Frutas Zarlanga', 'data' => [5, 7, 3]]
      ]
   ]
]);

?>
<br><br>
<?php

echo Highcharts::widget([
   'options' => [
      'title' => ['text' => 'Efectividad de Relevadores'],
      'xAxis' => [
         'categories' => $users
      ],
      'yAxis' => [
         'title' => ['text' => 'Porcentaje de eficiencia']
      ],
      'series' => [
         ['name' => 'Relevadores', 'data' => $percent]
      ]
   ]
]);

?>
</div>
