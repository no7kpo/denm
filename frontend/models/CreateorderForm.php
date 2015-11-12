<?php
namespace frontend\models;

//use common\models\User;
use yii\base\Model;
use Yii;


class CreateorderForm extends Model
{
    public $deliveryDate;


    public function rules()
    {
        return [
            [['deliveryDate'], 'date', 'format'=>'d-m-Y'],
        ];
    }


    public function createorder($id)
    {
        if ($this->validate()) {
            //return $deliveryDate;
        }
    }
}
