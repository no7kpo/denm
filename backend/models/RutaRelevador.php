<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "ruta_relevador".
 *
 * @property string $idruta
 * @property integer $idrelevador
 *
 * @property User $idrelevador0
 * @property Ruta $idruta0
 */
class RutaRelevador extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ruta_relevador';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idruta', 'idrelevador'], 'required'],
            [['idruta', 'idrelevador'], 'integer'],
            [['idrelevador'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idruta' => Yii::t('app', 'Route'),
            'idrelevador' => Yii::t('app', 'Employee'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdrelevador0()
    {
        return $this->hasOne(User::className(), ['id' => 'idrelevador']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdruta0()
    {
        return $this->hasOne(Ruta::className(), ['id' => 'idruta']);
    }
}
