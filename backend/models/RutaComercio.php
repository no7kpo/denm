<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ruta_comercio".
 *
 * @property string $idruta
 * @property string $idcomercio
 * @property integer $orden
 * @property integer $relevado
 *
 * @property Comercios $idcomercio0
 * @property Rutas $idruta0
 */
class RutaComercio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta_comercio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idruta', 'idcomercio', 'orden'], 'required'],
            [['idruta', 'idcomercio', 'orden', 'relevado'], 'integer'],
            [['relevado'],'default','value'=>'0']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idruta' => Yii::t('app', 'Route'),
            'idcomercio' => Yii::t('app', 'Shop'),
            'orden' => Yii::t('app', 'Order'),
            'relevado' => Yii::t('app', 'Relevated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomercio0()
    {
        return $this->hasOne(Comercios::className(), ['id' => 'idcomercio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdruta0()
    {
        return $this->hasOne(Rutas::className(), ['id' => 'idruta']);
    }
}
