<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property string $id
 * @property string $Nombre
 * @property string $idcategoria
 * @property string $Imagen
 *
 * @property ProductoTienda[] $productoTiendas
 * @property Comercios[] $idcomercios
 * @property Categorias $idcategoria0
 * @property StockPedido $stockPedido
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Nombre', 'idcategoria', 'Imagen'], 'required'],
            [['idcategoria'], 'integer'],
            [['Nombre', 'Imagen'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'Nombre' => Yii::t('app', 'Name'),
            'idcategoria' => Yii::t('app', 'Category'),
            'Imagen' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductoTiendas()
    {
        return $this->hasMany(ProductoTienda::className(), ['idproducto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomercios()
    {
        return $this->hasMany(Comercios::className(), ['id' => 'idcomercio'])->viaTable('producto_tienda', ['idproducto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcategoria0()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'idcategoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStockPedido()
    {
        return $this->hasMany(StockPedido::className(), ['idproducto' => 'id'])->viaTable('stock_pedido', ['idproducto' => 'id']);
    }
}
