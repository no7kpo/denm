<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rutas".
 *
 * @property string $id
 * @property string $fecha
 * @property string $iduser
 *
 * @property RutaComercio[] $rutaComercios
 * @property Comercios[] $idcomercios
 */
class Ruta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rutas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'iduser'], 'required'],
            [['fecha'], 'safe'],
            [['iduser'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'iduser' => 'Iduser',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRutaComercios()
    {
        return $this->hasMany(RutaComercio::className(), ['idruta' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcomercios()
    {
        return $this->hasMany(Comercios::className(), ['id' => 'idcomercio'])->viaTable('ruta_comercio', ['idruta' => 'id']);
    }
}
