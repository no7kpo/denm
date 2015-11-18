<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "comercios".
 *
 * @property string $id
 * @property string $nombre
 * @property string $latitud
 * @property string $longitud
 * @property integer $prioridad
 * @property string $hora_apertura
 * @property string $hora_cierre
 * @property string $direccion
 * @property integer $dia
 *
 * @property ProductoTienda[] $productoTiendas
 * @property Productos[] $idproductos
 * @property Ruta $ruta
 * @property StockPedido $stockPedido
 */
class Comercios extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comercios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'latitud', 'longitud', 'prioridad', 'hora_apertura', 'hora_cierre'], 'required'],
            [['prioridad', 'dia'], 'integer'],
            [['hora_apertura', 'hora_cierre'], 'safe'],
            [['nombre'], 'string', 'max' => 50],
            [['latitud', 'longitud'], 'string', 'max' => 100],
            [['direccion'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Name'),
            'latitud' => Yii::t('app', 'Latitude'),
            'longitud' => Yii::t('app', 'Longitude'),
            'prioridad' => Yii::t('app', 'Priority'),
            'hora_apertura' => Yii::t('app', 'Open hour'),
            'hora_cierre' => Yii::t('app', 'Close hour'),
            'direccion' => Yii::t('app', 'Adress'),
            'dia' => Yii::t('app', 'Day of the week'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTiendas()
    {
        return $this->hasMany(ProductoTienda::className(), ['idcomercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdproductos()
    {
        return $this->hasMany(Productos::className(), ['id' => 'idproducto'])->viaTable('producto_tienda', ['idcomercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuta()
    {
        return $this->hasOne(Ruta::className(), ['idcomercio' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockPedido()
    {
        return $this->hasMany(StockPedido::className(), ['idcomercio' => 'id'])->viaTable('stock_pedido', ['idcomercio' => 'id']);
    }
}
