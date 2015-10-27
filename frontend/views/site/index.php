<?php

/* @var $this yii\web\View */

$this->title = 'Relevadores';

if(!Yii::$app->user->getIsGuest()){
?>

<div class="site-index">

    <div class="row" id="indx-welcome">
        <div class="col-md-4">
            <div>
                <h2><p>Welcome back fulano!</p></h2>
                <p> - It's nice see you again</p>
            </div>
        </div>

        <div class="col-md-8 right">
            <img class="img-responsive right" src="http://gamers-on.com/wp-content/uploads/2015/02/google-maps_infografia.jpg">
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-5">
                <h3>Your best route for today</h3>
                <img class="img-responsive" src="http://i.imgur.com/us91yIY.png">
                <br>
                <p class="inline"><a class="btn btn-default btn-primary btn-sm" href="#">Restore routes&raquo;</a></p>
                <p class="inline"><a class="btn btn-default btn-primary btn-sm" href="#">Check our stock</a></p>
            </div>
            <div class="col-lg-7">

                <div class="dropdown datepicker-inline">
                    <h2>Deliveries</h2>
                    <select class="btn btn-sm dropdown-toggle" id="datepicker-btn">
                      <option value="today" selected>Today</option>
                      <option value="tomorrow">Tomorrow</option>
                      <option value="t_week">This week</option>
                      <option value="n_week">Next week</option>
                    </select>
                </div>

                <br>
                <div class="table-responsive">
                    <table class="table table-hover" id="delivery-table">
                        <tr>
                            <th>#</th>
                            <th>Delivery point</th>
                            <th>Day</th>
                            <th>Map</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><a class="btn-default" href="#"><img class="info" src="https://cdn4.iconfinder.com/data/icons/Primo_Icons/PNG/128x128/info_blue.png"> Devoto San Martin</a></td>
                            <td>10-11-2015</td>
                            <td><a class="btn btn-xs btn-default" href="#">Show</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><a class="btn-default" href="#"><img class="info" src="https://cdn4.iconfinder.com/data/icons/Primo_Icons/PNG/128x128/info_blue.png"> Tienda Inglesa Propios</a></td>
                            <td>10-11-2015</td>
                            <td><a class="btn btn-xs btn-default" href="#">Show</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a class="btn-default" href="#"><img class="info" src="https://cdn4.iconfinder.com/data/icons/Primo_Icons/PNG/128x128/info_blue.png"> Cobadonga Hogar </a></td>
                            <td>10-11-2015</td>
                            <td><a class="btn btn-xs btn-default" href="#">Show</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a class="btn-default" href="#"><img class="info" src="https://cdn4.iconfinder.com/data/icons/Primo_Icons/PNG/128x128/info_blue.png"> Cobadonga Hogar </a></td>
                            <td>10-11-2015</td>
                            <td><a class="btn btn-xs btn-default" href="#">Show</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a class="btn-default" href="#"><img class="info" src="https://cdn4.iconfinder.com/data/icons/Primo_Icons/PNG/128x128/info_blue.png"> Cobadonga Hogar </a></td>
                            <td>10-11-2015</td>
                            <td><a class="btn btn-xs btn-default" href="#">Show</a></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><a class="btn-default" href="#"><img class="info" src="https://cdn4.iconfinder.com/data/icons/Primo_Icons/PNG/128x128/info_blue.png"> Cobadonga Hogar </a></td>
                            <td>10-11-2015</td>
                            <td><a class="btn btn-xs btn-default" href="#">Show</a></td>
                        </tr>
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
            <h1>Please <a href=<?php echo $_SERVER['SERVER_NAME']."/site/login"; ?>> login</a> or <a href=<?php echo $_SERVER['SERVER_NAME']."/site/signup"; ?>>signup</a>.</h1>
        </div>
    </div>
</div>

<?php } ?>