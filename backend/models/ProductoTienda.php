<?php
namespace backend\models;
use Yii;
/**
 * This is the model class for table "producto_tienda".
 *
 * @property string $idproducto
 * @property string $idcomercio
 *
 * @property Comercios $idcomercio0
 * @property Productos $idproducto0
 */
class ProductoTienda extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto_tienda';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idproducto', 'idcomercio'], 'required'],
            [['idproducto', 'idcomercio'], 'integer']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idproducto' => Yii::t('app', 'product'),
            'idcomercio' => Yii::t('app', 'shop'),
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
        return $this->hasOne(Producto::className(), ['id' => 'idproducto']);
    }
    public function getAllProductos($idComercio)
    {
        return $this->find('idproducto')->where(['idcomercio' => $idComercio])->all();
    }
    public function getAllComercios($idProducto)
    {
        return $this->find('idcomercio')->where(['idproducto' => $idProducto])->all();
    }
}