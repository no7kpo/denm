<?php
namespace common\models;
use Yii;
/**
 * This is the model class for table "stock_pedido".
 *
 * @property string $idcomercio
 * @property string $idproducto
 * @property integer $stock
 * @property integer $pedido
 * @property string $fecha
 *
 * @property Comercios $idcomercio0
 * @property Productos $idproducto0
 */
class StockPedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stock_pedido';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idcomercio', 'idproducto', 'stock', 'pedido', 'fecha'], 'required'],
            [['idcomercio', 'idproducto', 'stock', 'pedido'], 'integer'],
            [['fecha'], 'safe'],
            [['idcomercio'], 'unique'],
            [['idproducto'], 'unique']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcomercio' => Yii::t('app', 'Shop'),
            'idproducto' => Yii::t('app', 'Products'),
            'stock' => Yii::t('app', 'Stock'),
            'pedido' => Yii::t('app', 'Request'),
            'fecha' => Yii::t('app', 'Date'),
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
    public function getIdproducto0()
    {
        return $this->hasOne(Productos::className(), ['id' => 'idproducto']);
    }
}