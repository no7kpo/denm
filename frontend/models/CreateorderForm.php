<?php
namespace frontend\models;

//use common\models\User;
use yii\base\Model;
use Yii;


class CreateorderForm extends Model
{
    public $deliveryDate;
    public $amount;


    public function rules()
    {
        return [
            [['deliveryDate'], 'date', 'format'=>'d-m-Y'],
        ];
    }


    public function createorder($id)
    {
        if ($this->validate()) {
            /*$user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }*/
            //$deliveryDate = ->$this->deliveryDate;
            //return $deliveryDate;
        }
    }
}
